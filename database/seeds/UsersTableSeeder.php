<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => str_random(10).' '.str_random(10),
            'username' => str_random(10),
            'email' => str_random(10).'@gmail.com',
            'password' => bcrypt('hunter1'),
            'integrations' => '{}', // more info about this in app/Http/Controllers/Auth/RegisterController.php
        ]);
    }
}
