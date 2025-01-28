<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'Super',
            'surname' => 'Admin',
            'phone' => '5551234567',
            'email' => 'admin@admin.com',
            'password' => Hash::make('12345678')
        ]);
    }
} 