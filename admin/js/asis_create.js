$(document).ready(function() {

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    var rol = 'AS';

    //Verificar existencia de usuario y generar usuario y password

    $('#asistente-datos').submit(e => {
        e.preventDefault();
        const new_pass = generatePassword();

        const postUsr = {
            usuario: rol + $('#cedula_asis').val(),
            clave: new_pass,
            fecha_registro: f_actual,
            estado_usr: 1,
            id_rol: 6
        };

        const usuario = rol + $('#cedula_asis').val();

        $.post('../php/asistente/asistente-list-usr.php', { usuario }, (response) => {
            if (response != false) {
                $('#texto_modal').html(`Usuario para ASISTENTE con cédula: ${$('#cedula_asis').val()} ya se encuentra registrado`);
                $('#modal_icon').attr('style', "color: orange");
                $('#modal_icon').attr("class", "fa fa-id-card fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            } else {
                $.post('../php/asistente/asistente-add-usr.php', postUsr, (response) => {
                    console.log(response);
                    const usuario = rol + $('#cedula_asis').val();
                    let id_usuario = 0;
                    $.post('../php/asistente/asistente-list-usr.php', { usuario }, (response) => {
                        id_usuario = JSON.parse(response).id_usuario;
                        //====================IMAGEN==================
                        let url_img = '';
                        if ($('#imagen').val() == '') {
                            url_img = 'assets/images/perfil.png';
                        }
                        //====================CLOSE IMAGEN==================
                        const postData = {
                            nombres_asis: $('#nombres_asis').val(),
                            apellidos_asis: $('#apellidos_asis').val(),
                            cedula_asis: $('#cedula_asis').val(),
                            telefono_asis: $('#telefono_asis').val(),
                            celular_asis: $('#celular_asis').val(),
                            correo_asis: $('#correo_asis').val().replace(/\s+/g, ''),
                            direccion_asis: $('#direccion_asis').val(),
                            imagen: url_img,
                            id_usuario: id_usuario
                        };
                        console.log(postData);

                        //Envío de la contraseña al correo
                        const datNotiMail = {
                            nom_ape: $("#nombres_asis").val() + " " + $("#apellidos_asis").val(),
                            correo: $("#correo_asis").val().replace(/\s+/g, ''),
                            rol: 'ASISTENTE',
                            clave: new_pass
                        };
                        $.ajax({
                            type: "POST",
                            url: "../php/notificacion/mail/pass-mail-send.php",
                            data: datNotiMail,
                            success: function (response) {
                                console.log(response);
                            }
                        });

                        $.post('../php/asistente/asistente-add.php', postData, (response) => {
                            $('#texto_modal').html(response);
                            $('#modal_icon').attr("class", "fa fa-user-plus fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                            $('#asistente-datos').trigger('reset');
                        });


                    });

                });
            }

        });


    });

    //===========================================Verificar extensión de archivos=====================================//
    $("#imagen").change(function() {
        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2]))) {
            alert('Por favor seleccione un formato de imagen válido (JPEG/JPG/PNG).');
            $("#imagen").val('');
            return false;
        }
    });


});