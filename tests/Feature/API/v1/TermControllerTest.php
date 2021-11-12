<?php

namespace Tests\Feature\API\v1;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\NonCourseAssignment;
use App\Models\Offering;
use App\Models\PartOfTerm;
use App\Models\Term;

class TermControllerTest extends ControllerTestCase
{
    protected string $class = Term::class;
    protected string $endpoint = 'terms';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Term();
    }

    public function testActionableItemsCount(): void
    {
        $term = $this->test_instances[0];
        $term->name = "Term 1";
        $term->save();

        // no confirmed values present
        $nonassignment = factory(NonCourseAssignment::class)->create();
        $nonassignment->term()->associate($term);
        $nonassignment->save();

        $part_of_term = factory(PartOfTerm::class)->create();
        $part_of_term->term()->associate($term);
        $part_of_term->save();

        $course = factory(Course::class)->create();

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
                'actionable_items_count' => 'true'
            ]
        );

        $response->assertJson([
            'error' => false,
            'terms' => [['actionable_items' => 0]],
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
                'actionable_items_count' => 'true'
            ]
        );

        $response->assertJson([
            'error' => false,
            'terms' => [['actionable_items' => 3]],
        ]);

        // course deleted, only non-assignment should be counted
        $course->deleted_at = date("Y-m-d H:i:s");
        $course->save();

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'id' => 1,
                'actionable_items_count' => 'true'
            ]
        );

        $response->assertJson([
            'error' => false,
            'terms' => [['actionable_items' => 1]],
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
                'actionable_items_count' => 'true'
            ]
        );

        $response->assertJson([
            'error' => false,
            'terms' => [['actionable_items' => 0]],
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
                'actionable_items_count' => 'true'
            ]
        );

        $response->assertJson([
            'error' => false,
            'terms' => [['actionable_items' => 1]],
        ]);
    }
}
