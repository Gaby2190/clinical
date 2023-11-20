$(document).ready(function() {
    const id = $("#id_fpago").val();
    getFpago();


    function getFpago() {
        $.post('../php/fpago/fpago-list.php', { id }, (response) => {
            const fpago = JSON.parse(response).nombre;
            $('#fpago').val(fpago);
        });
    }


    //ACTUALIZAR DATOS DE USUARIO
    $('#btn_datos').click(function(e) {
        e.preventDefault();
        const postData = {
            id: id,
            nombre: $('#fpago').val()
        };

        if (postData.nombre == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.post('../php/fpago/fpago-update.php', postData, (response) => {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                setTimeout(function() { window.location.href = "fpago_read.php"; }, 3000);
            });
        }


    });

});