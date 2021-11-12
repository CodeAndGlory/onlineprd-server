<?php

namespace App\Http\Controllers\API;

use App\Services\AssignmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssignmentController extends APIController
{
    public function __construct(AssignmentService $service)
    {
        parent::__construct($service, 'assignment');
    }
    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getAssignmentsByUserTerm(Request $request)
    {
        return response()->json($this->service->getAssignmentsByUserTerm($request), 200);
    }
}
