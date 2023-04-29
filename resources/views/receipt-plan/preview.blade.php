<div class="row" id="preview">
    <div class="container-fluid">  
        <div class="col-lg-12 box-form-container">  
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Aberto por') !!}:                                
                    {!! Form::select('user_id', \App\Models\User::where([['active',true]])->pluck('name','id'), $user_id ?? '', ['placeholder' => '', 'id' => 'user_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>  
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Dt. Abertura') !!}:
                    {!! Form::text('date_start', $date_start ?? '', ['id' => 'date_start','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Dt. Prevista') !!}:
                    {!! Form::text('date_expected', $date_expected ?? '', ['id' => 'date_expected','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Fornecedor:') !!}:
                    {!! Form::select('supplier_id', \App\Models\Supplier::where([['active',true]])->pluck('name','id'), $supplier_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div> 
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Operação:') !!}:
                    {!! Form::select('operation_type_id', \App\Models\OperationType::where([['active',true]])->pluck('name','id'), $operation_type_id ?? '', ['placeholder' => '', 'id' => 'operation_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('N° Nota Fiscal') !!}:
                    {!! Form::text('nf_number', $nf_number ?? '', ['id' => 'nf_number','class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Transportadora:') !!}:
                    {!! Form::select('shipping_company_id', \App\Models\ShippingCompany::where([['active',true]])->pluck('name','id'), $shipping_company_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div> 
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Frete por conta') !!}   
                    {!! Form::select('shipping', ['COMAN' => 'COMAN', 'FORNECEDOR' => 'FORNECEDOR','OUTRO' => 'OUTRO'], $shipping ?? '', ['placeholder' => '', 'id' => 'shipping','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}                             
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Valor do Frete') !!}   
                    {!! Form::text('shipping_amount', $shipping_amount ?? '', ['id' => 'shipping_amount','class' => 'form-control','data-mask-type' => 'money','maxlength' => 20]) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Local descarga') !!}   
                    {!! Form::select('branch_id', \App\Models\Branch::where([['active',true]])->pluck('name','id'), $branch_id ?? '', ['placeholder' => '', 'id' => 'branch_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Forma de Pagto') !!}   
                    {!! Form::select('payment_method_id', \App\Models\PaymentMethod::where([['active',true]])->pluck('name','id'), $payment_method_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Prazo de Pagto') !!}   
                    {!! Form::select('payment_term_id', \App\Models\PaymentTerm::where([['active',true]])->pluck('name','id'), $payment_term_id ?? '', ['placeholder' => '', 'id' => 'payment_term','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Data Base Pagto') !!}   
                    {!! Form::select('payment_base_date', ['Emissão da Nota' => 'Emissão da Nota', 'Recebimento' => 'Recebimento', 'Termino da Segragação' => 'Termino da Segragação'], $payment_base_date ?? '', ['placeholder' => '', 'id' => 'payment_base_date','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Total Negociado') !!}:
                    {!! Form::text('total_traded', $total_traded ?? '', ['id' => 'total_traded','class' => 'form-control','data-mask-type' => 'money','maxlength' => 20]) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Crítica Financeira:') !!}:
                    {!! Form::select('payment_comment', ['ALINHAR FISCAL. APÓS SEGREGAÇÃO' => 'ALINHAR FISCAL. APÓS SEGREGAÇÃO','NEGOCIAR DEVOLUÇÃO' => 'NEGOCIAR DEVOLUÇÃO','CONTRATO SEM DEVOLUÇÃO' => 'CONTRATO SEM DEVOLUÇÃO','DEVOL. RETORNA P/ FORNECEDOR' => 'DEVOL. RETORNA P/ FORNECEDOR','ENCONTRO DE CONTAS' => 'ENCONTRO DE CONTAS','MISTO DE ENCONTRO DE CONTAS' => 'MISTO DE ENCONTRO DE CONTAS'], $payment_comment ?? '', ['placeholder' => '', 'id' => 'payment_comment','class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Total Qtd. Kg') !!}:
                    {!! Form::text('total_quantity', $total_quantity ?? '', ['id' => 'total_quantity','class' => 'form-control','data-mask-type' => 'money','maxlength' => 20]) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-12 pd-t-5 pd-b-5"><hr></div>
    <div class="col-lg-12">
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
            <tbody>   
                @for ($i = 0; $i < $number_prevision; $i++)
                    <tr>
                        <td>
                            {!! Form::select('prev_product_category_id['.$i.']', \App\Models\ProductCategory::where([['category_id',NULL],['active', true]])->pluck('name','id'), $prev_product_category_id[$i] ?? '', ['placeholder' => '', 'id' => 'prev_product_category_id['.$i.']','class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::select('prev_product_type_id['.$i.']', \App\Models\ProductType::where([['category_id','=', $prev_product_category_id[$i]]],['active',true])->pluck('name','id'), $prev_product_type_id[$i] ?? '', ['placeholder' => '', 'id' => 'prev_product_type_id['.$i.']','class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::select('prev_shaving_type_id['.$i.']', \App\Models\ShavingType::where([['active',true]])->pluck('name','id'), $prev_shaving_type_id[$i] ?? '', ['placeholder' => '', 'id' => 'prev_shaving_type_id['.$i.']','class' => 'form-control']) !!}
                        </td>
                        <td>
                            {!! Form::text('prev_percent['.$i.']', $prev_percent[$i], ['id' => 'prev_percent['.$i.']','class' => 'form-control','data-mask-type' => 'percent','maxlength' => 6]) !!}
                        </td>
                        <td>
                            {!! Form::text('prev_quantity['.$i.']', $prev_quantity[$i], ['id' => 'prev_quantity['.$i.']','class' => 'form-control','data-mask-type' => 'money','maxlength' => 12]) !!}
                        </td>
                        <td>
                            {!! Form::text('prev_amount['.$i.']', $prev_amount[$i], ['id' => 'prev_amount['.$i.']','class' => 'form-control','data-mask-type' => 'money','maxlength' => 12,'data-indice' => $i]) !!}
                        </td>     
                        <td>
                            {!! Form::text('prev_total['.$i.']', $prev_total[$i], ['id' => 'prev_total['.$i.']','class' => 'form-control','data-mask-type' => 'money','maxlength' => 12,'data-indice' => $i]) !!}
                        </td>                                                
                    </tr>
                @endfor                 
            </tbody>
        </table>
    </div>
    <div class="col-lg-12 pd-t-5 pd-b-5"><hr></div>
    <div class="col-lg-12">
        <table class="table table-bordered table-list">
            <thead>
                <tr style="vertical-align: middle !important;">
                    <th width="90%" class="text-left">Arquivo</th>
                    <th width="10%" class="text-center">Abrir</th>
                </tr>
            </thead>
            <tbody>     
                @if(isset($upload_file))
                    @foreach($upload_file as $k => $v)
                        <tr>
                            <td style="height: 40px; padding-left: 20px; font-weight: bold;">
                                {{$v['filename']}}
                            </td>                                           
                            <td class="text-center">
                                @if(!empty($v['filename']))
                                    <button type="button" class="btn btn-primary btn-sm" data-indice="{{$k}}" data-icon="fa fa-eye" data-file="{{url('storage/receipt-plan/'.$v['filename'])}}" onclick="Application.onViewFile(this);">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </button>   
                                @endif
                            </td>
                        </tr>
                    @endforeach         
                @endif
            </tbody>
        </table>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
        $('#preview input,#preview textarea,#preview select').each(function(){
            //$(this).prop('disabled', true);
            $(this).attr('onfocus','blur();');
            $(this).addClass('disabled');    
        });
    });
</script>
    