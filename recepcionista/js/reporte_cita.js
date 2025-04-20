$(document).ready(function () {
    const id_cita = $("#id_cita").val();
    $.ajax({
        type: "POST",
        url: "../php/plan_t/plan_t-get.php",
        data: {id_cita},
        success: function (response) {
            console.log(response);
            if (response == "false") {
                $("#desc_receta").attr('disabled', 'disabled');
            }
        }
    }); 
    
    $("#desc_receta").click(function (e) { 
        e.preventDefault();
        window.open(`../php/reportes/reporte_receta.php?id_cita=${id_cita}`, '_blank');
    });
    $("#desc_certmed").click(function (e) { 
        e.preventDefault();
        window.open(`../php/reportes/certificado_medico.php?id_cita=${id_cita}`, '_blank');
    });
}); 