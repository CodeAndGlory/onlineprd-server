<?php

namespace Tests\Feature\API\v1;

use App\Models\Offering;

class OfferingControllerTest extends ControllerTestCase
{
    protected string $class = Offering::class;
    protected string $endpoint = 'offerings';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Offering();
    }

    public function testTimeStampNull()
    {
        $id = 1;
        $instance = $this->test_instances[0];
        $instance->id = $id;
        $instance->save();

        $response = $this->call(
            'PUT',
            $this->base_path.$this->endpoint.'/'.$id,
            ['confirmed' => null]
        );

        $response
            ->assertJson([
                'offering' => ['confirmed' => null],
            ]);

//        $response = $this->call(
//            'PUT',
//            $this->base_path.$this->endpoint.'/'.$id,
//            ['confirmed' => '2020-10-13 00:00:00']
//        );
//
//        $response
//            ->assertJson([
//                'offering' => ['confirmed' => '2020-10-13 00:00:00'],
//            ]);
    }
}
