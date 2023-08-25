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
            'last_name' =>'buckhill',
            'email' => 'admin@buckhill.co.uk',
            'password'=>'admin'
        ]);
    }
}
