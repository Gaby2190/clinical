$(document).ready(function() {
    $('#div_table').hide();

    $('#texto_modal').html("Por favor seleccione una nueva fecha para reagendar la cita");
    $('#modal_icon').attr('style', "color: orange");
    $('#modal_icon').attr("class", "fa fa-calendar fa-4x animated rotateIn mb-4");
    $('#modalPush').modal("show");

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    $('#fecha_cita').attr('min', f_actual);
    $('#fecha_cita').attr('value', f_actual);

    function generarTabla() {
        //=====Declarar variables para generar horarios=====//
        var h_ingreso = 8;
        var h_salida = 22;
        var horarios_citas = [];
        //=====Tomar datos del id de la cita y de la fecha=====//
        const id_cita = $("#id_cita").val();
        const fecha = $('#fecha_cita').val();
        //======Obtención de horas actuales=====//
        const horaACT = new Date();
        const h = horaACT.getHours();
        //===== Comprobación si la fecha seleccionada es igual a la fecha actual =====//
        if (fecha == f_actual) {
            if ((h > h_ingreso) && (h < h_salida)) {
                h_ingreso = h + 1;
            }
        }
        //=====Obtención de tiempo de atención promedio según el id del médico=====//
        $.ajax({
            type: "POST",
            data: { id_cita },
            url: "../php/cita/cita-read-id.php",
            success: function(response) {
                const id_medico = JSON.parse(response).id_medico;
                $.ajax({
                    type: "POST",
                    url: '../php/medico/medico-list.php',
                    data: { id_medico },
                    success: function(response) {
                        const tap = Number(JSON.parse(response).tiempo_ap);
                        //======== Declarar contadores para generar horario en array==========//
                        const num_h = h_salida - h_ingreso;
                        let cont_h = h_ingreso;
                        let cont_m = 0;
                        const num_cita = (num_h * 60) / tap;

                        for (let i = 0; i < num_cita; i++) {
                            if (cont_m == 0) {
                                horarios_citas[i] = cont_h + ":" + cont_m + "0";
                            } else {
                                horarios_citas[i] = cont_h + ":" + cont_m;
                            }

                            cont_m += tap;


                            if (cont_m == 60) {
                                cont_h += 1;
                                cont_m = 0;
                            }

                        }
                        //==========Listar horarios de medico segun fecha (citas)
                        const postDatCas = {
                            id_medico: id_medico,
                            fecha: fecha
                        };

                        // Buscar horarios de citas para la fecha seleccionada en base al medico y fecha y almacenar en array
                        const resp = $.ajax({
                            type: "POST",
                            url: '../php/cita/cita-med-list.php',
                            data: postDatCas,
                            global: false,
                            async: false,
                            success: function(response) {
                                return response;
                            }
                        }).responseText;

                        //=====Guarda en un array las citas en las cuales el médico tiene citas para la fecha =======//
                        const horas = [];
                        if (resp != false) {
                            const resp_citas = JSON.parse(resp);
                            resp_citas.forEach(r_cita => {
                                var h_cita = r_cita.hora.slice(0, -3).replace(/:/g, '');
                                if (h_cita[0] == "0") {
                                    h_cita = h_cita.replace("0", '');
                                }
                                horas.push(`${h_cita}`);
                            });
                        }

                        //======Comprobar si en el arreglo general de horarios están incluido los calores de las citas ocupadas=========
                        for (let i = 0; i < horarios_citas.length; i++) {
                            const id_cit = horarios_citas[i].replace(/:/g, '');
                            if (horas.includes(`${id_cit}`)) {
                                $("#citas_table>tbody").append(`<tr Turnoid="${id_cit}" idT="${horarios_citas[i]}"><td>${$('#fecha_cita').val()}</td><td>${horarios_citas[i]}</td><td><a style="color: rgb(122, 120, 120);cursor: default;" class="btn" id="agendado_btn"><span class="fa fa-calendar"></span> RESERVADO</a></td></tr>`);
                            } else {
                                $("#citas_table>tbody").append(`<tr Turnoid="${id_cit}" idT="${horarios_citas[i]}" fecha="${$('#fecha_cita').val()}"><td>${$('#fecha_cita').val()}</td><td>${horarios_citas[i]}</td><td><a href="#" style="color: #ff" class="btn" id="disponible_btn"><span class="fa fa-check"></span> DISPONIBLE</a></td></tr>`);
                            }
                        }
                    }
                });
            }
        });
    }

    $('#gen_citas').click(function(e) {
        e.preventDefault();
        $("#citas_body > tr").remove();
        generarTabla();
        $('#div_table').show();
    });

    $(document).on('click', '#disponible_btn', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const hora = $(elemento).attr('idT');
        const fecha = $(elemento).attr('fecha');
        const id_cita = $("#id_cita").val();

        const dataCita = {
            id_cita: id_cita,
            fecha: fecha,
            hora: hora
        };

        $('#texto_modal_c').html(`Desea reagendar una cita a las ${hora}h para el ${fecha}`);
        $('#modal_icon_c').attr("class", "fa fa-calendar fa-4x animated rotateIn mb-4");
        $('#modalConfirmacion').modal("show");

        $('#crear').click(function(e) {
            e.preventDefault();
            $("#citas_body tr").remove();
            $('#div_table').hide();
            $.ajax({
                type: "POST",
                url: '../php/cita/cita-reagendar.php',
                data: dataCita,
                success: function(response) {
                    $('#texto_modal').html(response);
                    $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    setTimeout(function() { window.location.href = "admin.php"; }, 3000);
                }
            });
        });

    });
});