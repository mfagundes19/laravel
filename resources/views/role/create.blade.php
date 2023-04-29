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
    </div>
</div>
<div class="content">
    <div class="row row-content-page">
        <div class="col-lg-12"><div class="spacing"></div></div>
        <div class="col-lg-12">
            {!! Form::open(['url' => url($route->module.'/create'),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/save'),'data-view' => $route->module.'/create']) !!}  
                {!! Form::hidden('procedure', 'create', ['id' => 'procedure']) !!}
                <div class="row col-lg-12">
                    <div class="col-lg-12">
                        <div class="form-group">
                            {!! Form::label('Nome') !!}:
                            {!! Form::text('name', $name ?? '', ['id' => 'name','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 pd-r-20">
                    <div class="table-responsive">
                        <table class="table table-bordered table-list">
                            <thead>
                                <tr>
                                    <th width="50%" class="text-left">Módulo</th>
                                    <th width="10%" class="text-center">Visualizar</th>
                                    <th width="10%" class="text-center">Adicionar</th>
                                    <th width="10%" class="text-center">Alterar</th>
                                    <th width="10%" class="text-center">Excluir</th>
                                    <th width="10%" class="text-center">Extra</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (\App\Models\Module::all() as $key => $element)
                                    @php                            
                                    $module_view[$key] = (isset($module_view[$key])) ? true : false;
                                    $module_create[$key] = (isset($module_create[$key])) ? true : false;
                                    $module_edit[$key] = (isset($module_edit[$key])) ? true : false;
                                    $module_delete[$key] = (isset($module_delete[$key])) ? true : false;
                                    $module_extra[$key] = (isset($module_extra[$key])) ? true : false;
                                    @endphp
                                    <tr>
                                        <td>
                                            {{$element->name}}
                                            {!! Form::hidden('module_id['.$key.']', $element->id, ['id' => 'module_id['.$key.']','class' => 'form-control']) !!}
                                        </td>
                                        <td class="text-center">
                                            {!! Form::checkbox('module_view['.$key.']', '1', $module_view[$key],['id' => 'module_view['.$key.']']) !!}
                                        </td>
                                        <td class="text-center">
                                            {!! Form::checkbox('module_create['.$key.']', '1', $module_create[$key],['id' => 'module_create['.$key.']']) !!}
                                        </td>
                                        <td class="text-center">
                                            {!! Form::checkbox('module_edit['.$key.']', '1', $module_edit[$key],['id' => 'module_edit['.$key.']']) !!}
                                        </td> 
                                        <td class="text-center">
                                            {!! Form::checkbox('module_delete['.$key.']', '1', $module_delete[$key],['id' => 'module_delete['.$key.']']) !!}
                                        </td>
                                        <td class="text-center">
                                            {!! Form::checkbox('module_extra['.$key.']', '1', $module_extra[$key],['id' => 'module_extra['.$key.']']) !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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