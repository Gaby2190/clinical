$(document).ready(function() {
    $('#div_table_casos').hide();
    $('#nombres_paci1').attr('disabled', 'disabled');
    $('#apellidos_paci1').attr('disabled', 'disabled');
    $('#nombres_paci2').attr('disabled', 'disabled');
    $('#apellidos_paci2').attr('disabled', 'disabled');
    const id_paciente= document.getElementById("id_paciente").value;
    const id_medico= document.getElementById("id_medico").value;
    const id_especialidad= document.getElementById("id_especialidad").value;
    const seguro= document.getElementById("seguro").value;
    precargar(id_paciente, id_medico, id_especialidad);
        
    function precargar(id_paciente, id_medico, id_especialidad)
     {
        $.ajax({
                    type: "POST",
                    url: '../php/caso/caso-list-pac-det.php',
                    data: { id_paciente, id_medico, id_especialidad },
                    success: function(response) {
                        const casos = JSON.parse(response);
                        console.log(casos);
                        let template = '';
                        casos.forEach(caso => {
                            const id_caso = caso.id_caso;
                            //========Separaci贸n de un nombre y un apellido ===================
                            const nombre = caso.nombres_medi;
                            const apellido = caso.apellidos_medi;
                            const nom_ape = caso.sufijo + " " + nombre + " " + apellido;
                            const ult_fecha = ultimaF(id_caso);
                            console.log(ult_fecha);
                            let detalle;
                            if ((caso.descripcion == null) || caso.descripcion == "") {
                                detalle = "N/A";
                            } else {
                                detalle = caso.descripcion;
                            }

                            if (ult_fecha.ok == false) {
                                template += `
                                        <tr class="bg-blue" casoID="${caso.id_caso}">
                                            <td class="pt-3" hidden>${caso.id_caso}</td>
                                            <td class="pt-3">${nom_ape}</td>
                                            <td class="pt-3">${detalle}</td>
                                            <td class="pt-3">${ult_fecha.msg}</td>
                                            <td class="pt-3"></td>
                                        </tr>
                                        <tr id="spacing-row">
                                            <td></td>
                                        </tr>
                                    `;
                            } else {
                                template += `
                                    <tr class="bg-blue" casoID="${caso.id_caso}">
                                        <td class="pt-3" hidden>${caso.id_caso}</td>
                                        <td class="pt-3">${nom_ape}</td>
                                        <td class="pt-3">${detalle}</td>
                                        <td class="pt-3">${ult_fecha.msg}</td>
                                        <td class="pt-3"><a href="#" id='agendar_item'><span class="fa fa-calendar btn"></span>Agendar</a></td>
                                    </tr>
                                    <tr id="spacing-row">
                                        <td></td>
                                    </tr>
                                `;
                            }
                        });

                        $('#casos_body').html(template);
                        if (casos.length != 0) {
                            $('#div_table_casos').show();
                        } else {
                            $('#div_table_casos').hide();
                            $('#texto_modal').html(`El paciente ${paciente.nombres_paci1} ${paciente.apellidos_paci1} no cuenta con un caso registrado`);
                            $('#modal_icon').attr('style', "color: orange");
                            $('#modal_icon').attr("class", "fa fa-user fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                        }
                    }
                });
     }

    $('#buscar_btn').click(function(e) {
        e.preventDefault();
        $('#modalBusqueda').modal("show");
        listarPacientes();
    });

    function listarPacientes() {
        $.ajax({
            type: "POST",
            url: '../php/paciente/pacientes-list-caso-a.php',
            success: function(response) {
                const pacientes = JSON.parse(response);
                let template = '';
                pacientes.forEach(paci => {
                    //========Uni贸n de un nombre y un apellido ===================
                    const nom_ape = paci.nombres_paci1 + " " + paci.nombres_paci2 + " " + paci.apellidos_paci1 + " " + paci.apellidos_paci2;

                    template += `
                                    <tr class="bg-blue" pacienteID="${paci.id_paciente}" pacienteUSR="${paci.id_usuario}">
                                        <td class="pt-3" hidden>${paci.id_paciente}</td>
                                        <td class="pt-2">
                                            <img src="../${paci.imagen}" class="rounded-circle" alt="">
                                            <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                        </td>
                                        <td class="pt-3">${paci.cedula_paci}</td>
                                        <td class="pt-3">${paci.celular_paci}</td>
                                        <td class="pt-3"><a href="#" id='add_item'><span class="fa fa-plus btn"></span>Seleccionar</a></td>
                                    </tr>
                                    <tr id="spacing-row">
                                        <td></td>
                                    </tr>
                        `;

                });
                $('#pacientes').html(template);
            }
        });
    }

    function ultimaF(id_cas) {
        const id_caso = id_cas;
        const resp = $.ajax({
            type: "POST",
            url: '../php/cita/cita-ult-fecha.php',
            data: { id_caso },
            global: false,
            async: false,
            success: function(response) {
                return response;
            }
        }).responseText;

        if (resp == false) {

            const resp2 = $.ajax({
                type: "POST",
                url: '../php/cita/cita-list-agen.php',
                data: { id_caso },
                global: false,
                async: false,
                success: function(response) {
                    return response;
                }
            }).responseText;
            if (resp2 != false) {
                const dat = JSON.parse(resp2);
                var h_cita = dat.hora.slice(0, -3);
                const datos = {
                    ok: false,
                    msg: `Tiene cita agendada para el ${dat.fecha} a las ${h_cita}h`
                };
                return datos;
            } else {
                const datos = {
                    ok: true,
                    msg: `El paciente no cuenta con citas`
                };
                return datos;
            }
        } else {
            const datos = {
                ok: true,
                msg: JSON.parse(resp).fecha
            };
            return datos;
        }
    }


    $(document).on('click', '#add_item', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id_paciente = $(elemento).attr('pacienteID');
        const id_usuario = $(elemento).attr('pacienteUSR');
        console.log(id_usuario);
        $.ajax({
            type: "POST",
            url: '../php/paciente/paciente-list-dat.php',
            data: { id_usuario },
            success: function(response) {
                const paciente = JSON.parse(response);
                $('#nombres_paci1').val(paciente.nombres_paci1);
                $('#nombres_paci2').val(paciente.nombres_paci2);
                $('#apellidos_paci1').val(paciente.apellidos_paci1);
                $('#apellidos_paci2').val(paciente.apellidos_paci2);
                $('#modalBusqueda').modal("hide");
                $.ajax({
                    type: "POST",
                    url: '../php/caso/caso-list-pac.php',
                    data: { id_paciente },
                    success: function(response) {
                        const casos = JSON.parse(response);
                        console.log(casos);
                        let template = '';
                        casos.forEach(caso => {
                            const id_caso = caso.id_caso;
                            //========Separaci贸n de un nombre y un apellido ===================
                            const nombre = caso.nombres_medi;
                            const apellido = caso.apellidos_medi;
                            const nom_ape = caso.sufijo + " " + nombre + " " + apellido;
                            const ult_fecha = ultimaF(id_caso);
                            console.log(ult_fecha);
                            let detalle;
                            if ((caso.descripcion == null) || caso.descripcion == "") {
                                detalle = "N/A";
                            } else {
                                detalle = caso.descripcion;
                            }

                            if (ult_fecha.ok == false) {
                                template += `
                                        <tr class="bg-blue" casoID="${caso.id_caso}">
                                            <td class="pt-3" hidden>${caso.id_caso}</td>
                                            <td class="pt-3">${nom_ape}</td>
                                            <td class="pt-3">${detalle}</td>
                                            <td class="pt-3">${ult_fecha.msg}</td>
                                            <td class="pt-3"></td>
                                        </tr>
                                        <tr id="spacing-row">
                                            <td></td>
                                        </tr>
                                    `;
                            } else {
                                template += `
                                    <tr class="bg-blue" casoID="${caso.id_caso}">
                                        <td class="pt-3" hidden>${caso.id_caso}</td>
                                        <td class="pt-3">${nom_ape}</td>
                                        <td class="pt-3">${detalle}</td>
                                        <td class="pt-3">${ult_fecha.msg}</td>
                                        <td class="pt-3"><a href="#" id='agendar_item'><span class="fa fa-calendar btn"></span>Agendar</a></td>
                                    </tr>
                                    <tr id="spacing-row">
                                        <td></td>
                                    </tr>
                                `;
                            }
                        });

                        $('#casos_body').html(template);
                        if (casos.length != 0) {
                            $('#div_table_casos').show();
                        } else {
                            $('#div_table_casos').hide();
                            $('#texto_modal').html(`El paciente ${paciente.nombres_paci1} ${paciente.apellidos_paci1} no cuenta con un caso registrado`);
                            $('#modal_icon').attr('style', "color: orange");
                            $('#modal_icon').attr("class", "fa fa-user fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                        }
                    }
                });
            }
        });
        e.preventDefault();

    }); 

    //Busqueda en la tabla de pacientes
    $("#busc_paci").keyup(function() {
        _this = this;
        $.each($("#tabla_pac tbody tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });
    //OJO-------------------------
    $(document).on('click', '#agendar_item', (e) => {
        
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const hora = $("#turno").val();
        const id_caso = $(elemento).attr('casoID');
        const fecha = $("#fecha_cita").val();
        const seguro = $("#seguro").val();
        const numeroDia = new Date(fecha).getDay();
        const dias = [
            'domingo',
            'lunes',
            'martes',
            'miércoles',
            'jueves',
            'viernes',
            'sábado',
          ];
        const nombreDia = dias[numeroDia+1];

        const dataCita = {
            fecha: fecha,
            hora: hora,
            tipo_cita: 0,
            id_caso: id_caso,
            seguro: seguro
        };
        
        $('#texto_modal_c').html(`Generar cita para el día ${nombreDia} (${fecha}) a las ${hora}h`);
        $('#modal_icon_c').attr("class", "fa fa-calendar fa-4x animated rotateIn mb-4");
        $('#modalConfirmacion').modal("show");

        $('#crear').click(function(e) {
            e.preventDefault();
            $("#citas_body tr").remove();
            $('#div_table').hide();
            $.ajax({ 
                type: "POST",
                url: '../php/cita/cita-add.php',
                data: dataCita,
                success: function(response) {
                    $('#texto_modal').html(response);
                    $('#modal_icon').attr('style', "color: rgb(57, 160, 57)");
                    $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $.ajax({
                        type: "POST",
                        url: "../php/caso/caso-get.php",
                        data: {id_caso},
                        success: function (response) {
                            const paci = JSON.parse(response);
                            const datMail = {
                                medico: paci.sufijo + " " + paci.nombres_medi + " " + paci.apellidos_medi,
                                tipo_cita: 0,
                                nom_ape: paci.nombres_paci1 + " " + paci.nombres_paci2 + " " + paci.apellidos_paci1 + " " + paci.apellidos_paci2,
                                correo: paci.correo_paci,
                                fecha: fecha,
                                hora: hora
                            };
                            
                            $.ajax({
                                type: "POST",
                                url: "../php/notificacion/mail/cita-mail.php",
                                data: datMail,
                                success: function (response) {
                                    console.log(response);
                                    /*
                                    const datos_msn_doc = paci.nom_ape_medi + ","+ fecha + "," + hora;
                                    const num_doc = paci.celular_medi;
                                    const cedula_doc = paci.cedula_medi;

                                    var dia = new Date(fecha).getDay();
                                    var mes = new Date(fecha).getMonth();
                                    var year = new Date(fecha).getFullYear();

                                    const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];
                                    mes = (meses[mes]);

                                    fecha_msn=dia+" de "+mes+" del "+year;
                                    var settings = {
                                        "url": "https://api.massend.com/api/sms",
                                        "method": "POST",
                                        "timeout": 0,
                                        "headers": {
                                            "Content-Type": "application/json"
                                        },
                                        "data": JSON.stringify({
                                            "user": "cesmed@massend.com",
                                            "pass": "cesmed123",
                                            "mensajeid": "44937",
                                            "campana": "CLINICAL CESMED S.C.",
                                            "telefono": num_doc,
                                            "dni": cedula_doc,
                                            "tipo": "1",
                                            "ruta": "0",
                                            "datos": datos_msn_doc
                                        }),
                                        };
                                        
                                        $.ajax(settings).done(function (response) {
                                        console.log(response);
                                        });
                                    */
                                }
                                    
                            });
                            
                        }
                    });
                    setTimeout(function() { window.location.href = "rece.php"; }, 3000);
                        
                   
                } 
            });
        });

    });


});