<?php

namespace Tests\Feature\Http\Controller\API;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        \Artisan::call('passport:install');

        User::create([
            "name" => "test",
            "email" => "test@test.com",
            "password" => bcrypt("123")
        ]);
    }

    public function testLogin()
    {
        $response = $this->json('POST', route('auth.login'), [
            "password" => "123",
            "email" => "test@test.com",
        ]);
        $response->assertStatus(200);
    }
}
