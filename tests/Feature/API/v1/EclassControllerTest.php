<?php

namespace Tests\Feature\API\v1;

use App\Models\Eclass;

class EclassControllerTest extends ControllerTestCase
{
    protected string $class = Eclass::class;
    protected string $endpoint = 'eclasses';
    protected string $record = 'eclass';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Eclass();
    }
}
