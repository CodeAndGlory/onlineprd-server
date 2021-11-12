<?php

namespace App\Http\Controllers\API;

use App\services\DepartmentService;

class DepartmentController extends APIController
{
    public function __construct(DepartmentService $service)
    {
        parent::__construct($service, 'department');
    }
}
