<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => true,
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Abdul Jabbar',
            'email' => 'abdul@gmail.com',
            'password' => Hash::make('12345678'),
            'is_admin' => false,
        ]);
        $products = [
            ['636G67', 'HODDIE JACKET', 208000, '1.jpg'],
            ['6DSJI67', 'HODDIE JACKET', 89000, '2.jpg'],
            ['63756G67', 'HODDIE JACKET', 350030, '3.jpg'],
            ['636GG67', 'HODDIE JACKET', 670000, '4.jpg'],
            ['63633G67', 'HODDIE JACKET', 80000, '5.jpg'],
            ['636GG67', 'HODDIE JACKET', 200000, '6.jpg'],

        ];
        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product[0],
                'description' => $product[1],
                'price' => $product[2],
                'image' => 'product/'.$product[3],
                'stock' => fake()->numberBetween(1, 1000),
            ]);
        }
    }
}
