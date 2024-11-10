$(document).ready(function () {
    const id_cita = $("#id_cita").val();
    $.ajax({
        type: "POST",
        url: "ticket-datos-comp.php",
        data: {id_cita},
        success: function (response) {
            const datos = JSON.parse(response);
            console.log(datos);
            $("#medico").html(datos.sufijo +" "+ datos.nom_ape_medi);
            $("#turno").html("Referencia: "+ datos.id_cita);
            $("#fecha").html("Fecha: "+ datos.fecha);
            $("#hora").html("Hora: "+ datos.hora.substring(0, 5) + "h");
            $("#paciente").html("Paciente: "+ datos.apellidos_paci1 +" "+ datos.apellidos_paci2+" "+ datos.nombres_paci1);
            if (Number(datos.tipo_cita) == 1) {
                $("#t_cita").html("Tipo de Cita: Normal");
            }else{
                $("#t_cita").html("Tipo de Cita: Control");
            }
           
            $("#f_pago").html("Forma de Pago: <br>"+ datos.nombre+ "</br>");

            $("#valor").html("Valor Cancelado: "+ datos.costo+ "USD");
                    
               


        }
    });

});