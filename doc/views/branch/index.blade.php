<div class="content-header">
    {!! Form::open(['url' => url('branches'),'id' => 'form-research','method' => 'POST','data-action' => url('branches'),'data-refresh' => true,'onsubmit' => 'return false']) !!}
    <div class="container-fluid">
        <div class="row mb-2 row-content-header">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Unidades</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('branches') }}">Unidades</a></li>
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="col-lg-12"><div class="spacing"></div></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box-panel-control col-lg-12">
                
                <button type="button" class="btn btn-primary btn-sm" 
                    data-action="{{url($route->module.'/create')}}" 
                    onclick="Application.onCreate(this);">
                    <span class="label-btn">Adicionar</span><i class="glyphicon fa fa-plus" aria-hidden=true></i>
                </button>
                
                <div id="box-research" class="box-panel-research">
                    <div class="row">
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
    <div class="col-lg-12"><div class="spacing"></div></div>
    <div class="col-lg-12">
        <table class="table table-bordered table-list">
            <thead>
                <tr>
                    <th width="90%">Nome</th>
                    <th width="5%" class="text-center">Editar</th>
                    <th width="5%" class="text-center">Excluir</th>
                </tr>
            </thead>
            @forelse($list as $element)
                <tr>
                    <td>{{$element->name}}</td>
                    <td class="text-center">
                        @if(Auth::user()->hasPermission($route->module,'edit'))
                            <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/edit')}}" data-id="{{$element->id}}" onclick="Application.onEdit(this);" data-toggle="tooltip" data-placement="left" title="Editar" data-original-title="Editar">
                                <i class="fa fa-pen" aria-hidden="true"></i>
                            </button>
                        @else
                            <span> - </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if(Auth::user()->hasPermission($route->module,'delete'))
                            <button type="button" class="btn btn-danger btn-sm btn-icon" data-action="{{url($route->module.'/delete')}}" data-id="{{$element->id}}" onclick="Application.onDelete(this);" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir">
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
    <div class="modal" tabindex="-1" role="dialog" id="modal-view-page">
        <div class="modal-dialog modal-lg modal-xl" role="document">
            <div class="modal-content">
                {!! Form::open(['url' => url('branches/create'),'id' => 'form-modal','method' => 'POST','data-action' => url('branches/create'),'data-refresh' => true]) !!}  
                {!!Form::hidden('refresh_route',1, ['id' => 'refresh_route'])!!}
                {!! Form::close() !!}
                <div class="modal-header">
                    <h5 class="modal-title">Cadastro de Filial</h5>
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