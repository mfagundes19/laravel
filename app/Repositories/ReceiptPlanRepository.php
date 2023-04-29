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
        $where[] = array('receipt_plan.id','>','0');
        $where[] = array('receipt_plan.active', true);
        if(!empty($criteria['research_branch_id'])) {
            $where[] = array('branch_id', $criteria['research_branch_id']);
        }
        if(!empty($criteria['research_operation_type_id'])) {
            $where[] = array('operation_type_id', $criteria['research_operation_type_id']);
        }
        if(!empty($criteria['research_supplier_id'])) {
            $where[] = array('supplier_id', $criteria['research_supplier_id']);
        }        
        if(!empty($criteria['research_user_id'])) {
            $where[] = array('user_id', $criteria['research_user_id']);
        }        
        if(!empty($criteria['research_shipping_company_id'])) {
            $where[] = array('shipping_company_id', $criteria['research_shipping_company_id']);
        } 
        if(!empty($criteria['research_payment_method_id'])) {
            $where[] = array('payment_method_id', $criteria['research_payment_method_id']);
        } 
        if(!empty($criteria['research_shipping'])) {
            $where[] = array('shipping', $criteria['research_shipping']);
        } 
        if(!empty($criteria['research_nf_number'])) {
            $where[] = array('nf_number','ILIKE','%'.$criteria['research_nf_number'].'%');
        }
        $columns = [
            'receipt_plan.id',
            'receipt_plan.date_start',
            'receipt_plan.date_expected',
            'receipt_plan.nf_number',
            'receipt_plan.oc_number',
            'shipping_company.name as shipping_company',
            'supplier.name as supplier',
            'supplier.name as supplier',
            'operation_type.name as operation',
            'receipt_plan.payment_comment',
            'receipt_plan.receipt_status',
            'receipt_plan.total_traded',
            'receipt_plan.total_quantity'
        ];
        $query = $this->model->select($columns)
                    ->join('operation_type', 'receipt_plan.operation_type_id', '=', 'operation_type.id')
                    ->join('supplier', 'receipt_plan.supplier_id', '=', 'supplier.id')
                    ->join('shipping_company', 'receipt_plan.shipping_company_id', '=', 'shipping_company.id')
                    ->where($where)
                    ->orderBy('id','desc')
                    ->paginate($limit);
        return $query;
    }

    public function findNotify($criteria) 
    {
        $ReceiptPlanNotifyReceipt = new \App\Models\ReceiptPlanNotifyReceipt();
        if(!empty($criteria['receipt_plan_id'])) {
            $where[] = array('receipt_plan_notify_receipt.receipt_plan_id','=', $criteria['receipt_plan_id']);
        }
        $columns = [
            'receipt_plan_notify_receipt.id',
            'receipt_plan_notify_receipt.date',
            'receipt_plan_notify_receipt.hour',
            'receipt_plan_notify_receipt.observations',
            'user.name as user'
        ];
        $query = $ReceiptPlanNotifyReceipt->select($columns)
                                ->join('user', 'receipt_plan_notify_receipt.user_id', '=', 'user.id')
                                ->where($where)
                                ->get();
        return $query;
    }
    
}//end class