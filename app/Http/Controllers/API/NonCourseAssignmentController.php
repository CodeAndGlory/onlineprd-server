<?php

namespace App\Http\Controllers\API;

use App\Services\NonCourseAssignmentService;

class NonCourseAssignmentController extends APIController
{
    public function __construct(NonCourseAssignmentService $service)
    {
        parent::__construct($service, 'non_course_assignment');
    }
}
