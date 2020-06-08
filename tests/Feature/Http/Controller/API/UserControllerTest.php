<?php

namespace Tests\Feature\Http\Controller\API;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $user;
    private $users;
    private $token;

    protected function setUp(): void
    {
        parent::setUp();

        \Artisan::call('passport:install');

        $this->user = User::create([
            "name" => "test",
            "email" => "test@test.com",
            "password" => bcrypt("123")
        ]);

        $login = [
            "email" => $this->user->email,
            "password" => "123",
        ];

        Auth::attempt($login);
        $this->token = Auth::user()->createToken('authToken')->accessToken;
        $this->users = factory(User::class, 10)->create();
    }

//    public function testIndex()
//    {
//        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->get(route('users.index'));
//        $response->assertStatus(200)->assertJson($this->users->toArray());
//    }

    public function testShow()
    {
        $new = factory(User::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->get(route('users.show', ['user' => $new->id]));
        $response->assertStatus(200)->assertJson($new->toArray());
    }

    public function testStoreInvalid()
    {
        $response = $this->json('POST', route('users.store'), []);
        $response->assertStatus(422)->assertJsonValidationErrors(["name", "email", "password"]);
    }

    public function testStoreInvalidByName()
    {
        $response = $this->json('POST', route('users.store'), [
            "email" => "test@test.com",
            "password" => "120",
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(["name"]);
    }

    public function testStoreInvalidByEmail()
    {
        $response = $this->json('POST', route('users.store'), [
            "name" => "test",
            "password" => "120",
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(["email"]);
    }

    public function testStoreInvalidByPassword()
    {
        $response = $this->json('POST', route('users.store'), [
            "name" => "test",
            "email" => "test@test.com",
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(["password"]);
    }

    public function testStore()
    {
        $response = $this->json('POST', route('users.store'), [
            "name" => "test",
            "email" => "test2@test.com",
            "password" => "123"
        ]);
        $response->assertStatus(201);
    }

    public function testUpdateInvalid()
    {
        $new = factory(User::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('users.update', ['user' => $new->id]), []);
        $response->assertStatus(422);
    }

    public function testUpdateInvalidByName()
    {
        $new = factory(User::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('users.update', ['user' => $new->id]), [
            "email" => "test@test.com.br",
            "password" => "123",
        ]);
        $response->assertStatus(422);
    }

    public function testUpdateInvalidByEmail()
    {
        $new = factory(User::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('users.update', ['user' => $new->id]), [
            "name" => "test",
            "password" => "123",
        ]);
        $response->assertStatus(422);
    }

    public function testUpdate()
    {
        $new = factory(User::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('users.update', ['user' => $new->id]), [
            "name" => "test",
            "email" => "test@test.com.br",
            "password" => "123",
        ]);
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $new = factory(User::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('DELETE', route('users.destroy', ['user' => $new->id]));
        $response->assertStatus(204);
    }
}
