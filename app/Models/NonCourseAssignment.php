<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Assignment
 * @package App\Models
 */
class NonCourseAssignment extends EloquentModel implements Model
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
        'position_id' => 'integer',
        'campus_id' => 'integer',
        'department_id' => 'integer',
        'eclass_id' => 'bigInteger',
        'term_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'hours_worked' => 'integer',
        'stipend' => 'decimal',
//        'accept_assignment' => 'integer',
        'confirmed' => 'timestamp',
        'verified' => 'timestamp',
        'stipend_verified' => 'timestamp',
        'edited' => 'timestamp',
        'approved' => 'timestamp',
        'notified' => 'timestamp',
        'superseded' => 'timestamp',
        'accepted' => 'timestamp',
        'signature' => 'string',
        'signature_timestamp' => 'timestamp',
    ];
    /**
     * @var array
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'user_id' => 'integer',
        'position_id' => 'integer',
        'campus_id' => 'integer',
        'department_id' => 'integer',
        'eclass_id' => 'bigInteger',
        'term_id' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'hours_worked' => 'integer',
        'stipend' => 'decimal',
//        'accept_assignment' => 'integer',
        'confirmed' => 'timestamp',
        'verified' => 'timestamp',
        'stipend_verified' => 'timestamp',
        'edited' => 'timestamp',
        'approved' => 'timestamp',
        'notified' => 'timestamp',
        'superseded' => 'timestamp',
        'accepted' => 'timestamp',
        'signature' => 'string',
        'signature_timestamp' => 'timestamp',
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
     * Get all of the assignment's comments.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

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
     * Get the position of the assignment.
     *
     * @return BelongsTo
     */
    public function position(): BelongsTo
    {
        return $this->belongsTo(FormFieldLookup::class);
    }

    /**
     * @return BelongsTo
     */
    public function campus(): BelongsTo
    {
        return $this->belongsTo(FormFieldLookup::class);
    }

    /**
     * @return BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return BelongsTo
     */
    public function eclass(): BelongsTo
    {
        return $this->belongsTo(Eclass::class);
    }

    /**
     * @return BelongsTo
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * @return MorphMany
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    /**
     * @return BelongsToMany
     */
    public function letters(): BelongsToMany
    {
        return $this->belongsToMany(Letter::class,
            'non_course_assignments_letters',
            'non_course_assignment_id',
            'letter_id'
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
     * @return array
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
