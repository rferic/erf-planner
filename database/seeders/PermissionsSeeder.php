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
            ['name' => 'settings-get', 'guard_name' => 'web'],
            ['name' => 'settings-publish', 'guard_name' => 'web'],
            ['name' => 'settings-delete', 'guard_name' => 'web'],
            ['name' => 'users-get', 'guard_name' => 'web'],
            ['name' => 'users-publish', 'guard_name' => 'web'],
            ['name' => 'users-delete', 'guard_name' => 'web'],
            ['name' => 'statuses-get', 'guard_name' => 'web'],
            ['name' => 'statuses-publish', 'guard_name' => 'web'],
            ['name' => 'statuses-delete', 'guard_name' => 'web'],
            ['name' => 'clients-get', 'guard_name' => 'web'],
            ['name' => 'clients-publish', 'guard_name' => 'web'],
            ['name' => 'clients-delete', 'guard_name' => 'web'],
            ['name' => 'projects-get', 'guard_name' => 'web'],
            ['name' => 'projects-publish', 'guard_name' => 'web'],
            ['name' => 'projects-delete', 'guard_name' => 'web']
        ], ['name', 'guard_name']);
    }
}
