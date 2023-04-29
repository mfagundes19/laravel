<div class="row">
    <div class="container-fluid">
        <div class="col-lg-12 box-form-container">
            {!! Form::open(['url' => url($route->module.'/rate'),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/rate'),'data-refresh' => true]) !!}  
            {!! Form::hidden('page_number_prevision', $page_number_prevision ?? 1, ['id' => 'page_number_prevision']) !!}
            <div class="col-lg-2">
                <div class="form-group">
                    {!! Form::label('Total Quantidade(Kg)') !!}:
                    {!! Form::text('page_total_quantity', $page_total_quantity ?? '', ['id' => 'page_total_quantity','class' => 'form-control','data-mask-type' => 'float','maxlength' => 9]) !!}
                </div>
            </div>
            <table class="table table-bordered table-list"  style="margin-bottom: -1px;">
                <thead>
                    <tr style="vertical-align: middle !important;">
                        <th width="80%" class="text-left">Previsão de Produto/Família</th>
                        <th width="10%" class="text-center">
                            <button type="button" onclick="javascript: Application.onChangeQuantityModal(this);" class="btn-link" data-target="page_number_prevision" data-parameter="plus">Adicionar</button>    
                        </th>
                        <th width="10%" class="text-center">
                            <button type="button" onclick="javascript: Application.onChangeQuantityModal(this);" class="btn-link" data-target="page_number_prevision" data-parameter="minus">Remover</button>    
                        </th>
                    </tr>
                </thead>
            </table>
            {!! Form::textarea('modal_json_receipt_plan_rate', $modal_json_receipt_plan_rate ?? '', ['id' => 'modal_json_receipt_plan_rate','class' => 'form-control','style' => 'display: none;','rows' => 3]) !!}   
            <table class="table table-bordered table-list">
                <thead>
                    <tr style="vertical-align: middle !important;">
                        <th width="15%" class="text-left">Grupo</th>
                        <th width="15%" class="text-center">Tipo de Produto</th>
                        <th width="15%" class="text-center">Tipo de Apara</th>
                        <th width="10%" class="text-center">Prev. (%)</th>
                        <th width="10%" class="text-center">Prev. (KG)</th>
                        <th width="15%" class="text-center">Unitário (R$)</th>
                        <th width="15%" class="text-center">Total (R$)</th>
                        <th width="5%" class="text-center">Limpar</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $page_number_prevision; $i++)
                        <tr>
                            <td>
                                {!! Form::select('prev_product_category_id['.$i.']', \App\Models\ProductCategory::where([['category_id',NULL],['active', true]])->pluck('name','id'), $prev_product_category_id[$i] ?? '', ['placeholder' => '', 'id' => 'page_prev_product_category_id_'.$i,'class' => 'form-control','data-rule-required' => 'false','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onRefreshModal(this);','onblur' => 'javascript: ReceiptPlan.onBlurPrevision(this);']) !!}
                            </td>
                            <td>
                                {!! Form::select('prev_product_type_id['.$i.']', \App\Models\ProductType::where([['category_id','=', $prev_product_category_id[$i]]],['active',true])->pluck('name','id'), $prev_product_type_id[$i] ?? '', ['placeholder' => '', 'id' => 'page_prev_product_type_id_'.$i,'class' => 'form-control','data-rule-required' => 'false','data-msg-required' => '* Campo Obrigatório','onblur' => 'javascript: ReceiptPlan.onBlurPrevision(this);']) !!}
                            </td>
                            <td>
                                {!! Form::select('prev_shaving_type_id['.$i.']', \App\Models\ShavingType::where([['active',true]])->pluck('name','id'), $prev_shaving_type_id[$i] ?? '', ['placeholder' => '', 'id' => 'page_prev_shaving_type_id_'.$i,'class' => 'form-control','data-rule-required' => 'false','data-msg-required' => '* Campo Obrigatório','onblur' => 'javascript: ReceiptPlan.onBlurPrevision(this);']) !!}
                            </td>
                            <td>
                                {!! Form::text('prev_percent['.$i.']', $prev_percent[$i] ?? '', ['id' => 'page_prev_percent_'.$i,'class' => 'form-control','data-mask-type' => 'percent','maxlength' => 6,'onblur' => 'ReceiptPlan.onBlurPrevision(this);']) !!}
                            </td>
                            <td>
                                {!! Form::text('prev_quantity['.$i.']', $prev_quantity[$i] ?? '', ['id' => 'page_prev_quantity_'.$i,'class' => 'form-control','data-mask-type' => 'float','maxlength' => 9,'onblur' => 'ReceiptPlan.onBlurPrevision(this);']) !!}
                            </td>
                            <td>
                                {!! Form::text('prev_amount['.$i.']', $prev_amount[$i] ?? '', ['id' => 'page_prev_amount_'.$i,'class' => 'form-control','data-mask-type' => 'money','maxlength' => 12,'data-indice' => $i,'onblur' => 'ReceiptPlan.onBlurPrevision(this);']) !!}
                            </td>                                                
                            <td>
                                {!! Form::text('prev_total['.$i.']', $prev_total[$i] ?? '', ['id' => 'page_prev_total_'.$i,'class' => 'form-control','data-mask-type' => 'money','maxlength' => 12,'data-indice' => $i,'onblur' => 'ReceiptPlan.onBlurPrevision(this);']) !!}
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
            <div class="text-right">
                <button type="button" class="btn btn-primary btn-sm" onclick="ReceiptPlan.onAplicarRateio(this);">
                    Aplicar Rateio
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

</div><br>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
        switch($("#type_rate").val()) {
            case 'detalhado':
                var page_number_prevision = $("#page_number_prevision").val();
                for(var i=0; i < page_number_prevision; i++) {
                    $('#page_prev_percent_'+i).attr('onfocus','blur()');
                    $('#page_prev_percent_'+i).addClass('disabled');
                }
                $("#page_total_quantity").parent().parent().hide();
                break;
            case 'proporcional':
                var page_number_prevision = $("#page_number_prevision").val();
                for(var i=0; i < page_number_prevision; i++) {
                    $('#page_prev_percent_'+i).attr('onfocus','');
                    $('#page_prev_percent_'+i).removeClass('disabled');
                }
                break;
        }
    });
</script>
    