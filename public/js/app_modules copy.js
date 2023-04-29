
let ReceiptPlan =  {
    onOpenRateio: function(button) {
        $("#type_rate").val($(button).attr('data-type'));
        Application.onModal(button);
    },
    onRemovePrevision: function(button) {
        $(button).html('<i class="fa fa-spinner fa-pulse"></i>');
        let indice = $(button).attr('data-indice');
        //$('#prev_product_category_id['+indice+']').val('');
        try{
            field_indice = document.getElementById('page_prev_product_category_id_'+indice);
            field_indice.value = '';
            field_indice = document.getElementById('page_prev_product_type_id_'+indice);
            field_indice.value = '';
            field_indice = document.getElementById('page_prev_shaving_type_id_'+indice);
            field_indice.value = '';
            field_indice = document.getElementById('page_prev_percent_'+indice);
            field_indice.value = '';
            field_indice = document.getElementById('page_prev_amount_'+indice);
            field_indice.value = '';
            field_indice = document.getElementById('page_prev_total_'+indice);
            field_indice.value = '';    
            setTimeout(function() { $(button).html('<i class="fa fa-eraser" aria-hidden="true"></i>'); }, 500);            
        }
        catch(e) { console.log(e); };
    },
    onBlurPrevision: function() {
        let number_prevision = parseInt($("#number_prevision").val());
        let total_quantity = 0;
        var strData = "";
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
                total_quantity+= quantity;
                total_amount = (quantity * amount);
                total_amount = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_amount);
                total_amount = total_amount.replace("R$","");
            } else {
                total_amount = "";
            }
            document.getElementById('page_prev_total_'+i).value = total_amount;

        }     
    },
    onAplicarRateio: function() {
        switch($("#type_rate").val()) {
            case 'detalhado':
                this.onReteioDetalhado();
                break;
            case 'proporcional':
                this.onReteioProporcional();
                break;
        }
        $("#tbody_rate").html('');
        let number_prevision = parseInt($("#number_prevision").val());
        /*
        var jsonMaterialComposition = [];
        var jsonData = $("#json_material_composition").val().trim();
        if(jsonData.length > 0) {
            var json_material_composition = $("#json_material_composition").val();
            jsonMaterialComposition = JSON.parse(json_material_composition);
            var jsonMaterialElement = {
                "material_id": $("#material_id").val()
            }
            jsonMaterialComposition.push(jsonMaterialElement);
        } else {
            var jsonMaterialElement = {
                "material_id": $("#material_id").val()
            }
            jsonMaterialComposition.push(jsonMaterialElement);
        }
        $('#json_material_composition').val(JSON.stringify(jsonMaterialComposition));
        */

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
            /*
            html+= ("<tr>");
                html+= ("<td height='35'>");
                    html+= ("<span>"+prev_product_category_text+"</span><input type='"+input_type+"' name='prev_product_category_id["+i+"]' id='prev_product_category_id_"+i+"' value='"+prev_product_category_id+"'>");
                html+= ("</td>");
                html+= ("<td>");
                    html+= ("<span>"+prev_product_type_text+"</span><input type='"+input_type+"' name='prev_product_type_id["+i+"]' id='prev_product_type_id_"+i+"' value='"+prev_product_type_id+"'>");
                html+= ("</td>");
                html+= ("<td>");
                    html+= ("<span>"+prev_shaving_type_text+"</span><input type='"+input_type+"' name='prev_shaving_type_id["+i+"]' id='prev_shaving_type_id_"+i+"' value='"+prev_shaving_type_id+"'>");
                html+= ("</td>");
                html+= ("<td>");
                    html+= ("<span>"+prev_percent+"</span><input type='"+input_type+"' name='prev_percent["+i+"]' id='prev_percent_"+i+"' value='"+prev_percent+"'>");
                html+= ("</td>");
                html+= ("<td>");
                    html+= ("<span>"+prev_quantity+"</span><input type='"+input_type+"' name='prev_quantity["+i+"]' id='prev_quantity_"+i+"' value='"+prev_quantity+"'>");
                html+= ("</td>");
                html+= ("<td>");
                    html+= ("<span>"+prev_amount+"</span><input type='"+input_type+"' name='prev_amount["+i+"]' id='prev_amount_"+i+"' value='"+prev_amount+"'>");
                html+= ("</td>");
                html+= ("<td>");
                    html+= ("<span>"+prev_total+"</span><input type='"+input_type+"' name='prev_total["+i+"]' id='prev_total_"+i+"' value='"+prev_total+"'>");
                html+= ("</td>");
            html+= ("</tr>");
            */
        }
        $('#json_receipt_plan_rate').val(JSON.stringify(jsonRateReceiptPlan));

        //console.log(html);
        //$("#tbody_rate").html(html);
        setTimeout(() => {
            $('.close').trigger('click');
        }, 500);        
    },
    onReteioDetalhado: function() {
        let number_prevision = parseInt($("#number_prevision").val());
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
            } else {
                total_quantity+= 0.00;
                total_amount+= 0.00; 
            }
        }     
        total_amount = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_amount);
        total_amount = total_amount.replace("R$","");
        total_quantity = new Intl.NumberFormat('pt-BR', { style: 'currency', currency: 'BRL' }).format(total_quantity);
        total_quantity = total_quantity.replace("R$","");
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
    }
};

