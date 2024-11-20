$(document).ready(function() { 
    const id_cita = $("#id_cita").val();
    $.ajax({
        type: "POST",
        url: "../php/ticket/ticket-datos-pre.php",
        data: {id_cita},
        success: function (response) {
            const datos = JSON.parse(response);
            $("#medico").html(datos.sufijo +" "+ datos.nom_ape_medi);
            $("#turno").html("Turno N°: "+ datos.id_cita);
            let fecha_cita=datos.fecha;
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
           
            
              let  id_medico= datos.id_medico;
              let   id_paciente= datos.id_paciente;
            

            $.ajax({
                type: 'POST',
                url: '../php/ticket/ticket-ult-cita.php',
                data: {id_medico, id_paciente},
                success: function (response){
                    const dat_fecha = JSON.parse(response);
                    let ult_fecha = dat_fecha.ult_cita;
                    console.log(ult_fecha);
                    console.log(fecha_cita);

                    var diff = new Date(fecha_cita).getTime() - new Date(ult_fecha).getTime();
                                    
                    $("#ult_cita").html("Ultima cita: "+ dat_fecha.ult_cita + "(Hace "+diff/(1000*60*60*24)+" dias)");
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
            
            $.ajax({
                type: "POST",
                url: "../php/cita/cita-espera.php",
                data: { id_cita },
                success: function(response) {
                    $('#texto_modal').html("Se ha ingresado satisfactoriamente al paciente a sala de espera");
                    $('#modal_icon').attr('style', "color: rgb(57, 160, 57)");
                    $('#modal_icon').attr("class", "fa fa-clock-o fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    window.open(`../php/ticket/ticket.php?id_cita=${id_cita}`, '_blank');
                    setTimeout(function() { window.location.href = "rece.php"; }, 1000);
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
    var cont_fp=0;

    //==========Cargar cita pagos a la tabla========//
    cargarCitasPago();

    function cargarCitasPago() {
        $.ajax({
            type: "POST",
            url: "../php/cita_pago/cita_pago-get.php",
            data: { id_cita },
            async:false,
            success: function(response) {
                if (response != false) {
                    const cpagos = JSON.parse(response);
                    cpagos.forEach(cp => {
                        const id_cita_pago = cp.id_cita_pago;
                        const descripcion = cp.descripcion;
                        const f_pago = cp.nombre;
                        const costo = cp.costo;
                        $("#fp_table>tbody").append(`<tr idCP='${id_cita_pago}' cCP='${costo}'>
                                                        <td>${f_pago}</td>
                                                        <td>${descripcion}</td>
                                                        <td>$${costo}</td>
                                                        <td><button id='eliminar_fp' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                    </tr>`);
                        cont_fp +=1;
                        console.log(cont_fp);
                        if (cont_fp>=1)
                            {
                                $('#btn_espera_ing').removeAttr('disabled');
                            }
                            else
                            {
                                $('#btn_espera_ing').attr('disabled', 'disabled');
                            }
                    }); 
                }      
            }
        });
    }
   
    //Clic en el boton del modal para añadir otros
    $('#add_fpago').click(function(e) {
        
        e.preventDefault();
        const id_f_pago = $('#select_fpago').val();
        const f_pago = $('#select_fpago option:selected').html();
        const descripcion = $('#descripcion').val();
        const costo = $('#costo').val();
        const id_usuario = $("#id_usuario").val();
        //======FECHA Y HORAS ACTUALES=====
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        //fecha
        var fecha_p = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        //hora
        const hora_p = d.getHours() + ':' + d.getMinutes();

        if (costo == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#descripcion').val('');
            $('#costo').val('');
        } else {
           
            $.ajax({
                type: "POST",
                url: "../php/cita_pago/cita_pago-add.php",
                data: {
                    id_f_pago,
                    descripcion,
                    costo,
                    id_cita,
                    fecha_p,
                    hora_p,
                    id_usuario
                },
                success: function (response) {
                    console.log(response);
                    $.ajax({
                        type: "POST",
                        url: "../php/cita_pago/cita_pago-get_id.php",
                        data: {
                            id_f_pago,
                            descripcion,
                            costo
                        },
                        success: function (response) {
                            const id_cita_pago = JSON.parse(response).id_cita_pago;
                            const descripcion = JSON.parse(response).descripcion;
                            const costo = JSON.parse(response).costo;
                            addCP(id_cita_pago, f_pago, descripcion,costo);
                            cont_fp +=1;
                            console.log(cont_fp);
                            if (cont_fp>=1)
                                {
                                    $('#btn_espera_ing').removeAttr('disabled');
                                }
                                else
                                {
                                    $('#btn_espera_ing').attr('disabled', 'disabled');
                                }
                        }
                    });
                }
            });
            $('#descripcion').val('');
            $('#costo').val('');
        }

    });

     //Funcion para cargar los datos en la tabla
     function addCP(id,fP,dCP, cCP) {
        const id_cita_pago = id;
        const f_pago = fP;
        const descripcion = dCP;
        const costo = cCP;
        $("#fp_table>tbody").append(`<tr idCP='${id_cita_pago}' cCP='${costo}'>
                                                    <td>${f_pago}</td>
                                                    <td>${descripcion}</td>
                                                    <td>$${costo}</td>
                                                    <td><button id='eliminar_fp' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///Botón de eliminar/////
    $(document).on('click', '#eliminar_fp', (e) => {
        
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita_pago = $(element).attr('idCP');
        const costo = $(element).attr('cCP');
        $("#fp_body > tr").remove();
        $.ajax({
            type: "POST",
            url: "../php/cita_pago/cita_pago-delete.php",
            data:{id_cita_pago},
            success: function (response) {
                console.log(response);
                cargarCitasPago();
                cont_fp -=1;
                console.log(cont_fp);
                if (cont_fp>=1)
                {
                    $('#btn_espera_ing').removeAttr('disabled');
                }
                else
                {
                    $('#btn_espera_ing').attr('disabled', 'disabled');
                }
            }
        });
        
    });
});