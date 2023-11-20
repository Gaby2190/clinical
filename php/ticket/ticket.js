$(document).ready(function () {
    const id_cita = $("#id_cita").val();
    $.ajax({
        type: "POST",
        url: "../ticket-datos.php",
        data: {id_cita},
        success: function (response) {
            const datos = JSON.parse(response);
            console.log(datos);
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
                url: "../tarifa-med.php",
                data: {id_cita},
                success: function (response) {
                    console.log(response);
                    const tipo_cita = Number(JSON.parse(response).tipo_cita);
                    const pago_ingreso = Number(JSON.parse(response).pago_ingreso);
                    if (pago_ingreso == 1) {
                        if (tipo_cita == 1) {
                            $("#lbl_cobrar").html(`Valor cancelado: $${JSON.parse(response).tarifa} dólares`);
                        }else{
                            $("#lbl_cobrar").html(`Valor cancelado: $${JSON.parse(response).tarifa_control} dólares`);
                        }
                    }else{ 
                        $("#lbl_cobrar").html("Valor cancelado: $0 dólares");
                    }
                    
                }
            });
        }
    });

});