<?php 

namespace App\Repositories;

interface RepositoryInterface {

    public function create(array $data);

    public function update(array $data);

    public function find($id);

    public function findAll();

    public function delete();

}

