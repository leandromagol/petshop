<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderStatus::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'title' => 'open',
        ]);

        OrderStatus::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'title' => 'pending_payment',
        ]);

        OrderStatus::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'title' => 'paid',
        ]);

        OrderStatus::create([
            'uuid' => \Illuminate\Support\Str::uuid(),
            'title' => 'shipped',
        ]);

         OrderStatus::create([
             'uuid' => \Illuminate\Support\Str::uuid(),
             'title' => 'cancelled',
         ]);
    }
}
