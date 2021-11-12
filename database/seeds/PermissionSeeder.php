<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create',
            'read',
            'update',
            'delete',
        ];

        $subjects = [
            'acceptance letter templates',
            'acceptances reports',
            'assignments reports',
            'assignments',
            'comments',
            'department roles',
            'departments',
            'form field lookups',
            'stipend verification tags',
            'users',
            'verification tags',
        ];

        foreach ($permissions as $permission) {
            foreach ($subjects as $subject) {
                Permission::firstOrCreate(
                    ['name' => "$permission $subject"],
                    ['guard_name' => 'web']
                );
            }
        }
    }
}

