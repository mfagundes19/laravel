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
        <div class="col-lg-12 box-form-container">
            {!! Form::open(['url' => url($route->module.'/'.$route->action),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/save'),'data-refresh' => true]) !!}  
                {!! Form::hidden('procedure', $route->action, ['id' => 'procedure']) !!}
                {!! Form::hidden('supplier_id', $supplier_id ?? '', ['id' => 'supplier_id']) !!}
                <div class="row">
                    <div class="col-lg-12">
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
                            @break
                        @endswitch
                    @endif
                    <div class="col-lg-12"><div class="spacing"><hr></div></div>                
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Apelido') !!}:
                            {!! Form::text('nickname', $nickname ?? '', ['id' => 'nickname','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Fantasia') !!}:
                            {!! Form::text('name', $name ?? '', ['id' => 'name','class' => 'form-control uppercase','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Indicador de IE') !!}:
                            {!! Form::select('indexer_state', ['1' => 'Contribuinte ICMS', '2' => 'Contribuinte isento de Inscrição no cadastro de Contribuintes do ICMS','9' => 'Não Contribuinte, que pode ou não possuir Inscrição Estadual no Cadastro de Contribuintes do ICMS'], $indexer_state ?? '', ['placeholder' => '', 'id' => 'indexer_state','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Inscrição Municipal') !!}:
                            {!! Form::text('municipal_registration', $municipal_registration ?? '', ['id' => 'municipal_registration','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Inscrição Estadual') !!}:
                            {!! Form::text('state_registration', $state_registration ?? '', ['id' => 'state_registration','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Tipo de Parceiro') !!}:
                            {!! Form::select('partner_type_id', \App\Models\PartnerType::where([['active',true]])->pluck('name','id') , $partner_type_id ?? '', ['placeholder' => '', 'id' => 'partner_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Classe') !!}:
                            {!! Form::select('supplier_category_id', \App\Models\SupplierCategory::where([['active',true]])->pluck('name','id'), $supplier_category_id ?? '', ['placeholder' => '', 'id' => 'supplier_category_id','class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Região') !!}:
                            {!! Form::select('region_id', \App\Models\Region::where([['active',true]])->pluck('name','id'), $region_id ?? '', ['placeholder' => '', 'id' => 'region_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
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
                            {!! Form::select('state', \App\Models\State::pluck('name','uf'), $state ?? '', ['placeholder' => '', 'id' => 'state','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','onchange' => 'Application.onRefresh(this);']) !!}
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
                            {!! Form::label('Dados Bancários') !!}:
                            {!! Form::textarea('payment_information',$payment_information ?? '', ['id' => 'payment_information','class' => 'form-control','placeholder' => 'Observações','rows' => 3]) !!}   
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Observações') !!}:
                            {!! Form::textarea('observations',$observations ?? '', ['id' => 'observations','class' => 'form-control','placeholder' => 'Observações','rows' => 3]) !!}   
                        </div>
                    </div>
                    <div class="col-lg-12"><div class="spacing"><hr></div></div>
                    {!! Form::hidden('number_contact', $number_contact ?? 3, ['id' => 'number_contact']) !!}
                    <div class="col-lg-12">
                        <table class="table table-bordered table-list"  style="margin-bottom: -1px;">
                            <thead>
                                <tr style="vertical-align: middle !important;">
                                    <th width="80%" class="text-left">Contatos</th>
                                    <th width="10%" class="text-center">
                                        <button type="button" onclick="javascript: Application.onChangeQuantity(this);" class="btn-link" data-target="number_contact" data-parameter="plus">Adicionar</button>    
                                    </th>
                                    <th width="10%" class="text-center">
                                        <button type="button" onclick="javascript: Application.onChangeQuantity(this);" class="btn-link" data-target="number_contact" data-parameter="minus">Remover</button>    
                                    </th>
                                </tr>
                            </thead>
                        </table>
                        <table class="table table-bordered table-list">
                            <thead>
                                <tr style="vertical-align: middle !important;">
                                    <th width="30%">Nome</th>
                                    <th width="25%">E-mail</th>
                                    <th width="15%">Telefone</th>
                                    <th width="20%">Área de Atuação</th>
                                    <th width="5%" class="text-center">Limpar</th>
                                </tr>
                            </thead>
                        <tbody>
                            @for ($i = 0; $i < $number_contact; $i++)
                                    <tr>
                                        <td>
                                            {!! Form::text('contact_name['.$i.']', $contact_name[$i] ?? '', ['id' => 'contact_name_'.$i,'class' => 'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('contact_email['.$i.']', $contact_email[$i] ?? '', ['id' => 'contact_email_'.$i,'class' => 'form-control']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('contact_telephone['.$i.']', $contact_telephone[$i] ?? '', ['id' => 'contact_telephone_'.$i,'class' => 'form-control','placeholder' => '(00)00000-0000','data-mask-type' => 'cellphone']) !!}
                                        </td>
                                        <td>
                                            {!! Form::text('contact_role['.$i.']', $contact_role[$i] ?? '', ['id' => 'contact_role_'.$i,'class' => 'form-control']) !!}
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
