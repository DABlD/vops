<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'dmendoza',
            'fname' => 'David',
            'mname' => 'Roga',
            'lname' => 'Mendoza',
            'role' => 'Admin',
            'email' => 'davidmendozaofficial@gmail.com',
            'birthday' => '1997-11-12',
            'gender' => 'Male',
            'address' => 'Rm. 628, Park Avenue Mansions, Park Avenue St.,, Barangay 81',
            'contact' => '09154590172',
            'email_verified_at' => now()->toDateTimeString(),
            'password' => '123456'
        ]);
    }
}
