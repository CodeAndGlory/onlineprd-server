<?php

namespace App\Http\Controllers\API;

use App\services\DepartmentUserRoleService;

class DepartmentUserRoleController extends APIController
{
    public function __construct(DepartmentUserRoleService $service)
    {
        parent::__construct($service, 'department_user_role');
    }
}
