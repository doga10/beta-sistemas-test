<?php

namespace Tests\Unit\Entities;

use App\Entities\Contact;

use App\Entities\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use DatabaseMigrations;

    public function testFillableAttribute()
    {
        $fillable = ['user_id', 'name', 'email', 'phone'];
        $contact = new Contact();
        $this->assertEquals($fillable, $contact->getFillable());
    }

    public function testList()
    {
        factory(User::class, 1)->create();
        factory(Contact::class, 1)->create();
        $contacts = Contact::all();
        $this->assertCount(1, $contacts);
        $contactKeys = array_keys($contacts->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            "id",
            "user_id",
            "name",
            "email",
            "phone",
            "created_at",
            "updated_at",
        ], $contactKeys);
    }

    public function testCreate()
    {
        factory(User::class, 1)->create();
        $user = User::find(1);

        $data = [
            "user_id" => $user->id,
            "name" => "test",
            "email" => "test@test.com",
            "phone" => "123"
        ];
        $contact = Contact::create($data);
        $contact->refresh();
        $this->assertEquals('test', $contact->name);
        $this->assertEquals(1, $contact->user_id);
        $this->assertEquals('test@test.com', $contact->email);
        $this->assertEquals('123', $contact->phone);
    }

    public function testShow()
    {
        factory(User::class, 1)->create();
        factory(Contact::class, 1)->create();
        $contact = Contact::find(1);
        $this->assertNotEmpty($contact);
    }

    public function testDelete()
    {
        factory(User::class, 1)->create();
        factory(Contact::class, 1)->create();
        $contact = Contact::find(1);
        $this->assertNotEmpty($contact);
        $contact->delete();
        $contact = Contact::find(1);
        $this->assertNull($contact);
    }
}
