$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();

    listarcitas();
    listarResultado();

    $('#div_table_citas').hide();
    $('#div_table_resultados').hide();


    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;


    function listarcitas() {
        $.ajax({
            type: "POST",
            url: "../php/medico/medico-list-id.php",
            data: {id_usuario},
            success: function (response) {
                const fecha = f_actual;
                const id_medico = JSON.parse(response).id_medico;
                const dataEspera = {
                    id_medico: id_medico,
                    fecha: fecha
                }; 
                $.ajax({
                    type: "POST",
                    data: dataEspera,
                    url: '../php/cita/cita-espera-med.php',
                    success: function(response) {
                        if (response == false) {
                            $('#texto_modal').html("No se encuentran pacientes en sala de espera con cita agendada");
                            $('#modal_icon').attr('style', "color: #22445d");
                            $('#modal_icon').attr("class", "fa fa-info-circle fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                            $('#div_table_citas').hide();
                        } else {
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
                                
                                const seguro = cita.aseguradora;
                                template += `
                                                <tr class="bg-blue" citaID="${cita.id_cita}">
                                                    <td class="pt-3" hidden>${cita.id_cita}</td>
                                                    <td class="pt-3">${cita.fecha}</td>
                                                    <td class="pt-3">${hora}h</td>
                                                    <td class="pt-3">${nom_apep}</td>
                                                    <td class="pt-3">${nom_apem}</td>
                                                    <td class="pt-3"><a href="atencion_paci.php?id_paciente=${cita.id_paciente}&id_cita=${cita.id_cita}"" style="color: #fff" class="btn btn-success btn-sm">Atender</a></td>
                                                    `;
                                if (seguro < 2)
                                {
                                  //  template += `<td class="pt-3"><a href="atencion_paci_sin.php?id_paciente=${cita.id_paciente}&id_cita=${cita.id_cita}"" style="color: #fff" class="btn btn-warning btn-sm">Atender Sin Formulario</a></td>`;
                                }
                                 template += `             
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
        });
    } 


    function listarResultado() {
        $.ajax({
            type: "POST",
            url: "../php/medico/medico-list-id.php",
            data: {id_usuario},
            success: function (response) {
                const fecha = f_actual;
                const id_medico = JSON.parse(response).id_medico;
                const dataResultado = {
                    id_medico: id_medico,
                    fecha: fecha
                };  
                $.ajax({
                    type: "POST", 
                    data: dataResultado,
                    url: '../php/cita/cita-resultado-med.php',
                    success: function(response) {
                        if (response != false) {
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
                                                    <td class="pt-3"><a href="atencion_paci.php?id_paciente=${cita.id_paciente}&id_cita=${cita.id_cita}"" style="color: #fff" class="btn btn-success btn-sm">Atender</a></td>
                                                </tr>
                                                <tr id="scitang-row">
                                                    <td></td>
                                                </tr>
                                    `;
        
                            });
                            $('#resultados_body').html(template);
                            $('#div_table_resultados').show();
                        }else{
                            $('#div_table_resultados').hide();
                        }
                    }
                });
            }
        });
    }

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
});