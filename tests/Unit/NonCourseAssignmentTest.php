<?php


namespace Tests\Unit;

use App\Models\Department;
use App\Models\Eclass;
use App\Models\FormFieldLookup;
use App\Models\NonCourseAssignment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NonCourseAssignmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the Assignment->user method.
     *
     * @return void
     */
    public function testAssignmentUserMethod()
    {
        $assignment = factory(NonCourseAssignment::class)->create();
        $user = factory(User::class)->create();
        $assignment->user()->associate($user);
        $assignment->save();

        $this->assertDatabaseHas('non_course_assignments', [
            'id' => $assignment->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test the Assignment->position method.
     *
     * @return void
     */
    public function testAssignmentPositionMethod()
    {
        $assignment = factory(NonCourseAssignment::class)->create();
        $position = factory(FormFieldLookup::class)->create();
        $assignment->position()->associate($position);
        $assignment->save();

        $this->assertDatabaseHas('non_course_assignments', [
            'id' => $assignment->id,
            'position_id' => $position->id,
        ]);
    }

    /**
     * Test the Assignment->campus method.
     *
     * @return void
     */
    public function testAssignmentCampusMethod()
    {
        $assignment = factory(NonCourseAssignment::class)->create();
        $campus = factory(FormFieldLookup::class)->create();
        $assignment->campus()->associate($campus);
        $assignment->save();

        $this->assertDatabaseHas('non_course_assignments', [
            'id' => $assignment->id,
            'campus_id' => $campus->id,
        ]);
    }

    /**
     * Test the Assignment->department method.
     *
     * @return void
     */
    public function testAssignmentDepartmentMethod()
    {
        $assignment = factory(NonCourseAssignment::class)->create();
        $department = factory(Department::class)->create();
        $assignment->department()->associate($department);
        $assignment->save();

        $this->assertDatabaseHas('non_course_assignments', [
            'id' => $assignment->id,
            'department_id' => $department->id,
        ]);
    }

    /**
     * Test the Assignment->eclass method.
     *
     * @return void
     */
    public function testAssignmentEclassMethod()
    {
        $assignment = factory(NonCourseAssignment::class)->create();
        $eclass = factory(Eclass::class)->create();
        $assignment->eclass()->associate($eclass);
        $assignment->save();

        $this->assertDatabaseHas('non_course_assignments', [
            'id' => $assignment->id,
            'eclass_id' => $eclass->id,
        ]);
    }
}
