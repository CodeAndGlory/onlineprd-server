<?php

namespace App\Services;

use App\Models\Model;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * Class APIService
 * @package App\Services
 */
abstract class APIService
{
    /**
     * @var array
     */
    protected array $column_values = [];
    /**
     * @var int
     */
    protected int $count;
    /**
     * @var mixed
     */
    protected $error;
    /**
     * @var Model
     */
    protected Model $model;
    /**
     * @var array
     */
    protected array $pagination = [];
    /**
     * @var array
     */
    protected array $query_conditions = [];
    /**
     * @var array
     */
    protected array $request_values = [];
    /**
     * @var array
     */
    protected array $sort_order;
    /**
     * @var int
     */
    protected int $status;
    /**
     * @var array
     */
    protected array $validation_rules = [];
    /**
     * Relationships to include with the API response.
     * @var array
     */
    protected array $with = [];

    /**
     * APIService constructor.
     * @param  Request  $request
     * @throws Exception
     */
    public function __construct(Request $request)
    {
        $this->setError(false);
        $this->setStatus(200);
        $this->setRequestValues($request);
        try {
            $this->setColumnValues();
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }
        try {
            $this->setQueryConditions();
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }
        try {
            $this->setWith();
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }
        try {
            $this->setSortOrder();
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }
        try {
            $this->setPagination();
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }
    }

    /**
     * @param  Request  $request
     */
    public function setRequestValues(Request $request): void
    {
        $this->request_values = $request->all();
    }

    /**
     * @throws Exception
     */
    public function setColumnValues(): void
    {
        $this->column_values = [];
        $columns = [];
        $allowed_columns = $this->model->getAllowedColumns();

        foreach ($this->request_values as $key => $value) {
            $columns[Str::snake($key)] = $value;
        }

        foreach ($allowed_columns as $column_name => $column_type) {
            if (array_key_exists($column_name, $columns)) {
                if ('date' === $column_type) {
                    $this->column_values[$column_name] = Carbon::parse($columns[$column_name])
                        ->format('Y-m-d');
                } elseif ('timestamp' === $column_type) {
                    $this->column_values[$column_name] = ($columns[$column_name] === NULL) ? NULL : Carbon::parse($columns[$column_name]);
                } else {
                    $this->column_values[$column_name] = $columns[$column_name];
                }
            }
        }
    }

    /**
     * @throws Exception
     */
    public function setQueryConditions(): void
    {
        $this->query_conditions = [];

        foreach ($this->request_values as $key => $request_value) {
            $camel_key = Str::camel($key);
            $lower_key = Str::lower($key);
            if (
                'searchOn' !== $camel_key
                && 'sortBy' !== $camel_key
                && 'sortDirection' !== $camel_key
                && 'search' !== $lower_key
                && 'skip' !== $lower_key
                && 'take' !== $lower_key
                && !in_array($camel_key, get_class_methods($this->model), true)
                && !in_array(Str::snake($key), Schema::getColumnListing($this->model->getTable()), true)
            ) {
                throw new RuntimeException('Invalid column name: '.$key, 422);
            }
        }

        foreach ($this->model->getFilterableColumns() as $column_name => $type) {
            if (isset($this->request_values[$column_name])) {
                $this->query_conditions[] = [$column_name, $this->request_values[$column_name]];
            }
        }
    }

    /**
     * Get the values from the "with" query parameter and check that
     * they correspond to member method names.
     *
     * @throws Exception
     */
    public function setWith(): void
    {
        $methods = get_class_methods($this->model);
        $model_relationships = $this->model->getRelationships();

        if (isset($this->request_values['with'])) {
            $this->request_values['with'] = Str::camel($this->request_values['with']);
            $with_relations = explode(',', $this->request_values['with']);
            foreach ($with_relations as $with_relation) {
                $with_sub_relations = explode('.', $with_relation);

                if (
                    'all' !== $with_sub_relations[0]
                    && in_array($with_sub_relations[0], $methods, true)
                ) {
                    $this->with[] = $with_relation;
                } elseif ('all' === $with_sub_relations[0] && '' !== $model_relationships) {
                    $model_relationships_arr = explode(',', $model_relationships);
                    $this->with = [...$this->with, ...$model_relationships_arr];

                    $this->addTagsToAll($with_relations, $model_relationships_arr);
                } else {
                    throw new RuntimeException("Invalid relationship: $with_relations[0]", 422);
                }
            }
        }
    }

