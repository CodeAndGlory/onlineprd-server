<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;

class PartOfTerm extends EloquentModel implements Model
{
    use RevisionableTrait, SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'parts_of_term';
    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var string[]
     */
    protected array $allowed_columns = [
        'name' => 'string',
        'term_id' => 'int',
        'start_date' => 'date',
        'end_date' => 'date',
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'name' => 'string',
        'term_id' => 'int',
        'start_date' => 'date',
        'end_date' => 'date',
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
    public function offerings(): HasMany
    {
        return $this->hasMany(Offering::class);
    }

    /**
     * @return MorphMany
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

    /**
     * @return BelongsTo
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
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
