<?php

namespace Tests\Unit;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Department;
use App\Models\FormFieldLookup;
use App\Models\Offering;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FormFieldLookupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the FormFieldLookup->assignmentsByPosition method.
     *
     * @return void
     */
    public function testFormFieldLookupAssignmentsByPositionMethod()
    {
        $form_field_lookup = factory(FormFieldLookup::class)->states('position')->create();
        $form_field_lookup->assignmentsByPosition()->save(factory(Assignment::class)->create());

        $this->assertDatabaseHas('assignments', [
            'position_id' => $form_field_lookup->id,
        ]);
        $this->assertDatabaseHas('form_field_lookups', [
            'field' => 'position',
        ]);
    }

    /**
     * Test the FormFieldLookup->coursesBySubject method.
     *
     * @return void
     */
    public function testFormFieldLookupCoursesBySubjectMethod()
    {
        $form_field_lookup = factory(FormFieldLookup::class)->states('subject')->create();
        $form_field_lookup->coursesBySubject()->save(factory(Course::class)->create());

        $this->assertDatabaseHas('courses', [
            'subject_id' => $form_field_lookup->id,
        ]);
        $this->assertDatabaseHas('form_field_lookups', [
            'field' => 'subject',
        ]);
    }

    /**
     * Test the FormFieldLookup->departmentsByCollege method.
     *
     * @return void
     */
    public function testFormFieldLookupDepartmentsByCollegeMethod()
    {
        $form_field_lookup = factory(FormFieldLookup::class)->states('college')->create();
        $form_field_lookup->departmentsByCollege()->save(factory(Department::class)->create());

        $this->assertDatabaseHas('departments', [
            'college_id' => $form_field_lookup->id,
        ]);
        $this->assertDatabaseHas('form_field_lookups', [
            'field' => 'college',
        ]);
    }

    /**
     * Test the FormFieldLookup->usersByPrefix method.
     *
     * @return void
     */
    public function testFormFieldLookupUsersByPrefixMethod()
    {
        $form_field_lookup = factory(FormFieldLookup::class)->states('prefix')->create();
        $form_field_lookup->usersByPrefix()->save(factory(User::class)->create());

        $this->assertDatabaseHas('users', [
            'prefix_id' => $form_field_lookup->id,
        ]);
        $this->assertDatabaseHas('form_field_lookups', [
            'field' => 'prefix',
        ]);
    }

    /**
     * Test the FormFieldLookup->offeringsByCampus method.
     *
     * @return void
     */
    public function testFormFieldLookupOfferingsByCampusMethod()
    {
        $form_field_lookup = factory(FormFieldLookup::class)->states('campus')->create();
        $form_field_lookup->offeringsByCampus()->save(factory(Offering::class)->create());

        $this->assertDatabaseHas('offerings', [
            'campus_id' => $form_field_lookup->id,
        ]);
        $this->assertDatabaseHas('form_field_lookups', [
            'field' => 'campus',
        ]);
    }
}
