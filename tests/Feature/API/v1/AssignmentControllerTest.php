<?php

namespace Tests\Feature\API\v1;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\NonCourseAssignment;
use App\Models\Offering;
use App\Models\Term;
use App\Models\User;

class AssignmentControllerTest extends ControllerTestCase
{
    protected string $class = Assignment::class;
    protected string $endpoint = 'assignments';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Assignment();
    }

    public function testGetAssignmentsByUserTerm(): void
    {
        unset($this->test_instances);
        // create a term that will be the target term for this test
        $term1 = factory(Term::class)->create();
        // create a dummy term which will not be the target term
        $term2 = factory(Term::class)->create();
        // get the id of term1 to use in the request
        $term_id = (string) $term1->getAttributes()['id'];
        // create a course that will be in the target term
        // and associate the course with the target term
        $course1 = factory(Course::class)->create();
        $course1->term()->associate($term1)->save();
        // create an offering for this course and associate it with the course
        $offering1 = factory(Offering::class)->create();
        $offering1->course()->associate($course1)->save();
        // create 2 assignments for this offering and associate them with the offering
        $assignment1a = factory(Assignment::class)->create();
        $assignment2 = factory(Assignment::class)->create();
        $assignment1a->offering()->associate($offering1)->save();
        $assignment2->offering()->associate($offering1)->save();
        // create 2 non-course assignments and associate them with the term
        $non_course_assignment1 = factory(NonCourseAssignment::class)->create();
        $non_course_assignment2 = factory(NonCourseAssignment::class)->create();
        $non_course_assignment1->term()->associate($term1)->save();
        $non_course_assignment2->term()->associate($term1)->save();

        // create a course and associate it with the dummy term
        $course2 = factory(Course::class)->create();
        $course2->term()->associate($term2)->save();
        // create an offering and associate it with this course
        $offering2 = factory(Offering::class)->create();
        $offering2->course()->associate($course2)->save();
        // create an assignment and associate it with this offering
        $assignment1b = factory(Assignment::class)->create();
        $assignment1b->offering()->associate($offering2)->save();

        // create 3 users
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user3 = factory(User::class)->create();
        // associate one of the target-term course assignments with user1
        $assignment1a->user()->associate($user1)->save();
        // associate one of the target-term non-course assignments with user1
        $non_course_assignment1->user()->associate($user1)->save();
        // associate the dummy term course assignment with user1
        $assignment1b->user()->associate($user1)->save();

        // associate the other target-term course assignment with user2
        $assignment2->user()->associate($user2)->save();

        // associate the other target-term non-course assignment with user3
        $non_course_assignment2->user()->associate($user3)->save();

        // 3 users should be returned from the request with 4 total assignments
        // user1 should be returned with 2 total assignments, 1 course and 1 non-course
        // (user1 has 1 assignment that is NOT in the requested term)
        // user2 should be returned with 1 course assignment
        // user3 should be returned with 1 non-course assignment

        // set attributes array
        $attributes = array('term_id' => $term_id);

        $response = $this->call('GET', $this->base_path.'assignments-by-user-term', $attributes);

        unset(
            $assignment1a,
            $assignment1b,
            $assignment2,
            $course1,
            $course2,
            $non_course_assignment1,
            $non_course_assignment2,
            $offering1,
            $offering2,
            $term1,
            $term2
        );

        $response->assertSuccessful();
        // 3 users should be returned
        $response->assertJsonCount(3, "users.*");
        // user 1 (index 0) should have 1 course assignment
        $response->assertJsonCount(1, "users.0.assignments");
        // and 1 non-course assignment
        $response->assertJsonCount(1, "users.0.non_course_assignments");
        // user 2 (index 1) should have 1 course assignment
        $response->assertJsonCount(1, "users.1.assignments");
        // and 0 non-course assignments
        $response->assertJsonCount(0, "users.1.non_course_assignments");
        // user 3 (index 2) should have 0 course assignments
        $response->assertJsonCount(0, "users.2.assignments");
        // and 1 non-course assignment
        $response->assertJsonCount(1, "users.2.non_course_assignments");
    }
}
