<?php

namespace Tests\Unit;

use App\Models\Assignment;
use App\Models\FormFieldLookup;
use App\Models\Offering;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the Assignment->user method.
     *
     * @return void
     */
    public function testAssignmentUserMethod()
    {
        $assignment = factory(Assignment::class)->create();
        $user = factory(User::class)->create();
        $assignment->user()->associate($user);
        $assignment->save();

        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test the Assignment->offering method.
     *
     * @return void
     */
    public function testAssignmentOfferingMethod()
    {
        $assignment = factory(Assignment::class)->create();
        $offering = factory(Offering::class)->create();
        $assignment->offering()->associate($offering);
        $assignment->save();

        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'offering_id' => $offering->id,
        ]);
    }

    /**
     * Test the Assignment->position method.
     *
     * @return void
     */
    public function testAssignmentPositionMethod()
    {
        $assignment = factory(Assignment::class)->create();
        $position = factory(FormFieldLookup::class)->create();
        $assignment->position()->associate($position);
        $assignment->save();

        $this->assertDatabaseHas('assignments', [
            'id' => $assignment->id,
            'position_id' => $position->id,
        ]);
    }
}
