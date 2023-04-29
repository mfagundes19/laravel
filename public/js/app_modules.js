
let Supplier = {
    onCreateSupplier: function(button) {
        Supplier.onModal(button);
    },
    onModal : function(button) {
        var btn = $(button).clone();
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        $(button).attr('disabled', true);
        setTimeout(() => {
            $(document).ready(function() { 
                $('#form-modal').append('<input type="hidden" name="refresh_route" id="refresh_route" value="1">');
                var button_url = $(button).attr('data-action');
                var options = {     
                    url: button_url,
                    success: function(html) {
                        $('#modal-load-content-supplier').html(html);
                    }
                }; 
                $('#form-modal').ajaxSubmit(options); 
                return false;
            }); 
            $('#modal-view-page-supplier').modal();
            $(button).html(btn.html());
            $(button).attr('disabled', false);
        }, 500);  
        
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
                    success: function(html) {
                        $('#modal-load-content-supplier').html(html);
                    }
                }; 
                $('#'+button.form.id).ajaxSubmit(options); 
            }, 500);
        }
        return;
    }
}

let ReceiptPlan =  {
    onOpenRateio: function(button) {
        $("#type_rate").val($(button).attr('data-type'));
        $("#title-modal-rate").html($(button).attr('data-type-title'));
        ReceiptPlan.onModal(button);
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
                $('#form-modal').append('<textarea name="modal_json_receipt_plan_rate" id="modal_json_receipt_plan_rate" style="display: none;">'+$("#json_receipt_plan_rate").val()+'</textarea>');
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
    onRemovePrevision: function(button) {
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        let indice = $(button).attr('data-indice');
        try{
            $('#page_prev_product_category_id_'+indice).val('');
            $('#page_prev_product_type_id_'+indice).val('');
            $('#page_prev_shaving_type_id_'+indice).val('');
            $('#page_prev_quantity_'+indice).val('');
            $('#page_prev_percent_'+indice).val('');
            $('#page_prev_amount_'+indice).val('');
            $('#page_prev_total_'+indice).val('');  
            setTimeout(function() { 
                $(button).html('<i class="fa fa-eraser" aria-hidden="true"></i>'); }
            , 500);            
        }
        catch(e) { 
            console.log(e); 
        };
    },
    onBlurPrevision: function() {
        let number_prevision = parseInt($("#page_number_prevision").val());
        let strData = "";
        switch($("#type_rate").val()) {
            case 'detalhado':
                var total_quantity_plan = 0;
                var total_amount_plan = 0;
                for(var i = 0; i < number_prevision; i++) {
                    var quantity = document.getElementById('page_prev_quantity_'+i);
                    var amount = document.getElementById('page_prev_amount_'+i);
                    var total_amount = 0;
                    if(quantity.value != "" && amount.value != "") {
                        strData = quantity.value;
                        strData = strData.replace(".","");
                        strData = strData.replace(",",".");
                        quantity = parseFloat(strData);
                        strData = amount.value;
                        strData = strData.replace(".","");
                        strData = strData.replace(",",".");
                        amount = parseFloat(strData);
                        total_quantity_plan+= quantity;
                        total_amount = (quantity * amount);
                        total_amount_plan+= total_amount;
                        total_amount = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'}).format(total_amount);
                        total_amount = total_amount.replace("R$","");
                        strData = total_amount;
                        total_amount = strData.trim(total_amount);
                    } else {
                        total_amount = "";
                    }
                    document.getElementById('page_prev_total_'+i).value = total_amount;
                } 
                total_amount_plan = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_amount_plan);
                total_amount_plan = total_amount_plan.replace("R$","");
                total_quantity_plan = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_quantity_plan);
                total_quantity_plan = total_quantity_plan.replace("R$ ","");        
                $("#total_traded").val(total_amount_plan);
                $("#total_quantity").val(total_quantity_plan);         
            break;
            case 'proporcional':
                var total_quantity_plan = $("#page_total_quantity").val();
                var total_quantity_percent = null;
                var total_amount_plan = 0;
                var total_quantity_plan_final = 0;
                for(var i = 0; i < number_prevision; i++) {
                    var percent = document.getElementById('page_prev_percent_'+i);
                    var amount = document.getElementById('page_prev_amount_'+i);
                    var quantity = 0;
                    var total_amount = "";
                    if(percent.value != "" && quantity.value != "") {
                        //Percent
                        strData = percent.value;
                        strData = strData.replace(",",".");
                        percent = parseFloat(strData);
                        //Amount
                        strData = amount.value;
                        strData = strData.replace(".","");
                        strData = strData.replace(",",".");
                        amount = parseFloat(strData);
                        //Total Quantity
                        strData = total_quantity_plan;
                        strData = strData.replace(".","");
                        strData = strData.replace(",",".");
                        total_quantity_percent = parseFloat(strData);
                        quantity = (total_quantity_percent / 100) * percent;             
                        total_amount = (quantity * amount);
                        total_amount_plan+= total_amount;
                        total_quantity_plan_final+= quantity;
                        quantity = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'}).format(quantity);
                        quantity = quantity.replace("R$","");
                        document.getElementById('page_prev_quantity_'+i).value = quantity;   
                        if(!isNaN(total_amount)) {
                            total_amount = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL'}).format(total_amount);
                            total_amount = total_amount.replace("R$","");
                            strData = total_amount;
                            total_amount = strData.trim(total_amount);
                            document.getElementById('page_prev_total_'+i).value = total_amount;  
                        }
                    } else {
                        total_amount = "";
                    }
                }
                total_amount_plan = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_amount_plan);
                total_amount_plan = total_amount_plan.replace("R$ ",""); 
                total_quantity_plan_final = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_quantity_plan_final);
                total_quantity_plan_final = total_quantity_plan_final.replace("R$ ","");
                $("#total_traded").val(total_amount_plan);
                $("#total_quantity").val(total_quantity_plan_final); 
            break;
        }
    },
    onAplicarRateio: function(button) {
        if(confirm('Deseja realmente aplicar este raeteio ao plano de recebimento?')) {
            $("#tbody_rate").html('');
            let number_prevision = parseInt($("#page_number_prevision").val());
            var jsonRateReceiptPlan = [];
            var jsonData = $("#json_receipt_plan_rate").val().trim();
            for(i=0; i < number_prevision; i++) {
                var prev_product_category_id = $("#page_prev_product_category_id_"+i).val();
                var prev_product_category_text = $("#page_prev_product_category_id_"+i+" option:selected").text();
                var prev_product_type_id = $("#page_prev_product_type_id_"+i).val();
                var prev_product_type_text = $("#page_prev_product_type_id_"+i+" option:selected").text();
                var prev_shaving_type_id = $("#page_prev_shaving_type_id_"+i).val();
                var prev_shaving_type_text = $("#page_prev_shaving_type_id_"+i+" option:selected").text();
                var prev_percent = $("#page_prev_percent_"+i).val();
                var prev_quantity = $("#page_prev_quantity_"+i).val();
                var prev_amount = $("#page_prev_amount_"+i).val();
                var prev_total = $("#page_prev_total_"+i).val();
                if(prev_product_category_id != "") {
                    var jsonRate = {
                        "prev_product_category_id": prev_product_category_id,
                        "prev_product_category_text": prev_product_category_text,
                        "prev_product_type_id": prev_product_type_id,
                        "prev_product_type_text": prev_product_type_text,
                        "prev_shaving_type_id": prev_shaving_type_id,
                        "prev_shaving_type_text": prev_shaving_type_text,
                        "prev_percent": prev_percent,
                        "prev_amount": prev_amount,
                        "prev_quantity" : prev_quantity,
                        "prev_total": prev_total,
                    }
                    jsonRateReceiptPlan.push(jsonRate);
                }
            }        
            $('#json_receipt_plan_rate').val(JSON.stringify(jsonRateReceiptPlan));
            var btn = $(button).clone();
            $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
            $(button).attr('disabled', true);
            setTimeout(() => {
                $('.close').trigger('click');
                Application.onRefreshOptional('form-general-receipt-plan');
            }, 500);        
        }
    },
    onReteioDetalhado: function() {
        let number_prevision = parseInt($("#page_number_prevision").val());
        let total_quantity = 0;
        let total_amount = 0;
        var strData = "";
        for(var i = 0; i < number_prevision; i++) {
            var quantity = document.getElementById('page_prev_quantity_'+i);
            var amount = document.getElementById('page_prev_amount_'+i);
            if(quantity.value != "" && amount.value != "") {
                strData = quantity.value;
                strData = strData.replace(",",".");
                quantity = parseFloat(strData);
                strData = amount.value;
                strData = strData.replace(",",".");
                amount = parseFloat(strData);
                total_quantity+= quantity;
                total_amount+= (quantity * amount); 
                //console.log(strData);
                var total_quantity_val = parseFloat(strData);
                console.log(total_quantity_val);
                quantity = (total_quantity_val / 100) * percent;            
                //document.getElementById('prev_quantity_'+i).value = quantity;   
                document.getElementById('prev_quantity_'+i).value = quantity;
            } else {
                total_quantity+= 0.00;
                total_amount+= 0.00; 
            }
        }     
        total_amount = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_amount);
        total_amount = total_amount.replace("R$","");
        total_quantity = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_quantity);
        total_quantity = total_quantity.replace("R$ ","");        
        $("#total_traded").val(total_amount);
        $("#total_quantity").val(total_quantity); 
        ReceiptPlan.onBlurPrevision();
    },
    onReteioProporcional: function() {
        if($("#total_quantity").val() == "") {
            alertify.error("Você precisa informar o total de kilos para continuar!");
            return;
        }
        let number_prevision = parseInt($("#number_prevision").val());
        let total_quantity = $("#total_quantity").val();
        let total_amount = 0;
        var strData = "";
        for(var i = 0; i < number_prevision; i++) {
            var percent = document.getElementById('page_prev_percent_'+i);
            var quantity = 0;
            if(percent.value != "" && total_quantity != "") {
                //Percent
                strData = percent.value;
                strData = strData.replace(",",".");
                percent = parseFloat(strData);
                //Total Quantity
                strData = total_quantity;
                strData = strData.replace(".","");
                strData = strData.replace(",",".");
                //console.log(strData);
                var total_quantity_val = parseFloat(strData);
                console.log(total_quantity_val);
                quantity = (total_quantity_val / 100) * percent;            
                document.getElementById('prev_quantity_'+i).value = quantity;           
            } else {
                total_amount = "0.00";
            }
        }     
        total_amount = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_amount);
        total_amount = total_amount.replace("R$","");
        $("#total_traded").val(total_amount);
        $("#total_quantity").val(total_quantity); 
        ReceiptPlan.onBlurPrevision();
    },
    onRemoveUpload: function(button) {
        var btn = $(button).clone();
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        $(button).attr('disabled', true);
        setTimeout(() => {
            //data-upload_id
            $(document).ready(function() { 
                let FormDataObject = new FormData();
                FormDataObject.append("_token", $('meta[name="csrf-token"]').attr('content'));
                FormDataObject.append('action', 'delete');
                FormDataObject.append('upload_id', $(button).attr('data-upload-id'));
                $.ajax({
                    type: 'POST',
                    url: $('#app').attr('data-base-url')+'/receipt-plan/upload',
                    data: FormDataObject,
                    processData: false, 
                    contentType: false, 
                    cache: false,     
                    dataType: 'json',
                    success: function(json) {
                        switch(json.result) {
                            case 'success':
                                alertify.success('Upload removido com sucesso!');
                                window.location.reload();
                                //Application.onRefreshOptional('form-general-receipt-plan');
                                break;
                            case 'error':
                                alertify.success('Erro ao excluir upload!');
                                break;
                            default:
                                return;
                        }
                    }
                });
            }); 
        }, 500);
    }
};

