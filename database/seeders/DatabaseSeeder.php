<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\katagori;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'Fadhil Rafif',
            'email' => 'admin@gmail.com',
            'role' => '1',
            'status' => 1,
            'hp' => '0812345678901',
            'password' => bcrypt('adminsuper'),
            ]);
            #untuk record berikutnya silahkan, beri nilai berbeda pada nilai: nama, email, hp dengan nilai masing-masing anggota kelompok
        User::create([
            'nama' => 'Jojo',
            'email' => 'jojo@gmail.com',
            'role' => '0',
            'status' => 1,
            'hp' => '081234567892',
            'password' => bcrypt('admin123'),
            ]);
            User::create([
                'nama' => 'Anggun',
                'email' => 'anggun@gmail.com',
                'role' => '0',
                'status' => 1,
                'hp' => '081234567892',
                'password' => bcrypt('admin123'),
                ]);
                User::create([
                    'nama' => 'Faiz',
                    'email' => 'faiz@gmail.com',
                    'role' => '0',
                    'status' => 1,
                    'hp' => '081234567892',
                    'password' => bcrypt('admin123'),
                    ]);
                    User::create([
                        'nama' => 'adnan',
                        'email' => 'adnan@gmail.com',
                        'role' => '0',
                        'status' => 1,
                        'hp' => '081234567892',
                        'password' => bcrypt('admin123'),
                        ]);
                        

    katagori::create([
    'nama_katagori' => 'Makanan',
    ]);
    katagori::create([
    'nama_katagori' => 'Minuman',
    ]);
    katagori::create([
    'nama_katagori' => 'Cemilan',
    ]);
}
}
