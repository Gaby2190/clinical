$(document).ready(function() {
    $('#div_cci_table').hide();
    $('#div_cce_table').hide();
    $('#div_ciet_table').hide();
    $('#div_btn_pdf').hide();

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    
    $('#fecha_cc').attr('value', f_actual);
    $('#fecha_cc').attr('max', f_actual);
     
    var c_ingresos = [];
    var c_egresos = [];

    
    function listarIngresos(){
        const fecha = $('#fecha_cc').val();
        const id_usuario = $("#id_usuario").val();
        $.ajax({
            type: "POST", 
            data: {fecha, id_usuario},
            url: '../php/cuadre_caja/citas_ingresos.php',
            success: function(response) {
                $("#cci_body tr").remove();
                if (response == false) {
                    $('#texto_modal').html("No se encuentran citas en ingresos");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_cci_table').hide();
                } else { 
                    const citas = JSON.parse(response);                  
                    let template = '';
                    let comision_cli=0;
                    let comision_doc=0;
                    let t_com_cli=0;
                    let t_com_doc=0;
                    let t_adicional=0;
                    let t_enfermeria=0;
                    let t_copago=0;
                    let t_consultas=0;
                    citas.forEach(cita => {
                        
                        const hora = cita.hora_p.slice(0, -3);
                        //========Separaci贸n de un nombre y un apellido MEDICO ===================
                        const nom_apem = cita.sufijo + " " + cita.nom_ape_medi;
                        //========Uni贸n de un nombre y un apellido PACIENTE ===================
                        const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
                    
                        
                        template += `
                                    <tr class="bg-blue" citaID="${cita.id_cita}">
                                        <td class="pt-3">${cita.id_cita}</td>
                                        <td class="pt-3">${cita.fecha_p}</td>
                                        <td class="pt-3">${hora}h</td>
                                        <td class="pt-3">${nom_apep}</td>
                                        <td class="pt-3">${nom_apem}</td>
                                        <td class="pt-3">${cita.tipo_pago}</td>
                                        <td class="pt-3">${cita.forma_pago}</td>
                                        <td class="pt-3">$${Number(cita.costo).toFixed(2)}</td>
                                      `;

                        //================= comisiones por consultas ========================
                        if((cita.id_tipo_pago<=2)&&(cita.id<=7))
                        {
                            if (cita.costo>0)
                                {
                                    if(cita.comision_c==5)
                                    {
                                        comision_cli=5;
                                        comision_doc=Number(cita.costo-5);
                                        
                                        
                                        
                                        template +=`<td class="pt-3">$${comision_cli.toFixed(2)}</td>
                                                    <td class="pt-3">$${comision_doc.toFixed(2)}</td>`;
                                    }
                                    else
                                    {
                                        comision_cli=Number(cita.costo)*(Number(cita.comision_c)/100);
                                        comision_doc=Number(cita.costo)-(Number(cita.costo)*(Number(cita.comision_c)/100));
                                        
                                    

                                        template +=`<td class="pt-3">$${comision_cli.toFixed(2)}</td>
                                                    <td class="pt-3">$${comision_doc.toFixed(2)}</td>`;
                                    }
                                }
                                else
                                {
                                    comision_cli=Number(cita.costo);
                                    comision_doc=Number(cita.costo);   
                                    template +=`<td class="pt-3">$${comision_cli.toFixed(2)}</td>
                                                <td class="pt-3">$${comision_doc.toFixed(2)}</td>`;
                                }
                                t_com_cli+=Number(comision_cli);
                                t_com_doc+=Number(comision_doc);
                                t_consultas+= comision_cli;
                           
                        }
                        //==================== Comisiones por adicionales =============
                        else if((cita.id_tipo_pago==3)&&(cita.id<=7))
                        {
                            if(cita.comision_a==5)
                            {
                                comision_cli=5;
                                comision_doc=Number(cita.costo-5);                                
                                template +=`<td class="pt-3">$${comision_cli.toFixed(2)}</td>
                                            <td class="pt-3">$${comision_doc.toFixed(2)}</td>`;
                            }
                            else
                            {
                                comision_cli=Number(cita.costo)*(Number(cita.comision_a)/100);
                                comision_doc=Number(cita.costo)-(Number(cita.costo)*(Number(cita.comision_a)/100));
                                template +=`<td class="pt-3">$${comision_cli.toFixed(2)}</td>
                                            <td class="pt-3">$${comision_doc.toFixed(2)}</td>`;
                            }

                            t_com_cli+=Number(comision_cli);
                            t_com_doc+=Number(comision_doc);
                            t_adicional+= comision_cli;
                        }
                        //===================  ENFERMERIA ==============
                        else if(cita.id_tipo_pago==5)
                        {
                            comision_cli=Number(cita.costo);
                            comision_doc=0;

                            t_com_cli+=Number(comision_cli);
                            t_com_doc+=Number(comision_doc);
                            t_enfermeria+= comision_cli;

                            template +=`<td class="pt-3">$${comision_cli.toFixed(2)}</td>
                            <td class="pt-3">$${comision_doc.toFixed(2)}</td>`;
                        }


                        //==============  COPAGOS ========================
                        else if(cita.id_tipo_pago==4)
                            {
                                comision_cli=Number(cita.costo);
                                comision_doc=0;
    
                                t_com_cli+=Number(comision_cli);
                                t_com_doc+=Number(comision_doc);
                                t_copago+= comision_cli;
    
                                template +=`<td class="pt-3">$${comision_cli.toFixed(2)}</td>
                                <td class="pt-3">$${comision_doc.toFixed(2)}</td>`;
                            }
                        //=====================  SEGUROS ========================
                        else if(cita.id>7)
                            {
                                comision_cli=0;
                                comision_doc=0;

                                t_com_cli+=Number(comision_cli);
                                t_com_doc+=Number(comision_doc);

                                template +=`<td class="pt-3">$${comision_cli.toFixed(2)}</td>
                                <td class="pt-3">$${comision_doc.toFixed(2)}</td>`;
                            }

                           

                            $('#tc').html("$"+t_consultas.toFixed(2));
                            $('#ta').html("$"+t_adicional.toFixed(2));
                            $('#te').html("$"+t_enfermeria.toFixed(2));
                            $('#tcp').html("$"+t_copago.toFixed(2));
                            $('#tcl').html("$"+t_com_cli.toFixed(2));
                            $('#tm').html("$"+t_com_doc.toFixed(2));
                            
                                        
                                     template +=`   
                                        <td class="pt-3"><B>${cita.descripcion}</B></td>
                                    </tr>
                                    `;
                                    
                       
                        
                      
                        
                    
                    });
                    
                    
                    $('#cci_body').html(template);
                    $('#div_cci_table').show();
                    //listarEgresos();
                }
            }
        });
    }
    
    function listarEgresos() {
        const fecha = $('#fecha_cc').val();
        const id_usuario = $("#id_usuario").val();
        $.ajax({
            type: "POST",
            url: "../php/cuadre_caja/medico_pago-get.php",
            data: {fecha, id_usuario},
            success: function (response) {
                if(response==false){
                     $('#texto_modal').html("No se encuentran citas en egresos");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_cce_table').hide();
                } else {
                    $('#div_cce_table').show();
                    const pagos = JSON.parse(response);
                    var template = '';
                    //Totalo de los metodos de pago del medico
                    var t_efectivo = 0;
                    var t_transferencia_b = 0;
                    var t_tarjeta_c = 0;
                    var t_tarjeta_d = 0;
                    var t_cheque = 0;
                    var t_letra_c = 0;
                    pagos.forEach(p => {
                        //Variables que se usarán de forma global para cargar los totales y cargarlos posteriormente al template
                        const fecha_p = p.fecha_p;
                        const hora_p = p.hora_p.slice(0, -3);
                        const id_pago = p.id_pago;
                        var medico = "";
                        var t_tarifas = 0;
                        var t_descuentos = 0;
                        var t_adicionales = 0;
                        var t_comisiones_ban = 0;
                        var t_retenciones_cli = 0;
                        var t_comisiones_c = 0;
                        var t_comisiones_a = 0;
                        var t_pagado = 0;
                        
                        
                        //Consulta las citas de cada id_pago
                        $.ajax({
                            type: "POST",
                            url: "../php/cuadre_caja/citas_egresos.php",
                            async: false,
                            data: {id_pago},
                            success: function (response) {
                                const citas = JSON.parse(response);
                                //Datos del médico
                                const nombrem = citas[0].nombres_medi;
                                const apellidom = citas[0].apellidos_medi;
                                medico = citas[0].sufijo + " " + nombrem + " " + apellidom;
                                //Variables para ver las formas de pago
                                var efectivo = 0;
                                var transferencia_b = 0;
                                var tarjeta_c = 0;
                                var tarjeta_d = 0;
                                var cheque = 0;
                                var letra_c = 0;
                                
                                citas.forEach(c => {
                                    const id_cita = c.id_cita;
                                    const com_c = Number(c.comision_c);
                                    const com_a = Number(c.comision_a);
                                    //Calcular la tarifa que fue de la cita y sumarlos al total
                                    var tarifa = 0;
                                    if (c.tipo_cita == "1") {
                                        tarifa = Number(c.tarifa);
                                    }else{
                                        if (c.tipo_cita == "0") {
                                            tarifa = Number(c.tarifa_control);
                                        }
                                    }
                                    t_tarifas += Number(tarifa);
                                    //Calcular los descuentos que fueron de la cita
                                    t_descuentos += Number(c.descuento);
                                    //Calcular los adicionales de cada cita y sumarlos al total
                                    var adicionales = 0;
                                    const r = $.ajax({
                                        type: "POST", 
                                        url: "../php/adicional-read.php",
                                        data: { id_cita },
                                        global: false,
                                        async: false,
                                        success: function(response) {
                                            return response;   
                                        }
                                    }).responseText;
                                    if (r != false) {
                                        const resp = JSON.parse(r);
                                            resp.forEach(r => {
                                            adicionales += Number(r.costo);
                                        });
                                    }
                                    t_adicionales += Number(adicionales);
                                    //Calcular las comisiones del banco y retenciones de la clínica y sumarlos al total
                                    var val_comision_ban = 0;
                                    var val_retencion_cli = 0;
                                    const cbrt = $.ajax({
                                        type: "POST",
                                        url: "../php/p_tarjeta/p_tarjeta-get.php",
                                        data: { id_cita },
                                        global: false,
                                        async: false,
                                        success: function(response) {
                                            return response;
                                        }
                                    }).responseText;
                                    if (cbrt != false) {
                                        const values = JSON.parse(cbrt);
                                            values.forEach(cbrt => {
                                            val_comision_ban += Number(cbrt.comision_ban);
                                            val_retencion_cli += Number(cbrt.retencion_cli);
                                        });
                                    }
                                    t_comisiones_ban += Number(val_comision_ban);
                                    t_retenciones_cli += Number(val_retencion_cli);
                                    //Calcular las comisiones de las consultas y las comisiones de los adicionales y sumarlos a los totales
                                    var comision_c = 0;
                                    var comision_a = 0;
                                    if (Number(com_c)>5) {
                                        comision_c = (((Number(tarifa)-Number(c.descuento))*Number(com_c))/100);  
                                    }else{
                                        comision_c =  Number(com_c);  
                                    }
                                    comision_a = (((Number(adicionales))*Number(com_a))/100);
                                    t_comisiones_c += Number(comision_c);
                                    t_comisiones_a += Number(comision_a);
                                });
                                
                                const medi_p = $.ajax({
                                    type: "POST",
                                    url: "../php/medico_pago/medico_pago-get.php",
                                    data: { id_pago },
                                    global: false,
                                    async: false,
                                    success: function(response) {
                                        return response;
                                    }
                                }).responseText;
                                if (medi_p != false) {
                                    const resp = JSON.parse(medi_p);
                                        resp.forEach(r => {
                                        switch (Number(r.id_f_pago)) {
                                            case 1:
                                                efectivo = r.costo;
                                                break;
                                            case 2:
                                                transferencia_b = r.costo;
                                                break;
                                            case 4:
                                                tarjeta_c = r.costo;
                                                break;
                                            case 5:
                                                tarjeta_d = r.costo;
                                                break;
                                            case 6:
                                                cheque = r.costo;
                                                break;
                                            case 7:
                                                letra_c = r.costo;
                                                break;
                                        }
                                    });
                                }
                                t_efectivo += Number(efectivo);
                                t_transferencia_b += Number(transferencia_b);
                                t_tarjeta_c += Number(tarjeta_c);
                                t_tarjeta_d += Number(tarjeta_d);
                                t_cheque += Number(cheque);
                                t_letra_c += Number(letra_c);
                                
                                t_pagado = t_tarifas - t_descuentos + t_adicionales - t_comisiones_ban - t_retenciones_cli - t_comisiones_c - t_comisiones_a;
                                
                                template += `
                                        <tr class="bg-blue">
                                            <td class="pt-3">${fecha_p}</td>
                                            <td class="pt-3">${hora_p}h</td>
                                            <td class="pt-3">${id_pago}</td>
                                            <td class="pt-3">${medico}</td>
                                            <td class="pt-3">$${Number(t_tarifas).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(t_descuentos).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(t_adicionales).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(t_comisiones_ban).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(t_retenciones_cli).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(t_comisiones_c).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(t_comisiones_a).toFixed(2)}</td>
                                            <td class="pt-3"><B>$${Number(t_pagado).toFixed(2)}</B></td>
                                    `;
                                    
                                if(Number(efectivo)>0){
                                    template += `<td class="pt-3"><I><B>$${Number(efectivo).toFixed(2)}</B></I></td>`;
                                }else{
                                    template += `<td class="pt-3"><I>$${Number(efectivo).toFixed(2)}</I></td>`;
                                }
                                if(Number(transferencia_b)>0){
                                    template += `<td class="pt-3"><I><B>$${Number(transferencia_b).toFixed(2)}</B></I></td>`;
                                }else{
                                    template += `<td class="pt-3"><I>$${Number(transferencia_b).toFixed(2)}</I></td>`;
                                }
                                if(Number(tarjeta_c)>0){
                                    template += `<td class="pt-3"><I><B>$${Number(tarjeta_c).toFixed(2)}</B></I></td>`;
                                }else{
                                    template += `<td class="pt-3"><I>$${Number(tarjeta_c).toFixed(2)}</I></td>`;
                                }
                                if(Number(tarjeta_d)>0){
                                    template += `<td class="pt-3"><I><B>$${Number(tarjeta_d).toFixed(2)}</B></I></td>`;
                                }else{
                                    template += `<td class="pt-3"><I>$${Number(tarjeta_d).toFixed(2)}</I></td>`;
                                }
                                if(Number(cheque)>0){
                                    template += `<td class="pt-3"><I><B>$${Number(cheque).toFixed(2)}</B></I></td>`;
                                }else{
                                    template += `<td class="pt-3"><I>$${Number(cheque).toFixed(2)}</I></td>`;
                                }
                                if(Number(letra_c)>0){
                                    template += `<td class="pt-3"><I><B>$${Number(letra_c).toFixed(2)}</B></I></td>`;
                                }else{
                                    template += `<td class="pt-3"><I>$${Number(letra_c).toFixed(2)}</I></td>`;
                                }
                                
                                template += `</tr>`;
                            }
                        });
                    });
                    template += `
                                <tr class="bg-blue">
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"></td>
                                    <td class="pt-3"><B>$${Number(t_efectivo).toFixed(2)}</B></td>
                                    <td class="pt-3"><B>$${Number(t_transferencia_b).toFixed(2)}</B></td>
                                    <td class="pt-3"><B>$${Number(t_tarjeta_c).toFixed(2)}</B></td>
                                    <td class="pt-3"><B>$${Number(t_tarjeta_d).toFixed(2)}</B></td>
                                    <td class="pt-3"><B>$${Number(t_cheque).toFixed(2)}</B></td>
                                    <td class="pt-3"><B>$${Number(t_letra_c).toFixed(2)}</B></td>
                                </tr>
                                `;
                    
                    const datEgr = {
                      t_efectivo,
                      t_transferencia_b,
                      t_tarjeta_c,
                      t_tarjeta_d,
                      t_cheque,
                      t_letra_c
                    };
                    c_egresos.push(datEgr);
                    $('#cce_body').html(template);
                    listarCiet();
                }
            }
        });
    }
    
    function listarCiet(){
        const ti = c_ingresos[0];
        const te = c_egresos[0];
        const template = `
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>EFECTIVO</I></B></td>
                        <td class="pt-3">$${Number(ti.t_efectivo).toFixed(2)}</td>
                        <td class="pt-3">$${Number(te.t_efectivo).toFixed(2)}</td>
                        <td class="pt-3"><B>$${(Number(ti.t_efectivo)-Number(te.t_efectivo)).toFixed(2)}</B></td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>TRANSFERENCIA BANCARIA</I></B></td>
                        <td class="pt-3">$${Number(ti.t_transferencia_b).toFixed(2)}</td>
                        <td class="pt-3">$${Number(te.t_transferencia_b).toFixed(2)}</td>
                        <td class="pt-3"><B>$${(Number(ti.t_transferencia_b)-Number(te.t_transferencia_b)).toFixed(2)}</B></td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>TARJETA DE CRÉDITO</I></B></td>
                        <td class="pt-3">$${Number(ti.t_tarjeta_c).toFixed(2)}</td>
                        <td class="pt-3">$${Number(te.t_tarjeta_c).toFixed(2)}</td>
                        <td class="pt-3"><B>$${(Number(ti.t_tarjeta_c)-Number(te.t_tarjeta_c)).toFixed(2)}</B></td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>TARJETA DE DÉBITO</I></B></td>
                        <td class="pt-3">$${Number(ti.t_tarjeta_d).toFixed(2)}</td>
                        <td class="pt-3">$${Number(te.t_tarjeta_d).toFixed(2)}</td>
                        <td class="pt-3"><B>$${(Number(ti.t_tarjeta_d)-Number(te.t_tarjeta_d)).toFixed(2)}</B></td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>CHEQUE</I></B></td>
                        <td class="pt-3">$${Number(ti.t_cheque).toFixed(2)}</td>
                        <td class="pt-3">$${Number(te.t_cheque).toFixed(2)}</td>
                        <td class="pt-3"><B>$${(Number(ti.t_cheque)-Number(te.t_cheque)).toFixed(2)}</B></td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>LETRA DE CAMBIO</I></B></td>
                        <td class="pt-3">$${Number(ti.t_letra_c).toFixed(2)}</td>
                        <td class="pt-3">$${Number(te.t_letra_c).toFixed(2)}</td>
                        <td class="pt-3"><B>$${(Number(ti.t_letra_c)-Number(te.t_letra_c)).toFixed(2)}</B></td>
                    </tr>
                    `;
        $('#ciet_body').html(template);
        
        const t_caja = (Number(ti.t_efectivo)-Number(te.t_efectivo)).toFixed(2);
        const t_cuentas = (Number(ti.t_transferencia_b)-Number(te.t_transferencia_b))+(Number(ti.t_tarjeta_c)-Number(te.t_tarjeta_c))+(Number(ti.t_tarjeta_d)-Number(te.t_tarjeta_d));
        const t_cheques = (Number(ti.t_cheque)-Number(te.t_cheque)).toFixed(2);
        const t_letras_c = (Number(ti.t_letra_c)-Number(te.t_letra_c)).toFixed(2);
        const t_total = Number(t_caja) + Number(t_cuentas) + Number(t_cheques) + Number(t_letras_c);
        const template2 = `
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>TOTAL CAJA</I></B></td>
                        <td class="pt-3">$${Number(t_caja).toFixed(2)}</td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>TOTAL CUENTAS</I></B></td>
                        <td class="pt-3">$${Number(t_cuentas).toFixed(2)}</td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>TOTAL CHEQUES</I></B></td>
                        <td class="pt-3">$${Number(t_cheques).toFixed(2)}</td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>TOTAL LETRAS DE CAMBIO</I></B></td>
                        <td class="pt-3">$${Number(t_letras_c).toFixed(2)}</td>
                    </tr>
                    <tr class="bg-blue">
                        <td class="pt-3"><B><I>TOTAL</I></B></td>
                        <td class="pt-3"><B>$${Number(t_total).toFixed(2)}</B></td>
                    </tr>
                    `;
        $('#tot_body').html(template2);
        $('#div_ciet_table').show();
        $('#div_btn_pdf').show();
    }
    
    $("#gen_reporte").on("click", function () {
        c_ingresos = [];
        c_egresos = [];
        $('#div_cci_table').hide();
        $('#div_cce_table').hide();
        $('#div_ciet_table').hide();
        $('#div_btn_pdf').hide();
        listarIngresos();
    });
    
    $("#btn_pdf").on("click", function () {
        const fecha = $('#fecha_cc').val();
        const id_usuario = $("#id_usuario").val();
        window.open(`../php/reportes/reporte_cuadre_c.php?fecha=${fecha}&id_usuario=${id_usuario}`, '_blank');
    });
    
    
    $("#btn_exportar").on("click", function () {
        //exportTableToExcel("cci_table", filename = 'cuadre_caja');
        $tabla = document.querySelector("#cci_table");
        //var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        let tableExport = new TableExport($tabla, {
            exportButtons: false, // No queremos botones
            filename: "Cuadre_caja", //Nombre del archivo de Excel
            sheetname: "Cuadre_caja", //Título de la hoja
        });
        let datos = tableExport.getExportData();
        let preferenciasDocumento = datos.cci_table.xlsx;
        tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
    });
    
});