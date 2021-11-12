<?php

namespace App\Http\Controllers\API;

use App\Services\PartOfTermService;

class PartOfTermController extends APIController
{
    public function __construct(PartOfTermService $service)
    {
        parent::__construct($service, 'part_of_term', 'parts_of_term');
    }
}
