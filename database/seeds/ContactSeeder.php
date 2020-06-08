<?php

use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Entities\User::class, 50)->create()->each(function ($user) {
            $user->contacts()->save(factory(App\Entities\Contact::class)->make());
        });
    }
}
