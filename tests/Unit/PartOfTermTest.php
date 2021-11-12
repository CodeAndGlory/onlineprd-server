<?php

namespace Tests\Unit;

use App\Models\Offering;
use App\Models\PartOfTerm;
use App\Models\Term;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PartOfTermTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /**
     * Test the PartOfTerm->offerings method.
     *
     * @return void
     */
    public function testPartOfTermOfferingsMethod()
    {
        $part_of_term = factory(PartOfTerm::class)->create();
        $part_of_term->offerings()->save(factory(Offering::class)->create());

        $this->assertDatabaseHas('offerings', [
            'part_of_term_id' => $part_of_term->id,
        ]);
    }

    /**
     * Test the PartOfTerm->term method.
     *
     * @return void
     */
    public function testPartOfTermTermMethod()
    {
        $part_of_term = factory(PartOfTerm::class)->create();
        $term = factory(Term::class)->create();
        $part_of_term->term()->associate($term);
        $part_of_term->save();

        $this->assertDatabaseHas('parts_of_term', [
            'id' => $part_of_term->id,
            'term_id' => $term->id,
        ]);
    }
}
