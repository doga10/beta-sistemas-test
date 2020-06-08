<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Service\SocialFacebookAccountService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use OpenApi\Annotations as OA;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          description="password",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="E-mail",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Returns user authentication",
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/api/redirect",
     *     @OA\Response(
     *          response="200",
     *          description="Redirect to authentication facebook",
     *     )
     * )
     */
    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * @OA\Get(
     *     path="/api/callback",
     *     @OA\Response(
     *          response="200",
     *          description="authentication to facebook",
     *     )
     * )
     */
    public function facebookCallback(SocialFacebookAccountService $service)
    {
        $user = $service->createOrGetUser(Socialite::driver('facebook')->user());
        return auth()->login($user);
    }
}
