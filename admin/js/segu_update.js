$(document).ready(function() {
    const id = $("#id_segu").val();
    getAseguradora();


    function getAseguradora() {
        $.post('../php/aseguradora/aseguradora-list.php', { id }, (response) => {
            const aseguradora = JSON.parse(response).nombre;
            $('#aseguradora').val(aseguradora);
        });
    }


    //ACTUALIZAR DATOS DE USUARIO
    $('#btn_datos').click(function(e) {
        e.preventDefault();
        const postData = {
            id: id,
            nombre: $('#aseguradora').val()
        };

        if (postData.nombre == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.post('../php/aseguradora/aseguradora-update.php', postData, (response) => {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                setTimeout(function() { window.location.href = "espe_read.php"; }, 3000);
            });
        }


    });

});