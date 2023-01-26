<?php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Throwable;

abstract class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * @param array|string $relations
     * @return Builder
     */
    protected function setBuilder(array|string $relations = [], array $conditions = []): Builder
    {
        return $conditions == [] ?
            $this->model->with($relations) :
            $this->model->with($relations)
                ->where(function ($builder) use ($conditions){
                    foreach ($conditions as $index => $condition) {
                        $builder->where($index, $condition);
                    }
                }) ;
    }

    /**
     * @param array|string $columns
     * @param array|string $relations
     * @return Collection
     */
    public function getAll(array|string $columns = ["*"], array|string $relations = [], array $conditions = []): Collection
    {
        return $this->setBuilder($relations, $conditions)->get($columns);
    }

    /**
     * @param int $modelId
     * @param array|string $columns
     * @param array|string $relations
     * @param array|string $appends
     * @return Model|null
     */
    public function findOrFail(int $modelId, array|string $columns = ["*"], array|string $relations = [], array|string $appends = []): ?Model
    {
        return $this->setBuilder($relations)->findOrFail($modelId, $columns)->append($appends);
    }

    /**
     * @param array $columns
     * @return Model|null
     */
    public function create(array $columns): ?Model
    {
        return $this->model->query()->create($columns);
    }

    /**
     * @param Model $model
     * @param array $columns
     * @return Model|null
     */
    public function update(Model $model, array $columns): ?Model
    {
        $model->update($columns);
        return $model;
    }

    /**
     * @param Model $model
     * @return bool
     * @throws Throwable
     */
    public function delete(Model $model): bool
    {
        return $model->deleteOrFail();
    }

    /**
     * @param array|string $columns
     * @param array|string $relations
     * @param int $paginate
     * @param string $pageName
     * @param int|null $page
     * @return LengthAwarePaginator
     */
    public function paginate(array|string $columns = ["*"], array|string $relations = [], int $paginate = 15, string $pageName = 'page', int|null $page = null, string $orderedColumn = null, string $direction = "asc", array $conditions = []): LengthAwarePaginator
    {
        $builder = $this->setBuilder($relations, $conditions);
        return !is_null($orderedColumn) ? $builder->orderBy($orderedColumn, $direction)->paginate($paginate, $columns, $pageName, $page) : $builder->paginate($paginate, $columns, $pageName, $page);
    }

    public function findByColumns(array $conditions, array|string $columns = ["*"], array|string $relations = [], array|string $appends = []): ?Model
    {
        return $this->setBuilder($relations, $conditions)->first($columns)?->append($appends);
    }
}
