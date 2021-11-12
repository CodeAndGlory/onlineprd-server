<?php

namespace Tests\Unit;

use App\Models\Assignment;
use App\Models\Letter;
use App\Models\NonCourseAssignment;
use App\Models\User;
use App\Models\Term;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class LetterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the Letter->user method.
     *
     * @return void
     */
    public function testLetterUserMethod()
    {
        $letter = factory(Letter::class)->create();
        $user = factory(User::class)->create();
        $letter->user()->associate($user);
        $letter->save();

        $this->assertDatabaseHas('letters', [
            'id' => $letter->id,
            'user_id' => $user->id,
        ]);
    }

    /**
     * Test the Letter->term method.
     *
     * @return void
     */
    public function testLetterTermMethod()
    {
        $letter = factory(Letter::class)->create();
        $term = factory(Term::class)->create();
        $letter->term()->associate($term);
        $letter->save();

        $this->assertDatabaseHas('letters', [
            'id' => $letter->id,
            'term_id' => $term->id,
        ]);
    }

    /**
     * Test the Letter->Assignment relationship.
     *
     * @return void
     */
    public function testLetterBelongsToManyAssignments()
    {
        $letter = factory(Letter::class)->create();
        factory(Assignment::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $letter->assignments);
    }

    /**
     * Test the Assignment->Letter relationship.
     *
     * @return void
     */
    public function testAssignmentBelongsToManyLetters()
    {
        $assignment = factory(Assignment::class)->create();
        factory(Letter::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $assignment->letters);
    }

    /**
     * Test the Letter->NonCourseAssignment relationship.
     *
     * @return void
     */
    public function testLetterBelongsToManyNonCourseAssignments()
    {
        $letter = factory(Letter::class)->create();
        factory(NonCourseAssignment::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $letter->assignments);
    }

    /**
     * Test the NonCourseAssignment->Letter relationship.
     *
     * @return void
     */
    public function testNonCourseAssignmentBelongsToManyLetters()
    {
        $assignment = factory(NonCourseAssignment::class)->create();
        factory(Letter::class)->create();

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $assignment->letters);
    }
}
