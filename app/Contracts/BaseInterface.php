<?php

namespace App\Contracts;

interface BaseInterface
{

    /**
     * @param $entityId
     * @param array $columns
     *
     *  @return Model
     */
    public function find($entityId, array $columns = ['*']);

    /**
     * @param int $entityId
     * @param array $columns
     *
     *@return Model
     *@throws ModelNotFoundException
     *
     */
    public function findOrFail(string $entityId, array $columns = ['*']);

    /**
     * @param int $limit
     * @param array $criteria
     *
     * @return LengthAwarePaginator
     */
    public function paginate(int $limit = 10, array $criteria = []);

    /**
     * @param int $limit
     * @param array $criteria
     *
     * @return Paginator
     */
    public function simplePaginate(int $limit = 10, array $criteria = []);

    /**
     * @param array $criteria
     * @param array $columns
     *
     * @return LengthAwarePaginator
     */
    public function get(array $criteria = [], array $columns = []);

    /**
     * @param array $data
     *
     * @return Model
     */
    public function create(array $data = []);


}
