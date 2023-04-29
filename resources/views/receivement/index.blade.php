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
                <button type="button" class="btn btn-primary btn-sm" data-action="{{url($route->module.'/alternative')}}" onclick="Application.onView(this);">
                    <span class="label-btn">Alternativa</span><i class="glyphicon fa fa-eye" aria-hidden=true></i>
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
                    <th width="10%">Fornecedor</th>
                    <th width="10%">Loc. Desc.</th>
                    <th width="10%">Tipo Op.</th>
                    <th width="10%">RA</th>
                    <th width="10%">NF</th>
                    <th width="10%">Peso Comp.</th>
                    <th width="10%">Peso Rec.</th>
                    <th width="10%">Dif. Peso</th>
                    <th width="10%">Vol.</th>
                    <th width="10%">Vol. Rec.</th>
                    <th width="10%">Status</th>
                    <th width="20%" class="text-center">Ações</th>
                </tr>
            </thead>
            @forelse($list as $element)
                <tr>
                    <td>{{\Carbon\Carbon::parse($element->date_receivement)->format('d/m/Y')}}</td>
                    <td>{{$element->supplier}}</td>
                    <td>{{$element->branch}}</td>
                    <td>{{$element->operation}}</td>
                    <td>{{$element->ra_number}}</td>
                    <td>{{$element->nf_number}}</td>
                    <td>
                        @switch($element->weight_reference)
                            @case('weight-negotiated')
                                {{$element->weight_received}}
                            @break
                            @case('weight-nf')
                                {{$element->weight_received}}
                            @break
                        @endswitch
                    </td>
                    <td>{{$element->weight_received}}</td>
                    <td>{{$element->weight_difference}}</td>
                    <td>{{$element->massiness}}</td>
                    <td>{{$element->massiness_received}}</td>
                    <td>{{$element->status}}</td>
                    <td>
                        @if(Auth::user()->hasPermission($route->module,'edit'))
                            <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/edit')}}" data-id="{{$element->id}}" onclick="Application.onEdit(this);" data-toggle="tooltip" data-placement="left" title="Editar" data-original-title="Editar" style="padding-top: 8px; padding-bottom: 8px;">
                                <i class="fa fa-pen" aria-hidden="true"></i>
                            </button>
                        @endif
                        @if(Auth::user()->hasPermission($route->module,'edit'))
                            <button type="button" class="btn btn-secondary btn-sm btn-icon" data-action="{{url($route->module.'/verification/'.$element->id)}}" data-id="{{$element->id}}" data-modal="modal-view-page-verification" data-modal-load="modal-load-content-verification" onclick="Receivement.onModal(this);" data-toggle="tooltip" data-placement="left" title="Inspeção/Verificação de Cartões Amarelos" data-original-title="Inspeção/Verificação de Cartões Amarelos" style="padding-top: 8px; padding-bottom: 8px;">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </button>   
                        @endif
                        @if(Auth::user()->hasPermission($route->module,'delete'))
                            <button type="button" class="btn btn-danger btn-sm btn-icon" data-action="{{url($route->module.'/delete')}}" data-id="{{$element->id}}" onclick="Application.onDelete(this);" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir" style="padding-top: 8px; padding-bottom: 8px;">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>   
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
    <div class="modal" tabindex="-1" role="dialog" id="modal-view-page-verification">
        <div class="modal-dialog modal-xl" role="document" style="width: 100% !important;">
            <div class="modal-content">
                {!! Form::open(['url' => url($route->module.'/verification'),'id' => 'form-modal','method' => 'POST','data-action' => url($route->module.'/verification'),'data-refresh' => true]) !!}  
                {!! Form::close() !!}
                <div class="modal-header">
                    <h5 class="modal-title" id="title-modal-rate">Cartão Amarelo</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="modal-load-content-verification">
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
    $('button').on('click', function(){
        $(this).tooltip('dispose');
        $(this).tooltip();
    });
</script>