<?php

namespace App\Http\Controllers\API;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends APIController
{
    public function __construct(UserService $service)
    {
        parent::__construct($service, 'user');
    }

    /**
     * @return JsonResponse
     */
    public function userInfo()
    {
        return response()->json($this->service->getUserInfo(), 200);
    }

    /**
     * @return JsonResponse
     */
    public function countOfUnverified()
    {
        return response()->json($this->service->getCountOfUnverified(), 200);
    }
}
