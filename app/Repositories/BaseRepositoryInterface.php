<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

interface BaseRepositoryInterface
{
    /**
     * Get all records from the given model
     * @param array|string $columns
     * @param array|string $relations
     * @param array $conditions
     * @return Collection
     */
    public function getAll(array|string $columns = ["*"], array|string $relations = [], array $conditions = []): Collection;

    /**
     * Find a model record from database or returns 404
     * @param int $modelId
     * @param array|string $columns
     * @param array|string $relations
     * @param array|string $appends
     * @return Model|null
     */
    public function findOrFail(
        int          $modelId,
        array|string $columns = ["*"],
        array|string $relations = [],
        array|string $appends = []
    ): ?Model;

    /**
     * Store a new record to given database
     * @param array $columns
     * @return Model|null
     */
    public function create(array $columns): ?Model;

    /**
     * Updates a record from database
     * @param Model $model
     * @param array $columns
     * @return Model|null
     */
    public function update(Model $model, array $columns): ?Model;

    /**
     * Deletes the given model data or returns 404
     * @param Model $model
     * @return bool
     * @throws Throwable
     */
    public function delete(Model $model): bool;

    /**
     * @param array|string $columns
     * @param array|string $relations
     * @param int $paginate
     * @param string $pageName
     * @param int|null $page
     * @param string|null $orderedColumn
     * @param string $direction
     * @param array $conditions
     * @return LengthAwarePaginator
     */
    public function paginate(
        array|string $columns = ["*"],
        array|string $relations = [],
        int          $paginate = 15,
        string       $pageName = 'page',
        int|null     $page = null,
        string $orderedColumn = null,
        string $direction = "asc",
        array $conditions = []
    ): LengthAwarePaginator;

    /**
     * @param array $conditions
     * @param array|string $columns
     * @param array|string $relations
     * @param array|string $appends
     * @return Model|null
     */
    public function findByColumns(
        array $conditions,
        array|string $columns = ["*"],
        array|string $relations = [],
        array|string $appends = []
    ): ?Model;
}
