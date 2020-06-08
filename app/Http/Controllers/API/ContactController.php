<?php

namespace App\Http\Controllers\API;

use App\Entities\Contact;
use OpenApi\Annotations as OA;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    private $rules = [
        "user_id" => "required|integer",
        "name" => "required",
        "email" => "required|email",
        "phone" => "required",
    ];

    /**
     * @OA\Get(
     *     path="/api/contacts",
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
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Contact"))
     *     )
     * )
     */
    public function index()
    {
        return Contact::all();
    }

    /**
     * @OA\Get(
     *     path="/api/users/contacts",
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
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Contact"))
     *     )
     * )
     */
    public function contacts(Request $request)
    {
        return Contact::where('user_id', Auth::user()->id)->get();
    }

    /**
     * @OA\Post(
     *     path="/api/contacts",
     *     @OA\Parameter(
     *          name="bearer",
     *          in="header",
     *          description="bearer token",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="name",
     *          in="query",
     *          description="username",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          description="user id",
     *          required=true,
     *          @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          in="query",
     *          description="E-mail",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *          name="phone",
     *          in="query",
     *          description="phone",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="201",
     *          description="Returns contacts",
     *          @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);
        return Contact::create($request->all());
    }

    /**
     * @OA\Get(
     *     path="/api/contacts/{id}",
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
     *          response="200",
     *          description="Returns contacts",
     *          @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function show(Contact $contact)
    {
        return $contact;
    }

    /**
     * @OA\Put(
     *     path="/api/contacts/{id}",
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
     *     @OA\Parameter(
     *          name="password",
     *          in="query",
     *          description="phone",
     *          required=true,
     *          @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *          response="200",
     *          description="Returns contacts",
     *          @OA\JsonContent(ref="#/components/schemas/Contact")
     *     )
     * )
     */
    public function update(Request $request, Contact $contact)
    {
        $this->validate($request, $this->rules);
        return $contact->update($request->all());
    }

    /**
     * @OA\Delete(
     *     path="/api/contacts/{id}",
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
     *          description="remove contact"
     *     )
     * )
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->noContent();
    }
}
