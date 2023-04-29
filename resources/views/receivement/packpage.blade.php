<div class="row">
    <div class="container-fluid">
        {!! Form::open(['url' => url($route->module.'/packpage'),'id' => 'form-'.$route->module.'-'.$route->action,'method' => 'POST','data-action' => url($route->module.'/packpage'),'data-refresh' => true]) !!}  
        {!! Form::hidden('receipt_plan_id', $receipt_plan_id ?? '', ['id' => 'receipt_plan_id']) !!}
        {!! Form::hidden('user_id', $user_id ?? '', ['id' => 'user_id']) !!}
        {!! Form::hidden('packpage_indice', '', ['id' => 'packpage_indice']) !!}
        <div class="col-lg-12 box-form-container">
            <div class="col-lg-3">
                {!! Form::label('Número Cartão') !!}:
                {!! Form::text('packpage_number_card',$packpage_number_card ?? '', ['id' => 'packpage_number_card','class' => 'form-control','placeholder' => '','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}   
            </div>
            <div class="col-lg-3">
                {!! Form::label('Peso') !!}:
                {!! Form::text('packpage_weight',$packpage_weight ?? '', ['id' => 'packpage_weight','class' => 'form-control','placeholder' => '','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório','data-mask-type' => 'money']) !!}   
            </div>
            <div class="col-lg-6">
                {!! Form::label('Grupo do Produto') !!}:
                {!! Form::select('packpage_product_type_id', \App\Models\ProductType::where([['active',true]])->pluck('name','id'), $packpage_product_type_id ?? '', ['placeholder' => '', 'id' => 'packpage_product_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
            </div>
            <div class="col-lg-6">
                {!! Form::label('Tipo de Apara') !!}:
                {!! Form::select('packpage_shaving_type_id', \App\Models\ShavingType::where([['active',true]])->pluck('name','id'), $packpage_shaving_type_id ?? '', ['placeholder' => '', 'id' => 'packpage_shaving_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
            </div>
            <div class="col-lg-6">
                {!! Form::label('Vasilhame') !!}:
                {{$packpage_container_type_id}}
                {!! Form::select('packpage_container_type_id', \App\Models\ContainerType::where([['active',true]])->pluck('name','id'), $packpage_container_type_id ?? '', ['placeholder' => '', 'id' => 'packpage_container_type_id','class' => 'form-control','data-rule-required' => 'true','data-msg-required' => '* Campo Obrigatório']) !!}
            </div>
            <div class="col-lg-12">
                {!! Form::label('Observações') !!}:
                {!! Form::textarea('packpage_observations',$packpage_observations ?? '', ['id' => 'packpage_observations','class' => 'form-control','placeholder' => 'Observações','rows' => 3]) !!}   
                <div class="">
                    {!! Form::textarea('packpage_json_packpage',$packpage_json_packpage ?? '', ['id' => 'packpage_json_packpage','class' => 'form-control','placeholder' => '','rows' => 3]) !!}   
                </div>
            </div>
            <div class="col-lg-12"><br></div>
            <div class="col-lg-12">
                <div class="text-right">
                    <button type="button" class="btn btn-primary btn-sm" id="btnAddPackpage" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage">
                        <span class="label-btn">Cadastrar</span><i class="fa fa-check" aria-hidden=true></i>
                    </button>
                    <button type="button" class="btn btn-primary btn-sm hidden" id="btnEditPackpage" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage">
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
                        <th width="10%" class="text-center">Nº Cartão</th>
                        <th width="10%" class="text-center">Peso</th>
                        <th width="10%">Grupo</th>
                        <th width="10%">Apara</th>
                        <th width="10%">Vasilhame</th>
                        <th width="10%" class="text-center">Tempo</th>
                        <th width="10%" class="text-center">Status</th>
                        <th width="20%" class="text-center">Ações</th>
                    </tr>
                </thead>
                @if(count($list_packpage) > 0)
                    @foreach($list_packpage as $k => $v)
                        <tr data-id="{{$k}}" @if(!empty($v['observations'])) bgcolor="#ffcc00" @endif>
                            <td class="text-center">{{$v['number_card']}}</td>
                            <td class="text-center">{{$v['weight']}}kg</td>
                            <td>{{$v['product_type'] ?? ''}}</td>
                            <td>{{$v['shaving_type'] ?? ''}}</td>
                            <td>{{$v['container_type'] ?? ''}}</td>
                            <td class="text-center"><span id="label_time_{{$k}}">{{$v['elapsed_time']}}</span></td>
                            <td class="text-center"><span id="label_status_{{$k}}">{{$v['status']}}</span></td>
                            <td class="text-center">
                                @if(Auth::user()->hasPermission($route->module,'edit'))
                                    <button type="button" id="btn_play_{{$k}}" class="btn btn-secondary btn-sm btn-icon btn-play" data-toggle="tooltip" data-placement="left" title="Iniciar" data-original-title="Editar"  data-indice="{{$k}}" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage" data-indice="{{$k}}" onclick="Receivement.onPackpageEdit(this);">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" id="btn_pause_{{$k}}" class="btn btn-secondary btn-sm btn-icon btn-pause" data-toggle="tooltip" data-placement="left" title="Parar" data-original-title="Editar"  data-indice="{{$k}}" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage" data-indice="{{$k}}" onclick="Receivement.onPackpageEdit(this);" disabled>
                                        <i class="fa fa-pause" aria-hidden="true"></i>
                                    </button>
                                    <button type="button" id="btn_stop_{{$k}}" class="btn btn-secondary btn-sm btn-icon btn-stop" data-toggle="tooltip" data-placement="left" title="Finalizar" data-original-title="Editar"  data-indice="{{$k}}" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage" data-indice="{{$k}}" onclick="Receivement.onPackpageEdit(this);" disabled>
                                        <i class="fa fa-stop" aria-hidden="true"></i>
                                    </button>
                                @endif
                                @if(Auth::user()->hasPermission($route->module,'edit'))
                                    <button type="button" class="btn btn-secondary btn-sm btn-icon btn-edit" data-toggle="tooltip" data-placement="left" title="Editar" data-original-title="Editar"  data-indice="{{$k}}" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage" data-indice="{{$k}}" onclick="Receivement.onPackpageEdit(this);">
                                        <i class="fa fa-pen" aria-hidden="true"></i>
                                    </button>
                                @endif
                                @if(Auth::user()->hasPermission($route->module,'delete'))
                                    <button type="button" class="btn btn-danger btn-sm btn-icon btn-remove" data-toggle="tooltip" data-placement="left" title="Excluir" data-original-title="Excluir" data-indice="{{$k}}" data-target="form-{{$route->module}}-{{$route->action}}" data-modal="modal-view-page-packpage" data-modal-load="modal-load-content-packpage" data-indice="{{$k}}" onclick="Receivement.onPackpageDelete(this);">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </button>   
                                @endif
                                <input type="hidden" name="time_start_{{$k}}" id="time_start_{{$k}}" value="">
                                <input type="hidden" name="elapsed_time_{{$k}}" id="elapsed_time_{{$k}}" value="">
                            </td>
                        </tr>
                        <tr id="div_packpage_{{$k}}" style="display: none;">
                            <td colspan="100%">
                                <table class="table table-bordered table-list">
                                    <thead>  
                                        <tr>
                                            <th width="15%">Observações</th>
                                        </tr>
                                    </thead>
                                    <tr>
                                        <td>{{$v['observations']}}</td>        
                                    </tr>
                                </table>                
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

        $('table tr').on('click', function(){
            var receivement_id = $(this).attr('data-id');
            if($('#div_packpage_'+$(this).attr('data-id')).css('display') == 'none') {
                $('#div_packpage_'+$(this).attr('data-id')).show();
            } else {
                $('#div_packpage_'+$(this).attr('data-id')).hide();
            }
        });

        $('.btn-play').on('click', function() {
            var button = $(this);
            $("#btn_play_"+$(button).attr('data-indice')).attr('disabled', true);
            $("#btn_pause_"+$(button).attr('data-indice')).attr('disabled', false);
            $("#time_start_"+$(button).attr('data-indice')).val(moment().format('YYYY-MM-DD HH:mm:ss'));
            $("#label_status_"+$(button).attr('data-indice')).html('Iniciado');
        });
        $('.btn-pause').on('click', function() {
            var button = $(this);
            $("#btn_pause_"+$(button).attr('data-indice')).attr('disabled', true);
            $("#btn_stop_"+$(button).attr('data-indice')).attr('disabled', false);
            var antes = moment($("#time_start_"+$(button).attr('data-indice')).val());
            var depois = moment(moment().format('YYYY-MM-DD HH:mm:ss'));
            var horas = depois.diff(antes, 'hours');
            var minutos = depois.diff(antes, 'minutes');
            var segundos = depois.diff(antes, 'seconds');
            var elapsed_time = DateTimeApp.onFormatTime(horas,minutos,segundos);
            $("#elapsed_time_"+$(button).attr('data-indice')).val(horas+":"+minutos+":"+segundos);
            $("#label_time_"+$(button).attr('data-indice')).html(elapsed_time);
            $("#label_status_"+$(button).attr('data-indice')).html('Parado');
        });
        $('.btn-stop').on('click', function() {
            var button = $(this);
            $("#label_status_"+$(button).attr('data-indice')).html('Finalizado');
        });
        $("#btnAddPackpage").on('click', function(){
            var jsonPackpage = [];
            if($("#packpage_json_packpage").val() != "") {
                jsonPackpage = JSON.parse($("#packpage_json_packpage").val());
            }
            var element = {
                "number_card": $("#packpage_number_card").val(),
                "weight": $("#packpage_weight").val(),
                "product_type_id": $("#packpage_product_type_id").val(),
                "product_type": $("#packpage_product_type_id option:selected").text(),
                "shaving_type_id": $("#packpage_shaving_type_id").val(),
                "shaving_type": $("#packpage_shaving_type_id option:selected").text(),
                "container_type_id": $("#packpage_container_type_id").val(),
                "container_type": $("#packpage_container_type_id option:selected").text(),
                "observations": $("#packpage_observations").val(),
                "elapsed_time": "00:00",
                "status": "Iniciado",
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
            $("#weight_received").val(weight_received);
            $("#json_packpage").val(JSON.stringify(jsonPackpage));
            setTimeout(() => {
                Receivement.onRefreshModal($(this));
            }, 500);       
        });
        $("#btnEditPackpage").on('click', function(){
            var button = $(this);
            var jsonPackpage = [];
            if($("#packpage_json_packpage").val() != "") {
                jsonPackpage = JSON.parse($("#packpage_json_packpage").val());
            }
            $.each( jsonPackpage, function( k, v ) {
                if($("#packpage_indice").val() == k) {
                    var element = {
                        "number_card": $("#packpage_number_card").val(),
                        "weight": $("#packpage_weight").val(),
                        "packpage_product_type_id": $("#packpage_product_type_id").val(),
                        "packpage_product_type": $("#packpage_product_type_id option:selected").text(),
                        "shaving_type_id": $("#packpage_shaving_type_id").val(),
                        "shaving_type": $("#packpage_shaving_type_id option:selected").text(),
                        "container_type_id": $("#packpage_container_type_id").val(),
                        "container_type": $("#packpage_container_type_id option:selected").text(),
                        "observations": $("#packpage_observations").val(),
                    };
                    jsonPackpage[k] = element;
                }
            });
            $("#packpage_json_packpage").val('');
            $("#packpage_json_packpage").val(JSON.stringify(jsonPackpage));
            $("#json_packpage").val(JSON.stringify(jsonPackpage));
            setTimeout(() => {
                Receivement.onRefreshModal(button);
            }, 500);   
        });
        $(".btn-edit").on('click', function(){
            $("#btnAddPackpage").addClass('hidden');
            $("#btnEditPackpage").removeClass('hidden');
            var indice = $(this).attr('data-indice');
            var jsonPackpage = [];
            if($("#packpage_json_packpage").val() != "") {
                jsonPackpage = JSON.parse($("#packpage_json_packpage").val());
            }
            if($(this).attr('data-indice') != null) {
                $("#packpage_indice").val($(this).attr('data-indice'));
                var element = jsonPackpage[$(this).attr('data-indice')];
                $("#packpage_number_card").val(element.number_card);
                $("#packpage_weight").val(element.weight);
                $("#packpage_shaving_type_id").val(element.shaving_type_id);
                $("#packpage_container_type_id").val(element.container_type_id);
                $("#packpage_observations").val(element.observations);
            }
        });
        $(".close").on('click', function(){
            Application.onRefreshOptional('form-general-receivement');
        }); 
    });
</script>
    