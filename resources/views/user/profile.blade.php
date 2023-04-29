<div class="content-header">
    <div class="container-fluid">
        <div class="row row-content-header">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Usuários</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('users') }}">Usuários</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="content">
    <div class="row row-content-page">
        <div class="col-lg-12">
            {!! Form::open(['url' => url($route->module.'/'.$route->action),'id' => 'form-general-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/save'),'data-view' => $route->module.'/'.$route->action, 'files' => true]) !!}  
                {!! Form::hidden('procedure', $route->action, ['id' => 'procedure']) !!}
                {!! Form::hidden('user_id', $user_id ?? '', ['id' => 'user_id']) !!}
                <div class="row col-lg-12">
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Nome') !!}:
                            {!! Form::text('name', $name ?? '', ['id' => 'name','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('E-mail') !!}:
                            {!! Form::text('email', $email ?? '', ['id' => 'email','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','data-check-field' => 'email', 'data-check-action' => $route->module.'/exists', 'data-check-seqnr' => $user_id,'data-check-msg' => 'Já existe um usuário com este e-mail cadastrado. Verifique!','onblur' => 'Application.onExists(this);']) !!}
                        </div>
                    </div>       
                    <div class="col-lg-6">
                        <div class="form-group">
                            {!! Form::label('Senha') !!}:
                            {!! Form::password('password', ['id' => 'password','class' => 'form-control']) !!}
                        </div>
                    </div>     
                    <div class="col-lg-10">
                        <div class="form-group">
                            {!! Form::label('Foto') !!}:
                            {!! Form::file('user_photo', ['id' => 'user_photo','class' => 'form-control','style' => 'height: 45px !important;','onchange' => 'PreviewImageThumb(this);'])  !!}
                        </div>
                    </div>   
                    <div class="col-lg-2">
                        <div id="box-preview-image" style="display: inline;">
                            <img src="{{url('/images/no-image.jpg')}}" id="preview-image" style="margin-top: 30px; border: solid 1px #CDCDCD; padding: 5px;">
                        </div>
                    </div>      




                </div>
                <div class="col-lg-12 mg-t-20 pd-t-10 bdr-t">
                    <button type="submit" class="btn btn-primary btn-sm" onclick="Application.onValidate(this);">
                        <span class="label-btn">Salvar</span><i class="fa fa-check" aria-hidden=true></i>
                    </button> 
                    <span class="spacer-bar">|</span>
                    <button type="button" class="btn btn-secondary btn-sm" data-action="{{ route($route->module, $research_parameters) }}" onclick="Application.onRedirect(this);">
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
