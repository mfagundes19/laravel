var Application = {
    onStartLayout: function() {
        if(parseInt($('#main-sidebar').height()) < parseInt($('#main').height()+120)) {
            $('#main-sidebar').css({
                'min-height': +parseInt($('#main').height()+120)+'px'
            });
        }
    },
    onReady: function() {
        this.onStartLayout();
        $('input').each(function() {
            var mask = $(this).attr('data-mask-type');
            if($(this).attr('data-mask-type') !== undefined) {
                switch(mask) {
                    case 'telephone':
                        var options =  {
                            onChange: function(value, e, field, options) {
                              var mask = (value.length > 14) ? '(00) 00000-0000' : '(00) 0000-00000';
                              $(field).mask(mask, options);
                            }
                        };
                        $(this).mask('(00) 0000-00000', options);
                        break;
                    case 'comercialphone':
                        $(this).mask('(00) 0000-0000');
                        break;
                    case 'cellphone':
                        $(this).mask('(00) 00000-0000');
                        break;
                    case 'cpf':
                        $(this).mask('000.000.000-00', {reverse: true});
                        break;
                    case 'cnpj':
                        $(this).mask('00.000.000/0000-00', {reverse: true});
                        break;
                    case 'cep':
                        $(this).mask('00000-000');
                        break;
                    case 'percent':
                        $(this).mask('#.##0,00', {reverse: true});
                        break;
                    case 'float':
                        $(this).mask('##0,00', {reverse: true});
                        break;  
                    case 'number':
                        $(this).mask('0000000000', {reverse: true});
                        break;
                    case 'money':
                        $(this).mask('000.000.000.000.000,00', {reverse: true});
                        break;
                    case 'ip_address':
                        $(this).mask('099.099.099.099');
                        break;
                    case 'date':
                        $(this).mask('00/00/0000');
                        break;
                    case 'time':
                        $(this).mask('00:00:00');
                        break;
                    case 'hour':
                        $(this).mask('00:00');
                        break;
                    case 'date_time':
                        $(this).mask('00/00/0000 00:00:00');
                        break;
                }
            }
            //DatePicker
            $('input').each(function(){
                if($(this).attr('data-mask-type') == 'date') {
                    flatpickr.localize(flatpickr.l10ns.pt);
                    flatpickr($(this), {dateFormat: "d/m/Y"});
                }
            });
        });
    },
    onSubmit: function(button) {
        let target = "#"+button.form.id;
        $(target).submit();
    },
    onCreate: function(button) {
        try {
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
            setTimeout(() => {
                location.href = $(button).attr('data-action');
            }, 1000);
        } 
        catch(e)  { console.log(e); }
    },
    onEdit: function(button) {
        try {           
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
            setTimeout(() => {
                location.href = $(button).attr('data-action')+'/'+$(button).attr('data-id');
            }, 1000);  
        }
        catch(e) { console.log(e); }         
    },
    onDelete: function (button){
        try { 
            alertify.confirm('Deseja excluir este registro??',function (e) { 
                if(e) { 
                    $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
                    $(button).attr('disabled', true);
                    setTimeout(() => {
                        location.href = $(button).attr('data-action')+'/'+$(button).attr('data-id');     
                    }, 1000);                      
                }
            });            
        }
        catch(e) { console.log(e); }         
    },
    onView: function(button) {
        try {  
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
            setTimeout(() => {
                if($(button).attr('data-id') != undefined) {
                    location.href = $(button).attr('data-action')+'/'+$(button).attr('data-id');
                } else {
                    location.href = $(button).attr('data-action');
                }
                
                $(button).attr('disabled', false);
            }, 1000);                
        }
        catch(e) { console.log(e); }   
    },
    onViewFile: function(button) {
        try {  
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
            setTimeout(() => {
                window.open($(button).attr('data-file'));
                $(button).html('<i class="'+$(button).attr('data-icon')+'"></i>');
                $(button).attr('disabled', false);
            }, 1000);                
        }
        catch(e) { console.log(e); }   
    },
    onShow: function(button) {
        window.open($(button).attr('data-action')+'/'+$(button).attr('data-id'));
    },
    onLoadButton: function(button) {
        try
        {
            let label = $(button).html();
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
        }
        catch(e) { console.log(e); } 
    },
    onValidate: function(button) {
        try
        {            
            let target = "#"+button.form.id;
            $(target).validate({
                rules : { },
                messages : { },        
                errorElement: "span",
                errorClass: "error-label",
                errorPlacement: function(error, element) {
                    $(element).attr('data-tippy', error.text());
                    //error.insertBefore(element);
                    $(element).attr('title', error.text());
                    $(element).attr('data-toggle', 'tooltip');
                    $(element).attr('data-placement', 'top');
                    $(element).tooltip();                                
                },
                showErrors: function(errorMap, errorList) { 
                    this.defaultShowErrors();
                },          
                highlight: function(element) {
                    $(element).addClass("error-element");
                },
                unhighlight: function(element) {
                    $(element).removeClass("error-element");
                }
            });
            if($(target).valid() == true) {
                //$(button).html(label);
                $(target).attr('action', $(target).attr('data-action'));
                $(target).submit();
                return;
            }
        }
        catch(e) { console.log(e); }
    },
    onRedirect: function(button) 
    {
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        $(button).attr('disabled', true);
        setTimeout(() => {
            location.href = $(button).attr('data-action');
        }, 1000);  
    },
    ToolTip: function() {
        $('input[rel="tooltip"],select[rel="tooltip"],textarea[rel="tooltip"]').each(function() {
            if($(this).attr('placeholder') !== undefined) {
                $(this).attr('title',$(this).attr('placeholder'));
                $(this).attr('data-toggle', 'tooltip');
                $(this).attr('data-placement', 'top');
            }
            $(this).tooltip();
        });
    },
    onChangeCEP: function() {
        let zipcode = $("#zipcode").val().replace(/[^0-9]/, "");
        if(zipcode.length !== 8) return false;
        $.getJSON("https://viacep.com.br/ws/"+$("#zipcode").val().replace(/[^0-9]/,"")+"/json/", function(data) {  
            try 
            {             
                $('#address').val(data.logradouro);
                $('#complement').val(data.complemento);
                $('#district').val(data.bairro);
                $('#city').val(data.localidade);
                $('#state').val(data.uf);
            } 
            catch(e) 
            { 
                console.log(e);
                alert(e);
            }
        });		
    },
    onChangeQuantity: function(button) {
        let target = $(button).attr('data-target');
        let current = parseInt($('#'+target).val());
        let parameter = $(button).attr('data-parameter');
        let target_form = $(button).attr('data-form');
        switch(parameter) {
            case 'plus':
                current = (current > 0) ? (current + 1) : 1;
                break;
            case 'minus':
                current = (current > 1) ? (current - 1) : 1;
                break;
        }
        $('#'+target).val(current);
        Application.onRefresh(button);
    },
    onRemoveElement: function(button) {
        let parameter = JSON.parse($(button).attr('data-parameter'));
        for (i in parameter.fields) {
            //$('#'+parameter.fields[i]+'['+i+']').val('');
            //console.log($('#'+parameter.fields[i]+'['+i+']').val());
        }
    },
    onRefresh: function(button) {
        if($(button).attr('type') == 'button') {
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
            setTimeout(() => {
                $('#'+button.form.id).append('<input type="hidden" name="refresh_route" id="refresh_route" value="1">');
                $(document).ready(function() { 
                    var options = {     
                        url: $('#'+button.form.id).attr('action'),
                        beforeSubmit:  function() {
                            //$('#main').html('<div align="center"><img src="'+$('#app').attr('data-base-url')+'/images/loading.gif" width="36" border="0"></div>');
                        },
                        success: function(html) {
                            $('#main').html(html);
                        }
                    }; 
                    $('#'+button.form.id).ajaxSubmit(options); 
                    return false;
                }); 
            }, 1000);  
        } else {
            $("#btn-submit-research").html('<i class="fa fa-spinner fa-pulse"></i>');
            $("#btn-submit-research").attr('disabled', true);
            $('#'+button.form.id).append('<input type="hidden" name="refresh_route" id="refresh_route" value="1">');
            $(document).ready(function() { 
                var options = {     
                    url: $('#'+button.form.id).attr('action'),
                    beforeSubmit:  function() {
                        //$('#main').html('<div align="center"><img src="'+$('#app').attr('data-base-url')+'/images/loading.gif" width="36" border="0"></div>');
                    },
                    success: function(html) {
                        $('#main').html(html);
                    }
                }; 
                $('#'+button.form.id).ajaxSubmit(options); 
                return false;
            }); 
        }
    },
    onRefreshOptional: function(form) {
    try {
            $('#'+form).append('<input type="hidden" name="refresh_route" id="refresh_route" value="1">');
            $(document).ready(function() { 
                var options = {     
                    url: $('#'+form).attr('action'),
                    beforeSubmit:  function() {
                        //$('#main').html('<div align="center"><img src="'+$('#app').attr('data-base-url')+'/images/loading.gif" width="36" border="0"></div>');
                    },
                    success: function(html) {
                        $('#main').html(html);
                    }
                }; 
                $('#'+form).ajaxSubmit(options); 
                return false;
            }); 
        } catch(e) {
            console.log(e);
        }
    },
    onModal : function(button) {
        var btn = $(button).clone();
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        $(button).attr('disabled', true);
        setTimeout(() => {
            $('.modal-title').html($(button).attr('data-original-title'));
            $(document).ready(function() { 
                $('#form-modal').append('<input type="hidden" name="refresh_route" id="refresh_route" value="1">');
                var button_url = $(button).attr('data-action');
                if($(button).attr('data-id') != "") {
                    button_url+= "/"+$(button).attr('data-id');
                }
                var options = {     
                    url: button_url,
                    success: function(html) {
                        $('#modal-load-content').html(html);
                    }
                }; 
                $('#form-modal').ajaxSubmit(options); 
                return false;
            }); 
            $('#modal-view-page').modal();
            $(button).html(btn.html());
            $(button).attr('disabled', false);
        }, 500);  
        
    },
    onRefreshModal: function(button) {
        $('#'+button.form.id).append('<input type="hidden" name="refresh_route" id="refresh_route" value="1">');
        $(document).ready(function() { 
            var options = {     
                url: $('#'+button.form.id).attr('action'),
                beforeSubmit:  function() {
                    //$('#main').html('<div align="center"><img src="'+$('#app').attr('data-base-url')+'/images/loading.gif" width="36" border="0"></div>');
                },
                success: function(html) {
                    $('#modal-load-content').html(html);
                }
            }; 
            $('#'+button.form.id).ajaxSubmit(options); 
            return false;
        }); 
    },
    onValidateModal: function(button) {
        let target = "#"+button.form.id;
        $(target).validate({
            rules : { },
            messages : { },        
            errorElement: "span",
            errorClass: "error-label",
            errorPlacement: function(error, element) {
                error.insertBefore(element);
            },
            showErrors: function(errorMap, errorList) { 
               this.defaultShowErrors();
            },          
            highlight: function(element) {
                $(element).addClass("error-element");
            },
            unhighlight: function(element) {
                $(element).removeClass("error-element");
            }
        });
        if($(target).valid() == true)
        {
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
            setTimeout(() => {
                var options = {     
                    url: $('#'+button.form.id).attr('action'),
                    beforeSubmit:  function() {
                        //$('#main').html('<div align="center"><img src="'+$('#app').attr('data-base-url')+'/images/loading.gif" width="36" border="0"></div>');
                    },
                    success: function(html) {
                        $('#modal-load-content').html(html);
                    }
                }; 
                $('#'+button.form.id).ajaxSubmit(options); 
            }, 500);
        }
        return;
    },
    onLoadModal: function(button) {
        try
        {
            //$(button).append('<input type="hidden" name="historic_id" id="historic_id" value="'+$(button).attr('data-id')+'">');
            //$(button).append('<input type="hidden" name="operation" id="operation" value="4">');                
            $('#historic_id').val($(button).attr('data-id'));
            $('#operation').val('4');
            var options = {     
                url: $(button).attr('data-action'),
                beforeSubmit:  function() {
                    //$('#modal-load-content').html('<div align="center"><img src="'+$('#app').attr('data-base-url')+'/images/loading.gif" width="36" border="0"></div>');
                },
                success: function(html) {
                    $('#modal-load-content').html(html);
                }
            }; 
            $('#'+button.form.id).ajaxSubmit(options); 
        }
        catch(e)
        {
            console.log(e);
        }
    },
    onRemoveModal: function (button)
    {
        alertify.confirm('Deseja excluir este registro??',function (e) { 
            if(e) { 
                
                $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
                $(button).attr('disabled', true);
                setTimeout(() => {
                    $(button).append('<input type="hidden" name="registration_id" id="registration_id" value="'+$(button).attr('data-id')+'">');
                    $(button).append('<input type="hidden" name="operation" id="operation" value="3">');                
                    var options = {     
                        //url: $('#'+button.form.id).attr('action'),
                        url: $(button).attr('data-action')+'/'+$(button).attr('data-id'),
                        success: function(html) {
                            $('#modal-load-content').html(html);
                        }
                    }; 
                    $('#'+button.form.id).ajaxSubmit(options); 
                }, 500);
            } 
        });
    },
    onChangeQuantityModal: function(button) {
        let target = $(button).attr('data-target');
        let current = parseInt($('#'+target).val());
        let parameter = $(button).attr('data-parameter');
        let target_form = $(button).attr('data-form');
        switch(parameter) {
            case 'plus':
                current = (current > 0) ? (current + 1) : 1;
                break;
            case 'minus':
                current = (current > 1) ? (current - 1) : 1;
                break;
        }
        $('#'+target).val(current);
        Application.onRefreshModal(button);
    },
    onExists: function(field) {
        if($(field).val() !== '') {
            $(document).ready(function() { 
                let FormDataObject = new FormData();
                FormDataObject.append("_token", $('meta[name="csrf-token"]').attr('content'));
                FormDataObject.append('value', $(field).val());
                FormDataObject.append('field', $(field).attr('data-check-field'));
                FormDataObject.append('seqnr', $(field).attr('data-check-seqnr'));
                $.ajax({
                    type: 'POST',
                    url: $('#app').attr('data-base-url')+'/'+$(field).attr('data-check-action'),
                    data: FormDataObject,
                    processData: false, 
                    contentType: false, 
                    cache: false,     
                    dataType: 'json',
                    success: function(json) {
                        switch(json.result) {
                            case 'true':
                                alertify.alert($(field).attr('data-check-msg'));
                                $(field).val('');
                                $(field).focus();
                                break;
                            case 'false':
                                break;
                            default:
                                return;
                        }
                    }
                });
            });
        }
    },
};

var DateTimeApp = {
    onFormatTime: function(hour, minute, second) {
        var time_hour = hour;
        var time_minute = minute;
        var time_second = second;
        var time_full = null;
        if(parseInt(time_hour) < 10) {
            time_hour = "0"+time_hour;
        }
        if(parseInt(time_minute) < 10) {
            time_minute = "0"+time_minute;
        }
        if(parseInt(time_second) < 10) {
            time_second = "0"+time_second;
        }
        time_full = time_hour+":"+time_minute+":"+time_second;
        return time_full;
    }
};

function PreviewImageThumb(object)  
{
    if(object.files && object.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e){
            document.getElementById("preview-image").src = e.target.result;
            document.getElementById("box-preview-image").style.display = "inline";  
        };
        reader.readAsDataURL(object.files[0]);
    }
}