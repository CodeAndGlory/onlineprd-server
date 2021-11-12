<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Eclass
 * @package App\Models
 */
class Eclass extends EloquentModel implements Model
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
        'abbreviation' => 'string',
        'description' => 'string',
        'full_time' => 'boolean',
        'category' => 'string',
        'active' => 'boolean',
        'student' => 'string',
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'abbreviation' => 'string',
        'description' => 'string',
        'full_time' => 'boolean',
        'category' => 'string',
        'active' => 'boolean',
        'student' => 'string',
    ];
    /**
     * @var array
     */
    protected array $validation_rules = [];
    /**
     * @var string[]
     */
    protected $relationships = '';

    /**
     * @return HasMany
     */
    public function assignment(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * @return HasMany
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return MorphMany
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    /**
     * @return string[]
     */
    public function getAllowedColumns(): array
    {
        return $this->allowed_columns;
    }

    /**
     * @return string[]
     */
    public function getFilterableColumns(): array
    {
        return $this->filterable_columns;
    }

    /**
     * @param  Model  $model
     * @return array
     */
    public function getValidationRules(Model $model = null): array
    {
        return $this->validation_rules;
    }

    /**
     * @return string
     */
    public function getRelationships(): string
    {
        return $this->relationships;
    }
}