    /**
     * @param  array  $with_relations
     * @param  array  $relationships
     */
    public function addTagsToAll(array $with_relations, array $relationships): void
    {
        if (in_array('tags', $with_relations, true)) {
            foreach ($relationships as $all) {
                $with_tags = explode('.', $all);
                for ($i = count($with_tags) - 1; $i >= 0; $i--) {
                    $this->with[] = implode('.', array_merge($with_tags, ['tags']));
                    unset($with_tags[$i]);
                }
            }
        }
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param  mixed  $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param  Model  $model
     */
    public function setModel(Model $model): void
    {
        $this->model = $model;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param  int  $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @param  string  $relation
     * @return array|false|string[]
     */
    public function getRelationIDsFromRequest(string $relation)
    {
        if (array_key_exists($relation, $this->request_values)) {
            return explode(',', $this->request_values[$relation]);
        }

        return [];
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param  Model  $model
     */
    public function delete(Model $model): void
    {
        $model->delete();
    }

    /**
     * @return Collection|null
     */
    public function index(): ?Collection
    {
        $conditions = $this->query_conditions;
        $sort_order = $this->sort_order;
        $pagination = $this->pagination;
        $search_conditions = $this->getSearchConditions();

        $query = $this->model->where($conditions);

        if ([] !== $search_conditions) {
            $query->whereLike(...$search_conditions);
        }

        $this->count = $query->count();

        if ($sort_order['column']) {
            $query = $query->orderBy($sort_order['column'], $sort_order['direction']);
        }

        if ($pagination['skip'] !== false) {
            $query->skip($pagination['skip']);
        }

        if ($pagination['take']) {
            $query->take($pagination['take']);
        }

        if (isset($this->request_values['with'])) {
            $query->with($this->with);
        }

        if (false === $this->error) {
            return $query->get();
        }

        return null;
    }

    /**
     * Get the search string and columns from the request values.
     *
     * @return array [search_string, [search_columns]]
     */
    public function getSearchConditions(): array
    {
        $search_on = [];
        if (isset($this->request_values['search'])) {
            $search_terms = $this->request_values['search'];
            if (isset($this->request_values['search_on'])) {
                $search_on = explode(',', $this->request_values['search_on']);
            } elseif (isset($this->request_values['search-on'])) {
                $search_on = explode(',', $this->request_values['search-on']);
            }

            if ([] === $search_on) {
                $search_on = array_keys($this->model->getFilterableColumns());
            }

            return array($search_on, $search_terms);
        }

        return [];
    }

    /**
     * Get the requested model, including any related models from the "with" parameter.
     * @param  Model  $model
     * @return array|null
     */
    public function show(Model $model): ?array
    {
        if (false === $this->error) {
            $collection = $model->with($this->with)->where('id', $model->id)->get();

            return $collection[0]->toArray();
        }

        return null;
    }

    /**
     * @param  Request  $request
     * @return Model|null
     */
    public function store(Request $request): ?Model
    {
        try {
            $this->validate($request);
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }

        if (false === $this->error) {
            return $this->model->create($this->column_values);
        }

        return null;
    }

    /**
     * @param  Request  $request
     * @param  Model|null  $model
     * @throws Exception
     */
    public function validate(Request $request, Model $model = null): void
    {
        $rules = $this->getValidationRules($model);
        $validator = Validator::make($request->all(), $rules);

        $errors = $validator->errors();
        $messages = $errors->getMessages();
        if (count($messages) > 0) {
            foreach ($messages as $message) {
                throw new RuntimeException($message[0], 422);
            }
        }
    }

    /**
     * @param  Model  $model
     * @return array
     */
    public function getValidationRules(Model $model = null): array
    {
        return $this->model->getValidationRules($model);
    }

    /**
     * @param  Request  $request
     * @param  Model  $model
     * @return Model|null
     */
    public function update(Request $request, Model $model): ?Model
    {
        try {
            $this->validate($request, $model);
        } catch (Exception $e) {
            $this->error[$e->getCode()][] = $e->getMessage();
            $this->setStatus($e->getCode());
        }

        if (false === $this->error) {
            $model->update($this->column_values);

            return $model;
        }

        return null;
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function setSortOrder(): void
    {
        foreach ($this->request_values as $key => $value) {
            $kebab_key = Str::kebab(Str::camel($key));
            if ('sort-by' === $kebab_key) {
                $column = $value;
                if (isset($direction)) {
                    break;
                }
            } elseif ('sort-direction' === $kebab_key) {
                $direction = $value;
                if (isset($column)) {
                    break;
                }
            }
        }

        $sort_order = [
            'column' => false,
            'direction' => 'asc',
        ];

        $this->sort_order = $sort_order;

        if (isset($column)) {
            if (array_key_exists($column, $this->model->getAllowedColumns())) {
                $sort_order['column'] = $column;
            } else {
                throw new RuntimeException("Invalid sort-by column: $column", 422);
            }
        }

        if (isset($direction)) {
            if ('asc' === $direction || 'desc' === $direction) {
                $sort_order['direction'] = $direction;
            } else {
                throw new RuntimeException("Invalid sort-direction: $direction", 422);
            }
        }

        $this->sort_order = $sort_order;
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function setPagination(): void
    {
        $pagination = [
            'skip' => false,
            'take' => false,
        ];
        foreach ($pagination as $name => $value) {
            if (isset($this->request_values[$name])) {
                if (is_numeric($this->request_values[$name])) {
                    $pagination[$name] = (int) $this->request_values[$name];
                } else {
                    throw new RuntimeException("Invalid $name: $value is not numeric", 422);
                }
            }
        }

        $this->pagination = $pagination;
    }
}
