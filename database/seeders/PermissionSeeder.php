<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'view courses',
            'create courses',
            'update courses',
            'delete courses',
            'lesson operation',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $teacher = Role::findOrCreate('teacher');
        $teacher->givePermissionTo(['view courses', 'update courses']);

        $superAdmin = Role::findOrCreate('superAdmin');
        $superAdmin->givePermissionTo(Permission::all());
    }
}
