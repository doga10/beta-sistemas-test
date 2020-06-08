<?php

namespace Tests\Unit\Entities;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use DatabaseMigrations;

    public function testLogin()
    {
        $data = [
            "name" => "test",
            "email" => "test@test.com",
            "password" => bcrypt("123")
        ];
        $user = User::create($data);
        $user->refresh();
        $login = [
            "email" => $user->email,
            "password" => "123",
        ];

        Auth::attempt($login);
        $login = Auth::user();

        $this->assertNotEmpty($login);
    }
}
