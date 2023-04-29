@php
if(isset($module_id) && !empty($module_id))
{
    $Module = new \App\Models\Module();
    $Module = $Module->find($module_id);
    if(!empty($Module) && empty($name))
    {
        $name = $Module->name;
        $link = $Module->module;
    }
}
@endphp
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
    </div>
</div>
<div class="content">
    <div class="row row-content-page">
        <div class="col-lg-12">
            {!! Form::open(['url' => url($route->module.'/edit'),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/save'),'data-refresh' => true]) !!}  
                {!! Form::hidden('procedure', 2, ['id' => 'procedure']) !!}
                {!! Form::hidden('product_category_id', $product_category_id ?? '', ['id' => 'product_category_id']) !!}
                {!! Form::hidden('research_parameters', $research_parameters ?? '', ['id' => 'menu_id']) !!}
                <div class="row col-lg-12">
                <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Nome') !!}:
                            {!! Form::text('name', $name ?? '', ['id' => 'name','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Categoria') !!}:
                            {!! Form::select('category_id', \App\Models\ProductCategory::pluck('name','id'), $category_id ?? '', ['placeholder' => 'Selecione', 'id' => 'category_id','class' => 'form-control','onchange' => 'Application.onRefresh(this);']) !!}
                        </div>
                    </div> 
                </div>
                <div class="col-lg-12 mg-t-20 pd-t-10 bdr-t">
                    <button type="submit" class="btn btn-primary btn-sm" onclick="Application.onValidate(this);">
                        <span class="label-btn">Salvar</span><i class="fa fa-check" aria-hidden=true></i>
                    </button> 
                    <span class="spacer-bar">|</span>
                    <button type="button" class="btn btn-secondary btn-sm" data-action="{{ route($route->module,$research_parameters) }}" onclick="Application.onRedirect(this);">
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
