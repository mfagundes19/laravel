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
                <button type="button" class="btn btn-primary btn-sm" data-action="{{url($route->module.'/create')}}" onclick="Application.onCreate(this);">
                    <span class="label-btn">Adicionar</span><i class="glyphicon fa fa-plus" aria-hidden=true></i>
                </button>
                <div id="box-research" class="box-panel-research">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::select('research_supplier_id', \App\Models\Supplier::where('active',true)->pluck('name','id'), $research_supplier_id ?? '', ['placeholder' => 'Fornecedor', 'id' => 'research_supplier_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::text('research_search', $research_search ?? '', ['id' => 'research_search','class' => 'form-control','placeholder' => 'Busca']) !!}
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
                    <th width="30%">Fornecedor</th>
                    <th width="20%">E-mail</th>
                    <th width="10%" class="text-right">Valor Frete</th>
                    <th width="10%" class="text-right">Total Qtd.</th>
                    <th width="10%" class="text-right">Valor Total</th>
                    <th width="10%" class="text-center">Ações</th>
                </tr>
            </thead>
            @forelse($list as $element)
                <tr>
                    <td>{{$element->supplier_name}}</td>
                    <td>{{$element->supplier_email}}</td>
                    <td class="text-right">R$ {{\Str::currency($element->shipping_amount,'br')}}</td>
                    <td class="text-right">R$ {{\Str::currency($element->total_quantity,'br')}}</td>
                    <td class="text-right">R$ {{\Str::currency($element->total_amount,'br')}}</td>
                    <td class="text-center">
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
        <div class="modal-dialog modal-lg modal-fullscreen-lg" role="document">
            <div class="modal-content">
                {!! Form::open(['url' => url($route->module.'/payment'),'id' => 'form-modal','method' => 'POST','data-action' => url($route->module.'/payment'),'data-refresh' => true]) !!}  
                {!!Form::hidden('refresh_route',1, ['id' => 'refresh_route'])!!}
                {!! Form::close() !!}
                <div class="modal-header">
                    <h5 class="modal-title">Visualizar</h5>
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