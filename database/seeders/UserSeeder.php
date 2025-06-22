<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@samudera.id',
            'password' => bcrypt('secret'),
        ])->assignRole('admin');

        // \App\Models\User::factory()->create([
        //     'name' => 'User',
        //     'email' => 'testuser@gmail.com',
        //     'password' => bcrypt('p$ssw#rd'),
        // ])->assignRole('user');

        // \App\Models\User::factory()->create([
        //     'name' => 'User',
        //     'email' => 'testvendor@gmail.com',
        //     'password' => bcrypt('p$ssw#rd'),
        // ])->assignRole('vendor');
    }
}
