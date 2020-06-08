<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\SocialFacebookAccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->validate([
            "email" => "required|string",
            "password" => "required|string",
        ]);

        if (!Auth::attempt($login))
            return response([ 'message' => 'login invalid' ]);

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        return response([ 'user' => Auth::user(), "token" => $accessToken ]);
    }

    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        return auth()->login($user);
    }
}
