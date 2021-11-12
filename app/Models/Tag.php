<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Venturecraft\Revisionable\RevisionableTrait;

class Tag extends EloquentModel implements Model
{
    use RevisionableTrait;

    /**
     * @var array
     */
    protected $guarded = [];
    /**
     * @var string[]
     */
    protected array $allowed_columns = [
        'value' => 'string',
        'body' => 'string',
        'taggable_id' => 'integer',
        'taggable_type' => 'string',
        'user_id' => 'integer',
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'value' => 'string',
        'body' => 'string',
        'taggable_id' => 'integer',
        'taggable_type' => 'string',
        'user_id' => 'integer',
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
     * @return MorphTo
     */
    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(user::class);
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
