<div class="row">
    <div class="container-fluid">
        {!! Form::open(['url' => url($route->module.'/verification/'.$receivement_id),'id' => 'form-'.$route->module.'-'.$route->action,'method' => 'POST','data-action' => url($route->module.'/verification/'.$receivement_id),'data-refresh' => true]) !!}  
        {!! Form::hidden('receivement_id', $receivement_id ?? '', ['id' => 'receivement_id']) !!}
        {!! Form::hidden('receivement_packpage_id', $receivement_packpage_id ?? '', ['id' => 'receivement_packpage_id']) !!}
        <div class="col-lg-12">
            <table class="table table-bordered table-list">
                <thead>
                    <tr style="vertical-align: middle !important;">
                        <th width="10%" class="text-center">Número Cartão</th>
                        <th width="10%" class="text-center">Peso</th>
                        <th width="20%">Tipo de Apara</th>
                        <th width="20%">Vasilhame</th>
                        <th width="30%">Observações</th>
                        <th width="10%" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($packpage) > 0)
                        @foreach($packpage as $k => $v)
                            <tr>
                                <td class="text-center">{{$v['number_card']}}</td>
                                <td class="text-center">{{$v['weight']}}kg</td>
                                <td>{{$v['shaving_type']}}</td>
                                <td>{{$v['container_type']}}</td>
                                <td>{{$v['observations']}}</td>
                                <td class="text-center">
                                    @if(Auth::user()->hasPermission($route->module,'create'))
                                        @if(empty($v['status']))
                                        <button type="button" 
                                            class="btn btn-secondary btn-sm btn-icon btn-check" 
                                            data-toggle="tooltip" 
                                            data-placement="left" 
                                            title="Validar" 
                                            data-original-title="Validar" 
                                            data-id="{{$v['receivement_packpage_id']}}" 
                                            data-parameter="1"
                                            data-target="form-{{$route->module}}-{{$route->action}}" 
                                            data-modal="modal-view-page-verification" 
                                            data-modal-load="modal-load-content-verification"
                                            >
                                            <i class="fa fa-check" aria-hidden="true" style="color: green;"></i>
                                        </button>
                                        <button type="button" 
                                            class="btn btn-secondary btn-sm btn-icon btn-check" 
                                            data-toggle="tooltip" 
                                            data-placement="left" 
                                            title="Validar" 
                                            data-original-title="Validar" 
                                            data-id="{{$v['receivement_packpage_id']}}" 
                                            data-parameter="2"
                                            data-target="form-{{$route->module}}-{{$route->action}}" 
                                            data-modal="modal-view-page-verification" 
                                            data-modal-load="modal-load-content-verification"
                                            >
                                            <i class="fa fa-times" aria-hidden="true" style="color: red;"></i>
                                        </button>
                                        @else
                                            @if($v['status'] == 1)
                                                <span type="button" class="btn btn-success btn-sm btn-icon" style="width: 40px;">
                                                    <i class="fa fa-check" aria-hidden="true"></i>
                                                </span>    
                                            @endif
                                            @if($v['status'] == 2)
                                                <button type="button" class="btn btn-danger btn-sm btn-icon" style="width: 40px;">
                                                    <i class="fa fa-times" aria-hidden="true"></i>
                                                </button>    
                                            @endif
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="4">Nenhum registro encontrado...</td></tr>        
                    @endif
                </tbody>
            </table>
        </div>
        {!! Form::close() !!}
    </div>
</div><br>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
        /**
         * onclick="Receivement.onCheckPackpage(this);"
         */
        $(".btn-check").on('click', function(){
            let FormDataObject = new FormData();
            let button = $(this);
            FormDataObject.append("_token", $('meta[name="csrf-token"]').attr('content'));
            FormDataObject.append('receivement_packpage_id', $(button).attr('data-id'));
            FormDataObject.append('status', $(button).attr('data-parameter'));
            $.ajax({
                type: 'POST',
                url: $('#app').attr('data-base-url')+'/receivement/inspection',
                data: FormDataObject,
                processData: false, 
                contentType: false, 
                cache: false,     
                dataType: 'json',
                success: function(json) {
                    switch(json.result) {
                        case 'success':
                            alertify.success('Operação relizada com sucesso!');
                            break;
                        case 'error':
                            alertify.error('Não foi possivel realizar a operação!');
                            break;
                        default:
                            return;
                    }
                }
            });
            setTimeout(() => {
                //$('.close').trigger('click');
                Receivement.onRefreshModal(button);
            }, 500);        
        });
    });
</script>
    