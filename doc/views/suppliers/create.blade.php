<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2 row-content-header">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{$route->name}}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{$route->module}}">{{$route->name}}</a></li>
                    <li class="breadcrumb-item active">Adicionar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="container-fluid">
        <div class="col-lg-12">
            {!! Form::open(['url' => url($route->module.'/create'),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/save'),'data-refresh' => true]) !!}  
                {!! Form::hidden('procedure', 1, ['id' => 'procedure']) !!}
                {!! Form::hidden('supplier_id', $supplier_id ?? '', ['id' => 'supplier_id']) !!}
                <div class="row col-lg-12">
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Classe') !!}:
                            {!! Form::select('supplier_category_id', \App\Models\SupplierCategory::pluck('name','id'), $supplier_category_id ?? '', ['placeholder' => '', 'id' => 'supplier_category_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Tipo de Cadastro') !!}:
                            {!! Form::select('registration_type_id', ['1' => 'Pessoa Física', '2' => 'Pessoa Jurídica'], $registration_type_id ?? '', ['placeholder' => '', 'id' => 'registration_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onRefresh(this);']) !!}
                        </div>
                    </div>
                    @if(!empty($registration_type_id))
                        @switch($registration_type_id)
                            @case(1)
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('CPF') !!}:
                                        {!! Form::text('document', $document ?? '', ['id' => 'document','class' => 'form-control','data-mask-type' => 'cpf', 'data-rule-cpf' => 'true','data-msg-cpf' => '* CPF Inválido']) !!} 
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Nome') !!}:
                                        {!! Form::text('company', $company ?? '', ['id' => 'company','class' => 'form-control uppercase','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        {!! Form::label('Fantasia') !!}:
                                        {!! Form::text('name', $name ?? '', ['id' => 'name','class' => 'form-control uppercase','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                                    </div>
                                </div>
                            @break
                            @case(2)
                                <div class="col-lg-6">
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
                            @break
                        @endswitch
                    @endif
                    <div class="col-lg-12"><div class="spacing"><hr></div></div>                
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('E-mail') !!}:
                            {!! Form::text('email', $email ?? '', ['id' => 'email','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('E-mail Alternativo') !!}:
                            {!! Form::text('email_secundary', $email_secundary ?? '', ['id' => 'email_secundary','class' => 'form-control']) !!}
                        </div>
                    </div>                
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Telefone') !!}:
                            {!! Form::text('telephone', $telephone  ?? '', ['id' => 'telephone','class' => 'form-control','placeholder' => '(00)0000-0000','data-mask-type' => 'telephone','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Telefone Alternativo') !!}:
                            {!! Form::text('telephone_secundary', $telephone_secundary  ?? '', ['id' => 'telephone_secundary','class' => 'form-control','placeholder' => '(00)0000-0000','data-mask-type' => 'telephone']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('CEP') !!}:
                            {!! Form::text('zipcode', $zipcode ?? '', ['id' => 'zipcode','class' => 'form-control','placeholder' => '00000-000','data-mask-type' => 'cep','onblur' => 'Application.onChangeCEP();']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Estado') !!}:
                            {!! Form::select('state', \App\Models\State::pluck('name','uf'), $state ?? '', ['placeholder' => '', 'id' => 'state','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onReload(this);']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Logradouro') !!}:
                            {!! Form::text('address', $address ?? '', ['id' => 'address','class' => 'form-control','placeholder' => 'Logradouro']) !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('Número') !!}:
                            {!! Form::text('number', $number ?? '', ['id' => 'number','class' => 'form-control','placeholder' => 'Número']) !!}
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="form-group">
                            {!! Form::label('Complemento') !!}:
                            {!! Form::text('complement', $complement ?? '', ['id' => 'complement','class' => 'form-control','placeholder' => 'Complemento']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Bairro') !!}:
                            {!! Form::text('district', $district ?? '', ['id' => 'district','class' => 'form-control','placeholder' => 'Bairro']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Cidade') !!}:
                            {!! Form::select('city', \App\Models\City::where('uf','LIKE','%'.$state.'%')->pluck('name','name'), $city ?? '', ['placeholder' => '', 'id' => 'city','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Observações') !!}:
                            {!! Form::textarea('observations',$observations ?? '', ['id' => 'observations','class' => 'form-control','placeholder' => 'Observações','rows' => 3]) !!}   
                        </div>
                    </div>
                </div>
                <div class="col-lg-12"><div class="spacing"><hr></div></div>
                <div class="col-lg-12">
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
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
    });
</script>
