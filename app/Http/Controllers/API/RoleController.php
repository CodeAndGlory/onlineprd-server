<?php

namespace App\Http\Controllers\API;

use App\Services\RoleService;

class RoleController extends APIController
{
    public function __construct(RoleService $service)
    {
        parent::__construct($service, 'role');
    }
}
