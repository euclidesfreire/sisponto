<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository 
{
	protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    // public function create(array $data)
    // {
    //     return $this->model->create($data);
    // }

    // public function update(array $data, $id, $attribute = null)
    // {
    //     if (is_null($attribute)) {
    //         $attribute = $this->model->getKeyName();
    //     }
    //     $updated = 0;
    //     $collection = $this->model->where($attribute, '=', $id)->get();
    //     if ($collection) {
    //         foreach ($collection as $obj) {
    //             $obj->fill($data)->save();
    //         }
    //         $updated = $collection->count();
    //     }
    //     return $updated;
    // }

    public function all()
    {
        return $this->model->all();
    }

    public function lists($identifier, $field)
    {
        return $this->model->pluck($field, $identifier);
    }
}