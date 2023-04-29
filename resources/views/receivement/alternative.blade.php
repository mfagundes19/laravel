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
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="col-lg-12 box-table-content">
        <table class="table table-bordered table-list">
            <thead>
                <tr>
                    <th width="10%">Dt. Rec.</th>
                    <th width="10%">Peso Comp.</th>
                    <th width="10%">Peso Rec.</th>
                    <th width="10%">Dif. Peso</th>
                    <th width="10%">Vol.</th>
                    <th width="10%">Vol. Rec.</th>
                    <th width="30%">Status</th>
                    <th width="10%" class="text-center">Ações</th>
                </tr>
            </thead>
            @forelse($list as $element)
                <tr data-id="{{$element->id}}">
                    <td>{{\Carbon\Carbon::parse($element->date_receivement)->format('d/m/Y')}}</td>
                    <td>N/C</td>
                    <td>N/C</td>
                    <td>N/C</td>
                    <td>{{$element->massiness}}</td>
                    <td>{{$element->massiness_received}}</td>
                    <td>Em Recebimnento</td>
                    <td class="text-center">
                        @if(Auth::user()->hasPermission($route->module,'edit'))
                            <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/edit')}}" data-id="{{$element->id}}" onclick="Application.onEdit(this);" data-toggle="tooltip" data-placement="left" title="Editar" data-original-title="Editar" style="padding-top: 8px; padding-bottom: 8px;">
                                <i class="fa fa-pen" aria-hidden="true"></i>
                            </button>
                        @endif
                        @if(Auth::user()->hasPermission($route->module,'delete'))
                            <button type="button" class="btn btn-danger btn-sm btn-icon" data-action="{{url($route->module.'/delete')}}" data-id="{{$element->id}}" onclick="Application.onDelete(this);" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir" style="padding-top: 8px; padding-bottom: 8px;">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>   
                        @endif
                    </td>
                </tr>
                <tr id="div_receivement_{{$element->id}}" style="display: none;">
                    <td colspan="100%">
                        <table class="table table-bordered table-list">
                            <thead>  
                                <tr>
                                    <th width="15%">RA</th>
                                    <th width="15%">NF</th>
                                    <td width="25%">Fornecedor</td>
                                    <td width="20%">Local de Descarga</td>
                                    <td width="20%">Tipo de Operação</td>
                                </tr>
                            </thead>
                            <tr>
                                <td>{{$element->ra_number}}</td>
                                <td>{{$element->nf_number}}</td>
                                <td>{{$element->supplier}}</td>
                                <td>{{$element->branch}}</td>
                                <td>{{$element->operation}}</td>            
                            </tr>
                        </table>                
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
        $('table tr').on('click', function(){
            var receivement_id = $(this).attr('data-id');
            if($('#div_receivement_'+$(this).attr('data-id')).css('display') == 'none') {
                $('#div_receivement_'+$(this).attr('data-id')).show();
            } else {
                $('#div_receivement_'+$(this).attr('data-id')).hide();
            }
        });
    });
    $(document).keypress(function(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if (keycode == '13') 
        {
            $('#btn-submit-research').trigger('click');    
        }
    });
</script>