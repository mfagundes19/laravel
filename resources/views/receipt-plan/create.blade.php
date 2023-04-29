
<div class="content-header">
    <div class="container-fluid">
        <div class="row row-content-header">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$route->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url($route->module) }}">{{$route->name}}</a></li>
                    <li class="breadcrumb-item active">Adicionar</li>
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
                    {!! Form::hidden('receipt_plan_id', '', ['id' => 'receipt_plan_id']) !!}
                    {!! Form::hidden('type_rate', '', ['id' => 'type_rate']) !!}
                    <div class="row col-lg-12">  
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Aberto por') !!}:                                
                                {!! Form::select('user_id', \App\Models\User::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $user_id ?? '', ['placeholder' => '', 'id' => 'user_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>  
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Dt. Abertura') !!}:
                                {!! Form::text('date_start', $date_start ?? '', ['id' => 'date_start','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','autocomplete' => 'off','data-datepicker' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Dt. Prevista') !!}:
                                {!! Form::text('date_expected', $date_expected ?? '', ['id' => 'date_expected','class' => 'form-control datepicker','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','autocomplete' => 'off','data-datepicker' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Fornecedor:') !!}:
                                <div class="col-lg-10" style="padding: 0px;">
                                    {!! Form::select('supplier_id', \App\Models\Supplier::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $supplier_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                </div>    
                                <div class="col-lg-1">
                                    <button class="btn btn-primary btn-sm" data-action="{{url($route->module.'/supplier')}}" style="padding-top: 8px; padding-bottom: 8px;" onclick="Supplier.onCreateSupplier(this);">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Operação:') !!}:
                                {!! Form::select('operation_type_id', \App\Models\OperationType::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $operation_type_id ?? '', ['placeholder' => '', 'id' => 'operation_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('N° Nota Fiscal') !!}:
                                {!! Form::text('nf_number', $nf_number ?? '', ['id' => 'nf_number','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Transportadora:') !!}:
                                {!! Form::select('shipping_company_id', \App\Models\ShippingCompany::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $shipping_company_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Frete por conta') !!}   
                                {!! Form::select('shipping', ['COMAN' => 'COMAN', 'FORNECEDOR' => 'FORNECEDOR','OUTRO' => 'OUTRO'], $shipping ?? '', ['placeholder' => '', 'id' => 'shipping','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}                             
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Valor do Frete') !!}   
                                {!! Form::text('shipping_amount', $shipping_amount ?? '', ['id' => 'shipping_amount','class' => 'form-control','data-mask-type' => 'money','maxlength' => 20]) !!}
                            </div>
                        </div>
                        @switch($operation_type_id)
                            @case(1)
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Local descarga') !!}   
                                        {!! Form::select('branch_id', \App\Models\Branch::where([['active',true]])->pluck('name','id'), $branch_id  ?? '', ['placeholder' => '', 'id' => 'branch_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Forma de Pagto') !!}   
                                        {!! Form::select('payment_method_id', \App\Models\PaymentMethod::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $payment_method_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Prazo de Pagto') !!}   
                                        {!! Form::select('payment_term_id', \App\Models\PaymentTerm::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $payment_term_id ?? '', ['placeholder' => '', 'id' => 'payment_term_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Data Base Pagto') !!}   
                                        {!! Form::select('payment_base_date', ['Emissão da Nota' => 'Emissão da Nota', 'Recebimento' => 'Recebimento', 'Termino da Segragação' => 'Termino da Segragação'], $payment_base_date ?? '', ['placeholder' => '', 'id' => 'payment_base_date','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Valor Total Negociado') !!}:
                                        {!! Form::text('total_traded', $total_traded ?? '', ['id' => 'total_traded','class' => 'form-control disabled','data-mask-type' => 'money','maxlength' => 20,'onfocus' => 'blur();']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Crítica Financeira:') !!}:
                                        {!! Form::select('payment_comment', ['ALINHAR FISCAL. APÓS SEGREGAÇÃO' => 'ALINHAR FISCAL. APÓS SEGREGAÇÃO','NEGOCIAR DEVOLUÇÃO' => 'NEGOCIAR DEVOLUÇÃO','CONTRATO SEM DEVOLUÇÃO' => 'CONTRATO SEM DEVOLUÇÃO','DEVOL. RETORNA P/ FORNECEDOR' => 'DEVOL. RETORNA P/ FORNECEDOR','ENCONTRO DE CONTAS' => 'ENCONTRO DE CONTAS','MISTO DE ENCONTRO DE CONTAS' => 'MISTO DE ENCONTRO DE CONTAS'], $payment_comment ?? '', ['placeholder' => '', 'id' => 'payment_comment','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Total Quantidade(Kg)') !!}:
                                        {!! Form::text('total_quantity', $total_quantity ?? '', ['id' => 'total_quantity','class' => 'form-control disabled','data-mask-type' => 'float','maxlength' => 9,'onfocus' => 'blur();']) !!}
                                    </div>
                                </div>
                            @break
                            @case(2)
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Local descarga') !!}   
                                        {!! Form::select('branch_id', \App\Models\Branch::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $branch_id  ?? '', ['placeholder' => '', 'id' => 'branch_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Crítica Financeira:') !!}:
                                        {!! Form::select('payment_comment', ['ALINHAR FISCAL. APÓS SEGREGAÇÃO' => 'ALINHAR FISCAL. APÓS SEGREGAÇÃO','NEGOCIAR DEVOLUÇÃO' => 'NEGOCIAR DEVOLUÇÃO','CONTRATO SEM DEVOLUÇÃO' => 'CONTRATO SEM DEVOLUÇÃO','DEVOL. RETORNA P/ FORNECEDOR' => 'DEVOL. RETORNA P/ FORNECEDOR','ENCONTRO DE CONTAS' => 'ENCONTRO DE CONTAS','MISTO DE ENCONTRO DE CONTAS' => 'MISTO DE ENCONTRO DE CONTAS'], $payment_comment ?? '', ['placeholder' => '', 'id' => 'payment_comment','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Total Quantidade(Kg)') !!}:
                                        {!! Form::text('total_quantity', $total_quantity ?? '', ['id' => 'total_quantity','class' => 'form-control disabled','data-mask-type' => 'float','maxlength' => 9,'onfocus' => 'blur();']) !!}
                                    </div>
                                </div>
                                {!! Form::hidden('total_traded', $total_traded ?? '', ['id' => 'total_traded','class' => 'form-control']) !!}
                            @break
                            @case(3)
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Local descarga') !!}   
                                        {!! Form::select('branch_id', \App\Models\Branch::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $branch_id  ?? '', ['placeholder' => '', 'id' => 'branch_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Crítica Financeira:') !!}:
                                        {!! Form::select('payment_comment', ['ALINHAR FISCAL. APÓS SEGREGAÇÃO' => 'ALINHAR FISCAL. APÓS SEGREGAÇÃO','NEGOCIAR DEVOLUÇÃO' => 'NEGOCIAR DEVOLUÇÃO','CONTRATO SEM DEVOLUÇÃO' => 'CONTRATO SEM DEVOLUÇÃO','DEVOL. RETORNA P/ FORNECEDOR' => 'DEVOL. RETORNA P/ FORNECEDOR','ENCONTRO DE CONTAS' => 'ENCONTRO DE CONTAS','MISTO DE ENCONTRO DE CONTAS' => 'MISTO DE ENCONTRO DE CONTAS'], $payment_comment ?? '', ['placeholder' => '', 'id' => 'payment_comment','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Ação:') !!}:
                                        {!! Form::select('proceeding', ['retrabalho' => 'RETRABALHO','materia-prima' => 'MATÉRIA-PRIMA'], $payment_comment ?? '', ['placeholder' => '', 'id' => 'proceeding','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Total Quantidade(Kg)') !!}:
                                        {!! Form::text('total_quantity', $total_quantity ?? '', ['id' => 'total_quantity','class' => 'form-control disabled','data-mask-type' => 'float','maxlength' => 9,'onfocus' => 'blur();']) !!}
                                    </div>
                                </div>
                                {!! Form::hidden('total_traded', $total_traded ?? '', ['id' => 'total_traded','class' => 'form-control']) !!}
                            @break
                            @case(4)
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Local descarga') !!}   
                                        {!! Form::select('branch_id', \App\Models\Branch::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $branch_id  ?? '', ['placeholder' => '', 'id' => 'branch_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Forma de Cobrança') !!}   
                                        {!! Form::select('payment_method_id', \App\Models\PaymentMethod::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $payment_method_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Prazo de Cobrança') !!}   
                                        {!! Form::select('payment_term_id', \App\Models\PaymentTerm::where([['active',true]])->orderBy('name', 'asc')->pluck('name','id'), $payment_term_id ?? '', ['placeholder' => '', 'id' => 'payment_term_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Data Base Cobrança') !!}   
                                        {!! Form::select('payment_base_date', ['Emissão da Nota' => 'Emissão da Nota', 'Recebimento' => 'Recebimento', 'Termino da Segragação' => 'Termino da Segragação'], $payment_base_date ?? '', ['placeholder' => '', 'id' => 'payment_base_date','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        {!! Form::label('Crítica Financeira:') !!}:
                                        {!! Form::select('payment_comment', ['ALINHAR FISCAL. APÓS SEGREGAÇÃO' => 'ALINHAR FISCAL. APÓS SEGREGAÇÃO','NEGOCIAR DEVOLUÇÃO' => 'NEGOCIAR DEVOLUÇÃO','CONTRATO SEM DEVOLUÇÃO' => 'CONTRATO SEM DEVOLUÇÃO','DEVOL. RETORNA P/ FORNECEDOR' => 'DEVOL. RETORNA P/ FORNECEDOR','ENCONTRO DE CONTAS' => 'ENCONTRO DE CONTAS','MISTO DE ENCONTRO DE CONTAS' => 'MISTO DE ENCONTRO DE CONTAS'], $payment_comment ?? '', ['placeholder' => '', 'id' => 'payment_comment','class' => 'form-control']) !!}
                                    </div>
                                </div>
                                {!! Form::hidden('total_traded', $total_traded ?? '', ['id' => 'total_traded','class' => 'form-control']) !!}
                                {!! Form::hidden('total_quantity', $total_quantity ?? '', ['id' => 'total_quantity','class' => 'form-control']) !!}
                            @break
                        @endswitch
                        <div class="col-lg-12">    
                            <div class="row">
                            <div class="col-lg-4">    
                                <button type="button" class="btn btn-primary btn-block" data-action="{{url($route->module.'/rate')}}" data-type="detalhado" data-type-title="Rateio Detalhado" onclick="ReceiptPlan.onOpenRateio(this);">
                                    Rateio Detalhado
                                </button>
                            </div>
                            <div class="col-lg-4"> 
                                <button type="button" class="btn btn-primary btn-block" data-action="{{url($route->module.'/rate')}}" data-type="proporcional" data-type-title="Rateio Proporcional" onclick="ReceiptPlan.onOpenRateio(this);">
                                    Rateio Proporcional
                                </button>
                                </div>
                            </div>
                            <!-- <div class="col-lg-4"> 
                                <button type="button" class="btn btn-primary btn-block" onclick="ReceiptPlan.onReteioDetalhado(this);">
                                    Rateio por Média
                                </button>   
                            </div> -->
                        </div>  
                        <div class="col-lg-12 mg-t-20 pd-t-10">
                            <div class="hidden">
                                {!! Form::textarea('json_receipt_plan_rate',$json_receipt_plan_rate ?? '', ['id' => 'json_receipt_plan_rate','class' => 'form-control','rows' => 3]) !!} 
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-list"  style="margin-bottom: -1px;">
                                    <thead>
                                        <tr style="vertical-align: middle !important;">
                                            <th width="100%" class="text-left">Previsão de Produto/Família</th>
                                        </tr>
                                    </thead>
                                </table>
                                <table class="table table-bordered table-list">
                                    <thead>
                                        <tr style="vertical-align: middle !important;">
                                            <th width="15%" class="text-left">Grupo</th>
                                            <th width="15%" class="text-center">Tipo de Produto</th>
                                            <th width="15%" class="text-center">Tipo de Apara</th>
                                            <th width="10%" class="text-center">Prev. (%)</th>
                                            <th width="15%" class="text-center">Prev. (KG)</th>
                                            <th width="15%" class="text-center">Unitário (R$)</th>
                                            <th width="15%" class="text-center">Total (R$)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbody_rate">
                                        @foreach ($receipt_plan_rate as $rate)
                                            <tr style="vertical-align: middle !important;">
                                                <td width="15%" class="text-center">{{$rate['prev_product_category_text']}}</td>
                                                <td width="15%" class="text-center">{{$rate['prev_product_type_text']}}</td>
                                                <td width="15%" class="text-center">{{$rate['prev_shaving_type_text']}}</td>
                                                <td width="10%" class="text-center">{{$rate['prev_percent']}}</td>
                                                <td width="15%" class="text-center">{{$rate['prev_quantity']}}</td>
                                                <td width="15%" class="text-center">{{$rate['prev_amount']}}</td>                                                
                                                <td width="15%" class="text-center">{{$rate['prev_total']}}</td>
                                            </tr>
                                        @endforeach     
                                    </tbody>
                                </table>
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
                                            <th width="90%" class="text-left">Arquivo</th>
                                            <th width="10%" class="text-center">
                                                Limpar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < $number_upload; $i++)
                                            <tr>
                                                <td>
                                                    {!! Form::file('upload_file['.$i.']', ['id' => 'upload_file['.$i.']','class' => 'form-control','style' => 'height: 45px !important;'])  !!}
                                                </td>                                              
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-danger btn-sm" data-indice="{{$i}}" onclick="ReceiptPlan.onRemovePrevision(this);">
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
<div class="modal" tabindex="-1" role="dialog" id="modal-view-page">
    <div class="modal-dialog modal-xl" role="document" style="width: 100% !important;">
        <div class="modal-content">
            {!! Form::open(['url' => url($route->module.'/rate'),'id' => 'form-modal','method' => 'POST','data-action' => url($route->module.'/rate'),'data-refresh' => true]) !!}  
            {!!Form::hidden('refresh_route',1, ['id' => 'refresh_route'])!!}
            {!! Form::close() !!}
            <div class="modal-header">
                <h5 class="modal-title" id="title-modal-rate">Personalização de Rateio</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-load-content">
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="modal-view-page-supplier">
    <div class="modal-dialog modal-xl" role="document" style="width: 100% !important;">
        <div class="modal-content">
            {!! Form::open(['url' => url($route->module.'/supplier'),'id' => 'form-modal','method' => 'POST','data-action' => url($route->module.'/supplier'),'data-refresh' => true]) !!}  
            {!!Form::hidden('refresh_route',1, ['id' => 'refresh_route'])!!}
            {!! Form::close() !!}
            <div class="modal-header">
                <h5 class="modal-title">Fornecedor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-load-content-supplier">
            </div>
        </div>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
    });
</script>
