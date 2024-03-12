<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class RepositoryAbstract
{
    protected Model $model;
    protected mixed $with = [];
    protected string $order = 'id';
    protected string $orderDirection = 'desc';

    public function __construct()
    {
        $this->model = app($this->model());
    }

    abstract public function model();

    public function all()
    {
        return $this->model->query()->orderBy('id', 'desc')->with($this->with)->get();
    }

    public function paginate($limit = 25)
    {
        return $this->model->query()->orderBy($this->order, $this->orderDirection)->with($this->with)->paginate($limit);
    }

    public function paginateWithSearch($search, $limit=25)
    {
        return $this->model->query()->orderBy($this->order, $this->orderDirection)->with($this->with)->filter($search)->paginate($limit);
    }

    public function search($search)
    {
        return $this->model->query()->orderBy($this->order, $this->orderDirection)->with($this->with)->filter($search)->get();
    }

    public function getBy($col, $value)
    {
        return $this->model->query()->where($col, $value)->orderBy($this->order, $this->orderDirection)->with($this->with)->get();
    }

    public function paginateBy($col, $value, $limit=25)
    {
        return $this->model->query()->where($col, $value)->orderBy($this->order, $this->orderDirection)->with($this->with)->paginate($limit);
    }

    public function create(array $data)
    {
        return $this->model->query()->create($data);
    }

    public function updateOrCreate(array $attributes, array $values)
    {
        return $this->model->query()->updateOrCreate($attributes, $values);
    }

    public function find($id)
    {
        return $this->model->query()->with($this->with)->find($id);
    }

    public function first()
    {
        return $this->model->query()->with($this->with)->first();
    }

    public function latest()
    {
        return $this->model->query()->with($this->with)->latest()->first();
    }

    public function findMany($ids)
    {
        return $this->model->query()->with($this->with)->findMany($ids);
    }

    public function with($relations)
    {
        $this->with = $relations;
        return $this;
    }

    public function orderBy($field, $direction)
    {
        $this->order = $field;
        $this->orderDirection = $direction;
        return $this;
    }

    public function update(Model $model, array $data)
    {
        return $model->update($data);
    }

    public function delete($id)
    {
        return $this->model->query()->where('id', $id)->delete();
    }

    public function exists($id)
    {
        return $this->model->query()->where('id', $id)->exists();
    }
}
