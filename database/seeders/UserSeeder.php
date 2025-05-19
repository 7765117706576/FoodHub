<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         User::insert([
        [
 
            'name' => 'Gandi',
            'email' => 'Gandi@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'penjual',
        ],
        [
            'name' => 'Imran',
            'email' => 'Imran1q2w@gmail.com',
            'password' => bcrypt('Imran123'),
            'role' => 'pembeli',
        ],
    ]);
    }
}
