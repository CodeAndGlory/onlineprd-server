<?php

namespace Tests\Unit;

use App\Models\Department;
use App\Models\DepartmentUserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentUserRoleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the DepartmentUserRole->user method.
     *
     * @return void
     */
    public function testDepartmentUserRoleUserMethod()
    {
        $department_role = factory(DepartmentUserRole::class)->create();
        $user = factory(User::class)->create();
        $department_role->user()->associate($user);
        $department_role->save();

        $this->assertDatabaseHas('department_user_roles', [
            'id' => $department_role->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test the DepartmentUserRole->department method.
     *
     * @return void
     */
    public function testDepartmentUserRoleDepartmentMethod()
    {
        $department_role = factory(DepartmentUserRole::class)->create();
        $department = factory(Department::class)->create();
        $department_role->department()->associate($department);
        $department_role->save();

        $this->assertDatabaseHas('department_user_roles', [
            'id' => $department_role->id,
            'department_id' => $department->id,
        ]);
    }

    /**
     * Test the DepartmentUserRole->role method.
     *
     * @return void
     */
    public function testDepartmentUserRoleRoleMethod()
    {
        $department_role = factory(DepartmentUserRole::class)->create();
        $role = factory(Role::class)->create();
        $department_role->role()->associate($role);
        $department_role->save();

        $this->assertDatabaseHas('department_user_roles', [
            'id' => $department_role->id,
            'role_id' => $role->id,
        ]);
    }
}
