<?php

namespace Tests\Feature\API\v1;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Department;
use App\Models\NonCourseAssignment;
use App\Models\Offering;
use App\Models\PartOfTerm;
use App\Models\Term;
use App\Models\User;

class DepartmentControllerTest extends ControllerTestCase
{
    protected string $class = Department::class;
    protected string $endpoint = 'departments';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Department();
    }

    public function testIndexAll()
    {
        $courses = [];
        $offerings = [];
        $assignments = [];
        $users = [];

        foreach ($this->test_instances as $instance) {
            $instance->save();

            for ($i = 0; $i < 2; $i++) {
                $courses[] = factory(Course::class)->create();
                $instance->courses()->save(end($courses));
                for ($l = 0; $l < 2; $l++) {
                    $offerings[] = factory(Offering::class)->create();
                    end($courses)->offerings()->save(end($offerings));
                    for ($j = 0; $j < 2; $j++) {
                        $assignments[] = factory(Assignment::class)->create();
                        end($offerings)->assignments()->save(end($assignments));
                        $users[] = factory(User::class)->create();
                        end($assignments)->user()->associate(end($users))->save();
                    }
                }
            }
        }

        $params = ['with' => 'all'];
        $response = $this->call('GET', $this->base_path.$this->endpoint, $params);

        $response->assertJsonPath('departments.0.courses.0.offerings.0.assignments.0.user.id', $users[0]->id);
    }

    public function testSaveUsers()
    {
        $instance = $this->test_instances[0];
        $users = factory(User::class, 3)->create();

        $user_ids = '';
        foreach ($users as $user) {
            $user_ids .= "$user->id, ";
        }
        $user_ids = rtrim($user_ids, ' ,');

        $attributes = array_merge($instance->toArray(), ['users' => $user_ids]);

        $result = $this->call(
            'POST',
            $this->base_path.$this->endpoint,
            $attributes
        );

        $department_id = $result->json('department.id');

        foreach ($users as $user) {
            $this->assertDatabaseHas('department_user', [
                'department_id' => $department_id,
                'user_id' => $user->id
            ]);
        }
    }

    public function testUpdateUsers()
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $department_id = $instance->id;
        $users = factory(User::class, 3)->create();

        $user_ids = '';
        foreach ($users as $user) {
            $user_ids .= "$user->id, ";
        }
        $user_ids = rtrim($user_ids, ' ,');

        $attributes = ['users' => $user_ids];

        $result = $this->call(
            'PUT',
            $this->base_path.$this->endpoint.'/'.$department_id,
            $attributes
        );

        foreach ($users as $user) {
            $this->assertDatabaseHas('department_user', [
                'department_id' => $department_id,
                'user_id' => $user->id
            ]);
        }
    }

    public function testDestroyRelations()
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $department_id = $instance->id;
        $users = factory(User::class, 3)->create();

        $instance->users()->sync($users);

        $result = $this->call(
            'DELETE',
            $this->base_path.$this->endpoint.'/'.$department_id
        );

        foreach ($users as $user) {
            $this->assertDatabaseMissing('department_user', [
                'user_id' => $user->id,
                'department_id' => $department_id
            ]);
        }
    }

    public function testActionableItemsByTermId(): void
    {
        $department = $this->test_instances[0];
        $department->name = "Department 1";
        $department->save();

        $course = factory(Course::class)->create();
        $course->department()->associate($department);
        $course->save();

        $term = factory(Term::class)->create();
        $term->id = 1;
        $term->save();

        // no confirmed values present
        $nonassignment = factory(NonCourseAssignment::class)->create();
        $nonassignment->term()->associate($term);
        $nonassignment->department()->associate($department);
        $nonassignment->save();

        $part_of_term = factory(PartOfTerm::class)->create();
        $part_of_term->term()->associate($term);
        $part_of_term->save();

        $offering = factory(Offering::class)->create();
        $offering->partOfTerm()->associate($part_of_term);
        $offering->course()->associate($course);
        $offering->save();

        $assignment = factory(Assignment::class)->create();
        $assignment->offering()->associate($offering);
        $assignment->save();

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'id' => 1,
                'actionable_items_by_term_id' => 1
            ]
        );

        $response->assertJson([
            'error' => false,
            'departments' => [['actionable_items' => 0]],
        ]);

        // confirmed values
        $nonassignment->confirmed = date("Y-m-d H:i:s");
        $nonassignment->save();
        $offering->confirmed = date("Y-m-d H:i:s");
        $offering->save();

        $assignment->confirmed = date("Y-m-d H:i:s");
        $assignment->save();

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'id' => 1,
                'actionable_items_by_term_id' => 1
            ]
        );

        $response->assertJson([
            'error' => false,
            'departments' => [['actionable_items' => 3]],
        ]);

        // course deleted, only non-assignment should be counted
        $course->deleted_at = date("Y-m-d H:i:s");
        $course->save();

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'id' => 1,
                'actionable_items_by_term_id' => 1
            ]
        );

        $response->assertJson([
            'error' => false,
            'departments' => [['actionable_items' => 1]],
        ]);

        // confirmed values and verified values
        $course->deleted_at = null;
        $course->save();

        $nonassignment->verified = date("Y-m-d H:i:s");
        $nonassignment->save();
        $offering->verified = date("Y-m-d H:i:s");
        $offering->save();
        $assignment->verified = date("Y-m-d H:i:s");
        $assignment->save();

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'id' => 1,
                'actionable_items_by_term_id' => 1
            ]
        );

        $response->assertJson([
            'error' => false,
            'departments' => [['actionable_items' => 0]],
        ]);

        // offering deleted, non-assignment should only be counted
        $nonassignment->verified = null;
        $nonassignment->save();
        $offering->verified = null;
        $offering->deleted_at = date("Y-m-d H:i:s");
        $offering->save();
        $assignment->verified = null;
        $assignment->save();

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'id' => 1,
                'actionable_items_by_term_id' => 1
            ]
        );

        $response->assertJson([
            'error' => false,
            'departments' => [['actionable_items' => 1]],
        ]);
    }
}
