<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Validation\Rule;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Venturecraft\Revisionable\RevisionableTrait;

/**
 * Class User
 * @package App\Models
 */
class User extends Authenticatable implements Model
{
    use HasApiTokens, HasRoles, Notifiable, RevisionableTrait, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'spartan_id',
        'prefix_id',
        'avatar',
        'eclass_id',
        'verified'
    ];

    /**
     * @var string[]
     */
    protected $guarded = [
        'id',
        'provider_name',
        'provider_id',
        'email_verified_at',
        'created_at',
        'updated_at',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected array $allowed_columns = [
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'email',
        'password' => 'string',
        'spartan_id' => 'int',
        'prefix_id' => 'int',
        'avatar' => 'string',
        'eclass_id' => 'int',
        'verified' => 'int',
        'nullable' => [
            'first_name',
            'last_name',
            'password',
            'spartan_id',
            'prefix_id',
            'avatar',
            'eclass_id',
        ]
    ];
    /**
     * @var string[]
     */
    protected array $filterable_columns = [
        'id' => 'integer',
        'first_name' => 'string',
        'last_name' => 'string',
        'email' => 'email',
        'spartan_id' => 'int',
        'prefix_id' => 'int',
        'eclass_id' => 'int',
        'verified' => 'int'
    ];

    /**
     * @var string[]
     */
    protected array $validation_rules = [];

    /**
     * @var string[]
     */
    protected $relationships = 'assignments.offering.course.department';

    /**
     * @return HasMany
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * @return HasMany
     */
    public function nonCourseAssignments(): HasMany
    {
        return $this->hasMany(NonCourseAssignment::class);
    }

    /**
     * Get all of the comments made by this user.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get any departments that this user is the contact for.
     *
     * @return HasMany
     */
    public function contactFor(): HasMany
    {
        return $this->hasMany(Department::class, 'contact_user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class);
    }

    /**
     * @return BelongsTo
     */
    public function prefix(): BelongsTo
    {
        return $this->belongsTo(FormFieldLookup::class);
    }

    /**
     * @return BelongsTo
     */
    public function eclass(): BelongsTo
    {
        return $this->belongsTo(Eclass::class);
    }

    /**
     * @return MorphMany
     */
    public function tags(): MorphMany
    {
        return $this->morphMany(Tag::class, 'taggable');
    }

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
     * @return array
     */
    public function getValidationRules(Model $model = null): array
    {
        return $this->validation_rules;
    }

    public function setValidationRules(): void
    {
        $this->validation_rules = [
            'first_name' => 'max:120',
            'last_name' => 'max:120',
            'email' => [
                'email',
                Rule::unique('users')->ignore($this->id),
            ],
        ];
    }

    /**
     * @return string
     */
    public function getRelationships(): string
    {
        return $this->relationships;
    }
}
