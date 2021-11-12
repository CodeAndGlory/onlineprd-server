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
class Assignment extends EloquentModel implements Model
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
        'offering_id' => 'bigInteger',
        'hours_worked' => 'integer',
        'stipend' => 'decimal',
        'minimum_enrollment' => 'integer',
        'accept_assignment' => 'integer',
        'accept_prorate' => 'integer',
        'confirmed' => 'timestamp',
        'verified' => 'timestamp',
        'stipend_verified' => 'timestamp',
        'edited' => 'timestamp',
        'approved' => 'timestamp',
        'notified' => 'timestamp',
        'superseded' => 'timestamp',
        'accepted' => 'timestamp',
        'prorate_accepted' => 'timestamp',
        'signature' => 'string',
        'signature_timestamp' => 'timestamp',
        'eclass_id' => 'integer',
    ];
    /**
     * @var array
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'user_id' => 'integer',
        'position_id' => 'integer',
        'offering_id' => 'bigInteger',
        'hours_worked' => 'integer',
        'stipend' => 'decimal',
        'minimum_enrollment' => 'integer',
        'accept_assignment' => 'integer',
        'accept_prorate' => 'integer',
        'confirmed' => 'timestamp',
        'verified' => 'timestamp',
        'stipend_verified' => 'timestamp',
        'edited' => 'timestamp',
        'approved' => 'timestamp',
        'notified' => 'timestamp',
        'superseded' => 'timestamp',
        'accepted' => 'timestamp',
        'prorate_accepted' => 'timestamp',
        'signature' => 'string',
        'signature_timestamp' => 'timestamp',
        'eclass_id' => 'integer',
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
     * @return BelongsTo
     */
    public function eclass(): BelongsTo
    {
        return $this->belongsTo(Eclass::class);
    }

    /**
     * Get the related offering.
     *
     * @return BelongsTo
     */
    public function offering(): BelongsTo
    {
        return $this->belongsTo(Offering::class);
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
     * @return MorphMany
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
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
     * @return BelongsToMany
     */
    public function letters(): BelongsToMany
    {
        return $this->belongsToMany(
            Letter::class,
            'assignments_letters',
            'assignment_id',
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
