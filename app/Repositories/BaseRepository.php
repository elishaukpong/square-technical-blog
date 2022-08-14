<?php

namespace App\Repositories;

use App\Contracts\BaseInterface;
use Illuminate\Container\Container as App;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

abstract class BaseRepository implements BaseInterface
{
    protected $with = [];

    /**
     * @var App
     */
    protected $app;

    /** @var string */
    protected $order = null;

    protected $direction = 'desc';

    /**
     * @var Model
     */
    protected $model;

    /**
     * @param App $app
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    protected function makeModel()
    {
        $this->model = $this->app->make($this->getModelClass());
    }

    /**
     * @return string
     */
    abstract protected function getModelClass(): string;

    /**
     * @param int $limit
     * @param array $criteria
     *
     * @return Paginator
     */
    public function simplePaginate($limit = 10, $criteria = [])
    {
        return $this->filter($criteria)->simplePaginate($limit);
    }

    /**
     * @return Builder
     */
    public function builder()
    {
        return $this->model->query();
    }

    /**
     * @param array $criteria
     *
     * @return Builder
     */
    public function filter($criteria = [])
    {
        $criteria = $this->order($criteria);

        /** @var Model $latest */
        $latest = $this->model->with($this->with);
        if ('' != $this->order) {
            $latest->orderBy($this->order, $this->direction);
        }

        if (isset($criteria['search'])) {
            foreach ($this->model->searchable as $method => $columns) {
                if (method_exists($this->model, $method)) {
                    $latest->orWhereHas($method, function ($query) use ($criteria, $columns) {
                        /* @var $query Builder */
                        $query->where(function ($query2) use ($criteria, $columns) {
                            /* @var $query2 Builder */
                            foreach ((array)$columns as $column) {
                                $query2->orWhere($column, 'like', '%' . $criteria['search'] . '%');
                            }
                        });
                    });
                } else {
                    $latest->orWhere($columns, 'like', '%' . $criteria['search'] . '%');
                }
            }
        }
        unset($criteria['search']);

        return $latest->where($criteria);
    }

    /**
     * prepare order for query.
     *
     * @param array $criteria
     *
     * @return array
     */
    private function order($criteria = [])
    {
        if (isset($criteria['order'])) {
            $this->order = $criteria['order'];
            unset($criteria['order']);
        }

        if (isset($criteria['direction'])) {
            $this->direction = $criteria['direction'];
            unset($criteria['direction']);
        }
        unset($criteria['page']);

        return $criteria;
    }

    /**
     * @param int $limit
     * @param array $criteria
     *
     * @return LengthAwarePaginator
     */
    public function paginate($limit = 10, $criteria = [])
    {
        return $this->filter($criteria)->paginate($limit);
    }

    /**
     * @param array $criteria
     *
     * @param array $columns
     * @return Builder[]|Collection
     */
    public function get($criteria = [], $columns = ['*'])
    {
        return $this->filter($criteria)->get($columns);
    }

    /**
     * @param $entityId
     * @param array $columns
     *
     * @return Model|Model
     */
    public function find($entityId = 0, $columns = ['*'])
    {

        $entity = $this->model->with($this->with)->find($entityId, $columns);


        return $entity;
    }

    /**
     * @param $entityId
     * @param array $columns
     *
     * @return Model|Model
     * @throws ModelNotFoundException
     *
     */
    public function findOrFail($entityId = 0, $columns = ['*'])
    {
        return  $this->model->with($this->with)->findOrFail($entityId, $columns);
    }

    /**
     * @param $haystack
     * @param $needle
     *
     * @return Model[]|Model[]|Collection
     */
    public function search($haystack, $needle)
    {
        return $this->model->where($haystack, 'like', $needle)->get();
    }

    /**
     * @param array $attributes
     *
     * @return Model|Model
     */
    public function create($attributes = [])
    {
        return $this->model->create($attributes);
    }

}
