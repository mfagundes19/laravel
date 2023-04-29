<?php

namespace App\Repositories;

use App\Repositories\Repository;

class ReceivementRepository extends Repository
{
    public function __construct()
    {
        $this->model = new \App\Models\Receivement();
    }

    public function findBy($criteria, $order, $limit = 0, $offset = 0)
    {
        $where = array();
        $where[] = array('receivements.id','>','0');
        if(!empty($criteria['research_receipt_plan_id']))
        {
            $where[] = array('receivements.receipt_plan_id', $criteria['research_receipt_plan_id']);
        }   
        if(!empty($criteria['research_fiscal_status_id']))
        {
            $where[] = array('receivements.fiscal_status_id', $criteria['research_fiscal_status_id']);
        }   
        if(!empty($criteria['receivements.research_segregation_status_id']))
        {
            $where[] = array('segregation_status_id', $criteria['research_segregation_status_id']);
        }
        if(!empty($criteria['research_segregator_id']))
        {
            $where[] = array('receivements.segregator_id', $criteria['research_segregator_id']);
        }
        if(!empty($criteria['research_user_id']))
        {
            $where[] = array('receivements.user_id', $criteria['research_user_id']);
        }        
        if(!empty($criteria['research_branch_id']))
        {
            $where[] = array('receipt_plans.branch_id', $criteria['research_branch_id']);
        }
        if(!empty($criteria['research_operation_type_id']))
        {
            $where[] = array('receipt_plans.operation_type_id', $criteria['research_operation_type_id']);
        }
        if(!empty($criteria['research_supplier_id']))
        {
            $where[] = array('receipt_plans.supplier_id', $criteria['research_supplier_id']);
        }        
        if(!empty($criteria['research_search']))
        {
            $where[] = array('responsible','ILIKE','%'.$criteria['research_search'].'%');
        }

        // $columns = [
        //     'receivements.id',
        //     'receipt_plans.number_ra',
        //     'users.name as user',
        //     'reveivements.date_receivement',
        //     'fiscal_status.name as fiscal_status',
        //     'segregation_status.name as segregation_status'
        // ];
        $columns = [
            'receivements.id',
            'receipt_plans.number_ra',
            'users.name as user',
            'receivements.date_receivement',
            'receivements.cargo_addressing',
            'fiscal_status.name as fiscal_status',
            'segregation_status.name as segregation_status',
            'segregators.name as segregator',
        ];
        $query = $this->model->select($columns)
                ->join('receipt_plans', 'receivements.receipt_plan_id', '=', 'receipt_plans.id')
                ->join('segregation_status', 'receivements.segregation_status_id', '=', 'segregation_status.id')
                ->join('fiscal_status', 'receivements.fiscal_status_id', '=', 'fiscal_status.id')
                ->join('users', 'receivements.user_id', '=', 'users.id')
                ->join('segregators', 'receivements.segregator_id', '=', 'segregators.id')
                ->where($where)->paginate($limit);
        return $query;
    }

}//end class