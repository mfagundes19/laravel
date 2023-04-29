<div class="content-header">
    <div class="container-fluid">
        <div class="row row-content-header">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$route->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url($route->module) }}">{{$route->name}}</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div><br>
</div>
<div class="content">
    <div class="row col-lg-12">
        <div class="container-fluid">
            <div class="col-lg-12 box-form-container">
                {!! Form::open(['url' => url($route->module.'/'.$route->action),'id' => 'form-general-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/save'),'data-view' => $route->module.'/'.$route->action]) !!}  
                    {!! Form::hidden('procedure', 2, ['id' => 'procedure']) !!}
                    {!! Form::hidden('receivement_id', $receivement_id ?? '', ['id' => 'receivement_id']) !!}
                    <div class="row col-lg-12">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! Form::label('Plano de Recebimento') !!}:
                                {!! Form::select('receipt_plan_id', \App\Models\ReceiptPlan::pluck('number_ra','id'), $receipt_plan_id ?? '', ['placeholder' => '', 'id' => 'financial_status_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12"><div class="col-lg-12 mg-t-10 pd-t-10 bdr-t"></div></div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('Status Fiscal') !!}:
                                {!! Form::select('fiscal_status_id', \App\Models\FiscalStatus::pluck('name','id'), $fisccal_status_id ?? '', ['placeholder' => '', 'id' => 'fiscal_status_id','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('Status Segregação') !!}:
                                {!! Form::select('segregation_status_id', \App\Models\SegregationStatus::pluck('name','id'), $segregation_status_id ?? '', ['placeholder' => '', 'id' => 'segregation_status_id','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Número do R.A.') !!}:
                                {!! Form::text('number_ra', $number_ra ?? '', ['id' => 'number_ra','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('N° Nota Fiscal') !!}:
                                {!! Form::text('nf_number', $nf_number ?? '', ['id' => 'nf_number','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Unid. Rec.') !!}:
                                {!! Form::select('branch_id', \App\Models\Branch::pluck('name','id'), $branch_id ?? '', ['placeholder' => '', 'id' => 'branch_id','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Dt. Recebimento') !!}:
                                {!! Form::text('date_receivement', $date_receivement ?? '', ['id' => 'date_receivement','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Conferente') !!}:                                
                                {!! Form::select('user_id', \App\Models\User::pluck('name','id'), $user_id ?? '', ['placeholder' => '', 'id' => 'user_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>    
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('Fornecedor:') !!}:
                                {!! Form::select('supplier_id', \App\Models\Supplier::pluck('name','id'), $supplier_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-2">
                            <div class="form-group">
                                {!! Form::label('Cod. Forn.:') !!}:
                                {!! Form::text('supplier_id_code', str_pad($supplier_id,5,'0',STR_PAD_LEFT) ?? '', ['id' => 'supplier_id_code','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Operação:') !!}:
                                {!! Form::select('operation_type_id', \App\Models\OperationType::pluck('name','id'), $operation_type_id ?? '', ['placeholder' => '', 'id' => 'operation_type_id','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div>  
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Peso Total NF') !!}:
                                {!! Form::text('nf_weight', $nf_weight ?? '', ['id' => 'nf_weight','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Peso Conferido(Kg)') !!}:
                                {!! Form::text('nf_checked_weight', $nf_checked_weight ?? '', ['id' => 'nf_checked_weight','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Qtd. Vol. Rec.') !!}:
                                {!! Form::text('number_volume_received', $number_volume_received ?? '', ['id' => 'number_volume_received','class' => 'form-control','disabled' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Tipo de Vasilhame:') !!}:
                                {!! Form::select('container_type_id', \App\Models\ContainerType::pluck('name','id'), $container_type_id ?? '', ['placeholder' => '', 'id' => 'container_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('qualidade de Carga:') !!}:
                                {!! Form::select('cargo_quality_id', \App\Models\CargoQuality::pluck('name','id'), $cargo_quality_id ?? '', ['placeholder' => '', 'id' => 'cargo_quality_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Endereçamento da Carga:') !!}:
                                {!! Form::text('cargo_addressing', $cargo_addressing ?? '', ['id' => 'number_volume_shipped','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Qtd. Vol. Processados') !!}:
                                {!! Form::text('number_volume_processed', $number_volume_processed ?? '', ['id' => 'number_volume_processed','class' => 'form-control','data-mask-type' => 'number','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Segregador:') !!}:
                                {!! Form::select('segregator_id', \App\Models\Segregator::pluck('name','id'), $segregator_id ?? '', ['placeholder' => '', 'id' => 'segregator_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Dt. Início') !!}:
                                {!! Form::text('date_start', $date_start ?? '', ['id' => 'date_start','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Dt. Fim') !!}:
                                {!! Form::text('date_end', $date_end ?? '', ['id' => 'date_end','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Total de Proc. da Carga') !!}:
                                {!! Form::text('time_total_cargo_processing', $time_total_cargo_processing ?? '', ['id' => 'time_total_cargo_processing','class' => 'form-control','data-mask-type' => 'time','placeholder' => 'hh:mm:ss']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 mg-t-20 pd-t-10 bdr-t">
                        <button type="submit" class="btn btn-primary btn-sm" onclick="Application.onValidate(this);">
                            <span class="label-btn">Salvar</span><i class="fa fa-check" aria-hidden=true></i>
                        </button> 
                        <span class="spacer-bar">|</span>
                        <button type="button" class="btn btn-secondary btn-sm" data-action="{{ route($route->module,$research_parameters) }}" onclick="Application.onRedirect(this);">
                            <span class="label-btn">Voltar</span><i class="fa fa-reply" aria-hidden=true></i>
                        </button> 
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
    });
</script>
