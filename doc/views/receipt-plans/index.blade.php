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
            <div class="box-panel-control col-lg-12">
                <button type="button" class="btn btn-primary btn-sm" data-action="{{url($route->module.'/create')}}" onclick="Application.onCreate(this);">
                    <span class="label-btn">Adicionar</span><i class="glyphicon fa fa-plus" aria-hidden=true></i>
                </button>
                <div id="box-research" class="box-panel-research">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_operation_type_id', \App\Models\OperationType::pluck('name','id'), $research_operation_type_id ?? '', ['placeholder' => 'Operação', 'id' => 'research_operation_type_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_supplier_id', \App\Models\Supplier::pluck('name','id'), $supplier_id ?? '', ['placeholder' => 'Fornecedor', 'id' => 'research_supplier_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::select('research_user_id', \App\Models\User::pluck('name','id'), $research_cargo_quality_id ?? '', ['placeholder' => 'Aberto por', 'id' => 'research_user_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::text('research_nf_number', $research_nf_number ?? '', ['id' => 'research_nf_number','class' => 'form-control','placeholder' => 'Nº Nota Fiscal']) !!}
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
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
    <div class="col-lg-12"><div class="spacing"></div></div>
    <div class="col-lg-12">
        <table class="table table-bordered table-list">
            <thead>
                <tr>
                    <th width="15%">Data Abert.</th>
                    <th width="15%">Data Prev.</th>
                    <th width="10%">Usuário</th>
                    <th width="10%">NF</th>
                    <th width="10%">OC</th>
                    <th width="15%">Operação</th>
                    <th width="15%">Fornecedor</th>
                    <th width="5%" class="text-center">Ver</th>
                    <th width="5%" class="text-center">Editar</th>
                    <th width="5%" class="text-center">Excluir</th>
                </tr>
            </thead>
            @forelse($list as $element)
                <tr>
                    <td>{{\Carbon\Carbon::parse($element->date_start)->format('d/m/Y')}}</td>
                    <td>{{\Carbon\Carbon::parse($element->date_expected)->format('d/m/Y')}}</td>
                    <td>{{$element->user}}</td>
                    <td>{{$element->nf_number}}</td>
                    <td>{{$element->oc_number}}</td>
                    <td>{{$element->operation}}</td>
                    <td>{{$element->supplier}}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url('receivement/create')}}" data-id="{{$element->id}}" onclick="Application.onEdit(this);" data-toggle="tooltip" data-placement="left" title="Visualizar" data-original-title="Visualizar">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </button>

                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/edit')}}" data-id="{{$element->id}}" onclick="Application.onEdit(this);" data-toggle="tooltip" data-placement="left" title="Editar" data-original-title="Editar">
                            <i class="fa fa-pen" aria-hidden="true"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm btn-icon" data-action="{{url($route->module.'/delete')}}" data-id="{{$element->id}}" onclick="Application.onDelete(this);" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir">
                            <i class="fa fa-trash" aria-hidden="true"></i>

                        </button>   
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