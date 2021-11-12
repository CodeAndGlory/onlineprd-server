<?php

namespace App\Services;

use App\Models\NonCourseAssignment;
use Exception;
use Illuminate\Http\Request;

/**
 * Class AssignmentService
 * @package App\Services
 */
class NonCourseAssignmentService extends APIService
{
    /**
     * AssignmentService constructor.
     * @param  Request  $request
     * @param  NonCourseAssignment  $non_course_assignment
     * @throws Exception
     */
    public function __construct(Request $request, NonCourseAssignment $non_course_assignment)
    {
        $this->setModel($non_course_assignment);
        parent::__construct($request);
    }
}
