<?php

namespace Database\Seeders;

use App\Models\User;
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
        // Teachers
        User::create([
            'username' => 'teacher1',
            'name' => 'Giáo viên 1',
            'email' => 'teacher1@example.com',
            'phone' => '0901000001',
            'role' => 'teacher',
            'password' => Hash::make('123456a@A'),
        ]);

        User::create([
            'username' => 'teacher2',
            'name' => 'Giáo viên 2',
            'email' => 'teacher2@example.com',
            'phone' => '0901000002',
            'role' => 'teacher',
            'password' => Hash::make('123456a@A'),
        ]);

        // Students
        User::create([
            'username' => 'student1',
            'name' => 'Sinh viên 1',
            'email' => 'student1@example.com',
            'phone' => '0901000003',
            'role' => 'student',
            'password' => Hash::make('123456a@A'),
        ]);

        User::create([
            'username' => 'student2',
            'name' => 'Sinh viên 2',
            'email' => 'student2@example.com',
            'phone' => '0901000004',
            'role' => 'student',
            'password' => Hash::make('123456a@A'),
        ]);
    }
}
