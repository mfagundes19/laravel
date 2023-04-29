
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
                {!! Form::open(['url' => url($route->module.'/'.$route->action),'id' => 'form-general-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/save'),'data-view' => $route->module.'/'.$route->action]) !!}  
                    {!! Form::hidden('procedure', $route->action, ['id' => 'procedure']) !!}
                    {!! Form::hidden('receipt_plan_id', '', ['id' => 'receipt_plan_id']) !!}
                    <div class="row col-lg-12">  
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! Form::label('Fornecedor:') !!}:
                                {!! Form::select('supplier_id', \App\Models\Supplier::where([['active',true]])->pluck('name','id'), $supplier_id ?? '', ['placeholder' => '', 'id' => 'supplier_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div> 
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! Form::label('Nome/Razão Social:') !!}:
                                {!! Form::text('supplier_name', $supplier_name ?? '', ['id' => 'supplier_name','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Contato') !!}:
                                {!! Form::text('supplier_contact', $supplier_contact ?? '', ['id' => 'supplier_contact','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('Telefone') !!}:
                                {!! Form::text('supplier_telephone', $supplier_telephone ?? '', ['id' => 'supplier_telephone','class' => 'form-control','data-mask-type' => 'telephone']) !!}
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                {!! Form::label('E-mail:') !!}:
                                {!! Form::text('supplier_email', $supplier_email ?? '', ['id' => 'supplier_email','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Valor do Frete') !!}:
                                {!! Form::text('shipping_amount', $shipping_amount ?? '', ['id' => 'shipping_amount','class' => 'form-control','data-mask-type' => 'money','maxlength' => 20]) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Estado') !!}:
                                {!! Form::select('supplier_state', \App\Models\State::pluck('name','uf'), $supplier_state ?? '', ['placeholder' => '', 'id' => 'supplier_state','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Cidade') !!}:
                                {!! Form::select('supplier_city', \App\Models\City::where('uf','LIKE','%'.$supplier_state.'%')->pluck('name','name'), $supplier_city ?? '', ['placeholder' => '', 'id' => 'supplier_city','class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                {!! Form::label('Dt. Expiração') !!}:
                                {!! Form::text('date_expiration', $date_expiration ?? '', ['id' => 'date_expiration','class' => 'form-control','data-mask-type' => 'date','placeholder' => 'dd/mm/aaaa','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','autocomplete' => 'off','data-datepicker' => 'true']) !!}
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! Form::label('Anexo') !!}:
                                {!! Form::file('negotiation_upload', ['id' => 'negotiation_upload','class' => 'form-control','style' => 'height: 45px !important;','accept' => 'image/png, image/gif, image/jpeg'])  !!}
                            </div>
                        </div>
                        <div class="col-lg-12 mg-t-20 pd-t-10">
                            {!! Form::hidden('number_prevision', $number_prevision ?? '', ['id' => 'number_prevision']) !!}
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
                                            <th width="15%" class="text-center">Quantidade</th>
                                            <th width="60%" class="text-left">Produto</th>
                                            <th width="15%" class="text-center">R$ Unitário</th>
                                            <th width="10%" class="text-center">
                                                Limpar
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @for ($i = 0; $i < $number_prevision; $i++)
                                            <tr>
                                                <td>
                                                    {!! Form::text('prev_quantity['.$i.']', $prev_quantity[$i], ['id' => 'prev_quantity['.$i.']','class' => 'form-control','data-mask-type' => 'float','maxlength' => 8]) !!}
                                                </td>
                                                <td>
                                                {!! Form::text('prev_description['.$i.']', $prev_description[$i], ['id' => 'prev_description['.$i.']','class' => 'form-control','data-indice' => $i]) !!}
                                                </td>
                                                
                                                <td>
                                                    {!! Form::text('prev_amount['.$i.']', $prev_amount[$i], ['id' => 'prev_amount['.$i.']','class' => 'form-control','data-mask-type' => 'money','maxlength' => 12,'data-indice' => $i]) !!}
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
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Observações') !!}:
                            {!! Form::textarea('observations',$observations ?? '', ['id' => 'observations','class' => 'form-control','placeholder' => 'Observações','rows' => 3]) !!}   
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
