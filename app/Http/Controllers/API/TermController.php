<?php

namespace App\Http\Controllers\API;

use App\Services\TermService;

class TermController extends APIController
{
    public function __construct(TermService $service)
    {
        parent::__construct($service, 'term');
    }
}
