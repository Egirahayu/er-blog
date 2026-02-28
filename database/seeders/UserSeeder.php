<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Mohamad Egi Rahayu',
            'username'  => 'egirahayu',
            'email' => 'mohamadegirahayu@gmail.com',
            'password' => Hash::make('Egirahayu26')
        ]);

        User::factory(5)->create();
    }
}
