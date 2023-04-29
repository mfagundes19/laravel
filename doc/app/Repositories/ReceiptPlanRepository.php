<?php

namespace App\Repositories;

use App\Repositories\Repository;
use Illuminate\Http\Request;

class ReceiptPlanRepository extends Repository
{
    public function __construct()
    {        
        $this->model = new \App\Models\ReceiptPlan();
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('receipt_plans.id','>','0');
        if(!empty($criteria['research_branch_id']))
        {
            $where[] = array('branch_id', $criteria['research_branch_id']);
        }
        if(!empty($criteria['research_operation_type_id']))
        {
            $where[] = array('operation_type_id', $criteria['research_operation_type_id']);
        }
        if(!empty($criteria['research_supplier_id']))
        {
            $where[] = array('supplier_id', $criteria['research_supplier_id']);
        }        
        if(!empty($criteria['research_user_id']))
        {
            $where[] = array('user_id', $criteria['research_user_id']);
        }        
        if(!empty($criteria['research_number_ra']))
        {
            $where[] = array('number_ra','ILIKE','%'.$criteria['research_number_ra'].'%');
        }
        if(!empty($criteria['research_nf_number']))
        {
            $where[] = array('nf_number','ILIKE','%'.$criteria['research_nf_number'].'%');
        }
        if(!empty($criteria['research_search']))
        {
            $where[] = array('responsible','ILIKE','%'.$criteria['research_search'].'%');
        }
        $columns = [
            'receipt_plans.id',
            'receipt_plans.date_start',
            'receipt_plans.date_expected',
            'receipt_plans.nf_number',
            'receipt_plans.number_oc',
            'users.name as user',
            'suppliers.name as supplier',
            'operation_types.name as operation'
        ];
        $query = $this->model->select($columns)
                    ->join('operation_types', 'receipt_plans.operation_type_id', '=', 'operation_types.id')
                    ->join('suppliers', 'receipt_plans.supplier_id', '=', 'suppliers.id')
                    ->join('users', 'receipt_plans.user_id', '=', 'users.id')
                    ->where($where)->paginate($limit);
        return $query;
    }

}//end class