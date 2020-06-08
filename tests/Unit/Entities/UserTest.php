<?php

namespace Tests\Unit\Entities;

use App\Entities\User;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function testUseTraits()
    {
        $data = [
            "name" => "test",
            "email" => "test@test.com",
            "password" => "123"
        ];
        User::create($data);

        $traits = [
            HasApiTokens::class, Notifiable::class
        ];
        $userTraits = array_keys(class_uses(User::class));
        $this->assertEquals($traits, $userTraits);
    }

    public function testFillableAttribute()
    {
        $fillable = ['name', 'email', 'password'];
        $user = new User();
        $this->assertEquals($fillable, $user->getFillable());
    }

    public function testList()
    {
        factory(User::class, 1)->create();
        $users = User::all();
        $this->assertCount(1, $users);
        $userKeys = array_keys($users->first()->getAttributes());
        $this->assertEqualsCanonicalizing([
            "id",
            "name",
            "email",
            "email_verified_at",
            "password",
            "remember_token",
            "created_at",
            "updated_at",
        ], $userKeys);
    }

    public function testCreate()
    {
        $data = [
            "name" => "test",
            "email" => "test@test.com",
            "password" => "123"
        ];
        $user = User::create($data);
        $user->refresh();
        $this->assertEquals('test', $user->name);
    }

    public function testShow()
    {
        factory(User::class, 1)->create();
        $user = User::find(1);
        $this->assertNotEmpty($user);
    }

    public function testDelete()
    {
        factory(User::class, 1)->create();
        $user = User::find(1);
        $this->assertNotEmpty($user);
        $user->delete();
        $user = User::find(1);
        $this->assertNull($user);
    }
}
