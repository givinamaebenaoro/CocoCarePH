<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Handle email verification.
     *
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request, $id, $hash)
    {
        // Find the user
        $user = User::findOrFail($id);

        // Verify the hash
        if (! Hash::check($user->getEmailForVerification(), $hash)) {
            return redirect()->route('login.form')->with('error', 'Invalid verification link.');
        }

        // Find the verification token
        $tokenData = DB::table('verification_tokens')
            ->where('user_id', $id)
            ->where('expires_at', '>', now())
            ->first();

        if (!$tokenData) {
            return redirect()->route('login.form')->with('error', 'Invalid or expired verification token.');
        }

        // Mark the token as verified
        DB::table('verification_tokens')
            ->where('user_id', $id)
            ->update(['verified' => true]);

        // Update the user status if needed
        $user->email_verified_at = now();
        $user->save();

        return redirect()->route('login.form')->with('success', 'Email verified successfully. You can now log in.');
    }

    /**
     * Handle a resend request for the email verification notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request)
    {
        // Check if the user is already verified
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('status', 'Your email has already been verified.');
        }

        // Generate a new verification token
        $token = Str::random(60); // Generate a random token
        $expires_at = now()->addHours(24); // Set expiration time (e.g., 24 hours from now)

        // Store the verification token in the database
        $request->user()->verificationToken()->create([
            'token' => $token,
            'expires_at' => $expires_at,
        ]);

        // Send the verification email with the token
        $request->user()->sendEmailVerificationNotification($token);

        return back()->with('resent', true);
    }

    public function verifyEmail(Request $request, $token){
        $user = User::where('verification_token', $token)->first();

        if ($user) {
            $user->email_verified_at = now();
            $user->save();

            // Optionally, you can log in the user automatically here

            request()->session()->flash('success', 'Your email has been verified successfully.');
        } else {
            request()->session()->flash('error', 'Invalid verification token.');
        }

        return redirect()->route('home');
    }

}
