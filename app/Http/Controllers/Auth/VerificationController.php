<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
    public function verify($token)
    {
        // Find the token in the verification_tokens table
        $verificationToken = DB::table('verification_tokens')
            ->where('token', $token)
            ->where('expires_at', '>', now())
            ->where('used', false)
            ->first();

        if ($verificationToken) {
            // Mark the user as verified
            $user = User::find($verificationToken->user_id);
            if ($user) {
                $user->email_verified_at = now();
                $user->save();

                // Mark the token as used
                DB::table('verification_tokens')
                    ->where('id', $verificationToken->id)
                    ->update(['used' => true]);

                return redirect()->route('login')->with('status', 'Email verified successfully.');
            }

            return redirect()->route('login')->with('error', 'User not found.');
        }

        return redirect()->route('login')->with('error', 'Invalid or expired verification link.');
    }
}
