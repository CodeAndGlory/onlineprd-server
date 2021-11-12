<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class FormFieldLookup
 * @package App\Models
 */
class FormFieldLookup extends EloquentModel implements Model
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
        'field' => 'string',
        'name' => 'string',
        'abbreviation' => 'string',
        'active' => 'int',
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'name' => 'string',
        'field' => 'string',
        'abbreviation' => 'string',
        'active' => 'int',
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
    public function assignmentsByPosition(): HasMany
    {
        return $this->hasMany(Assignment::class, 'position_id');
    }

    /**
     * @return HasMany
     */
    public function coursesBySubject(): HasMany
    {
        return $this->hasMany(Course::class, 'subject_id');
    }

    /**
     * @return HasMany
     */
    public function departmentsByCollege(): HasMany
    {
        return $this->hasMany(Department::class, 'college_id');
    }

    /**
     * @return HasMany
     */
    public function usersByPrefix(): HasMany
    {
        return $this->hasMany(User::class, 'prefix_id');
    }

    /**
     * @return HasMany
     */
    public function offeringsByCampus(): HasMany
    {
        return $this->hasMany(Offering::class, 'campus_id');
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
