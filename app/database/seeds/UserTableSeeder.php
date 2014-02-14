<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
        	'email' => $_ENV['ADMIN_EMAIL'],
        	'name' => $_ENV['ADMIN_NAME'],
        	'password' => Hash::make($_ENV['ADMIN_PASS'])
        ));
    }
}