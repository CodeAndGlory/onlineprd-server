<?php

namespace App\Http\Controllers\API;

use App\Services\LetterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LetterController extends APIController
{
    public function __construct(LetterService $service)
    {
        parent::__construct($service, 'letter');
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function sendAppointmentLetter(Request $request)
    {
        return response()->json($this->service->sendAppointmentLetter($request), 200);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getLettersByAssignment(Request $request)
    {
        return response()->json($this->service->getLettersByAssignment($request), 200);
    }
}
