$(document).ready(function() {
    const id = $("#id_espe").val();
    getEspecialidad();


    function getEspecialidad() {
        $.post('../php/especialidad/especialidad-list.php', { id }, (response) => {
            const especialidad = JSON.parse(response).nombre;
            $('#especialidad').val(especialidad);
        });
    }


    //ACTUALIZAR DATOS DE USUARIO
    $('#btn_datos').click(function(e) {
        e.preventDefault();
        const postData = {
            id: id,
            nombre: $('#especialidad').val()
        };

        if (postData.nombre == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.post('../php/especialidad/especialidad-update.php', postData, (response) => {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                setTimeout(function() { window.location.href = "espe_read.php"; }, 3000);
            });
        }


    });

});