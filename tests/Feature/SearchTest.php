<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Offering;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class SearchTest
 * @package Tests\Feature
 */
class SearchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Course
     */
    protected $course;
    /**
     * @var Offering
     */
    protected $offering;
    /**
     * @var Assignment
     */
    protected $assignment;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();

        $this->course = factory(Course::class)->create();
        $this->offering = factory(Offering::class)->create();
        $this->assignment = factory(Assignment::class)->create();

        $this->course->offerings()->save($this->offering);
        $this->offering->assignments()->save($this->assignment);

        $this->offering->update(['note' => 'test this note']);
    }

    public function testSearch() // TODO: Use static test values.
    {
        $args = [
            'number',
            $this->course->number,
        ];

        $result = $this->course->whereLike(...$args)->get();

        foreach ($result as $item) {
            self::assertEquals($this->course->number, $item->number);
        }

        $args = [
            'offerings.crn',
            $this->offering->crn,
        ];

        $result = $this->course->whereLike(...$args)->get();

        foreach ($result as $item) {
            self::assertStringContainsString((string) $this->offering->crn, (string) $item->offerings->first()->crn);
        }

        $args = [
            'offerings.note',
            'test note',
        ];

        $result = $this->course->whereLike(...$args)->get();

        foreach ($result as $item) {
            self::assertEquals('test this note', $item->offerings->first()->note);
        }

        $args = [
            array_keys($this->course->getAllowedColumns()),
            $this->course->number,
        ];

        $result = $this->course->whereLike(...$args)->get();

        foreach ($result as $item) {
            self::assertStringContainsStringIgnoringCase($this->course->number, $item->number);
        }
    }
}
