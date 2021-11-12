<?php

namespace Tests\Feature\API\v1;

use App\Http\Middleware\Authenticate;
use App\Models\Assignment;
use App\Models\NonCourseAssignment;
use App\Models\Letter;
use App\Models\Term;
use App\Models\User;

class LetterControllerTest extends ControllerTestCase
{
    protected string $class = Letter::class;
    protected string $endpoint = 'letters';
    protected string $table = 'letters';
    protected string $record = 'letter';

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Letter();
    }

    public function testGetLettersByAssignment(): void
    {
        foreach ($this->test_instances as $instance) {
            $instance->save();
            $assignment = factory(Assignment::class)->create();
            $assignment->letters()->attach($instance->getAttributes()['id']);
        }

        // index of expected test instance to match assignment id (must be 1, 2, or 3)
        $index = 1;
        // id of assignment instance to filter for
        // since the second instance is the expected output (index 1)
        // the id of the matching assignment's id should be 1 greater
        $assignment_id_to_match             = $index + 1;

        $attributes = array('assignment_id' => $assignment_id_to_match);

        $response = $this->call('GET', $this->base_path.'letters-by-assignment', $attributes);

        $response->assertSuccessful();
        $response->assertJsonCount(1);

        $response->assertJsonPath("0.id", $this->test_instances[$index]->id);

//        the assertions below could be used if LetterService->getLettersByAssignment()
//        could be integrated into APIService->index()
//
//        $response->assertJson([
//            'error' => false
//        ]);
//        $response->assertStatus(200);
//
//        $response->assertJsonCount(3);
//
//        $response->assertJsonPath("$this->table.0.id", $this->test_instances[$index]->id);
    }

    public function testSendAppointmentLetter(): void
    {
        $attributes = array();
        // create term and user ids, add to $attributes
        $attributes['body']         = factory(Letter::class)->make()->toArray()['body'];
        $attributes['user_id']      = factory(User::class)->create()->toArray()['id'];
        $attributes['from_user_id'] = factory(User::class)->create()->toArray()['id'];
        $attributes['term_id']      = factory(Term::class)->create()->toArray()['id'];

        //create assignments, add ids to $attributes
        $attributes['assignment_ids'] = [];
        for ($i = 0; $i < $this->num_test_instances; $i++) {
            $attributes['assignment_ids'][] = factory(Assignment::class)->create()->toArray()['id'];
        }
        $attributes['non_course_assignment_ids'] = [];
        for ($i = 0; $i < $this->num_test_instances; $i++) {
            $attributes['non_course_assignment_ids'][] = factory(NonCourseAssignment::class)->create()->toArray()['id'];
        }

        $response = $this->call('GET', $this->base_path.'mail', $attributes);

        $response->assertJson([
            'error' => false,
        ]);

        $response->assertStatus(200);
    }
}
