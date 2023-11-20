$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();
    $.post('../php/medico/medico-list-id.php', { id_usuario }, (response) => {
        const medico = JSON.parse(response); 
        const id_medico = medico.id_medico;
        let nombree = medico.nombres_medi.split(' ')[0];
        let apellidoe = medico.apellidos_medi.split(' ')[0];
        $('#imagen-perfil').attr("src", "../" + medico.imagen);
        $('#nom_usr').html(nombree + " " + apellidoe);
        $('#name_medi').html(medico.sufijo + " " + medico.nombres_medi + " " + medico.apellidos_medi);
        $.ajax({
            type: "POST",
            url: "../php/medico/dashboard/citas_pendientes.php",
            data: {id_medico},
            success: function (response) {
                if (response != false) {
                    const citas = JSON.parse(response);
                    const num_cita = citas.length;
                    $('#total_cp').html(num_cita);
                }else{
                    $('#total_cp').html(0);
                }
                
            }
        });
        $.ajax({
            type: "POST",
            url: "../php/medico/dashboard/citas_atendidas.php",
            data: {id_medico},
            success: function (response) {
                if (response != false) {
                    const citas = JSON.parse(response);
                    const num_cita = citas.length;
                    $('#total_ca').html(num_cita);
                }else{
                    $('#total_ca').html(0);
                }
                
            }
        });
        $.ajax({
            type: "POST",
            url: "../php/medico/dashboard/citas_cobradas.php",
            data: {id_medico},
            success: function (response) {
                if (response != false) {
                    const citas = JSON.parse(response);
                    const num_cita = citas.length;
                    $('#total_cc').html(num_cita);
                }else{
                    $('#total_cc').html(0);
                }
                
            }
        });
        $.ajax({
            type: "POST",
            url: "../php/medico/dashboard/casos-abiertos.php",
            data: {id_medico},
            success: function (response) {
                if (response != false) {
                    const casos = JSON.parse(response);
                    const num_caso = casos.length;
                    $('#total_ca_a').html(num_caso);
                }else{
                    $('#total_ca_a').html(0);
                }
                
            }
        });
        $.ajax({
            type: "POST",
            url: "../php/medico/dashboard/casos-cerrados.php",
            data: {id_medico},
            success: function (response) {
                if (response != false) {
                    const casos = JSON.parse(response);
                    const num_caso = casos.length;
                    $('#total_ca_c').html(num_caso);
                }else{
                    $('#total_ca_c').html(0);
                }
                
            }
        });
    });

    $("#citas_ar").on("click", function () {
        $.ajax({
            type: "POST",
            url: "../php/medico/medico-list-id.php",
            data: {id_usuario},
            success: function (response) {
                const medico = JSON.parse(response); 
                const id_medico = medico.id_medico;
                $.ajax({
                    type: "POST",
                    data: { id_medico },
                    url: '../php/medico/dashboard/cita-ar-list.php',
                    success: function(response) {
                        if (response == false) {
                            $('#modalCAR').modal("hide");
                            $('#texto_modal').html("No se encuentran citas agendadas o reagendadas");
                            $('#modal_icon').attr('style', "color: orange");
                            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                        } else {
                            $('#modalCAR').modal("hide");
                            const citas = JSON.parse(response);
                            let template = '';
                            citas.forEach(cita => {       
                                const hora = cita.hora.slice(0, -3);
                                //========Unión de un nombre y un apellido PACIENTE ===================
                                const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
                                template += `
                                                <tr class="bg-blue" citaID="${cita.id_cita}">
                                                    <td class="pt-3" hidden>${cita.id_cita}</td>
                                                    <td class="pt-3">${nom_apep}</td>
                                                    <td class="pt-3">${cita.fecha}</td>
                                                    <td class="pt-3">${hora}h</td>
                                                </tr>
                                    `;
        
                            });
                            $('#tb_citasar').html(template);
                        }
                    }
                });
                $("#modalCAR").modal("show");
            }
        });
    });
    
    $("#citas_pc").on("click", function () {
        $.ajax({
            type: "POST",
            url: "../php/medico/medico-list-id.php",
            data: {id_usuario},
            success: function (response) {
                const medico = JSON.parse(response); 
                const id_medico = medico.id_medico;
                $.ajax({
                    type: "POST",
                    data: {id_medico},
                    url: '../php/medico/dashboard/cita-p-cobro.php',
                    success: function(response) {
                        if (response == false) {
                            $('#modalCPC').modal("hide");
                            $('#texto_modal').html("No se encuentran citas pendientes por cobrar");
                            $('#modal_icon').attr('style', "color: orange");
                            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                        } else {
                            $('#modalCPC').modal("hide");
                            const citas = JSON.parse(response);
                            let template = '';
                            let consultas = 0;
                            let descuentos = 0;
                            let adic = 0;
                            let com_c = 0;
                            let com_a = 0;
        
                            
                            citas.forEach(cita => {
                                 const id_cita = cita.id_cita;
                                 com_c = cita.comision_c;
                                 com_a = cita.comision_a;
        
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
        
                                var tipo_cita = "";
                                var tarifa = 0;
                                console.log(cita.tipo_cita);
                                if (cita.tipo_cita == "1") {
                                    tipo_cita = "Normal";
                                    tarifa = cita.tarifa;
                                }else{
                                    if (cita.tipo_cita == "0") {
                                        tipo_cita = "Control";
                                        tarifa = cita.tarifa_control;
                                    }
                                }
        
                                const hora = cita.hora.slice(0, -3);


                                //========Uni贸n de un nombre y un apellido PACIENTE ===================
                                const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
                                const total = tarifa - cita.descuento + adicionales + otros; 
                                consultas += Number(tarifa);
                                descuentos += Number(cita.descuento);
                                
                                adic += adicionales;
        
        
                                template += `
                                                <tr class="bg-blue" citaID="${cita.id_cita}">
                                                    <td class="pt-3" hidden>${cita.id_cita}</td>
                                                    <td class="pt-3">${cita.fecha}</td>
                                                    <td class="pt-3">${hora}h</td>
                                                    <td class="pt-3">${nom_apep}</td>
                                                    <td class="pt-3">${tipo_cita}</td>
                                                    <td class="pt-3">$${Number(tarifa).toFixed(2)}</td>
                                                    <td class="pt-3">$${Number(cita.descuento).toFixed(2)}</td>
                                                    <td class="pt-3">$${Number(adicionales).toFixed(2)}</td>
                                                    <td class="pt-3">$${Number(otros).toFixed(2)}</td>
                                                    <td class="pt-3">$${Number(total).toFixed(2)}</td>
                                                </tr>
                                            `;
        
                            });
                            $('#tb_citaspc').html(template);
                            $("#modalCPC").modal("show");
                        }
                    }
                });
            }
        });
    });
});