let Receivement  = { 
    onWeightNF: function(element) {
        try{
            $("#weight_nf").val($(element).val());
            $("#label_weight_nf").val($(element).val()+" kg");
        } catch(e) { 
            console.log(e); 
        }
    },
    onClearUpload: function(button) {
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        let indice = $(button).attr('data-indice');
        try{
            $('#upload_file_'+indice).val('');
            setTimeout(function() { 
                $(button).html('<i class="fa fa-eraser" aria-hidden="true"></i>'); }
            , 500);            
        }
        catch(e) { 
            console.log(e); 
        }
    },
    onRemoveUpload: function(button) {
        var btn = $(button).clone();
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        $(button).attr('disabled', true);
        setTimeout(() => {
            $(document).ready(function() { 
                let FormDataObject = new FormData();
                FormDataObject.append("_token", $('meta[name="csrf-token"]').attr('content'));
                FormDataObject.append('action', 'delete');
                FormDataObject.append('upload_id', $(button).attr('data-upload-id'));
                $.ajax({
                    type: 'POST',
                    url: $('#app').attr('data-base-url')+'/receivement/upload',
                    data: FormDataObject,
                    processData: false, 
                    contentType: false, 
                    cache: false,     
                    dataType: 'json',
                    success: function(json) {
                        switch(json.result) {
                            case 'success':
                                alertify.success('Upload removido com sucesso!');
                                window.location.reload();
                                break;
                            case 'error':
                                alertify.success('Erro ao excluir upload!');
                                break;
                            default:
                                return;
                        }
                    }
                });
            }); 
        }, 500);
    },
    onAdvancedOption: function(button){ 
        Receivement.onModal(button);
    },
    onPackpage: function(button){ 
        Receivement.onModal(button);
    },
    onModal : function(button) {
        var btn = $(button).clone();
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        $(button).attr('disabled', true);
        setTimeout(() => {
            $('.modal-title').html($(button).attr('data-original-title'));
            $(document).ready(function() { 
                $('#form-modal').append('<input type="hidden" name="refresh_route" id="refresh_route" value="1">');
                if($(button).attr('data-modal-textarea') != undefined) {
                    $('#form-modal').append('<textarea name="modal_'+$(button).attr('data-modal-textarea')+'" id="modal_'+$(button).attr('data-modal-textarea')+'" style="display: none;">'+$("#"+$(button).attr('data-modal-textarea')).val()+'</textarea>');
                }
                var options = {     
                    url: $(button).attr('data-action'),
                    success: function(html) {
                        $("#"+$(button).attr('data-modal-load')).html(html);
                    }
                }; 
                $('#form-modal').ajaxSubmit(options); 
                    return false;
            }); 
            $("#"+$(button).attr('data-modal')).modal();
            $(button).html(btn.html());
            $(button).attr('disabled', false);
        }, 500);  
    },
    onRefreshModal: function(button) {
        try {
            $('#'+$(button).attr('data-target')).append('<input type="hidden" name="refresh_route" id="refresh_route" value="1">');
            $(document).ready(function() { 
                var options = {     
                    url: $('#'+$(button).attr('data-target')).attr('action'),
                    success: function(html) {
                        $('#'+$(button).attr('data-modal-load')).html(html);
                    }
                }; 
                $('#'+$(button).attr('data-target')).ajaxSubmit(options); 
                return false;
            }); 
        } catch(e) {
            console.log(e);
        }
    },
    onPackpageSave: function(button) {
        try {

        } catch(e) {
            console.log(e);
        }
    },
    onPackpageEdit: function(button) {

    },
    onPackpageDelete: function(button) {
        try {
            var jsonPackpage = JSON.parse($("#packpage_json_packpage").val());
            var indice = $(this).attr('data-indice');
            jsonPackpage.splice(indice, 1);
            console.log(jsonPackpage);
            $("#packpage_json_packpage").val(JSON.stringify(jsonPackpage));
            Receivement.onRefreshModal(button);
        } catch(e) { console.log(e); }        
    },
    onCheckPackpage: function(button) {
        try {
            Receivement.onRefreshModal(button);
        } catch(e) { console.log(e); }        
    },
    onDifferenceWeight(button) {
        try {
            var weight_received = $("#weight_received").val();
            var weight_difference = 0.00;
            var weight_reference = null;
            $("#weight_reference").val($(button).attr('data-parameter'));
            switch($(button).attr('data-parameter')) {
                case 'weight-negotiated':
                    weight_reference = $("#weight_negotiated").val();
                    break;
                case 'weight-nf':
                    weight_reference = $("#weight_nf").val();
                    break;
            }
            var strData = new String();
            strData = weight_received;
            strData = weight_received.replace(",",".");
            weight_received = parseFloat(strData);
            strData = weight_reference;
            strData = weight_reference.replace(",",".");
            weight_reference = parseFloat(strData);
            weight_difference = Math.abs(weight_reference - weight_received);
            $("#weight_reference").val($(button).attr('data-parameter'));
            $("#weight_difference").val(weight_difference);
            $("#label_weight_difference").val(weight_difference);
            $(".btn-weight").removeClass('btn-success');
            $(button).addClass('btn-success');
        } catch(e) { console.log(e); }        
    }
};
