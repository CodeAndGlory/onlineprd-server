<?php

namespace Tests\Feature\API\v1;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Offering;
use App\Models\User;

class CourseControllerTest extends ControllerTestCase
{
    protected string $class = Course::class;
    protected string $endpoint = 'courses';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Course();
    }

    public function testIndexAll()
    {
        $offerings = [];
        $assignments = [];
        $users = [];

        foreach ($this->test_instances as $instance) {
            $instance->save();

            for ($l = 0; $l < 2; $l++) {
                $offerings[] = factory(Offering::class)->create();
                $instance->offerings()->save(end($offerings));
                for ($j = 0; $j < 2; $j++) {
                    $assignments[] = factory(Assignment::class)->create();
                    end($offerings)->assignments()->save(end($assignments));
                    $users[] = factory(User::class)->create();
                    end($assignments)->user()->associate(end($users))->save();
                }
            }
        }

        $params = ['with' => 'all'];
        $response = $this->call('GET', $this->base_path.$this->endpoint, $params);

        $response->assertJsonPath('courses.0.offerings.0.assignments.0.user.id', $users[0]->id);
    }
}
