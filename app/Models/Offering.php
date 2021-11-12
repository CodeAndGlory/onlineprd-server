<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class Offering
 * @package App\Models
 */
class Offering extends EloquentModel implements Model
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
        'course_id' => 'integer',
        'title' => 'string',
        'wi' => 'integer',
        'si' => 'integer',
        'meeting_days' => 'string',
        'type_id' => 'integer',
        'start_end_times_id' => 'integer',
        'crn' => 'integer',
        'part_of_term_id' => 'integer',
        'campus_id' => 'integer',
        'section' => 'string',
        'maximum_enrollment' => 'integer',
        'actual_enrollment' => 'integer',
        'note' => 'string',
        'confirmed' => 'timestamp',
        'verified' => 'timestamp',
        'edited' => 'timestamp',
        'start_date' => 'timestamp',
        'end_date' => 'timestamp',
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'title' => 'string',
        'wi' => 'integer',
        'si' => 'integer',
        'meeting_days' => 'string',
        'type_id' => 'integer',
        'start_end_times_id' => 'integer',
        'course_id' => 'bigInteger',
        'crn' => 'integer',
        'part_of_term_id' => 'integer',
        'campus_id' => 'integer',
        'section' => 'string',
        'confirmed' => 'timestamp',
        'verified' => 'timestamp',
        'edited' => 'timestamp',
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
     * Get all of the offering's comments.
     *
     * @return MorphMany
     */
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return HasMany
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
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
    public function courseType(): BelongsTo
    {
        return $this->belongsTo(FormFieldLookup::class);
    }

    /**
     * @return BelongsTo
     */
    public function startEndTimes(): BelongsTo
    {
        return $this->belongsTo(FormFieldLookup::class);
    }

    /**
     * @return BelongsTo
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * @return BelongsTo
     */
    public function partOfTerm(): BelongsTo
    {
        return $this->belongsTo(PartOfTerm::class);
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
