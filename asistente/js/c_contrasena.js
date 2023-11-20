$(document).ready(function () {
    const id_usuario = $("#id_usuario").val();
    $("#contrasena_datos").submit(function (e) { 
        e.preventDefault();
        if ($("#cont_new").val() == $("#cont_new_v").val()) {
            const postCont = {
                id_usuario: id_usuario,
                cont_ant: $("#cont_ant").val(),
                cont_new: $("#cont_new").val()
            }
            $.ajax({
                type: "POST",
                url: "../php/r_contrasena.php",
                data: postCont,
                success: function (response) {
                    if (response != false) {
                        $('#texto_modal').html(response + "<br>Cerrando Sesión...");
                        $('#modal_icon').attr('style', "color: green");
                        $('#modal_icon').attr("class", "fa fa-key fa-4x animated rotateIn mb-4");
                        $("#btn_a").hide();
                        $('#modalPush').modal("show");
                        setTimeout(function() { window.location.href = '../login/login.php?cerrar_sesion=1'; }, 4000);
                    }else{
                        $('#texto_modal').html('No se ha podido verificar la contraseaña actual');
                        $('#modal_icon').attr('style', "color: orange");
                        $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                        $('#modalPush').modal("show");
                    }
                }
            });
        }else{
            $('#texto_modal').html('Las contraseñas nuevas no coinciden, por favor ingrese nuevamente');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        }
        
    });
});