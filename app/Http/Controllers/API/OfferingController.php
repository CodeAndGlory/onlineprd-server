<?php

namespace App\Http\Controllers\API;

use App\Services\OfferingService;

class OfferingController extends APIController
{
    public function __construct(OfferingService $service)
    {
        parent::__construct($service, 'offering');
    }
}
