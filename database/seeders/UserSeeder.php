<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // สร้าง Admin
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123'),
            'role' => 'admin'
        ]);

       Employee::create([
            'user_id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => $admin->role,
            'gender' => 'ชาย',
            'phone' => '0812345678',
            'birth_date' => '1990-01-01',
            'address' => '123 ถนนหลัก กรุงเทพฯ',
            'department' => 'การบริหาร',
            'hourly_rate' => 500,
            'profile_image' => null
    ]);

        // สร้าง Employee ตัวอย่าง
        $employee = User::create([
            'name' => 'Employee',
            'email' => 'employee@example.com',
            'password' => Hash::make('123'),
            'role' => 'employee'
        ]);

     Employee::create([
            'user_id' => $employee->id,
            'name' => $employee->name,
            'email' => $employee->email,
            'role' => $employee->role,
            'gender' => 'ชาย',
            'phone' => '0898765432',
            'birth_date' => '1995-05-05',
            'address' => '456 ถนนรอง กรุงเทพฯ',
            'department' => 'ไอที',
            'hourly_rate' => 150,
            'profile_image' => null
    ]);
}
}