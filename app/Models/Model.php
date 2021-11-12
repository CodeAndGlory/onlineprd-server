<?php

namespace App\Models;

/**
 * Interface Model
 * @package App\Models
 */
interface Model
{
    /**
     * @param  Model  $model
     * @return string[]
     */
    public function getValidationRules(Model $model = null): array;

    /**
     * @return string[]
     */
    public function getAllowedColumns(): array;

    /**
     * @return string[]
     */
    public function getFilterableColumns(): array;

    /**
     * @return string
     */
    public function getRelationships(): string;

    /**
     * @return mixed
     */
    public function delete();

    /**
     * @param  array  $column_values
     * @return mixed
     */
    public function update(array $column_values);
}
