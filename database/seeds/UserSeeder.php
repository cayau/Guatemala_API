<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => "Carlos Ayaur",
            'email' => 'ayau15@gmail.com',
            'password' => Hash::make('guatemala1234'),
        ]);
    }
}
