<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'admin',
            'last_name' =>'admin',
            'email' => 'admin@admin',
            'password'=>'admin'
        ]);
    }
}
