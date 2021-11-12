<?php

namespace App\Http\Controllers\API;

use App\Services\PermissionService;

class PermissionController extends APIController
{
    public function __construct(PermissionService $service)
    {
        parent::__construct($service, 'permission');
    }
}
