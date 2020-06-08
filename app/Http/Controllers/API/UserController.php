<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Entities\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Returns contacts",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */
    public function index()
    {
        return User::all();
    }

    /**
     * @OA\Post(
     *     path="/api/users",
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="username",
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
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          description="Password",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Returns contacts",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "name" => "required|string",
            "password" => "required|string"
        ]);

        $data = [
            "email" => $request->get('email'),
            "name" => $request->get('name'),
            "password" =>  bcrypt($request->get('password'))
        ];
        return User::create($data);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID User",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Returns contacts",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID Contact",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="username",
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
     *          description="Returns contacts",
     *          @OA\JsonContent(ref="#/components/schemas/User")
     *     )
     * )
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            "email" => "required|email",
            "name" => "required"
        ]);

        return $user->update($request->all());
    }

    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="ID Contact",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *          response="204",
     *          description="remove user"
     *     )
     * )
     */
    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}
