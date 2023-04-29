<div class="content-header">
    {!! Form::open(['url' => url($route->module),'id' => 'form-research','method' => 'POST','data-action' => url($route->module),'data-refresh' => true,'onsubmit' => 'return false']) !!}
    <div class="container-fluid">
        <div class="row row-content-header">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$route->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{$route->module}}">Index</a></li>
                    <li class="breadcrumb-item active">{{$route->name}}</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="col-lg-12"><div class="spacing"></div></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box-panel-control">
                <button type="button" class="btn btn-primary btn-sm" data-action="{{url($route->module.'/create')}}" onclick="Application.onCreate(this);">
                    <span class="label-btn">Adicionar</span><i class="glyphicon fa fa-plus" aria-hidden=true></i>
                </button>
                <div id="box-research" class="box-panel-research">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_receipt_plan_id', \App\Models\ReceiptPlan::pluck('number_ra','id'), $research_receipt_plan_id ?? '', ['placeholder' => 'P. Recebimento', 'id' => 'research_receipt_plan_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_fiscal_status_id', \App\Models\FiscalStatus::pluck('name','id'), $research_fiscal_status_id ?? '', ['placeholder' => 'Status Fiscal', 'id' => 'research_fiscal_status_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_segregation_status_id', \App\Models\SegregationStatus::pluck('name','id'), $research_segregation_status_id ?? '', ['placeholder' => 'Status Segregação', 'id' => 'research_segregation_status_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_segregator_id', \App\Models\Segregator::pluck('name','id'), $research_segregator_id ?? '', ['placeholder' => 'Segregador', 'id' => 'research_segregator_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_branch_id', \App\Models\Branch::pluck('name','id'), $research_branch_id ?? '', ['placeholder' => 'Unidade', 'id' => 'research_branch_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_operation_type_id', \App\Models\OperationType::pluck('name','id'), $research_operation_type_id ?? '', ['placeholder' => 'Operação', 'id' => 'research_operation_type_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_supplier_id', \App\Models\Supplier::pluck('name','id'), $research_supplier_id ?? '', ['placeholder' => 'Fornecedor', 'id' => 'research_supplier_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_user_id', \App\Models\User::pluck('name','id'), $research_user_id ?? '', ['placeholder' => 'Conferente', 'id' => 'research_user_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! Form::text('research_search', $research_search ?? '', ['id' => 'research_search','class' => 'form-control','placeholder' => 'Busca']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="button" id="btn-submit-research" class="btn btn-primary btn-sm" onclick="Application.onRefresh(this);">
                                    <span class="label-btn">Buscar</span><i class="glyphicon glyphicon-search" aria-hidden=true></i>
                                </button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="col-lg-12 box-table-content">
        <table class="table table-bordered table-list">
            <thead>
                <tr>
                    <th width="10%">Nº RA</th>
                    <th width="15%">Fiscal</th>
                    <th width="15%">Segragação</th>
                    <th width="10%">D. Receb.</th>
                    <th width="15%">Conferente</th>
                    <th width="10%">End. Carga</th>
                    <th width="15%">Segragador</th>
                    <th width="5%" class="text-center">Pac.</th>
                    <th width="5%" class="text-center">Editar</th>
                    <th width="5%" class="text-center">Excluir</th>
                </tr>
            </thead>
            @forelse($list as $element)
                <tr>
                    <td>{{$element->number_ra}}</td>
                    <td>{{$element->fiscal_status}}</td>
                    <td>{{$element->segregation_status}}</td>
                    <td>{{$element->date_receivement}}</td>
                    <td>{{$element->user}}</td>
                    <td>{{$element->cargo_addressing}}</td>
                    <td>{{$element->segregator}}</td>
                    <td>
                        @if(Auth::user()->hasPermission($route->module,'extra'))
                            <button type="button" class="btn btn-default btn-xs btn-icon" data-action="{{url($route->module.'/packpage')}}" data-id="{{$element->id}}" onclick="Application.onModal(this);" data-toggle="tooltip" data-placement="left" title="Pacotes" data-original-title="Pacotes">
                                <i class="fa fa-pen" aria-hidden="true"></i>
                            </button>
                        @else
                            <span> - </span>
                        @endif
                    <td class="text-center">
                        @if(Auth::user()->hasPermission($route->module,'edit'))
                            <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/edit')}}" data-id="{{$element->id}}" onclick="Application.onEdit(this);" data-toggle="tooltip" data-placement="left" title="Editar" data-original-title="Editar" style="padding-top: 8px; padding-bottom: 8px;">
                                <i class="fa fa-pen" aria-hidden="true"></i>
                            </button>
                        @else
                            <span> - </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(Auth::user()->hasPermission($route->module,'delete'))
                            <button type="button" class="btn btn-danger btn-sm btn-icon" data-action="{{url($route->module.'/delete')}}" data-id="{{$element->id}}" onclick="Application.onDelete(this);" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir" style="padding-top: 8px; padding-bottom: 8px;">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>   
                        @else
                            <span> - </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="10">Nenhum registro encontrado...</td></tr>
            @endforelse
        </table>
    </div>
    <div class="col-lg-12">
        {!! $list->appends($parameters)->links() !!} 
    </div>
    {!! Form::close() !!}
</div>
<div class="modal" tabindex="-1" role="dialog" id="modal-view-page">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {!! Form::open(['url' => url($route->module.'/packpage'),'id' => 'form-modal','method' => 'POST','data-action' => url($route->module.'/payment'),'data-refresh' => true]) !!}  
            {!!Form::hidden('refresh_route',1, ['id' => 'refresh_route'])!!}
            {!! Form::close() !!}
            <div class="modal-header">
                <h5 class="modal-title">Controle de Pacotes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-load-content">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
    });
    $(document).keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') 
        {
            $('#btn-submit-research').trigger('click');    
        }
    });
</script>