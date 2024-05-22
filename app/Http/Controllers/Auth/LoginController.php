<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function credentials(Request $request){
        return ['email'=>$request->email,'password'=>$request->password,'status'=>'active','role'=>'admin'];
    }
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirect($provider)
    {
        // dd($provider);
        return Socialite::driver($provider)->stateless()->redirect();
    }

    public function Callback($provider)
    {
        try {
            $userSocial = Socialite::driver($provider)->stateless()->user();
            Log::info('User social data: ', ['user' => $userSocial]);
        } catch (\Exception $e) {
            Log::error('Socialite error: ', ['error' => $e->getMessage()]);
            return redirect('/login')->with('error', 'Something went wrong or you denied the request.');
        }

        $users = User::where('email', $userSocial->getEmail())->first();

        if ($users) {
            Auth::login($users);
            Log::info('User logged in: ', ['user' => $users]);
            return redirect('/')->with('success', 'You are logged in from ' . $provider);
        } else {
            $user = User::create([
                'name' => $userSocial->getName(),
                'email' => $userSocial->getEmail(),
                'image' => $userSocial->getAvatar(),
                'provider_id' => $userSocial->getId(),
                'provider' => $provider,
            ]);

            Log::info('New user created: ', ['user' => $user]);

            Auth::login($user);
            Log::info('New user logged in: ', ['user' => $user]);
            return redirect()->route('home');
        }
    }
}
