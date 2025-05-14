
$(document).ready(function() {
    const id_cita = $("#id_cita").val();
    listarcitas();
    function listarcitas(){
        $.ajax({
            type: "POST", 
            url: '../php/cita/cita-cobro-id.php',
            data: {id_cita},
            success: function(response) { 
                $("#cobros_body tr").remove();
                if (response == false) {
                    $('#texto_modal').html("No se encuentran citas pendientes por cobrar");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                } else { 
                    const citas = JSON.parse(response);
                    let template = '';
                    citas.forEach(cita => {
                        const id_cita = cita.id_cita;
                        var adicionales = 0;
                        var otros = 0;
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
    
                        const hora = cita.hora.slice(0, -3);
                        var tipo_cita = "";
                        var tarifa = 0;
                        if (Number(cita.pago_ingreso) == 0) {
                            if (cita.tipo_cita == "1") {
                                tipo_cita = "Normal";
                                tarifa = cita.tarifa;
                            }else{
                                if (cita.tipo_cita == "0") {
                                    tipo_cita = "Control";
                                    tarifa = cita.tarifa_control;
                                }
                            } 
                        }else{
                            if (cita.tipo_cita == "1") {
                                tipo_cita = "Normal";
                                tarifa = cita.tarifa;
                            }else{
                                if (cita.tipo_cita == "0") {
                                    tipo_cita = "Control";
                                    tarifa = cita.tarifa_control;
                                }
                            } 
                        }
                        if (cita.aseguradora>1)
                        {
                            console.log("Entro aseguradora");
                            tarifa = 0;
                            tipo_cita =  tipo_cita+" - "+cita.fp_nombre;
                        }
                        
                           
    
                        //========Separación de un nombre y un apellido MEDICO ===================
                        const nombrem = cita.nombres_medi;
                        const apellidom = cita.apellidos_medi;
                        const nom_apem = cita.sufijo + " " + nombrem + " " + apellidom;
                        //========Unión de un nombre y un apellido PACIENTE ===================
                        const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
                        const total = tarifa - cita.descuento + adicionales + otros;
    
                        if (Number(cita.actualizacion) === 0) {
                            if (total < 0) {
                                template += `
                                            <tr class="bg-blue" citaID="${cita.id_cita}" citaTotal="${total}">
                                                <td class="pt-3" hidden>${cita.id_cita}</td>
                                                <td class="pt-3">${cita.fecha}</td>
                                                <td class="pt-3">${hora}h</td>
                                                <td class="pt-3">${nom_apep}</td>
                                                <td class="pt-3">${nom_apem}</td>
                                                <td class="pt-3">${tipo_cita}</td>
                                                <td class="pt-3">$${tarifa}</td>
                                                <td class="pt-3">$${cita.descuento}</td>
                                                <td class="pt-3"><a href="#" id="adic_id"><u>$${Number(adicionales).toFixed(2)}</u></a></td>
                                                <td class="pt-3"><a href="#" id="otro_id"><u>$${Number(otros).toFixed(2)}</u></a></td>
                                                <td class="pt-3" style="color: red">$${total}</td>
                                                <td class="pt-3"><a href="otros_cobros.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-primary btn-sm" id="otros">Otros</a> <a href="cita_ticket_cob.php?total=${total}&id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-secondary btn-sm">Forma de pago</a> <a href="#" style="color: #fff" class="btn btn-success btn-sm" id="cobrar">Cobrar</a></td>
                                            </tr>
                                            <tr id="scitang-row">
                                                <td></td>
                                            </tr>
                                            `;
                            }else{
                                    template += `
                                                <tr class="bg-blue" citaID="${cita.id_cita}" citaTotal="${total}">
                                                    <td class="pt-3" hidden>${cita.id_cita}</td>
                                                    <td class="pt-3">${cita.fecha}</td>
                                                    <td class="pt-3">${hora}h</td>
                                                    <td class="pt-3">${nom_apep}</td>
                                                    <td class="pt-3">${nom_apem}</td>
                                                    <td class="pt-3">${tipo_cita}</td>
                                                    <td class="pt-3">$${tarifa}</td>
                                                    <td class="pt-3">$${cita.descuento}</td>
                                                    <td class="pt-3"><a href="#" id="adic_id"><u>$${Number(adicionales).toFixed(2)}</u></a></td>
                                                    <td class="pt-3"><a href="#" id="otro_id"><u>$${Number(otros).toFixed(2)}</u></a></td>
                                                    <td class="pt-3">$${total}</td>
                                                    <td class="pt-3"><a href="otros_cobros.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-primary btn-sm" id="otros">Otros</a> <a href="cita_ticket_cob.php?total=${total}&id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-secondary btn-sm">Forma de pago</a> <a href="#" style="color: #fff" class="btn btn-success btn-sm" id="cobrar">Cobrar</a></td>
                                                </tr>
                                                <tr id="scitang-row">
                                                    <td></td>
                                                </tr>
                                                `;
                            }
                        }
                        /*
                        if (Number(cita.actualizacion) === 0) {
                            if (total < 0) {
                                template += `
                                            <tr class="bg-blue" citaID="${cita.id_cita}" citaTotal="${total}">
                                                <td class="pt-3" hidden>${cita.id_cita}</td>
                                                <td class="pt-3">${cita.fecha}</td>
                                                <td class="pt-3">${hora}h</td>
                                                <td class="pt-3">${nom_apep}</td>
                                                <td class="pt-3">${nom_apem}</td>
                                                <td class="pt-3">${tipo_cita}</td>
                                                <td class="pt-3">$${tarifa}</td>
                                                <td class="pt-3">$${cita.descuento}</td>
                                                <td class="pt-3"><a href="#" id="adic_id"><u>$${Number(adicionales).toFixed(2)}</u></a></td>
                                                <td class="pt-3"><a href="#" id="otro_id"><u>$${Number(otros).toFixed(2)}</u></a></td> 
                                                <td class="pt-3" style="color: red">$${total}</td>
                                                <td class="pt-3"><a href="otros_cobros.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-primary btn-sm" id="otros">Otros</a> <a href="cita_pago.php?total=${total}&id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-secondary btn-sm">Forma de pago</a> <a href="paci_update_act.php?id_paciente=${cita.id_paciente}&id_usuario=${cita.id_usuario}&id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-success btn-sm">Actualizar datos</a></td>
                                            </tr>
                                            <tr id="scitang-row">
                                                <td></td>
                                            </tr>
                                            `;
                            }else{
                                    template += `
                                                <tr class="bg-blue" citaID="${cita.id_cita}" citaTotal="${total}">
                                                    <td class="pt-3" hidden>${cita.id_cita}</td>
                                                    <td class="pt-3">${cita.fecha}</td>
                                                    <td class="pt-3">${hora}h</td>
                                                    <td class="pt-3">${nom_apep}</td>
                                                    <td class="pt-3">${nom_apem}</td>
                                                    <td class="pt-3">${tipo_cita}</td>
                                                    <td class="pt-3">$${tarifa}</td>
                                                    <td class="pt-3">$${cita.descuento}</td>
                                                    <td class="pt-3"><a href="#" id="adic_id"><u>$${Number(adicionales).toFixed(2)}</u></a></td>
                                                    <td class="pt-3"><a href="#" id="otro_id"><u>$${Number(otros).toFixed(2)}</u></a></td>
                                                    <td class="pt-3">$${total}</td>
                                                    <td class="pt-3"><a href="otros_cobros.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-primary btn-sm" id="otros">Otros</a> <a href="cita_pago.php?total=${total}&id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-secondary btn-sm">Forma de pago</a> <a href="paci_update_act.php?id_paciente=${cita.id_paciente}&id_usuario=${cita.id_usuario}&id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-success btn-sm">Actualizar datos</a></td>
                                                </tr>
                                                <tr id="scitang-row">
                                                    <td></td>
                                                </tr>
                                                `;
                            }
                        }
                            */
    
                    }); 
                    $('#cobros_body').html(template);
                    $('#div_table_cobros').show();
                }
            }
        });
    }

    $(document).on('click', '#cobrar', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita = $(element).attr('citaID');
        const total = Number($(element).attr('citaTotal'));
        $.ajax({
            type: "POST",
            url: "../php/cita_pago/cita_pago-get.php",
            data: { id_cita },
            success: function(response) {
                if (response != false) {
                    var c_total = 0;
                    const cpagos = JSON.parse(response);
                    const pago_ingreso = Number(cpagos[0].pago_ingreso);
                    const tipo_cita = Number(cpagos[0].tipo_cita);
                    const tarifa = Number(cpagos[0].tarifa);
                    const tarifa_control = Number(cpagos[0].tarifa_control);
                    const id_seguro = Number(cpagos[0].aseguradora);
                    var tarifa_t = 0;
                    if(pago_ingreso == 1){
                        if (tipo_cita == 1) {
                            tarifa_t = tarifa;
                        }else{
                            if (tipo_cita == 0) {
                                tarifa_t = tarifa_control;
                            }
                        }
                    }
                    if (id_seguro > 1)
                    {
                        tarifa_t = 0;
                    }
                    
                    cpagos.forEach(cp => {
                        const costo = Number(cp.costo);
                        c_total += costo;
                    });
                    console.log(c_total + "/" + total);
                    if(Number(c_total)==Number(total)){
                        $('#texto_modal_conf').html('Desea realizar el cobro');
                        $('#modal_icon_conf').attr('style', "color: #22445d");
                        $('#modal_icon_conf').attr("class", "fa fa-question-circle fa-4x animated rotateIn mb-4");
                        $('#modalConfirmacion').modal("show");
                  
                
                        $("#btn_cobrar").click(function(e) {
                            e.preventDefault();
                            $.ajax({
                                type: "POST",
                                url: "../php/cobro.php",
                                data: { id_cita },
                                success: function(response) {
                                    console.log(response);
                                    $('#texto_modal').html(response);
                                    $('#modal_icon').attr("class", "fa fa-money fa-4x animated rotateIn mb-4");
                                    $('#modalPush').modal("show");
                                    setTimeout(function() { window.location.href = "c_pendientes.php"; }, 3000);
                                }
                            });
                        });
                    }else{
                        $('#texto_modal').html("Verificar que la suma total de las formas de pago coincida con el total a cobrar");
                        $('#modal_icon').attr("class", "fa fa-money fa-4x animated rotateIn mb-4");
                        $('#modalPush').modal("show");
                    }
                    
                }else{
                    $('#texto_modal').html("Por favor ingresar formas de pago");
                    $('#modal_icon').attr("class", "fa fa-money fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                }      
            }
        });
    });
    
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
                        
        if (r !== false) {
            const resp = JSON.parse(r);
                resp.forEach(r => {
                adicionales += `${r.descripcion} - $${r.costo}<br>`;
            });
        }
        $('#modal_a_text').html(adicionales);
        $('#modalAdicionales').modal("show");
        e.preventDefault();
    });

    //Get ID Cita Otro
    $(document).on('click', '#otro_id', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita = $(element).attr('citaID');
        var otros = "";
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
        if (o !== false) {
            const ot = JSON.parse(o);
                ot.forEach(o => {
                otros += `${o.descripcion} - $${o.costo}<br>`;
            });
        }
        $('#modal_o_text').html(otros);
        $('#modalOtros').modal("show");
        e.preventDefault();
    });
    

    //Busqueda en la tabla de pacientes
    $("#busc_paci").keyup(function() {
        _this = this;
        $.each($("#cobros_table tbody tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                {
                    $(this).hide();
                }
            else
                {
                    $(this).show();
                }
        });
    });

});