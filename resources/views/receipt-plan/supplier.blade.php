<div class="row">
    <div class="container-fluid">
        {!! Form::open(['url' => url($route->module.'/supplier'),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/supplier'),'data-refresh' => true]) !!}  
        {{$supplier_id ?? ''}}
        <div class="col-lg-12 box-form-container">
            <div class="col-lg-12">
                <div class="form-group">
                    {!! Form::label('CNPJ') !!}:
                    {!! Form::text('document', $document ?? '', ['id' => 'document','class' => 'form-control','data-mask-type' => 'cnpj', 'data-rule-cnpj' => 'true','data-msg-cnpj' => '* CNPJ Inválido']) !!} 
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Razão Social') !!}:
                    {!! Form::text('company', $company ?? '', ['id' => 'company','class' => 'form-control uppercase','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    {!! Form::label('Fantasia') !!}:
                    {!! Form::text('name', $name ?? '', ['id' => 'name','class' => 'form-control uppercase','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                </div>
            </div>
            <div class="col-lg-12"><br></div>
            <div class="col-lg-12">
                <div class="text-right">
                    <button type="button" class="btn btn-primary btn-sm" onclick="Supplier.onValidateModal(this);">
                        Cadastrar
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-12"><br></div>
        {!! Form::close() !!}
    </div>
</div><br>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();


        


    });
</script>
    