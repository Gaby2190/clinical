$(document).ready(function() {
    const tipo_cita = $("#id").val();
    $('#div_table').hide(); 
 
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
        //=====Tomar datos del id del caso y de la fecha=====//
        const id_caso = $('#id_caso').val();
        const fecha = $('#fecha_cita').val();
        //======Obtención de horas actuales=====//
        const horaACT = new Date();
        const h = horaACT.getHours();
        const d = horaACT.getMinutes();
        
        //=====Obtención de tiempo de atención promedio según el id del médico=====//
        $.ajax({
            type: "POST",
            url: '../php/caso/caso-list-id.php',
            data: { id_caso },
            success: function(response) {
                const id_medico = JSON.parse(response).id_medico;
                $.ajax({
                    type: "POST",
                    url: '../php/medico/medico-list.php',
                    data: { id_medico },
                    success: function(response) {
                        var tap = Number(JSON.parse(response).tiempo_ap);
                        if(Number(tap) == 25){
                            horarios_citas = ["8:00","8:25","8:50","9:15","9:40","10:05","10:30","10:55","11:20","11:45","12:10","12:35","13:00","13:25","13:50","14:15","14:40","15:05","15:30","15:55","16:20","16:45","17:10","17:35","18:00","18:25","18:50","19:15","19:40","20:05","20:30","20:55","21:20","21:45"];
                        }
                        //===== Comprobación si la fecha seleccionada es igual a la fecha actual =====//
                        var min_tmp = 0;
                        if (fecha == f_actual) {
                            if ((h > h_ingreso) && (h < h_salida)) {
                                h_ingreso = h;
                                if(tap == 30){
                                    if((d > 0) && (d <= 30)){
                                        min_tmp = 30;
                                    }
                                    if((d > 30) && (d < 60)){
                                        min_tmp = 0;
                                        h_ingreso = h + 1;
                                    }
                                }
                                if(tap == 20){
                                    if((d > 0) && (d <= 20)){
                                        min_tmp = 20;
                                    }
                                    if((d > 20) && (d <= 40)){
                                        min_tmp = 40;
                                    }
                                    if((d > 40) && (d < 60)){
                                        min_tmp = 0;
                                        h_ingreso = h + 1;
                                    }
                                }
                                if(tap == 15){
                                    if((d > 0) && (d <= 15)){
                                        min_tmp = 15;
                                    }
                                    if((d > 15) && (d <= 30)){
                                        min_tmp = 30;
                                    }
                                    if((d > 30) && (d <= 45)){
                                        min_tmp = 45;
                                    }
                                    if((d > 45) && (d < 60)){
                                        min_tmp = 0;
                                        h_ingreso = h + 1;
                                    }
                                }
                            }
                        }
                        
                        if ((fecha == f_actual)&&(Number(tap) == 25)) {
                            var posi = 0;
                            var array_aux = [];
                            var hor_a = 0;
                            var mi_a = 0;
                            for (let i = 0; i < horarios_citas.length; i++) {
                                var hora = 0;
                                if(i>=0 && i<5){
                                    hora = Number(horarios_citas[i].substring(0, 1));
                                }else{
                                    hora = Number(horarios_citas[i].substring(0, 2));
                                }
                                if(hora==h){
                                    hor_a = hora;
                                    array_aux.push(horarios_citas[i]);
                                }
                            }
                            for(let i = 0; i < array_aux.length; i++){
                                const minutos = Number(array_aux[i].substring(array_aux[i].length - 2, array_aux[i].length));
                                console.log(d+"."+minutos);
                                if(i==0){
                                    if((Number(d)>=0) && (Number(d)<Number(minutos))){
                                        mi_a = minutos;
                                        const txt_f = hor_a + ":" + mi_a;
                                        posi = horarios_citas.indexOf(txt_f);
                                    }
                                }
                                if((i>0)&&(i < Number(array_aux.length))){
                                    const minutos_ant = Number(array_aux[i-1].substring(array_aux[i-1].length - 2, array_aux[i-1].length));
                                    if((Number(d)>=Number(minutos_ant)) && (Number(d)<Number(minutos))){
                                        mi_a = minutos;
                                        const txt_f = hor_a + ":" + mi_a;
                                        posi = horarios_citas.indexOf(txt_f);
                                    }
                                }
                                if(i == (Number(array_aux.length)-1)){
                                    if((Number(d)>=Number(minutos)) && (Number(d)<60)){
                                        mi_a = minutos;
                                        mi_a = minutos;
                                        const txt_f = hor_a + ":" + mi_a;
                                        posi = horarios_citas.indexOf(txt_f)+1;
                                    }
                                }
                            }
                            
                            horarios_citas.splice(0, posi);
                            console.log(horarios_citas);
                        }
                        //======== Declarar contadores para generar horario en array==========//
                        if(Number(tap) != 25){
                            const num_h = h_salida - h_ingreso;
                            let cont_h = h_ingreso;
                            let cont_m = min_tmp;
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

                        // Buscar horarios de citas para la fecha seleccionada en base al medico y fecha y almacenar en array (PACIENTE EN ESPERA)
                        const resp_esp = $.ajax({
                            type: "POST",
                            url: '../php/cita/cita-med-list-esp.php',
                            data: postDatCas,
                            global: false,
                            async: false,
                            success: function(response) {
                                return response;
                            }
                        }).responseText;

                        //=====Guarda en un array las citas en las cuales el médico tiene citas para la fecha(PACIENTE EN ESPERA) =======//
                        const horas_esp = [];
                        if (resp_esp != false) {
                            const resp_citas = JSON.parse(resp_esp);
                            resp_citas.forEach(r_cita => {
                                var h_cita = r_cita.hora.slice(0, -3).replace(/:/g, '');
                                if (h_cita[0] == "0") {
                                    h_cita = h_cita.replace("0", '');
                                }
                                horas_esp.push(`${h_cita}`);
                            });
                        }

                        //======Comprobar si en el arreglo general de horarios están incluido los calores de las citas ocupadas=========
                        for (let i = 0; i < horarios_citas.length; i++) {
                            const id_cit = horarios_citas[i].replace(/:/g, '');
                            if (horas.includes(`${id_cit}`)) {
                                $("#citas_table>tbody").append(`<tr Turnoid="${id_cit}" idT="${horarios_citas[i]}"><td>${$('#fecha_cita').val()}</td><td>${horarios_citas[i]}</td><td><a style="color: rgb(122, 120, 120);cursor: default;" class="btn btns_agendamiento" id="agendado_btn"><span class="fa fa-calendar"></span> RESERVADO</a></td></tr>`);
                            } else {
                                if (horas_esp.includes(`${id_cit}`)) {
                                    $("#citas_table>tbody").append(`<tr Turnoid="${id_cit}" idT="${horarios_citas[i]}"><td>${$('#fecha_cita').val()}</td><td>${horarios_citas[i]}</td><td><a style="cursor: default;" class="btn btns_agendamiento" id="espera_btn"><span class="fa fa-clock-o"></span> EN SALA DE ESPERA</a></td></tr>`);
                                } else {
                                    $("#citas_table>tbody").append(`<tr Turnoid="${id_cit}" idT="${horarios_citas[i]}" id_caso="${id_caso}" fecha="${$('#fecha_cita').val()}"><td>${$('#fecha_cita').val()}</td><td>${horarios_citas[i]}</td><td><a href="#" class="btn btns_agendamiento" id="disponible_btn"><span class="fa fa-check"></span> DISPONIBLE</a></td></tr>`);
                                }
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
        const id_caso = $(elemento).attr('id_caso');
        const fecha = $(elemento).attr('fecha');
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
            tipo_cita: tipo_cita,
            id_caso: id_caso
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
                                tipo_cita: tipo_cita,
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
                                }
                            });
                            
                            const msg = "Estimado/a " + paci.nombres_paci1 + " " + paci.apellidos_paci1 + ", CESMED S.C. le recuerda que dispone de una cita agendada para el " + fecha + ", a las " + hora + "h, con el DR. " + paci.nom_ape_medi + ".";
                            const num_paci = paci.celular_paci;
                            const datMensaje = {
                                "user": "pruebas-comtelesis",
                                "pass": "commss2020-",
                                "msg": msg,
                                "num": num_paci,
                                "ruta": "S",
                                "camp": "CESMED S.C."
                            };
                            console.log(datMensaje);
                            $.ajax({
                                type: 'POST',
                                url: "https://app.massend.com/api/sms/",
                                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                                contentType: 'application/x-www-form-urlencoded',
                                data:  datMensaje,
                                success: function (response) {
                                    console.log(response);
                                }
                            });
                        }
                    });
                    setTimeout(function() { window.location.href = "admin.php"; }, 3000);
                }
            });
        });

    });
});