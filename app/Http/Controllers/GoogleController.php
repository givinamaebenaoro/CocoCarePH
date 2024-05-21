<?php

namespace App\Http\Controllers;

use App\User;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    //Login Using Google

    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try{
            $user = Socialite::driver('google')->user;
dd($user);
            // $saveUser = User::updateOrCreate([
            //     'google_id' => $user->getId(),
            // ],[
            //     'name' => $user->getName(),
            //     'email' => $user->getEmail(),
            //     'password' => Hash::make($user->getName().'@'.$user->getId())
            // ]);

            // Auth::loginUsingId($saveUser->id);

            // return redirect()->route('home');
        } catch (Throwable $th) {
            throw $th;
        }
    }
}
