<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Permission::upsert([
            ['name' => 'roles-get', 'guard_name' => 'web'],
            ['name' => 'roles-publish', 'guard_name' => 'web'],
            ['name' => 'roles-delete', 'guard_name' => 'web'],
            ['name' => 'users-get', 'guard_name' => 'web'],
            ['name' => 'users-publish', 'guard_name' => 'web'],
            ['name' => 'users-delete', 'guard_name' => 'web']
        ], ['name', 'guard_name']);
    }
}
