<?php

namespace App\Repositories;

use App\Repositories\Repository;

class SupplierRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\Supplier();
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('id','>','0');
        $where[] = array('active', true);
        if(!empty($criteria['research_search'])) {
            $where[] = array('name','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = ['*'];
        return $this->model->select($columns)->where($where)->orderBy('name','asc')->paginate($limit);
    }

}//end class