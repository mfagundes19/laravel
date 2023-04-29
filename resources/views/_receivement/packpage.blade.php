<div class="row">
    <div class="container-fluid">
        {!! Form::open(['url' => url($route->module.'/packpage'),'id' => 'form-'.$route->module.'-'.$route->action,'method' => 'POST','data-action' => url($route->module.'/packpage'),'data-refresh' => true]) !!}  
        {!! Form::hidden('receipt_plan_id', $receipt_plan_id ?? '', ['id' => 'receipt_plan_id']) !!}
        {!! Form::hidden('user_id', $user_id ?? '', ['id' => 'user_id']) !!}
        <div class="col-lg-12 box-form-container">
            <div class="col-lg-3">
                {!! Form::label('Número Cartão') !!}:
                {!! Form::text('packpage_number_card',$packpage_number_card ?? '', ['id' => 'packpage_number_card','class' => 'form-control','placeholder' => '','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}   
            </div>
            <div class="col-lg-3">
                {!! Form::label('Peso') !!}:
                {!! Form::text('packpage_weight',$packpage_weight ?? '', ['id' => 'packpage_weight','class' => 'form-control','placeholder' => '','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','data-mask-type' => 'money']) !!}   
            </div>
            <div class="col-lg-3">
                {!! Form::label('Tipo de Apara') !!}:
                {!! Form::select('packpage_shaving_type_id', \App\Models\ShavingType::where([['active',true]])->pluck('name','id'), $packpage_shaving_type_id ?? '', ['placeholder' => '', 'id' => 'packpage_shaving_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
            </div>
            <div class="col-lg-3">
                {!! Form::label('Vasilhame') !!}:
                {{$packpage_container_type_id}}
                {!! Form::select('packpage_container_type_id', \App\Models\ContainerType::where([['active',true]])->pluck('name','id'), $packpage_container_type_id ?? '', ['placeholder' => '', 'id' => 'packpage_container_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
            </div>
            <div class="col-lg-12">
                {!! Form::label('Observações') !!}:
                {!! Form::textarea('packpage_observations',$packpage_observations ?? '', ['id' => 'packpage_observations','class' => 'form-control','placeholder' => 'Observações','rows' => 3]) !!}   
                {!! Form::textarea('packpage_json_packpage',$packpage_json_packpage ?? '', ['id' => 'packpage_json_packpage','class' => 'form-control','placeholder' => '','rows' => 3]) !!}   
            </div>
            <div class="col-lg-12"><br></div>
            <div class="col-lg-12">
                <div class="text-right">
                    <button type="button" class="btn btn-primary btn-sm" id="btnAddPackpage" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage">
                        <span class="label-btn">Salvar</span><i class="fa fa-check" aria-hidden=true></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-lg-12"><br></div>
        {!! Form::close() !!}
        <div class="col-lg-12"><br></div>
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
                @if(count($list_packpage) > 0)
                    @foreach($list_packpage as $k => $v)
                        <tr>
                            <td class="text-center">{{$v['number_card']}}</td>
                            <td class="text-center">{{$v['weight']}}kg</td>
                            <td>{{$v['shaving_type']}}</td>
                            <td>{{$v['container_type']}}</td>
                            <td>{{$v['observations']}}</td>
                            <td class="text-center">
                                @if(Auth::user()->hasPermission($route->module,'edit'))
                                    <button type="button" class="btn btn-secondary btn-sm btn-icon btn-edit" data-toggle="tooltip" data-placement="left" title="Editar" data-original-title="Editar"  data-indice="{{$k}}" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage" onclick="Receivement.onPackpageEdit(this);">
                                        <i class="fa fa-pen" aria-hidden="true"></i>
                                    </button>
                                @endif
                                @if(Auth::user()->hasPermission($route->module,'delete'))
                                    <button type="button" class="btn btn-danger btn-sm btn-icon btn-remove" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir" data-indice="{{$k}}" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage" onclick="Receivement.onPackpageDelete(this);">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>   
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </table>
        </div>                
    </div>
</div><br>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
        $("#btnAddPackpage").on('click', function(){
            var jsonPackpage = [];
            if($("#packpage_json_packpage").val() != "") {
                jsonPackpage = JSON.parse($("#packpage_json_packpage").val());
            }
            var element = {
                "number_card": $("#packpage_number_card").val(),
                "weight": $("#packpage_weight").val(),
                "shaving_type_id": $("#packpage_shaving_type_id").val(),
                "shaving_type": $("#packpage_shaving_type_id option:selected").text(),
                "container_type_id": $("#packpage_container_type_id").val(),
                "container_type": $("#packpage_container_type_id option:selected").text(),
                "observations": $("#packpage_observations").val(),
            };
            jsonPackpage.push(element);
            var weight_received = 0;
            var strData = new String();
            for(var k in jsonPackpage) {
                console.log(jsonPackpage[k]);
                console.log(jsonPackpage[k].weight);
                strData = jsonPackpage[k].weight;
                strData = strData.replace(".","");
                strData = strData.replace(",",".");
                var weight = parseFloat(strData);
                weight_received+= weight;
            }
            $("#packpage_json_packpage").val(JSON.stringify(jsonPackpage));
            $("#packpage_json_packpage").val(JSON.stringify(jsonPackpage));
            $("#weight_received").val(weight_received);
            

            
            $("#json_packpage").val(JSON.stringify(jsonPackpage));
            setTimeout(() => {
                Receivement.onRefreshModal($(this));
            }, 500);       
        });
        $(".close").on('click', function(){
            Application.onRefreshOptional('form-general-receivement');
        }); 
    });
</script>
    