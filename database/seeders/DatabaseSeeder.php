<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

         User::factory()->create([
             'first_name' => 'admin',
             'last_name' =>'buckhill',
             'email' => 'admin@buckhill.co.uk',
             'password'=>'admin'
         ]);
         $this->call([
             OrderStatusSeeder::class
         ]);
    }
}
