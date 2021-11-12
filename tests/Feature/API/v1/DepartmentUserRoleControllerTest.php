<?php

namespace Tests\Feature\API\v1;

use App\Models\DepartmentUserRole;

class DepartmentUserRoleControllerTest extends ControllerTestCase
{
    protected string $class = DepartmentUserRole::class;
    protected string $endpoint = 'department-user-roles';
    protected string $table = 'department_user_roles';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new DepartmentUserRole();
    }
}
