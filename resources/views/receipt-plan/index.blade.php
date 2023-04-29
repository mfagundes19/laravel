<div class="content-header">
    {!! Form::open(['url' => url($route->module),'id' => 'form-research','method' => 'POST','data-action' => url($route->module),'data-refresh' => true,'onsubmit' => 'return false','data-loading' => 'btn-submit-research']) !!}
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
            <div class="box-panel-control col-lg-12">
                <!-- <button type="button" class="btn btn-primary btn-sm" data-action="{{url($route->module.'/create')}}" onclick="Application.onCreate(this);">
                    <span class="label-btn">Adicionar</span><i class="glyphicon fa fa-plus" aria-hidden=true></i>
                </button> -->
                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="label-btn">Adicionar</span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item" href="{{url($route->module.'/create/1')}}">Compra MP Ind</a>
                            <a class="dropdown-item" href="{{url($route->module.'/create/2')}}">Doação</a>
                            <a class="dropdown-item" href="{{url($route->module.'/create/3')}}">Devolução</a>
                            <a class="dropdown-item" href="{{url($route->module.'/create/4')}}">MDO</a>
                        </div>
                    </div>
                </div>
                <div id="box-research" class="box-panel-research">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::select('research_operation_type_id', \App\Models\OperationType::where('active',true)->pluck('name','id'), $research_operation_type_id ?? '', ['placeholder' => 'Operação', 'id' => 'research_operation_type_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::select('research_supplier_id', \App\Models\Supplier::where('active',true)->pluck('name','id'), $supplier_id ?? '', ['placeholder' => 'Fornecedor', 'id' => 'research_supplier_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_branch_id', \App\Models\Branch::where('active',true)->pluck('name','id'), $research_branch_id ?? '', ['placeholder' => 'Local de Descarga', 'id' => 'research_branch_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_shipping_company_id', \App\Models\ShippingCompany::where('active',true)->pluck('name','id'), $research_shipping_company_id ?? '', ['placeholder' => 'Transportadora', 'id' => 'research_shipping_company_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_shipping', ['COMAN' => 'COMAN', 'FORNECEDOR' => 'FORNECEDOR','OUTRO' => 'OUTRO'], $research_shipping ?? '', ['placeholder' => 'Frete por Conta', 'id' => 'research_shipping','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}                             
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::text('research_nf_number', $research_nf_number ?? '', ['id' => 'research_nf_number','class' => 'form-control','placeholder' => 'Nº Nota Fiscal']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button type="button" id="btn-submit-research" class="btn btn-primary btn-sm" onclick="Application.onRefresh(this);" data-loading="btn-submit-research">
                                    <span class="label-btn">Buscar</span><i class="glyphicon glyphicon-search" aria-hidden=true></i>
                                </button> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12"><div class="spacing"></div></div>
    <div class="col-lg-12">
        <table class="table table-bordered table-list">
            <thead>
                <tr>
                    <th width="8%">Dt. Abertura</th>
                    <th width="8%">Dt. Prevista</th>
                    <th width="10%">Transportadora</th>
                    <th width="8%">NF</th>
                    <th width="8%">Operação</th>
                    <th width="10%">Fornecedor</th>
                    <th width="10%">Total (Kg)</th>
                    <th width="10%">Total (R$)</th>
                    <th width="8%">Status</th>
                    <th width="20%" class="text-center">Ações</th>
                </tr>
            </thead>
            @forelse($list as $element)
                <tr>
                    <td>{{\Carbon\Carbon::parse($element->date_start)->format('d/m/Y')}}</td>
                    <td>{{\Carbon\Carbon::parse($element->date_expected)->format('d/m/Y')}}</td>
                    <td>{{$element->shipping_company}}</td>
                    <td>{{$element->nf_number}}</td>
                    <td>{{$element->operation}}</td>
                    <td>{{$element->supplier}}</td>
                    <td>{{\Str::currency($element->total_quantity,'br')}} kg</td>
                    <td>R$ {{\Str::currency($element->total_traded,'br')}}</td>
                    <td>
                        {!! Form::select('receipt_status_'.$element->id, ['Chegou' => 'Chegou', 'Chegou Parcial' => 'Chegou Parcial'], $element->receipt_status ?? '', ['placeholder' => '', 'id' => 'receipt_status_'.$element->id,'class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                    </td>
                    <td class="text-center">
                        @if(Auth::user()->hasPermission($route->module,'view'))
                            <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/notify-receipt')}}" data-id="{{$element->id}}" onclick="Application.onModal(this);" data-toggle="tooltip" data-placement="left" title="Registrar Chegada" data-original-title="Registrar Chegada">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </button>
                        @endif
                        @if(Auth::user()->hasPermission($route->module,'view'))
                            <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url('receivement/create')}}" data-id="{{$element->id}}" onclick="Application.onView(this);" data-toggle="tooltip" data-placement="left" title="Criar Recebimento" data-original-title="Criar Recebimento">
                                <i class="fa fa-share" aria-hidden="true"></i>
                            </button>
                        @endif
                        @if(Auth::user()->hasPermission($route->module,'view'))
                            <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/preview')}}" data-id="{{$element->id}}" onclick="Application.onModal(this);" data-toggle="tooltip" data-placement="left" title="Visualizar" data-original-title="Visualizar">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </button>
                        @endif
                        @if(Auth::user()->hasPermission($route->module,'edit'))
                        <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/edit')}}" data-id="{{$element->id}}" onclick="Application.onEdit(this);" data-toggle="tooltip" data-placement="left" title="Editar" data-original-title="Editar">
                            <i class="fa fa-pen" aria-hidden="true"></i>
                        </button>
                        @endif
                        @if(Auth::user()->hasPermission($route->module,'delete'))
                            <button type="button" class="btn btn-danger btn-sm btn-icon" data-action="{{url($route->module.'/delete')}}" data-id="{{$element->id}}" onclick="Application.onDelete(this);" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>   
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="12">Nenhum registro encontrado...</td></tr>
            @endforelse
        </table>
    </div>
    <div class="col-lg-12">
        {!! $list->appends($parameters)->links() !!} 
    </div>
    {!! Form::close() !!}
    <div class="modal" tabindex="-1" role="dialog" id="modal-view-page">
        <div class="modal-dialog modal-xl" role="document" style="width: 100% !important;">
            <div class="modal-content">
                {!! Form::open(['url' => url($route->module.'/payment'),'id' => 'form-modal','method' => 'POST','data-action' => url($route->module.'/payment'),'data-refresh' => true]) !!}  
                {!!Form::hidden('refresh_route',1, ['id' => 'refresh_route'])!!}
                {!! Form::close() !!}
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-load-content"></div>
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
        if (keycode == '13') {
            $('#btn-submit-research').trigger('click');    
        }
    });
    $('button').on('click', function(){
        $(this).tooltip('dispose');
        $(this).tooltip();
    });
</script>