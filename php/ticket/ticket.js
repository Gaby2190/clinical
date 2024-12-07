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
           
            $.ajax({
                type: "POST",
                url: "ticket-datos.php",
                data: {id_cita},
                async:false,
                success: function (response) {
                    if (response != false) {
                        const cpagos = JSON.parse(response);
                        cpagos.forEach(cp => {
                            var descripcion = cp.descripcion;
                            var f_pago = cp.nombre;
                            var costo = cp.costo;
                            var tipo_pago = cp.tipo_pago;
                            
                            $("#f_pago").append(`<label>${descripcion} ${tipo_pago}: <strong>$${costo} ${f_pago}</strong></label><br>`);
                        });
                    }

                }
            });

            
                    
               


        }
    });

});