<?php

namespace Tests\Feature\API\v1;

use App\Models\NonCourseAssignment;

class NonCourseAssignmentControllerTest extends ControllerTestCase
{
    protected string $class = NonCourseAssignment::class;
    protected string $table = 'non_course_assignments';
    protected string $endpoint = 'non-course-assignments';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new NonCourseAssignment();
    }
}
