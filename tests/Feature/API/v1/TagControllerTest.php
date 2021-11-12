<?php

namespace Tests\Feature\API\v1;

use App\Models\Tag;

class TagControllerTest extends ControllerTestCase
{
    protected string $class = Tag::class;
    protected string $endpoint = 'tags';

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new Tag();
    }

    /**
     * Test the delete endpoint for the resource.
     *
     * @return void
     */
    public function testDestroy(): void
    {
        $instance = $this->test_instances[0];
        $instance->save();

        $response = $this->call(
            'DELETE',
            $this->base_path.$this->endpoint."/".$this->test_instances[0]->id
        );

        $this->assertDatabaseMissing($this->table, [
            'id' => $instance->id,
        ]);
        $response->assertStatus(204);
    }
}
