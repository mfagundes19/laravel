<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Repositories\UserRepository;
use App\Repositories\ReceiptPlanRepository;
use App\Repositories\ReceivementRepository;

class DashboardController extends Controller
{
    public function index()
    {        

        $parameters = array();

        $UserRepository =  new UserRepository();
        $parameters['number_users'] = count($UserRepository->findAll());

        // $ReceiptPlanRepository = new ReceiptPlanRepository();
        // $parameters['number_receipt_plans'] = count($ReceiptPlanRepository->findAll());
        // $ReceivementRepository = new ReceivementRepository();
        // $parameters['number_receivement'] = count($ReceivementRepository->findAll());

        $parameters['number_receipt_plans'] = 0;
        $parameters['number_receivement'] = 0;
        $View = View::make('home',$parameters)->render();
        return view('layouts/app',array('View' => $View));
    }
}
