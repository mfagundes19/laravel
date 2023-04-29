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
                {!! Form::open(['url' => url($route->module.'/'.$route->action),'id' => 'form-general-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/save'),'data-view' => $route->module.'/'.$route->action,'enctype' => 'multipart/form-data']) !!}  
                    {!! Form::hidden('procedure', $route->action, ['id' => 'procedure']) !!}
                    {!! Form::hidden('receivement_id', $receivement_id ?? '', ['id' => 'receivement_id']) !!}
                    {!! Form::hidden('weight_reference', $weight_reference ?? '', ['id' => 'weight_reference']) !!}
                    <div class="row col-lg-12">
                        <div class="col-lg-2">
                            <div class="form-group">
                                {!! Form::label('Cod. Fornecedor') !!}:
                                {!! Form::text('supplier_code', $supplier_code ?? '', ['id' => 'supplier_code','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Fornecedor:') !!}:
                                {!! Form::select('supplier_id', \App\Models\Supplier::where([['active',true]])->pluck('name','id'), $supplier_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Dt. Recebimento') !!}:
                                {!! Form::text('date_receivement', $date_receivement ?? '', ['id' => 'date_receivement','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('R.A. Nº') !!}:   
                                {!! Form::text('ra_number', $ra_number ?? '', ['id' => 'ra_number','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Local descarga') !!}   
                                {!! Form::select('branch_id', \App\Models\Branch::where([['active',true]])->pluck('name','id'), $branch_id  ?? '', ['placeholder' => '', 'id' => 'branch_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                            {!! Form::label('Tipo de Operação:') !!}:
                                {!! Form::select('operation_type_id', \App\Models\OperationType::where([['active',true]])->pluck('name','id'), $operation_type_id ?? '', ['placeholder' => '', 'id' => 'operation_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">  
                                {!! Form::label('Tipo de Vasilhame:') !!}:
                                {!! Form::select('container_type_id', \App\Models\ContainerType::where([['active',true]])->pluck('name','id'), $container_type_id ?? '', ['placeholder' => '', 'id' => 'container_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('N.F. N°') !!}:
                                {!! Form::text('nf_number', $nf_number ?? '', ['id' => 'nf_number','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Recebedor') !!}:
                                {!! Form::text('receiver', $receiver ?? '', ['id' => 'receiver','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Volume NF') !!}:
                                {!! Form::text('massiness', $massiness ?? '', ['id' => 'massiness','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Volume Recebido') !!}:
                                {!! Form::text('massiness_received', $massiness_received ?? '', ['id' => 'massiness_received','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Tempo de Descarga') !!}:
                                {!! Form::text('time_discharge', $time_discharge ?? '', ['id' => 'time_discharge','class' => 'form-control','data-mask-type' => 'hour']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! Form::label('Observações') !!}:
                                {!! Form::textarea('observations',$observations ?? '', ['id' => 'observations','class' => 'form-control','placeholder' => 'Observações','rows' => 3]) !!}   
                            </div>
                        </div>   
                        <div class="col-lg-12">
                            <!-- 
                            <div class="col-lg-4">
                                <button class="btn btn-secondary btn-block">
                                    Peso Negociado
                                </button>
                            </div>
                            <div class="col-lg-4">
                                <button class="btn btn-secondary btn-block">
                                    Peso Nota Fiscal
                                </button>
                            </div>
                            -->
                            <table class="table table-bordered table-list">
                                <thead>
                                    <tr>
                                        <th width="60%"  class="text-center">Comparativo</th>
                                        <th width="20%" class="text-center">Peso Recebido</th>
                                        <th width="20%" class="text-center">Diferença Peso</th>
                                    </tr>
                                </thead>
                                <tr>
                                    <td>
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-secondary btn-block btn-weight" data-parameter="weight-negotiated" data-weight="10000.00" onclick="Receivement.onDifferenceWeight(this);" style="margin-bottom: 5px;">
                                            Peso Negociado
                                        </button>
                                        {!! Form::text('', '10.000,00 kg', ['id' => '','class' => 'form-control text-center','disabled' => 'true']) !!}
                                    </div>
                                    <div class="col-lg-6">
                                        <button type="button" class="btn btn-secondary btn-block btn-weight" data-parameter="weight-nf" data-weight="5000.00" onclick="Receivement.onDifferenceWeight(this);" style="margin-bottom: 5px;">
                                            Peso Nota Fiscal
                                        </button>
                                        {!! Form::text('', '5000,00 kg', ['id' => '','class' => 'form-control text-center','disabled' => 'true']) !!}
                                    </div>
                                    <td>
                                        {!! Form::text('', $weight_received ?? '', ['id' => '','class' => 'form-control text-center','style' => 'margin-bottom: 5px;']) !!}
                                        {!! Form::hidden('weight_received', $weight_received ?? '', ['id' => 'weight_received','class' => 'form-control']) !!}
                                    </td>
                                    <td>
                                        {!! Form::text('weight_difference', $weight_difference ?? '', ['id' => 'weight_difference','class' => 'form-control text-center']) !!}
                                    </td>
                                </tr>
                            </table>
                        </div>  
                        <div class="col-lg-12"><br></div>
                        <div class="col-lg-12">    
                            <div class="row">
                                <div class="col-lg-8">    
                                    <button type="button" class="btn btn-primary btn-block" id="btn-qualidade-carga" data-action="{{url($route->module.'/advanced')}}" data-modal-textarea="json_checklist" data-modal="modal-view-page-advanced" data-modal-load="modal-load-content-advanced"  onclick="Receivement.onAdvancedOption(this);">
                                        Qualidade da Carga / Restrição
                                    </button>
                                </div>
                                <div class="col-lg-4"> 
                                    <button type="button" class="btn btn-primary btn-block" id="btn-cartao-amarelo" data-action="{{url($route->module.'/packpage')}}" data-modal-textarea="json_packpage" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage" onclick="Receivement.onPackpage(this);">
                                        Cartões Amarelos
                                    </button>   
                                </div>
                                <div class="col-lg-12 hidden">    
                                    <textarea name="json_checklist" id="json_checklist" class="form-control">
                                        {{$json_checklist  ?? ''}}
                                    </textarea>    
                                </div>
                                <div class="col-lg-12 hidden">    
                                    <textarea name="json_packpage" id="json_packpage" class="form-control">
                                        {{$json_packpage ?? ''}}
                                    </textarea>    
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-12 mg-t-20 pd-t-10">
                            <input type="hidden" name="number_upload" id="number_upload" value="{{$number_upload}}">
                            <div class="table-responsive">
                                <table class="table table-bordered table-list"  style="margin-bottom: -1px;">
                                    <thead>
                                        <tr style="vertical-align: middle !important;">
                                            <th width="80%" class="text-left">Anexos/Documentos</th>
                                            <th width="10%" class="text-center">
                                                <button type="button" onclick="javascript: Application.onChangeQuantity(this);" class="btn-link" data-target="number_upload" data-parameter="plus">Adicionar</button>    
                                            </th>
                                            <th width="10%" class="text-center">
                                                <button type="button" onclick="javascript: Application.onChangeQuantity(this);" class="btn-link" data-target="number_upload" data-parameter="minus">Remover</button>    
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered table-list">
                                    <thead>
                                        <tr style="vertical-align: middle !important;">
                                            <th width="85%" class="text-left">Arquivo</th>
                                            <th width="15%" class="text-center">
                                                Ações
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(isset($upload_file) && count($upload_file) > 0)
                                            @foreach($upload_file as $k => $v)
                                                @if(!empty($v['filename']))
                                                    <tr>
                                                        <td style="height: 40px; padding-left: 20px; font-weight: bold;">
                                                            {{$v['filename']}}
                                                        </td>                                           
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-primary btn-sm" data-indice="{{$k}}" data-icon="fa fa-eye" data-file="{{url('storage/receivement/'.$v['filename'])}}" onclick="Application.onViewFile(this);">
                                                                <i class="fa fa-eye" aria-hidden="true"></i>
                                                            </button>  
                                                            <button type="button" class="btn btn-danger btn-sm" data-upload-id="{{$v['upload_id']}}" onclick="Receivement.onRemoveUpload(this);">
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>  
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach         
                                        @endif
                                        @for ($i = 0; $i < $number_upload; $i++)
                                            <tr>
                                                <td>
                                                    {!! Form::file('upload_file['.$i.']', ['id' => 'upload_file_'.$i,'class' => 'form-control','style' => 'height: 45px !important;'])  !!}
                                                </td>                                           
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" data-indice="{{$i}}" onclick="Receivement.onClearUpload(this);">
                                                        <i class="fa fa-eraser" aria-hidden="true"></i>
                                                    </button>       
                                                </td>
                                            </tr>
                                        @endfor    
                                    </tbody>
                                </table>
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
<div class="modal" tabindex="-1" role="dialog" id="modal-view-page-advanced">
    <div class="modal-dialog modal-xl" role="document" style="width: 100% !important;">
        <div class="modal-content">
            {!! Form::open(['url' => url($route->module.'/advanced'),'id' => 'form-modal','method' => 'POST','data-action' => url($route->module.'/advanced'),'data-refresh' => true]) !!}  
            {!!Form::hidden('refresh_route',1, ['id' => 'refresh_route'])!!}
            {!! Form::close() !!}
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal-rate">Qualidade da Carga e Restrições</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-load-content-advanced">
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modal-view-page-packpage">
    <div class="modal-dialog modal-xl" role="document" style="width: 100% !important;">
        <div class="modal-content">
            {!! Form::open(['url' => url($route->module.'/packpage'),'id' => 'form-modal','method' => 'POST','data-action' => url($route->module.'/packpage'),'data-refresh' => true]) !!}  
            {!!Form::hidden('refresh_route',1, ['id' => 'refresh_route'])!!}
            {!! Form::close() !!}
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal-rate">Cartão Amarelo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-load-content-packpage">
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
    
        // $("#btnPesoNegociado").on('click', function(){

        // });
        // $("#btnPesoNF").on('click', function(){

        // });












    });
</script>
