<?php

namespace Tests\Unit;

use App\Models\PartOfTerm;
use App\Models\Term;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TermTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the Term->partsOfTerm method.
     *
     * @return void
     */
    public function testTermPartsOfTermMethod()
    {
        $term = factory(Term::class)->create();
        $term->partsOfTerm()->save(factory(PartOfTerm::class)->create());

        $this->assertDatabaseHas('parts_of_term', [
            'term_id' => $term->id,
        ]);
    }
}
