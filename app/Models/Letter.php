<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class SentLetters
 * @package App\Models
 */
class Letter extends EloquentModel implements Model
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
        'user_id' => 'integer',
        'term_id' => 'integer',
        'body' => 'string',
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'user_id' => 'integer',
        'term_id' => 'integer',
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
     * Get the assigned user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(FormFieldLookup::class);
    }

    /**
     * @return BelongsToMany
     */
    public function assignments(): BelongsToMany
    {
        return $this->belongsToMany(
            Assignment::class,
            'assignments_letters',
            'letter_id',
            'assignment_id'
        );
    }

    /**
     * @return BelongsToMany
     */
    public function nonCourseAssignments(): BelongsToMany
    {
        return $this->belongsToMany(
            NonCourseAssignment::class,
            'non_course_assignments_letters',
            'letter_id',
            'non_course_assignment_id'
        );
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
     * @param  Model|null  $model
     *
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
