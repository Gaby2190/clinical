$(document).ready(function() { 
    const id_cita = $("#id_cita").val();
    $.ajax({
        type: "POST",
        url: "../php/ticket/ticket-datos.php",
        data: {id_cita},
        success: function (response) {
            const datos = JSON.parse(response);
            $("#medico").html(datos.sufijo +" "+ datos.apellidos_medi +" "+ datos.nombres_medi);
            $("#turno").html("Turno N°: "+ datos.id_cita);
            $("#fecha").html("Fecha: "+ datos.fecha);
            $("#hora").html("Hora: "+ datos.hora.substring(0, 5) + "h");
            $("#paciente").html("Paciente: "+ datos.apellidos_paci1 +" "+ datos.apellidos_paci2+" "+ datos.nombres_paci1+" "+ datos.nombres_paci2);
            if (Number(datos.tipo_cita) == 1) {
                $("#t_cita").html("Tipo de Cita: Normal");
            }else{
                $("#t_cita").html("Tipo de Cita: Control");
            }
            $.ajax({
                type: "POST",
                url: "../php/tarifa-med.php",
                data: {id_cita},
                success: function (response) {
                    const tipo_cita = Number(JSON.parse(response).tipo_cita);
                    const pago_ingreso = Number(JSON.parse(response).pago_ingreso);
                    if (pago_ingreso == 1) {
                        if (tipo_cita == 1) {
                            $("#lbl_cobrar").html(`Realizar cobro de la cita: $${JSON.parse(response).tarifa} dólares`);
                        }else{
                            $("#lbl_cobrar").html(`Realizar cobro de la cita: $${JSON.parse(response).tarifa_control} dólares`);
                        }
                    }else{ 
                        $("#lbl_cobrar").html("Realizar cobro de la cita: $0 dólares");
                    }
                    
                }
            });
        }
    });

    

    $("#btn_espera_ing").click(function (e) { 
        e.preventDefault();
        
        $('#texto_modal_e').html('Desea imprimir el ticket e ingresar al paciente a la sala de espera');
        $('#modal_icon_e').attr('style', "color: #22445d");
        $('#modal_icon_e').attr("class", "fa fa-question-circle fa-4x animated rotateIn mb-4");
        $('#modalEspera').modal("show");
        $(document).on('click', '#btn_espera', function() {
            const id_cita = $("#id_cita").val();
            //======FECHA Y HORAS ACTUALES=====
            var d = new Date();
            var month = d.getMonth() + 1;
            var day = d.getDate();
            //fecha
            var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
            //hora
            const hora = d.getHours() + ':' + d.getMinutes();
            const id_usuario = $("#id_usuario").val();
            $.ajax({
                type: "POST",
                url: "../php/tarifa-med.php",
                data: {id_cita},
                success: function (response) {
                    const tipo_cita = Number(JSON.parse(response).tipo_cita);
                    const pago_ingreso = Number(JSON.parse(response).pago_ingreso);
                     const id_f_pago = $('#select_fpago').val();
                    console.log(pago_ingreso);
                    console.log(tipo_cita);
                    if (pago_ingreso == 1) {
                        console.log(tipo_cita);
                        if (tipo_cita == 1) {
                            const tarifa = JSON.parse(response).tarifa;
                            console.log(tarifa);
                            const postPago = {
                                id_f_pago: id_f_pago,
                                descripcion: "PAGO DE TARIFA DE CITA NORMAL",
                                costo: tarifa,
                                id_cita: id_cita,
                                fecha_p: f_actual,
                                hora_p: hora,
                                id_usuario
                            };
                            $.ajax({
                                type: "POST",
                                url: "../php/cita_pago/cita_pago-add.php",
                                data: postPago,
                                success: function(response) {
                                    $.ajax({
                                        type: "POST",
                                        url: "../php/cita/cita-espera.php",
                                        data: { id_cita },
                                        success: function(response) {
                                           document.getElementById('btn_espera_ing').disabled = true;
                                          
                                            $('#texto_modal').html("Se ha ingresado satisfactoriamente al paciente a sala de espera");
                                            $('#modal_icon').attr('style', "color: rgb(57, 160, 57)");
                                            $('#modal_icon').attr("class", "fa fa-clock-o fa-4x animated rotateIn mb-4");
                                            $('#modalPush').modal("show");
                                            window.open(`../php/ticket/ticket.php?id_cita=${id_cita}`, '_blank');
                                            
                                            
                                            
                                        }
                                    });
                                }
                            });
                        }else{
                            console.log("control");
                            const tarifa_control = JSON.parse(response).tarifa_control;
                            const postPago = {
                                id_f_pago: id_f_pago,
                                descripcion: "PAGO DE TARIFA DE CITA DE CONTROL",
                                costo: tarifa_control,
                                id_cita: id_cita,
                                fecha_p: f_actual,
                                hora_p: hora,
                                id_usuario
                            };
                            $.ajax({
                                type: "POST",
                                url: "../php/cita_pago/cita_pago-add.php",
                                data: postPago,
                                success: function(response) {
                                    console.log(response);
                                    $.ajax({
                                        type: "POST",
                                        url: "../php/cita/cita-espera.php",
                                        data: { id_cita },
                                        success: function(response) {
                                            document.getElementById('btn_espera_ing').disabled = true;
                                            $('#texto_modal').html("Se ha ingresado satisfactoriamente al paciente a sala de espera");
                                            $('#modal_icon').attr('style', "color: rgb(57, 160, 57)");
                                            $('#modal_icon').attr("class", "fa fa-clock-o fa-4x animated rotateIn mb-4");
                                            $('#modalPush').modal("show");
                                            window.open(`../php/ticket/ticket.php?id_cita=${id_cita}`, '_blank');
                                        }
                                    });
                                }
                            });
                        }
                    }else{ 
                        const postPago = {
                            id_f_pago: id_f_pago,
                            descripcion: "PAGO DE TARIFA DE CITA",
                            costo: 0,
                            id_cita: id_cita,
                            fecha_p: f_actual,
                            hora_p: hora,
                            id_usuario
                        };
                        $.ajax({
                            type: "POST",
                            url: "../php/cita_pago/cita_pago-add.php",
                            data: postPago,
                            success: function(response) {
                                console.log(response);
                                $.ajax({
                                    type: "POST",
                                    url: "../php/cita/cita-espera.php",
                                    data: { id_cita },
                                    success: function(response) {
                                        document.getElementById('btn_espera_ing').disabled = true;
                                        $('#texto_modal').html("Se ha ingresado satisfactoriamente al paciente a sala de espera");
                                        $('#modal_icon').attr('style', "color: rgb(57, 160, 57)");
                                        $('#modal_icon').attr("class", "fa fa-clock-o fa-4x animated rotateIn mb-4");
                                        $('#modalPush').modal("show");
                                        window.open(`../php/ticket/ticket.php?id_cita=${id_cita}`, '_blank');
                                    }
                                });
                            }
                        });
                    }
                    
                }
            });
        });
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

});