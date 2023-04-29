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
                    {!! Form::text('receipt_plan_id', $receipt_plan_id ?? '', ['id' => 'receipt_plan_id']) !!}
                    <div class="row col-lg-12">  
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Dt. Abertura') !!}:
                                {!! Form::text('date_start', $date_start ?? '', ['id' => 'date_start','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Dt. Prevista') !!}:
                                {!! Form::text('date_expected', $date_expected ?? '', ['id' => 'date_expected','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('N° Nota Fiscal') !!}:
                                {!! Form::text('nf_number', $nf_number ?? '', ['id' => 'nf_number','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Nº Ordem de Compra') !!}:
                                {!! Form::text('number_oc', $number_oc ?? '', ['id' => 'number_oc','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('Aberto por') !!}:                                
                                {!! Form::select('user_id', \App\Models\User::pluck('name','id'), $user_id ?? '', ['placeholder' => '', 'id' => 'user_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>  
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('Operação:') !!}:
                                {!! Form::select('operation_type_id', \App\Models\OperationType::pluck('name','id'), $operation_type_id ?? '', ['placeholder' => '', 'id' => 'operation_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div>    
                        <div class="col-lg-6">
                            <div class="form-group">
                                {!! Form::label('Fornecedor:') !!}:
                                {!! Form::select('supplier_id', \App\Models\Supplier::pluck('name','id'), $supplier_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-12 mg-t-20 pd-t-10">
                            <input type="hidden" name="number_prevision" id="number_prevision" value="{{$number_prevision}}">
                            <div class="table-responsive">
                                <table class="table table-bordered table-list"  style="margin-bottom: -1px;">
                                    <thead>
                                        <tr style="vertical-align: middle !important;">
                                            <th width="80%" class="text-left">Previsão de Produto/Família</th>
                                            <th width="10%" class="text-center">
                                                <button type="button" onclick="javascript: Application.onChangeQuantity(this);" class="btn-link" data-target="number_prevision" data-parameter="plus">Adicionar</button>    
                                            </th>
                                            <th width="10%" class="text-center">
                                                <button type="button" onclick="javascript: Application.onChangeQuantity(this);" class="btn-link" data-target="number_prevision" data-parameter="minus">Remover</button>    
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered table-list">
                                    <thead>
                                        <tr style="vertical-align: middle !important;">
                                            <th width="40%" class="text-left">Família</th>
                                            <th width="25%" class="text-center">Tipo de Produto</th>
                                            <th width="25%" class="text-center">Previsão (%)</th>
                                            <th width="10%" class="text-center">
                                                Limpar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < $number_prevision; $i++)
                                            <tr>
                                                <td>
                                                    {!! Form::select('prev_product_category_id['.$i.']', \App\Models\ProductCategory::where('category_id', NULL)->pluck('name','id'), $prev_product_category_id[$i] ?? '', ['placeholder' => '', 'id' => 'prev_product_category_id['.$i.']','class' => 'form-control','data-rule-required' => 'false','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onRefresh(this);']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::select('prev_product_type_id['.$i.']', \App\Models\ProductType::where('category_id','=', $prev_product_category_id[$i])->pluck('name','id'), $prev_product_type_id[$i] ?? '', ['placeholder' => '', 'id' => 'prev_product_type_id['.$i.']','class' => 'form-control','data-rule-required' => 'false','data-msg-required' => '* Campo Obrigatório']) !!}
                                                </td>
                                                <td>
                                                    {!! Form::text('prev_percent['.$i.']', $prev_percent[$i] ?? '', ['id' => 'prev_percent['.$i.']','class' => 'form-control','data-mask-type' => 'percent','maxlength' => 6]) !!}
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm btn-icon" data-indice="{{$i}}" onclick="ReceiptPlan.onRemovePrevision(this);">
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
                        <button type="button" class="btn btn-secondary btn-sm" data-action="{{ url($route->module) }}" onclick="Application.onRedirect(this);">
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
