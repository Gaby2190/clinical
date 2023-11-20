$(document).ready(function () {
    const id_caso = $("#id_caso").val();

    $("#desc_pa").click(function (e) { 
        e.preventDefault();
        window.open(`../php/reportes/reporte_hcu_001.php?id_caso=${id_caso}`, '_blank');
    });
    $("#desc_ce").click(function (e) { 
        e.preventDefault();
        window.open(`../php/reportes/reporte_hcu_002.php?id_caso=${id_caso}`, '_blank');
    });
}); 