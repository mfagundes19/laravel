<?php

namespace App\Repositories;

use App\Repositories\RepositoryInterface;

class Repository implements RepositoryInterface
{

    protected $model;

    public function __construct()
    {
        $this->model = null;
    }

    public function save($model)
    {
        $this->model = (!empty($model)) ? $model : null;
        $this->model->save();
        $model->save();
        //Log - Activity Log
        activity()
            ->performedOn($model)
            ->createdAt(now()->subDays(10))
            ->useLog('Log de Cadastro')
            ->withProperties($model->toArray())->log('Log de Cadastro - '.get_class($model));        
        return $model;
    }

    public function delete($model)
    {
        $this->model = (!empty($model)) ? $model : null;
        $this->model->delete();
        return $this->model;
    }

    public function deleteBy($model, array $criteria)
    {
        $list = $model->select('*')->where($criteria['field'],'=',$criteria['id'])->get();
        foreach($list as $element)
        {
            $e = $model->find($element->id);
            if(!empty($e)) 
            {
                $e->delete();
            }
        }
    }

    public function findOneBy(array $criteria)
    {
        $where = array();
        $where[] = $criteria;
        return $this->model->where($where)->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function findBy($criteria, $order, $limit = 0)
    {
        return $this->model->get();
    }

    public function findAll()
    {
        return $this->model->get();
    }

}