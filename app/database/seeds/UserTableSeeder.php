<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
        	'email' => $_SERVER['ADMIN_EMAIL'],
        	'name' => $_SERVER['ADMIN_USER'],
        	'password' => Hash::make($_SERVER['ADMIN_PASS'])
        ));
    }
}