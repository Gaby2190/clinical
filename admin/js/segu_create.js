$(document).ready(function() {


    $('#aseguradora-datos').submit(e => {
        e.preventDefault();
        const aseguradora = $('#aseguradora').val();

        $.ajax({
            type: "POST",
            url: "../php/aseguradora/aseguradora-add.php",
            data: {aseguradora},
            success: function (response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-graduation-cap fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                $('#especialidad-datos').trigger('reset');
            }
        });

    });

});