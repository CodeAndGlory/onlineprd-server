<?php

namespace Tests\Feature\API\v1;

use App\Http\Middleware\Authenticate;
use App\Models\FormFieldLookup;
use App\Models\Model;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Testing\TestResponse as Response;
use Tests\TestCase;

/**
 * Class ControllerTestCase
 * @package Tests\Feature\API\v1
 */
abstract class ControllerTestCase extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    protected string $class;

    /**
     * @var Model
     */
    protected Model $model;

    /**
     * @var string
     */
    protected string $endpoint;

    /**
     * @var string
     */
    protected string $table;

    /**
     * Singular of $table.
     *
     * @var string
     */
    protected string $record;

    /**
     * @var string
     */
    protected string $filter_on;

    /**
     * @var string
     */
    protected string $filter_value;

    /**
     * @var string
     */
    protected string $base_path = 'api/v1/';

    /**
     * @var int
     */
    protected int $num_test_instances = 3;

    /**
     * @var array
     */
    protected array $test_instances = [];

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // Run tests without authentication.
        $this->withoutMiddleware([
            Authenticate::class
        ]);

        // Table name matches endpoint by default.
        if (!isset($this->table)) {
            $this->table = $this->endpoint;
        }

        // Record is the singular of table
        if (!isset($this->record)) {
            $this->record = substr($this->table, 0, -1);
        }

        // Create array of instances to use for testing without saving to db.
        for ($i = 0; $i < $this->num_test_instances; $i++) {
            $this->test_instances[$i] = factory($this->class)->make();
        }
    }

    public function testIndex(): void
    {
        foreach ($this->test_instances as $instance) {
            $instance->save();
        }

        $response = $this->call('GET', $this->base_path.$this->endpoint);

        $response->assertJson([
            'error' => false
        ]);
        $response->assertJsonCount($this->num_test_instances, $this->table);
        $response->assertJsonPath('count', $this->num_test_instances);

        for ($i = 0; $i < $this->num_test_instances; $i++) {
            // path = 'endpoint.index.id'
            $response->assertJsonPath("$this->table.$i.id", $this->test_instances[$i]->id);
        }
        $response->assertStatus(200);
    }

    public function testIndexSort(): void
    {
        foreach ($this->test_instances as $instance) {
            $instance->save();
        }

        $sort_by = array_key_first($this->model->getAllowedColumns());
        $sort_direction = 'desc';

        $params = [
            'sort_by' => $sort_by,
            'sort_direction' => $sort_direction,
        ];

        $sorted = DB::table($this->table)
            ->orderBy($sort_by, $sort_direction)
            ->get();

        $response = $this->call('GET', $this->base_path.$this->endpoint, $params);

        $response->assertJson([
            'error' => false
        ])
            ->assertJsonCount($this->num_test_instances, $this->table)
            ->assertJsonPath("$this->table.0.$sort_by", $sorted->get(0)->$sort_by)
            ->assertStatus(200);
    }

    public function testSortInvalidColumn(): void
    {
        foreach ($this->test_instances as $instance) {
            $instance->save();
        }

        $sort_by = 'not a column';

        $params = [
            'sort_by' => $sort_by,
            'sort_direction' => 'desc',
        ];

        $response = $this->call('GET', $this->base_path.$this->endpoint, $params);

        $response->assertJson([
            'error' => [
                '422' => [
                    "Invalid sort-by column: $sort_by"
                ]
            ]
        ]);
        $response->assertStatus(422);
    }

    public function testStore(): void
    {
        $attributes = $this->test_instances[0]->toArray();

        $response = $this->call('POST', $this->base_path.$this->endpoint, $attributes);

        $response->assertJson([
            'error' => false,
        ]);

        $this->compareColumns($response);
        $response->assertStatus(200);
    }

    public function testShow(): void
    {
        $instance = $this->test_instances[0];
        $instance->save();

        $response = $this->call('GET', $this->base_path.$this->endpoint."/$instance->id");

        $response->assertJson([
            'error' => false,
        ]);
        $this->compareColumns($response);
        $response->assertStatus(200);
    }

    public function testUpdate(): void
    {
        $instance = $this->test_instances[0];
        $instance->save();
        $update = $instance->toArray();
        $columns = $this->model->getAllowedColumns();

        if (isset($columns)) {
            $column = null;
            $column_type = null;
            foreach ($columns as $key => $value) {
                if (!is_array($columns[$key]) && strpos($key, '_id') === false) {
                    $column = $key;
                    $column_type = $value;

                    if ('string' === $column_type) {
                        $update[$column] = 'pre';
                        $instance->update($update);
                        $update[$column] = 'post';
                    } elseif ('email' === $column_type) {
                        $update[$column] = 'test1@example.com';
                        $instance->update($update);
                        $update[$column] = 'test2@example.com';
                    } elseif ('int' === $column_type || 'integer' === $column_type) {
                        $update[$column] = 12345;
                        $instance->update($update);
                        $update[$column] = 54321;
                    } elseif ('decimal' === $column_type) {
                        $update[$column] = 1.1;
                        $instance->update($update);
                        $update[$column] = 1.5;
                    } elseif ('date' === $column_type) {
                        $update[$column] = '01-01-2020';
                        $instance->update($update);
                        try {
                            $update[$column] = Carbon::parse('01-01-2021')->format('Y-m-d');
                        } catch (Exception $e) {
                            $update[$column] = [$e->getMessage()];
                        }
                    } elseif ('timestamp' === $column_type) {
                        $update[$column] = '1/1/2020';
                        $instance->update($update);
                        try {
                            $update[$column] = Carbon::parse('01-01-2021')
                                ->toIso8601ZuluString('microsecond');
                        } catch (Exception $e) {
                            $update[$column] = [$e->getMessage()];
                        }
                    } elseif ('boolean' === $column_type) {
                        $update[$column] = true;
                        $instance->update($update);
                        $update[$column] = false;
                    } else {
                        $this->output('Unsupported column type: '.$column_type);
                        $this->assertTrue(false);
                    }
                }
            }

            if (isset($update[$column])) {


                $class_methods = get_class_methods($this->model);
                $prefix = false;

                if (in_array('prefix', $class_methods, true)) {
                    $prefix = factory(FormFieldLookup::class)->create();
                    $update['prefix_id'] = $prefix->id;
                }

                $response = $this->call('PUT', $this->base_path.$this->endpoint."/$instance->id", $update);

                $response->assertJson([
                    'error' => false,
                ]);

                if (false !== $prefix) {
                    $this->assertDatabaseHas('users', [
                        'prefix_id' => $prefix->id,
                    ]);
                }

                $response->assertJsonPath("$this->record.$column", $update[$column]);
                $response->assertStatus(200);

                if (isset($this->model->getAllowedColumns()['nullable'][$column])) {
                    $update[$column] = '';
                    $response = $this->call('PUT', $this->base_path.$this->endpoint."/$instance->id", $update);

                    $response->assertJsonPath("$this->record.$column", null);
                }
            } else {
                $this->assertTrue(true);
            }

        } else {
            $this->assertTrue(false, 'No allowed columns set.');
        }
    }

    public function output($output): void
    {
        fwrite(STDERR, print_r($output, true));
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
            'deleted_at' => null,
        ]);
        $response->assertStatus(204);
    }

    public function testSearch(): void
    {
        foreach ($this->test_instances as $test_instance) {
            $test_instance->save();
        }
        $instance = $this->test_instances[0];

        $response = $this->call(
            'GET',
            $this->base_path.$this->endpoint,
            [
                'search-on' => 'id',
                'search' => $instance->id,
            ]
        );

        $response->assertJsonPath("$this->table.0.id", $instance->id);
    }

    protected function compareColumns(Response $response): void
    {
        $attributes = $this->test_instances[0]->toArray();

        foreach ($this->model->getAllowedColumns() as $column_name => $type) {
            if (isset($attributes[$column_name])) {
                if ('date' === $type) {
                    try {
                        $responseDate = Carbon::create($response->json("$this->record.$column_name"));
                    } catch (Exception $e) {
                        $responseDate = ['error' => $e->getMessage()];
                    }
                    $this->assertEquals($responseDate->toDateString(), $attributes[$column_name]->toDateString());
                } elseif ('int' === $type || 'integer' === $type) {
                    $this->assertSame(
                        $attributes[$column_name],
                        (int) $response->json("$this->record.$column_name")
                    );
                } elseif ('decimal' === $type) {
                    $this->assertSame(
                        $attributes[$column_name],
                        (float) $response->json("$this->record.$column_name")
                    );
                } elseif ('string' === $type) {
                    $this->assertSame(
                        (string) $attributes[$column_name],
                        $response->json("$this->record.$column_name")
                    );
                } else {
                    $response->assertJsonPath(
                        "$this->record.$column_name",
                        $attributes[$column_name]
                    );
                }
            }
        }
    }
}
