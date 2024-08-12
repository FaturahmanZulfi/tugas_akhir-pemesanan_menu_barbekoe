<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Ppn;
use App\Models\User;
use App\Models\Level;
use App\Models\Status;
use App\Models\Category;
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
            'id' => 1,
            'level' => 'Admin'
        ]);

        Level::create([
            'id' => 2,
            'level' => 'Pemilik'
        ]);

        Level::create([
            'id' => 3,
            'level' => 'Kasir'
        ]);
        
        Level::create([
            'id' => 4,
            'level' => 'Barista'
        ]);

        Level::create([
            'id' => 5,
            'level' => 'Koki'
        ]);

        Level::create([
            'id' => 6,
            'level' => 'Pelayan'
        ]);

        Ppn::create([
            'ppn' => '11'
        ]);

        // \App\Models\User::factory(100)->create();

        User::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'level_id' => '1'
        ]);

        User::create([
            'username' => 'pemilik',
            'password' => bcrypt('pemilik'),
            'level_id' => '2'
        ]);

        User::create([
            'username' => 'kasir',
            'password' => bcrypt('kasir'),
            'level_id' => '3'
        ]);

        User::create([
            'username' => 'barista',
            'password' => bcrypt('barista'),
            'level_id' => '4'
        ]);

        User::create([
            'username' => 'koki',
            'password' => bcrypt('koki'),
            'level_id' => '5'
        ]);

        User::create([
            'username' => 'pelayan',
            'password' => bcrypt('pelayan'),
            'level_id' => '6'
        ]);
    }
}
