<div class="row">
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
                    {!! Form::select('branch_id', \App\Models\Branch::where([['active',true]])->pluck('name','id'), $supplier_id ?? '', ['placeholder' => '', 'id' => 'branch_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Forma de Pagto') !!}   
                    {!! Form::select('payment_method_id', \App\Models\PaymentMethod::where([['active',true]])->pluck('name','id'), $supplier_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Prazo de Pagto') !!}   
                    {!! Form::select('payment_term', ['Á VISTA' => 'Á VISTA','0/30 D' => '0/30/45 D','0/30/45 D' => '0/30/45 D','0/30/45/60 D' => '0/30/45/60 D','5 D' => '5 D','7 D' => '14 D','14 D' => '14 D','21 D' => '21 D','28 D' => '28 d','30 D' => '30 D','35 D' => '35 D','45 D' => '45 D','50 D' => '50 D','28/35 D' => '28/35 D','35/35/42 D' => '35/35/42 D','28/35/42/49 D' => '28/35/42/49 D','28/35/42/49/56 D' => '28/35/42/49/56 D','30/60 D' => '30/60 D','30/45/60 D' => '30/45/60 D','30/45/60/75 D' => '30/45/60/75 D','30/60/90 D' => '30/60/90 D','30/60/90/120 D' => '30/60/90/120 D','45/60 D' => '45/60 D','45/60/75 D' => '45/60/75 D','45/60/75/90 D' => '45/60/75/90 D'], $payment_term ?? '', ['placeholder' => '', 'id' => 'payment_term','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
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
                    <th width="25%" class="text-left">Grupo</th>
                    <th width="30%" class="text-center">Tipo de Produto</th>
                    <th width="15%" class="text-center">Previsão (%)</th>
                    <th width="15%" class="text-center">Previsão (KG)</th>
                    <th width="15%" class="text-center">Valor (R$)</th>
                </tr>
            </thead>
            <tbody>   
                @for ($i = 0; $i < $number_prevision; $i++)
                    <tr>
                        <td>
                            {!! Form::select('prev_product_category_id['.$i.']', \App\Models\ProductCategory::where([['category_id',NULL],['active', true]])->pluck('name','id'), $prev_product_category_id[$i] ?? '', ['placeholder' => '', 'id' => 'prev_product_category_id['.$i.']','class' => 'form-control','data-rule-required' => 'false','onchange' => 'Application.onRefresh(this);','onblur' => 'javascript: ReceiptPlan.onChangeQuantity(this);']) !!}
                        </td>
                        <td>
                            {!! Form::select('prev_product_type_id['.$i.']', \App\Models\ProductType::where([['category_id','=', $prev_product_category_id[$i]]],['active',true])->pluck('name','id'), $prev_product_type_id[$i] ?? '', ['placeholder' => '', 'id' => 'prev_product_type_id['.$i.']','class' => 'form-control','data-rule-required' => 'false','onblur' => 'javascript: ReceiptPlan.onChangeQuantity(this);']) !!}
                        </td>
                        <td>
                            {!! Form::text('prev_percent['.$i.']', $prev_percent[$i], ['id' => 'prev_percent['.$i.']','class' => 'form-control','data-mask-type' => 'percent','maxlength' => 6,'onblur' => 'javascript: ReceiptPlan.onChangeQuantity(this);']) !!}
                        </td>
                        <td>
                            {!! Form::text('prev_quantity['.$i.']', $prev_percent[$i], ['id' => 'prev_quantity['.$i.']','class' => 'form-control','data-mask-type' => 'money','maxlength' => 12,'onblur' => 'javascript: ReceiptPlan.onChangeQuantity(this);']) !!}
                        </td>
                        <td>
                            {!! Form::text('prev_amount['.$i.']', $prev_amount[$i], ['id' => 'prev_amount['.$i.']','class' => 'form-control','data-mask-type' => 'money','maxlength' => 12,'data-indice' => $i,'onblur' => 'javascript: ReceiptPlan.onChangeQuantity(this);']) !!}
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
                    <th width="50%" class="text-left">Arquivo</th>
                    <th width="40%" class="text-left">Nome Original</th>
                    <th width="10%" class="text-center">Abrir</th>
                </tr>
            </thead>
            <tbody>   
                @for ($i = 0; $i < $number_upload; $i++)
                    <tr>
                        <td style="padding: 15px;">
                            {{$upload_filename[$i]}}
                        </td>
                        <td>
                            {{$upload_name[$i]}}
                        </td>
                        <td class="text-center">
                           <button type="button" class="btn btn-secondary btn-sm" data-file="{{url('storage/receipt-plan/'.$upload_filename[$i])}}" onclick="Application.onViewFile(this);">
                                <i class="fa fa-eye"></i>
                           </button>
                        </td>
                    </tr>
                @endfor                 
            </tbody>
        </table>
    </div>
</div>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
        $('input,textarea,select').each(function(){
            $(this).prop('disabled', true);
        });
    });
</script>
    