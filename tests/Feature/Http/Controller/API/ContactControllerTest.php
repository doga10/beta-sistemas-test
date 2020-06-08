<?php

namespace Tests\Feature\Http\Controller\API;

use App\Entities\Contact;
use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ContactControllerTest extends TestCase
{
    use DatabaseMigrations;

    private $user;
    private $token;
    private $contacts;

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
        $this->contacts = factory(Contact::class, 10)->create();
    }

    public function testContacts()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->get(route('users.contacts'));
        $response->assertStatus(200)->assertJson($this->contacts->toArray());
    }

    public function testIndex()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->get(route('contacts.index'));
        $response->assertStatus(200)->assertJson($this->contacts->toArray());
    }

    public function testShow()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->get(route('contacts.show', ['contact' => $contact->id]));
        $response->assertStatus(200)->assertJson($contact->toArray());
    }

    public function testStoreInvalid()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('POST', route('contacts.store'), []);
        $response->assertStatus(422)->assertJsonValidationErrors(["name", "email", "phone"]);
    }

    public function testStoreInvalidByName()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('POST', route('contacts.store'), [
            "email" => "test@test.com",
            "phone" => "120",
            "user_id" => $this->user->id
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(["name"]);
    }

    public function testStoreInvalidByEmail()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('POST', route('contacts.store'), [
            "name" => "test",
            "phone" => "120",
            "user_id" => $this->user->id
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(["email"]);
    }

    public function testStoreInvalidByPhone()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('POST', route('contacts.store'), [
            "name" => "test",
            "email" => "test@test.com",
            "user_id" => $this->user->id
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(["phone"]);
    }

    public function testStoreInvalidByUserId()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('POST', route('contacts.store'), [
            "name" => "test",
            "email" => "test@test.com",
            "phone" => "120"
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(["user_id"]);
    }

    public function testStore()
    {
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('POST', route('contacts.store'), [
            "name" => "test",
            "email" => "test@test.com",
            "phone" => "123",
            "user_id" => $this->user->id
        ]);
        $response->assertStatus(201);
    }

    public function testUpdateInvalid()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('contacts.update', ['contact' => $contact->id]), []);
        $response->assertStatus(422);
    }

    public function testUpdateInvalidByName()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('contacts.update', ['contact' => $contact->id]), [
            "email" => "test@test.com.br",
            "phone" => "123",
            "user_id" => $this->user->id
        ]);
        $response->assertStatus(422);
    }

    public function testUpdateInvalidByEmail()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('contacts.update', ['contact' => $contact->id]), [
            "name" => "test",
            "phone" => "123",
            "user_id" => $this->user->id
        ]);
        $response->assertStatus(422);
    }

    public function testUpdateInvalidByPhone()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('contacts.update', ['contact' => $contact->id]), [
            "name" => "test",
            "email" => "test@test.com.br",
            "user_id" => $this->user->id
        ]);
        $response->assertStatus(422);
    }

    public function testUpdateInvalidByUserId()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('contacts.update', ['contact' => $contact->id]), [
            "name" => "test",
            "email" => "test@test.com.br",
            "phone" => "5452"
        ]);
        $response->assertStatus(422);
    }

    public function testUpdate()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('PUT', route('contacts.update', ['contact' => $contact->id]), [
            "name" => "test",
            "email" => "test@test.com.br",
            "phone" => "123",
            "user_id" => $this->user->id
        ]);
        $response->assertStatus(200);
    }

    public function testDelete()
    {
        $contact = factory(Contact::class)->create();
        $response = $this->withHeaders(['Authorization' => "Bearer " . $this->token])->json('DELETE', route('contacts.destroy', ['contact' => $contact->id]));
        $response->assertStatus(204);
    }
}
