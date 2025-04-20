$(document).ready(function() {

    $('#div_table_citas').hide();

    var d = new Date(); 
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    $('#fecha_cita').attr('value', f_actual);

    $("#test_btn").click(function (e) { 
        e.preventDefault();
        alert($('#fecha_cita').val());
    });

    function listarcitas() {
        const fecha = $("#fecha_cita").val();
        $.ajax({
            type: "POST",
            data: { fecha },
            url: '../php/cita/cita-list-fech.php',
            success: function(response) {
                if (response == false) {
                    $('#texto_modal').html("No se encuentran citas generados para la fecha indicada");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_table_citas').hide();
                } else {
                    const citas = JSON.parse(response);
                    let template = '';
                    citas.forEach(cita => {

                        const hora = cita.hora.slice(0, -3);
                        
                        
                        var tipo_cita = cita.tipo_cita;
                        if(tipo_cita==0)
                        {
                           tipo_cita="Control"; 
                        }
                        else
                        {
                            tipo_cita="Normal";
                        }

                        //========Separación de un nombre y un apellido MEDICO ===================
                        const nombrem = cita.nombres_medi;
                        const apellidom = cita.apellidos_medi;
                        const nom_apem = cita.sufijo + " " + nombrem + " " + apellidom;
                        //========Unión de un nombre y un apellido PACIENTE ===================
                        const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
                        template += `
                                        <tr class="bg-blue" citaID="${cita.id_cita}">
                                            <td class="pt-3" hidden>${cita.id_cita}</td>
                                            <td class="pt-3">${tipo_cita}</td>
                                            <td class="pt-3">${cita.fecha}</td>
                                            <td class="pt-3">${hora}h</td>
                                            <td class="pt-3">${nom_apep} - <strong>${cita.seguro}</strong></td>
                                            <td class="pt-3">${nom_apem}</td>
                                            <td class="pt-3">
                                                <a href="paci_espera.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-success btn-sm">Ingresar a sala de espera</a>
                                            </td>
                                            <td class="pt-3">
                                                <a href="cita_reagendar.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-secondary btn-sm">Reagendar Cita</a>
                                            </td>
                                            <td class="pt-3">
                                                <a href="#" id='cancelar' style="color: #fff" class="btn btn-danger btn-sm">Cancelar Cita</a>
                                            </td>
                                            <td class="pt-3">
                                                <a href="cita_ticket_his.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-primary btn-sm">Registrar Abono</a>
                                            </td>
                                        </tr>
                                        <tr id="scitang-row">
                                            <td></td>
                                        </tr>
                            `;

                    });
                    $('#citas_body').html(template);
                    $('#div_table_citas').show();
                }
            }
        });
    }

    function listarPacientes() {
        $.ajax({
            type: "POST",
            url: '../php/paciente/pacientes-list-cita-a.php',
            success: function(response) {
                const pacientes = JSON.parse(response);
                let template = '';
                pacientes.forEach(paci => {
                    //========Unión de un nombre y un apellido ===================
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
                                        <td class="pt-3">
                                        <a href="#" id='add_item'><span class="fa fa-plus btn"></span>Seleccionar</a></td>
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

    $('#list_paci').click(function(e) {
        e.preventDefault();
        $('#modalBusqueda').modal("show");
        listarPacientes();
    });

    $(document).on('click', '#add_item', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id_paciente = $(elemento).attr('pacienteID');
        $.ajax({
            type: "POST",
            data: { id_paciente },
            url: '../php/cita/cita-list-paci.php',
            success: function(response) {
                if (response == false) {
                    $('#modalBusqueda').modal("hide");
                    $('#texto_modal').html("No se encuentran citas generados para el paciente indicada");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_table_citas').hide();
                } else {
                    $('#modalBusqueda').modal("hide");
                    const citas = JSON.parse(response);
                    let template = '';
                    citas.forEach(cita => {

                        const hora = cita.hora.slice(0, -3);

                        //========Separación de un nombre y un apellido MEDICO ===================
                        const nombrem = cita.nombres_medi;
                        const apellidom = cita.apellidos_medi;
                        const nom_apem = cita.sufijo + " " + nombrem + " " + apellidom;
                        //========Unión de un nombre y un apellido PACIENTE ===================
                        const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
                        template += `
                                        <tr class="bg-blue" citaID="${cita.id_cita}">
                                            <td class="pt-3" hidden>${cita.id_cita}</td>
                                            <td class="pt-3">${cita.fecha}</td>
                                            <td class="pt-3">${hora}h</td>
                                            <td class="pt-3">${nom_apep}</td>
                                            <td class="pt-3">${nom_apem}</td>
                                            <td class="pt-3">
                                                <a href="paci_espera.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-success btn-sm">Ingresar a sala de espera</a>
                                            </td>
                                            <td class="pt-3">
                                                <a href="cita_reagendar.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-secondary btn-sm">Reagendar Cita</a>
                                            </td>
                                            <td class="pt-3">
                                                <a href="#" id='cancelar' style="color: #fff" class="btn btn-danger btn-sm">Cancelar Cita</a>
                                            </td>
                                            <td class="pt-3">
                                                <a href="cita_ticket_his.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-primary btn-sm">Registrar Abono</a>
                                            </td>
                                        </tr>
                                        <tr id="scitang-row">
                                            <td></td>
                                        </tr>
                            `;

                    });
                    $('#citas_body').html(template);
                    $('#div_table_citas').show();
                }
            }
        });
        
        e.preventDefault();

    }); 

    $(document).on('click', '#cancelar', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita = $(element).attr('citaID');
        
        $('#texto_modal_conf').html('Estó seguro de que desea cancelar la cita');
        $('#modal_icon_conf').attr('style', "color: orange");
        $('#modal_icon_conf').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
        $('#modalConfirmacion').modal("show");


        $("#btn_cancelar").click(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "../php/cita/cita-cancel.php",
                data: { id_cita },
                success: function(response) {
                    console.log(response);
                    $('#texto_modal').html(response);
                    $('#modal_icon').attr("class", "fa fa-calendar fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    listarcitas();
                }
            });
        });

    });

    $("#list_citas").click(function(e) {
        e.preventDefault();
        listarcitas();
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
});