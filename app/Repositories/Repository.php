<?php 

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

class Repository implements RepositoryInterface {
    protected $model;

    /**
     * constructor
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param array $data
     * @return boolean
     */
    public function update(array $data) {
        return $this->model->update($data);
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function find($id) {
        return $this->model->find($id);
    }

    /**
     * @return mixed
     */
    public function findAll() {
        return $this->model->all();
    }

    /**
     * @return boolean
     */
    public function delete() {
        return $this->model->delete();
    }
}
