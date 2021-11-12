<?php

use App\Models\DepartmentUserRole;
use Illuminate\Database\Seeder;

class DepartmentUserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departmentRoles = [
            [
                'department_id' => '22',
                'user_id' => '1',
                'role_id' => '4'
            ],
            [
                'department_id' => '47',
                'user_id' => '2',
                'role_id' => '4'
            ],
            [
                'department_id' => '47',
                'user_id' => '2',
                'role_id' => '3'
            ],
            [
                'department_id' => '11',
                'user_id' => '2',
                'role_id' => '4'
            ],
            [
                'department_id' => '29',
                'user_id' => '3',
                'role_id' => '4'
            ]
        ];

        foreach ($departmentRoles as $departmentRole) {
            DepartmentUserRole::firstOrCreate(
                $departmentRole
            );
        }
//        factory(DepartmentUserRole::class, 15)->create();
    }
}
