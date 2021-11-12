<?php

namespace Tests\Unit;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\FormFieldLookup;
use App\Models\Offering;
use App\Models\PartOfTerm;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OfferingTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the Offering->assignments method.
     *
     * @return void
     */
    public function testOfferingAssignmentsMethod()
    {
        $offering = factory(Offering::class)->create();
        $offering->assignments()->save(factory(Assignment::class)->create());

        $this->assertDatabaseHas('assignments', [
            'offering_id' => $offering->id,
        ]);
    }

    /**
     * Test the Offering->campus method.
     *
     * @return void
     */
    public function testOfferingCampusMethod()
    {
        $offering = factory(Offering::class)->create();
        $campus = factory(FormFieldLookup::class)->create();
        $offering->campus()->associate($campus);
        $offering->save();

        $this->assertDatabaseHas('offerings', [
            'id' => $offering->id,
            'campus_id' => $campus->id,
        ]);
    }

    /**
     * Test the Offering->course method.
     *
     * @return void
     */
    public function testOfferingCourseMethod()
    {
        $offering = factory(Offering::class)->create();
        $course = factory(Course::class)->create();
        $offering->course()->associate($course);
        $offering->save();

        $this->assertDatabaseHas('offerings', [
            'id' => $offering->id,
            'course_id' => $course->id,
        ]);
    }

    /**
     * Test the Offering->partOfTerm method.
     *
     * @return void
     */
    public function testOfferingPartOfTermMethod()
    {
        $offering = factory(Offering::class)->create();
        $part_of_term = factory(PartOfTerm::class)->create();
        $offering->partOfTerm()->associate($part_of_term);
        $offering->save();

        $this->assertDatabaseHas('offerings', [
            'id' => $offering->id,
            'part_of_term_id' => $part_of_term->id,
        ]);
    }
}
