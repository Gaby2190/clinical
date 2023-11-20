$(document).ready(function() {


    $('#especialidad-datos').submit(e => {
        e.preventDefault();
        const especialidad = $('#especialidad').val();

        $.ajax({
            type: "POST",
            url: "../php/especialidad/especialidad-add.php",
            data: {especialidad},
            success: function (response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-graduation-cap fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                $('#especialidad-datos').trigger('reset');
            }
        });

    });

});