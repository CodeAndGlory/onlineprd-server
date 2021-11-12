<?php

namespace Tests\Feature\API\v1;

use App\Models\PartOfTerm;

class PartOfTermControllerTest extends ControllerTestCase
{
    protected string $class = PartOfTerm::class;
    protected string $endpoint = 'parts-of-term';
    protected string $table = 'parts_of_term';
    protected string $record = 'part_of_term';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new PartOfTerm();
    }
}
