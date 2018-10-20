<?php 
namespace App\Repositories;

use App\Repositories\Repository;
use App\Repositories\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class TodoRepository extends Repository implements RepositoryInterface {
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
