<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'Super Admin' => [
            ],
            'Employee' => [
                'read form field lookups',
            ],
            'Approver' => [
                'read assignments',
                'read form field lookups',
            ],
            'Scheduler' => [
                'create assignments',
                'create comments',
                'create users',
                'read assignments',
                'read comments',
                'read form field lookups',
                'read users',
                'update assignments',
                'update users',
            ],
            'UNCG Online Registration Team' => [
                'create comments',
                'create verification tags',
                'read acceptance letter templates',
                'read assignments',
                'read comments',
                'read form field lookups',
                'update acceptance letter templates',
                'update assignments',
            ],
            'UNCG Online Registration Manager' => [
                'create stipend verification tags',
                'read acceptance letter templates',
                'read assignments',
                'read form field lookups',
                'update acceptance letter templates',
                'update assignments',
            ],
            'UNCG Online Finance Team' => [
                'create comments',
                'read assignments',
                'read comments',
                'read form field lookups',
                'update assignments',
            ],
            'UNCG Online Data/Contacts Updater' => [
                'create acceptance letter templates',
                'create departments',
                'create form field lookups',
                'delete assignments',
                'read acceptance letter templates',
                'read departments',
                'read form field lookups',
                'update acceptance letter templates',
                'update departments',
                'update form field lookups',
            ],
            'UNCG Online Project Manager' => [
                'read assignments',
                'read comments',
                'read form field lookups',
                'read users',
            ]
        ];

        foreach ($roles as $name => $perms) {
            $role = Role::firstOrnew(
                ['name' => $name],
                ['guard_name' => 'web']
            );

            foreach ($perms as $perm) {
                $role->givePermissionTo($perm);
            }
            $role->save();
        }
    }
}
