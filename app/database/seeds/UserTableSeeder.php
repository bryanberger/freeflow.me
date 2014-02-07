<?php

class UserTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users')->delete();

        User::create(array(
        	'email' => 'leads@bryanberger.com',
        	'name' => 'deca',
        	'password' => Hash::make('test')
        ));
    }
}