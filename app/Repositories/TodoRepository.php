<?php 
namespace App\Repositories;

use App\Todo;
use App\Repositories\Repository;
use App\Repositories\RepositoryInterface;

class TodoRepository extends Repository implements RepositoryInterface {

    /**
     * TodoRepository constructor.
     * @param Todo $todo
     */
    public function __construct(Todo $todo)
    {
        $this->model = $todo;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
          $model =  $this->model->create($data);
          $model->refresh();
          return $model;
    }
}
