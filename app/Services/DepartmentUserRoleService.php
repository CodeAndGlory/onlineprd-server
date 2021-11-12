<?php

namespace App\Services;

use App\Models\DepartmentUserRole;
use Exception;
use Illuminate\Http\Request;

/**
 * Class DepartmentUserRoleService
 * @package App\Services
 */
class DepartmentUserRoleService extends APIService
{
    /**
     * DepartmentService constructor.
     *
     * @param  Request  $request
     * @param  DepartmentUserRole  $department_role
     *
     * @throws Exception
     */
    public function __construct(Request $request, DepartmentUserRole $department_role)
    {
        $this->setModel($department_role);
        parent::__construct($request);
    }
}
