<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Validation\Rule;
use Venturecraft\Revisionable\RevisionableTrait;

class Term extends EloquentModel implements Model
{
    use RevisionableTrait, SoftDeletes;

    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var string[]
     */
    protected array $allowed_columns = [
        'start_date' => 'date',
        'end_date' => 'date',
        'name' => 'string',
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'name' => 'string',
    ];
    /**
     * @var string[]
     */
    protected array $validation_rules = [];
    /**
     * @var string[]
     */
    protected $relationships = '';

    /**
     * @return array
     */
    public function getAllowedColumns(): array
    {
        return $this->allowed_columns;
    }

    /**
     * @return array
     */
    public function getFilterableColumns(): array
    {
        return $this->filterable_columns;
    }

    /**
     * @param  Model  $model
     * @return string[]
     */
    public function getValidationRules(Model $model = null): array
    {
        if (null !== $model) {
            return [
                'name' => [
                    Rule::unique('terms')->ignore($model->id),
                ],
                'start_date' => 'date',
                'end_date' => 'date',
            ];
        }

        return [
            'name' => [
                'required',
                'unique:terms',
            ],
            'start_date' => 'date',
            'end_date' => 'date',
        ];
    }

    /**
     * @return string
     */
    public function getRelationships(): string
    {
        return $this->relationships;
    }

    /**
     * @return HasMany
     */
    public function partsOfTerm(): HasMany
    {
        return $this->hasMany(PartOfTerm::class);
    }

    /**
     * @return MorphMany
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }
}
