<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Department
 * @package App\Models
 */
class Department extends EloquentModel implements Model
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
        'org_number' => 'string',
        'chair' => 'string',
        'name' => 'string',
        'abbreviation' => 'string',
        'department_building' => 'string',
        'department_office_number' => 'string',
        'department_phone_number' => 'integer',
        'contact_user_id' => 'integer',
        'college_id' => 'integer',
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'org_number' => 'string',
        'chair' => 'string',
        'name' => 'string',
        'abbreviation' => 'string',
        'department_building' => 'string',
        'department_office_number' => 'string',
        'department_phone_number' => 'integer',
    ];
    /**
     * @var array
     */
    protected array $validation_rules = [];
    /**
     * @var string
     */
    protected string $relationships = 'courses.offerings.assignments.user';

    /**
     * Return the college to which this department belongs.
     *
     * @return BelongsTo
     */
    public function college(): BelongsTo
    {
        return $this->belongsTo(FormFieldLookup::class);
    }

    /**
     * Return the user who is the primary contact for this department.
     *
     * @return BelongsTo
     */
    public function contactUser(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return all courses offered by this department.
     *
     * @return HasMany
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Return all non-course assignments offered by this department.
     *
     * @return HasMany
     */
    public function nonCourseAssignments(): HasMany
    {
        return $this->hasMany(NonCourseAssignment::class);
    }

    /**
     * @return MorphMany
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    /**
     * Return all users for this department.
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
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
