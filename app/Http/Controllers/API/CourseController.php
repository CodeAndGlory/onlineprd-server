<?php

namespace App\Http\Controllers\API;

use App\Services\CourseService;

class CourseController extends APIController
{
    public function __construct(CourseService $service)
    {
        parent::__construct($service, 'course');
    }
}
