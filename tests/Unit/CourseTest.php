<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Department;
use App\Models\FormFieldLookup;
use App\Models\Offering;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the Course->department method.
     *
     * @return void
     */
    public function testCourseDepartmentMethod()
    {
        $course = factory(Course::class)->create();
        $department = factory(Department::class)->create();
        $course->department()->associate($department);
        $course->save();

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'department_id' => $department->id,
        ]);
    }

    /**
     * Test the Course->offerings method.
     *
     * @return void
     */
    public function testCourseOfferingsMethod()
    {
        $course = factory(Course::class)->create();
        $course->offerings()->save(factory(Offering::class)->create());

        $this->assertDatabaseHas('offerings', [
            'course_id' => $course->id,
        ]);
    }

    /**
     * Test the Course->subject method.
     *
     * @return void
     */
    public function testCourseSubjectMethod()
    {
        $course = factory(Course::class)->create();
        $subject = factory(FormFieldLookup::class)->create();
        $course->subject()->associate($subject);
        $course->save();

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'subject_id' => $subject->id,
        ]);
    }
}
