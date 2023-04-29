<?php

namespace App\Repositories;

use App\Repositories\Repository;

class RoleRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\Role();
    }

    public function insertPermission($model)
    {
        $model->save();
        return $model;
    }

    public function removePermission($role_id)
    {
        $RolePermission = new \App\Models\RolePermission(); 
        $list = $RolePermission->select('*')->where('role_id','=',$role_id)->get();
        foreach($list as $element)
        {
            $model = $RolePermission->find($element->id);
            if(!empty($model)) 
            {
                $model->delete();
            }
        }
    }

    public function loadPermission($role_id, $module_id)
    {
        $RolePermission = new \App\Models\RolePermission(); 
        $where = array();
        $where[] = array('module_id','=',$module_id);
        $where[] = array('role_id','=',$role_id); 
        return $RolePermission->select('*')->where($where)->first();
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('id','>','0');
        $where[] = array('active', true);
        if(!empty($criteria['research_search']))
        {
            $where[] = array('name','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = ['id','name'];
        return $this->model->select($columns)->where($where)->paginate($limit);
    }

}//end class