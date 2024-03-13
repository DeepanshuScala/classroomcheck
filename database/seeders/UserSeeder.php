<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        User::create([
            'first_name' => 'ClassroomCopy',
            'surname' => 'Admin',
            'role_id' => 3,
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin'),
            'verified' => 1,
            'status' => 1
        ]);
    }

}
