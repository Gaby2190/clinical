$(document).ready(function() {
    getMedicos();

    $('#div_table_citas').hide();
    $('#div_table_resultados').hide();

    function msg() {
        $('#texto_modal').html("Por favor seleccione un médico para cargar la sala de espera");
        $('#modal_icon').attr('style', "color: #22445d");
        $('#modal_icon').attr("class", "fa fa-info-circle fa-4x animated rotateIn mb-4");
        $('#modalPush').modal("show");
    }


    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    $('#fecha_cita').attr('value', f_actual);
    $('#fecha_cita').attr('min', f_actual);

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

    function listarcitas() {
        const fecha = f_actual;
        const id_medico = $("#select_medico").val();
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
                        template += `
                                        <tr class="bg-blue" citaID="${cita.id_cita}">
                                            <td class="pt-3" hidden>${cita.id_cita}</td>
                                            <td class="pt-3">${cita.fecha}</td>
                                            <td class="pt-3">${hora}h</td>
                                            <td class="pt-3">${nom_apep}</td>
                                            <td class="pt-3">${nom_apem}</td>
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


    function listarResultado() {
        const fecha = f_actual;
        const id_medico = $("#select_medico").val();
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

    $("#list_espera").click(function(e) {
        e.preventDefault();
        if ($("#select_medico").val() == "") {
            msg();
        } else {
            listarcitas();
            listarResultado();
        }
    });
});