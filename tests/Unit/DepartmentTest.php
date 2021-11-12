<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Department;
use App\Models\FormFieldLookup;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DepartmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the Department->college method.
     *
     * @return void
     */
    public function testDepartmentCollegeMethod()
    {
        $department = factory(Department::class)->create();
        $college = factory(FormFieldLookup::class)->create();
        $department->college()->associate($college);
        $department->save();

        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'college_id' => $college->id,
        ]);
    }

    /**
     * Test the Department->contact method.
     *
     * @return void
     */
    public function testDepartmentContactMethod()
    {
        $department = factory(Department::class)->create();
        $contact = factory(User::class)->create();
        $department->contactUser()->associate($contact);
        $department->save();

        $this->assertDatabaseHas('departments', [
            'id' => $department->id,
            'contact_user_id' => $contact->id,
        ]);
    }

    /**
     * Test the Department->courses method.
     *
     * @return void
     */
    public function testDepartmentCoursesMethod()
    {
        $department = factory(Department::class)->create();
        $department->courses()->save(factory(Course::class)->create());

        $this->assertDatabaseHas('courses', [
            'department_id' => $department->id,
        ]);
    }

    /**
     * Test the Department->users method.
     *
     * @return void
     */
    public function testDepartmentUsersMethod()
    {
        $department = factory(Department::class)->create();
        $department->users()->save(factory(User::class)->create());

        $this->assertDatabaseHas('department_user', [
            'department_id' => $department->id,
        ]);
    }
}
