$(document).ready(function() {
    $('#fpago-datos').submit(e => {
        e.preventDefault();
        const fpago = $('#fpago').val();
        $.ajax({
            type: "POST",
            url: "../php/fpago/fpago-add.php",
            data: {fpago},
            success: function (response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-graduation-cap fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                $('#fpago-datos').trigger('reset');
            }
        });
    });
});