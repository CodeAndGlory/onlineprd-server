<?php

namespace App\Services;

use App\Models\Course;
use Exception;
use Illuminate\Http\Request;

/**
 * Class CourseService
 * @package App\Services
 */
class CourseService extends APIService
{
    /**
     * CourseService constructor.
     * @param  Request  $request
     * @param  Course  $course
     * @throws Exception
     */
    public function __construct(Request $request, Course $course)
    {
        $this->setModel($course);
        parent::__construct($request);
    }
}
