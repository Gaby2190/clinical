$(document).ready(function() {
    $('#gen_reporte').attr('disabled', 'disabled');
    $('#div_f_pago').hide();
    
    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    
    
    var verif = true;

    var array_citas  = [];
    var array_citas_c  = [];


    $("#div_table_cobros").hide();
    getMedicos();
    var id_citas = [];
    // Obtener Médicos
    function getMedicos() {
        $.ajax({
            url: '../php/medico/medicos-list-act.php',
            type: 'POST', 
            success: function(response) {
                const medicos = JSON.parse(response);
                let template = '<option selected="selected"></option>';
                medicos.forEach(medico => {
                    //========Separación de un nombre y un apellido ===================
                    let nombre = medico.nombres_medi;
                    let apellido = medico.apellidos_medi;
                    let nom_ape = apellido + " " + nombre;
                    template += `
                        <option value="${medico.id_medico}">${nom_ape}</option>
                        `;
                });

                $('#select_medico').html(template);

            }
        });
    }
    
    //Limitar caracteres de costo
    var cost = document.getElementById('costo');
    cost.addEventListener('input', function() {
        if (this.value.length > 7)
            this.value = this.value.slice(0, 7);
    });
    //Cargar formas de pago
    $.ajax({
        async: false,
        url: '../php/fpago/fpagos-list.php',
        type: 'POST',
        success: function(response) {
            const fpagos = JSON.parse(response);
            let template = '';
            fpagos.forEach(fp => {
                template += `
                <option value="${fp.id}">${fp.nombre}</option>
                `;
            });
            $('#select_fpago').html(template);
        }
    });

   
    $( "#select_medico" ).change(function() {
        var id_medico = $("#select_medico").val();
        const postmedicos = {
            id_medico: id_medico
        }
    
        $.ajax({
            url: '../php/cita/citas-med-sin-cobro.php',
            type: 'POST',
            data: postmedicos,
            success: function(response) {
                const fechas = JSON.parse(response);
                let template = '<option selected="selected"></option>';
                fechas.forEach(registros => {
                    //========Separación de un nombre y un apellido ===================
                    let fecha = registros.fecha;
                   
                    template += `
                        <option value="${fecha}">${fecha}</option>
                        `;
                });

                $('#select_fecha').html(template);

            }
        });
      });
      $( "#select_fecha" ).change(function() {
        formas_pago = [];
        array_citas  = [];
        array_citas_c  = [];
        id_citas = [];
        costo_fp = 0;
        $("#fp_body > tr").remove();
        $('#gen_reporte').attr('disabled', 'disabled');
         
            
               $('#respuesta').html('<div class="d-flex align-items-center"><strong>Espere porfavor estamos buscando las coincidencias...           </strong><div class="spinner-border text-info ml-auto" role="status" aria-hidden="true"></div></div>');
               $('#div_table_hcitas').hide();
              
            
        listarcobros($("#select_medico").val());
      });

    $("#gen_reporte").click(function (e) { 
        e.preventDefault();
        $('#texto_modal_conf').html('Desea Generar el Comprobante de pago');
        $('#modal_icon_conf').attr('style', "color: #22445d");
        $('#modal_icon_conf').attr("class", "fa fa-question-circle fa-4x animated rotateIn mb-4");
        $('#modalConfirmacion').modal("show");
 
        $("#btn_gen_rep").click(function(e) {
            e.preventDefault();
            const id_usuario = $("#id_usuario").val();
            const id_medico = $("#select_medico").val();
            const valor_total = Number($("#total_val").val());

            const postPago = {
                fecha_gen: f_actual,
                id_usuario: id_usuario,
                id_medico: id_medico,
                valor_total: valor_total 
            }

            $.ajax({
                type: "POST",
                url: "../php/pago/pago-add.php",
                data: postPago,
                success: function (response) {
                    $.ajax({
                        type: "POST",
                        url: "../php/pago/pago-get-id.php",
                        data: postPago,
                        success: function (response) {
                            const id_pago = JSON.parse(response).id_pago;
                             //======FECHA Y HORAS ACTUALES=====
                            var d = new Date();
                            var month = d.getMonth() + 1;
                            var day = d.getDate();
                            //fecha
                            var fecha_p = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
                            //hora
                            const hora_p = d.getHours() + ':' + d.getMinutes();
                            formas_pago.forEach(fp => {
                                $.ajax({
                                    type: "POST",
                                    url: "../php/medico_pago/medico_pago-add.php",
                                    data: {
                                        id_f_pago: fp.id_f_pago,
                                        descripcion: fp.descripcion,
                                        costo: fp.costo,
                                        id_pago: id_pago,
                                        fecha_p: fecha_p,
                                        hora_p: hora_p
                                    },
                                    success: function (response) {
                                        console.log(response);
                                    }
                                });
                            });
                            for (let i = 0; i < id_citas.length; i++) {
                                const id_cita = id_citas[i];
                                const postDetPago = {
                                    id_pago: id_pago,
                                    id_cita: id_cita
                                }
                                $.ajax({
                                    type: "POST",
                                    url: "../php/pago/detalle-pago-add.php",
                                    data: postDetPago,
                                    success: function (response) {
                                        $.ajax({
                                            type: "POST",
                                            url: "../php/cita_finalizada.php",
                                            data: { id_cita },
                                            success: function(response) {
                                                if (i == (id_citas.length-1)) {
                                                    //window.open(`../php/reportes/reporte_comp_p.php?id_medico=${id_medico}&id_usuario=${id_usuario}&id_pago=${id_pago}`, '_blank');
                                                    setTimeout(function() { window.location.href = "historial_pagos.php"; }, 3000);
                                                }
                                            }
                                        });
                                    }
                                });                            
                            }
                        }
                    });
                }
            });           
        });
      });



    function listarcobros(id) {
        const id_medico = id;
        var fecha_busc = $("#select_fecha").val();
        $.ajax({
            type: "POST",
            data: {id_medico, fecha_busc},
            url: '../php/cita/cita-cobrada.php',
            success: function(response) {
                 $("#respuesta").html('');
                if (response == false) {
                    $('#texto_modal').html("No se encuentran citas disponibles para pago");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $("#total_val").val(0);
                    $("#div_table_cobros").hide();
                    $('#div_f_pago').hide();
                } else {
                    
                    $("#div_table_cobros").show();
                    const citas = JSON.parse(response);
                    let template = '';
                    let com_c = 0;
                    let com_a = 0;

                    
                    citas.forEach(cita => {
                         const id_cita = cita.id_cita;
                         com_c = cita.comision_c;
                         com_a = cita.comision_a;

                         var adicionales = 0;
                         var otros = 0;
                         var val_comision_ban = 0;
                         var val_retencion_cli = 0;
                         
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
                        
                        const o = $.ajax({
                            type: "POST",
                            url: "../php/otros_c/otros_c-get.php",
                            data: { id_cita },
                            global: false,
                            async: false,
                            success: function(response) {
                                return response;
                            }
                        }).responseText;
                        if (o != false) {
                            const ot = JSON.parse(o);
                                ot.forEach(o => {
                                otros += Number(o.costo);
                            });
                        }
                        
                        //Valor de comisi��n del banco y retebnci��n de la cl��nica
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
                        
                        
                        //Verificar pago con tarjeta de cr��dito o tarjeta de d��bito
                        const verif_tarjeta = $.ajax({
                            type: "POST",
                            url: "../php/cita_pago/tarjeta_pago-get.php",
                            data: { id_cita },
                            global: false,
                            async: false,
                            success: function(response) {
                                return response;
                            }
                        }).responseText;

                        //Verificar transferencia bancaria de la cita
                        var val_transf = 0;
                        const t_b = $.ajax({
                            type: "POST",
                            url: "../php/cita_pago/transferencia_b-get.php",
                            data: { id_cita },
                            global: false,
                            async: false,
                            success: function(response) {
                                return response;
                            }
                        }).responseText;

                        if (t_b != false) {
                            const resp = JSON.parse(t_b);
                            resp.forEach(e => {
                                val_transf += Number(e.costo);
                            });
                        }
                        

                        var tipo_cita = "";
                        var tarifa = 0;
                        if (cita.tipo_cita == "1") {
                            tipo_cita = "Normal";
                            tarifa = cita.costo;
                        }else{
                            if (cita.tipo_cita == "0") {
                                tipo_cita = "Control";
                                tarifa = cita.costo;
                            }
                        }

                        if(cita.aseguradora > 1)
                            {
                                tipo_cita = tipo_cita+" - "+cita.nombre;
                                tarifa = cita.valor;
                            }


                        const hora = cita.hora.slice(0, -3);

                        //========Unión de un nombre y un apellido PACIENTE ===================
                        const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
                        const total = tarifa - cita.descuento + adicionales + otros; 

                        //Añadir a Json los valores de cada cita
                        var c_c = 0;
                        if (Number(com_c)>5) {
                            c_c = (((Number(tarifa)-Number(cita.descuento))*com_c)/100); 
                        }else{
                            c_c = com_c;                            
                        }
                        if(cita.aseguradora > 1)
                            {
                                c_c = 0;
                            }
                        const c_a = (((Number(adicionales))*com_a)/100);

                        array_citas.push({
                            'id_cita': Number(cita.id_cita),
                            'tarifa': Number(tarifa),
                            'descuento': Number(cita.descuento),
                            'adicionales': Number(adicionales),
                            'transferencia': Number(val_transf),
                            'comision_ban': Number(val_comision_ban),
                            'retencion_cli': Number(val_retencion_cli),
                            'com_c': Number(com_c),
                            'comision_con': Number(c_c),
                            'com_a': Number(com_a),
                            'comision_adi': Number(c_a)
                        });
                        //---------------------------------------
                        
                        if (verif_tarjeta == "true") {
                            //Comprobar si existen valores de cero en la comisi�0�7pn del banco y la retenci��n de la cl��nica
                            /*
                                if((Number(val_comision_ban == 0) || val_retencion_cli == 0)){
                                    verif = false;
                                }
                            */
                            template += `
                                        <tr class="bg-blue" citaID="${cita.id_cita}">
                                            <td class="pt-3" hidden>${cita.id_cita}</td>
                                            <td><input class="form-check-input" type="checkbox" id="check_cita"></td>
                                            <td class="pt-3">${cita.id_cita}</td>
                                            <td class="pt-3">${cita.fecha} ${hora}h</td>
                                            <td class="pt-3">${nom_apep}</td>
                                            <td class="pt-3">${tipo_cita}</td>
                                            <td class="pt-3">$${Number(tarifa).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(cita.descuento).toFixed(2)}</td>
                                            <td class="pt-3"><a href="#" id="adic_id"><u>$${Number(adicionales).toFixed(2)}</u></a></td>
                                            <td class="pt-3">$${Number(val_transf).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(val_comision_ban).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(val_retencion_cli).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(total).toFixed(2)}</td>
                                            <td class="pt-3"><a href="p_tarjeta.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-secondary btn-sm">Comisi&oacute;n y Retenci&oacute;n</a></td>
                                        </tr>
                                        <tr id="scitang-row">
                                            <td></td>
                                        </tr>
                                    `;
                        }
                        
                        if (verif_tarjeta == "false") {
                            template += `
                                        <tr class="bg-blue" citaID="${cita.id_cita}">
                                            <td class="pt-3" hidden>${cita.id_cita}</td>
                                            <td><input class="form-check-input" type="checkbox" id="check_cita"></td>
                                            <td class="pt-3">${cita.id_cita} </td>
                                            <td class="pt-3">${cita.fecha} ${hora}h</td>
                                            <td class="pt-3">${nom_apep}</td>
                                            <td class="pt-3">${tipo_cita}</td>
                                            <td class="pt-3">$${Number(tarifa).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(cita.descuento).toFixed(2)}</td>
                                            <td class="pt-3"><a href="#" id="adic_id"><u>$${Number(adicionales).toFixed(2)}</u></a></td>
                                            <td class="pt-3">$${Number(val_transf).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(val_comision_ban).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(val_retencion_cli).toFixed(2)}</td>
                                            <td class="pt-3">$${Number(total).toFixed(2)}</td>
                                             <td class="pt-3"><a href="p_tarjeta.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-secondary btn-sm">Comisi&oacute;n o Retenci&oacute;n</a></td>
                                        </tr>
                                        <tr id="scitang-row">
                                            <td></td>
                                        </tr>
                                    `;
                        }
                    }); 
                    $('#cobros_body').html(template);
                    $('#div_table_cobros').show();
                }
                

            }
        });
    }


    // Get ID Cita Adicionale
    $(document).on('click', '#adic_id', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita = $(element).attr('citaID');
        var adicionales = "";
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
                adicionales += `${r.descripcion} - $${r.costo}<br>`;
            });
        }
        $('#modal_a_text').html(adicionales);
        $('#modalAdicionales').modal("show");
        e.preventDefault();
    });


    //==================A�0�5ADIR UNA NUEVA FORMA DE PAGO=================
    var formas_pago = [];
    var costo_fp = 0;
    //Clic en el boton del modal para añadir otros
    $('#add_fpago').click(function(e) {
        e.preventDefault(); //evitar la accion por defecto
        const id_f_pago = $('#select_fpago').val();
        const f_pago = $('#select_fpago option:selected').html();
        const descripcion = $('#descripcion').val();
        const costo = $('#costo').val();
        const valor_total = Number($("#total_val").val());
        if (costo == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#descripcion').val('');
            $('#costo').val('');
        } else {
            $("#fp_body > #tb_row").remove();
            row_transf();
            addCP(id_f_pago, f_pago, descripcion,costo);
            costo_fp += Number(costo);
            if((Number(costo_fp)==Number(valor_total)) && verif==true){
                $('#gen_reporte').removeAttr('disabled');
            }else{
                $('#gen_reporte').attr('disabled', 'disabled');
            }
            const dat = {
                id_f_pago: id_f_pago,
                f_pago: f_pago,
                descripcion: descripcion,
                costo: costo
            };
            formas_pago.push(dat);
            $('#descripcion').val('');
            $('#costo').val('');
        }

    });
    
    //Funcion para cargar los datos en la tabla
    function addCP(id,fP,dCP, cCP) {
        const id_f_pago = id;
        const f_pago = fP;
        const descripcion = dCP;
        const costo = cCP;
        $("#fp_table>tbody").append(`<tr idFpago='${id_f_pago}' f_pago='${f_pago}' dMP='${descripcion}' cMP='${costo}'>
                                                    <td>${f_pago}</td>
                                                    <td>${descripcion}</td>
                                                    <td>$${costo}</td>
                                                    <td><button id='eliminar_fp' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }
    
    ///Botón de eliminar adicional/////
    $(document).on('click', '#eliminar_fp', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_f_pago = $(element).attr('idFpago');
        const f_pago = $(element).attr('f_pago');
        const descripcion = $(element).attr('dMP');
        const costo = $(element).attr('cMP');
        const valor_total = Number($("#total_val").val());
        
        const busqueda = JSON.stringify({
            id_f_pago: id_f_pago,
            f_pago: f_pago,
            descripcion: descripcion,
            costo: costo
        });

        let indice = formas_pago.findIndex(ante => JSON.stringify(ante) === busqueda);
        formas_pago.splice(indice, 1);
        $("#fp_body > tr").remove();
        costo_fp -= Number(costo);
        if((Number(costo_fp)==Number(valor_total)) && verif==true){
            $('#gen_reporte').removeAttr('disabled');
        }else{
            $('#gen_reporte').attr('disabled', 'disabled');
        }
        row_transf();
        formas_pago.forEach(fp => {
            addCP(fp.id_f_pago, fp.f_pago, fp.descripcion, fp.costo);
        });
        
    });

    //Verificar Cheaqueado
    $(document).on('click', '#check_cita', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita = $(element).attr('citaID');
        $(element).toggleClass("checked");
        if( $(element).hasClass("checked") ) {
            console.log(array_citas);
            for (let i = 0; i < array_citas.length; i++) {
                if ( Number(array_citas[i].id_cita) == Number(id_cita) ) {
                    array_citas_c.push(array_citas[i]);
                    id_citas.push(array_citas[i].id_cita);
                }             
            }
        } else {
            for (let i = 0; i < array_citas_c.length; i++) {
                if ( Number(array_citas_c[i].id_cita) == Number(id_cita) ) {
                    array_citas_c.splice(i, i+1);
                }                
            }

            for (let i = 0; i < id_citas.length; i++) {
                if (Number(id_citas[i])==Number(id_cita)) {
                    id_citas.splice(i, i+1);
                }                
            }
        }
        if (array_citas_c.length > 0) {
            var consultas = 0;
            var descuentos = 0;
            var adic = 0;
            var com_ban = 0;
            var ret_cli = 0;
            var com_c = 0;
            var c_c = 0;
            var com_a = 0;
            var c_a = 0;
            var transferencia = 0;

            array_citas_c.forEach(e => {
                consultas += Number(e.tarifa);
                descuentos += Number(e.descuento);
                adic += Number(e.adicionales);
                com_ban += Number(e.comision_ban);
                ret_cli += Number(e.retencion_cli);
                com_c = Number(e.com_c);
                if(e.tarifa>0){c_c += Number(e.comision_con);}
                com_a = Number(e.com_a);
                c_a += Number(e.comision_adi);
                transferencia += Number(e.transferencia);
            });
            console.log(array_citas_c);
            $('#div_f_pago').show();
            $("#consultas").html('$ ' +Number(consultas).toFixed(2));
            $("#descuentos").html('$ ' +Number(descuentos).toFixed(2));
            $("#adicionales").html('$ ' +Number(adic).toFixed(2));
            $("#lbl_retencion_cli").html('$ ' +Number(ret_cli).toFixed(2));
            $("#lbl_comision_ban").html('$ ' +Number(com_ban).toFixed(2));
            $("#n_citas").html(array_citas_c.length);
            const t_consultas = (consultas-descuentos);
            $("#t_consultas").html('$ ' +Number(t_consultas).toFixed(2));
            if (Number(com_c)>5) {
                $("#lbl_c_consulta").html('(CC) Comisión Consulta (TC x ' + com_c + '%):');   
            }else{
                $("#lbl_c_consulta").html('(CC) Comisión Consulta (NC x ' + com_c + '):');                
            }
            $("#c_consulta").html('$ ' + Number(c_c).toFixed(2)); 
            $("#lbl_c_adicional").html('(CA) Comisión Adicional (A x ' + com_a + '%):');
            $("#c_adicional").html('$ ' + Number(c_a).toFixed(2));
            $("#transferencias_b").html('$ ' + Number(transferencia).toFixed(2));
            $("#total").html('$ ' + Number((t_consultas-c_c-c_a+adic-com_ban-ret_cli-transferencia)).toFixed(2));     
            $("#total_val").val(Number((t_consultas-c_c-c_a+adic-com_ban-ret_cli-transferencia)).toFixed(2));
            row_transf();
            //Comprobación para habilitar botón comprobante de pago
            const nFilas = $("#fp_body tr").length;
            var total_fdp = 0;
            for (let i = 0; i < nFilas; i++) {
                const val = $(`#fp_body > tr:nth-child(${i+1})`).attr('cMP');
                const valor_t = Number($("#total_val").val());
                total_fdp += Number(val);
                if(valor_t == total_fdp) {
                    $('#gen_reporte').removeAttr('disabled');
                }else{
                    $('#gen_reporte').attr('disabled', 'disabled');
                }
            }
           //alert(total_fdp);
        } else {
            $('#div_f_pago').hide();
            $("#consultas").html('0');
            $("#descuentos").html('0');
            $("#adicionales").html('0');
            $("#lbl_retencion_cli").html('0');
            $("#lbl_comision_ban").html('0');
            $("#n_citas").html('0');
            $("#t_consultas").html('0');
            $("#lbl_c_consulta").html('(CC) Comisión Consulta:');
            $("#c_consulta").html('0');
            $("#lbl_c_adicional").html('(CA) Comisión Adicional:');
            $("#c_adicional").html('0');
            $("#transferencias_b").html('0');
            $("#total").html('0');     
            $("#total_val").val(0);
            $("#fp_body > #tb_row").remove();
        }
        console.log(id_citas);        
    });

    //Función para cargar las transferencias a la tabla
    function row_transf() {
        $("#fp_body > #tb_row").remove();
        var transferencias = 0;
        array_citas_c.forEach(e => {
            transferencias += Number(e.transferencia);
        });
        if (transferencias != 0) {
            $("#fp_table>tbody").append(`<tr id="tb_row" cMP="0">
                                            <td>TRANSFERENCIA BANCARIA</td>
                                            <td>Transferencia directa - CTA. Médico</td>
                                            <td>$${Number(transferencias).toFixed(2)}</td>
                                            <td></td>
                                        </tr>`);
        }
    }
});