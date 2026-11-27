<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Paket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'kasir',
            'email' => 'kasir@kasir.com',
            'password' => Hash::make('kasir'),
            'role' => 'kasir',
        ]);
    
        Paket::insert([
            ['nama_paket' => 'Reguler', 'satuan' => 'kg', 'harga' => 7000, 'created_at' => now(), 'updated_at' => now()],
            ['nama_paket' => 'Ekspress', 'satuan' => 'kg', 'harga' => 12000, 'created_at' => now(), 'updated_at' => now()],
            ['nama_paket' => 'Superkilat', 'satuan' => 'kg', 'harga' => 18000, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
