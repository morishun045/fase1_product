<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        User::truncate();

        User::create([
            'name' => '田中太郎',
            'email' => 'taro@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => '鈴木花子',
            'email' => 'hanako@example.com',
            'password' => Hash::make('password'),
        ]);

        User::create([
            'name' => '佐藤次郎',
            'email' => 'jiro@example.com',
            'password' => Hash::make('password'),
        ]);
    }
}
