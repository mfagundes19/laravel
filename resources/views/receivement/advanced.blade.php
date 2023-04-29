<div class="row">
    <div class="container-fluid">
        <div class="col-lg-12 box-form-container">
            {!! Form::open(['url' => url($route->module.'/rate'),'id' => 'form-'.$route->module,'method' => 'POST','data-action' => url($route->module.'/rate'),'data-refresh' => true]) !!}  
            {!! Form::hidden('page_number_prevision', $page_number_prevision ?? 1, ['id' => 'page_number_prevision']) !!}
            <div class="col-lg-6">
                @foreach(\App\Models\ReceivementChecklist::where([['type','cargo-quality']])->pluck('name','id') as $checklist_id => $checklist)
                    <div class="col-lg-12" style="padding: 3px; padding-top: 5px; padding-left: 15px; border: solid 1px #CDCDCD; margin-top: 5px; background-color: #E9E9E9E;">
                        {!! Form::checkbox('advanced_option', $checklist_id, $advanced_option_list[$checklist_id] ?? false, ['id' => 'advanced_option_'.$checklist_id]) !!}
                        <label for="advanced_option_{{$checklist_id}}">{{$checklist}}</label>
                    </div>
                @endforeach
                <div class="col-lg-12" style="padding: 5px; padding-top: 10px; padding-left: 15px; border: solid 1px #CDCDCD; margin-top: 5px; background-color: #E9E9E9E;">
                    <input id="option-outher-cargo-quality" type="checkbox">&nbsp;&nbsp;
                    <label for="option-outher-cargo-quality">Outro</label>
                </div>
                <div class="col-lg-12" id="option-cargo-quality" style="padding: 5px; padding-top: 10px; display: none;">
                    {!! Form::text('option-cargo-quality-text', $advanced_option_list['option-cargo-quality'] ?? '', ['id' => 'option-cargo-quality-text','class' => 'form-control']) !!}
                </div>
            </div>
            <div class="col-lg-6">
                @foreach(\App\Models\ReceivementChecklist::where([['type','restriction']])->pluck('name','id') as $checklist_id => $checklist)
                    <div class="col-lg-12" style="padding: 5px; padding-top: 5px; padding-left: 15px; border: solid 1px #CDCDCD; margin-top: 5px; background-color: #E9E9E9E;">
                        {!! Form::checkbox('advanced_option', $checklist_id, $advanced_option_list[$checklist_id] ?? false, ['id' => 'advanced_option_'.$checklist_id]) !!}
                        <label for="advanced_option_{{$checklist_id}}">{{$checklist}}</label>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-12"><br></div>
            <div class="col-lg-12">
                <div class="text-right">
                    <button type="button" class="btn btn-primary btn-sm" id="btnSalvarAdvanced">
                        Salvar
                    </button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div><br>
<script type="application/javascript">
    $(document).ready(function(){
        Application.onReady();
        $("#btnSalvarAdvanced").on('click', function(){
            var jsonChecklist = [];
            var button = $(this);
            $("input[name=advanced_option]").each(function(){
                var element = {};
                element[$(this).val()] = $(this).prop("checked");
                jsonChecklist.push(element);
            });
            if($("#option-outher-cargo-quality").prop('checked') == true) {
                var element = {};
                element['option-cargo-quality'] = $("#option-cargo-quality-text").val();
                jsonChecklist.push(element);
            }
            if($("#option-outher-restriction").prop('checked') == true) {
                var element = {};
                element['option-restriction'] = $("#option-restriction-text").val();
                jsonChecklist.push(element);
            }
            $('#json_checklist').val(JSON.stringify(jsonChecklist));
            var btn = $(button).clone();
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
            setTimeout(() => {
                $('.close').trigger('click');
                Application.onRefreshOptional('form-general-receipt-plan');
            }, 500);        
        });
        $("#option-outher-cargo-quality").on('click', function(){
           if($(this).prop('checked') == true) {
                $("#option-cargo-quality").toggle();
           } else {
                $("#option-cargo-quality").toggle();
           }
        });
        $("#option-outher-restriction").on('click', function(){
           if($(this).prop('checked') == true) {
                $("#option-restriction").toggle();
           } else {
                $("#option-restriction").toggle();
           }
        });
        if($("#option-cargo-quality-text").val() != "") {
            $("#option-outher-cargo-quality").click();   
        }
        if($("#option-cargo-quality-text").val() != "") {
            $("#option-outher-restriction").click();   
        }
    });
</script>
    