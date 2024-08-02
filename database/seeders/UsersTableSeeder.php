<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          // Create the student user
        $studentUser = User::create([
            'name' => 'Student User',
            'email' => 'student@example.com',
            'password' => bcrypt('password')
        ]);
        $studentUser->assignRole('student');

        // Create the teacher user
        $teacherUser = User::create([
            'name' => 'Teacher User',
            'email' => 'teacher@example.com',
            'password' => bcrypt('password')
        ]);
        $teacherUser->assignRole('teacher');

        // Create the super Admin
        $teacherUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superAdmin@example.com',
            'password' => bcrypt('password')
        ]);
        $teacherUser->assignRole('superAdmin');
    }
}
