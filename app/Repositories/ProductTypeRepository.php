<?php

namespace App\Repositories;

use App\Repositories\Repository;

class ProductTypeRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\ProductType();
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('product_type.id','>','0');
        $where[] = array('product_type.active', true);
        if(!empty($criteria['research_search'])) {
            $where[] = array('product_type.name','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = ['product_type.id','product_type.name','product_category.name as family'];
        $query = $this->model->select($columns)->join('product_category', 'product_type.category_id', '=', 'product_category.id')->where($where)->paginate($limit);
        return $query;
    }

}//end class