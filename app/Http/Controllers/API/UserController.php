<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "email" => "required|email",
            "name" => "required",
            "password" => "required"
        ]);

        return User::create($request->all());
    }

    public function show(User $user)
    {
        return $user;
    }

    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            "email" => "required|email",
            "name" => "required"
        ]);

        return $user->update($request->all());
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }
}
