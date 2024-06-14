<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Level;
use App\Models\Category;
use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Category Table Seeder
        Category::create([
            'category' => 'Makanan'
        ]);
        
        Category::create([
            'category' => 'Minuman'
        ]);

        // Status Table Seeder
        Status::create([
            'status' => 'Belum Dibayar'
        ]);

        Status::create([
            'status' => 'Sudah Dibayar'
        ]);

        Status::create([
            'status' => 'Sudah Disiapkan'
        ]);

        Status::create([
            'status' => 'Selesai'
        ]);

        // Level Table Seeder
        Level::create([
            'level' => 'Admin'
        ]);

        Level::create([
            'level' => 'Pemilik'
        ]);
        
        Level::create([
            'level' => 'Barista'
        ]);

        Level::create([
            'level' => 'Koki'
        ]);

        Level::create([
            'level' => 'Pelayan'
        ]);

        \App\Models\User::factory(100)->create();
    }
}
