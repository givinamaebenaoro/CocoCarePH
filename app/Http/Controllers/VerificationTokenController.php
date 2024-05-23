<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\VerificationToken;

class VerificationTokenController extends Controller
{
// Method to verify the token
public function verify(Request $request, $id, $token)
{
    // Find the verification token by ID and token value
    $verificationToken = VerificationToken::where('id', $id)
        ->where('token', $token)
        ->where('expires_at', '>', Carbon::now())
        ->where('used', 0)
        ->first();

    if (!$verificationToken) {
        return redirect('home')->with('error', 'Invalid or expired token.');
    }

    // Mark the token as used
    $verificationToken->used = true;
    $verificationToken->save();

    // Assuming VerificationToken is related to a User
    $user = User::find($verificationToken->user_id);

    if ($user && !$user->hasVerifiedEmail()) {
        $user->email_verified_at = Carbon::now();
        $user->save();

        // Optionally log the user in
        Auth::login.form($user);
    }

    // Redirect to the home page with a success message
    return redirect('home')->with('success', 'Email verified successfully.');
}
}
