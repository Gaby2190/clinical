$(document).ready(function() {

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    var rol = 'A';

    //Verificar existencia de usuario y generar usuario y password

    $('#administrador-datos').submit(e => {
        e.preventDefault();
        const new_pass = generatePassword();

        const postUsr = {
            usuario: rol + $('#cedula_admin').val(),
            clave: new_pass,
            fecha_registro: f_actual,
            estado_usr: 1,
            id_rol: 1
        };

        const usuario = rol + $('#cedula_admin').val();

        $.post('../php/administrador/administrador-list-usr.php', { usuario }, (response) => {
            if (response != false) {
                $('#texto_modal').html(`Usuario para ADMINISTRADOR con cédula: ${$('#cedula_admin').val()} ya se encuentra registrado`);
                $('#modal_icon').attr('style', "color: orange");
                $('#modal_icon').attr("class", "fa fa-id-card fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            } else {
                $.post('../php/administrador/administrador-add-usr.php', postUsr, (response) => {
                    console.log(response);
                    const usuario = rol + $('#cedula_admin').val();
                    let id_usuario = 0;
                    $.post('../php/administrador/administrador-list-usr.php', { usuario }, (response) => {
                        id_usuario = JSON.parse(response).id_usuario;
                        //====================IMAGEN==================
                        let url_img = '';
                        if ($('#imagen').val() == '') {
                            url_img = 'assets/images/principal_cesmed.jpeg';
                        } else {
                            //===========================================Añadir imagen=====================================//
                            const form_data = new FormData(document.getElementById("administrador-datos"));
                            url_img = 'assets/images/administrador/';
                            url_img += $.ajax({
                                type: "POST",
                                url: "../php/administrador/upload-img-admin.php",
                                data: form_data,
                                global: false,
                                async: false,
                                contentType: false,
                                cache: false,
                                processData: false,
                                success: function(response) {
                                    return (response);
                                }
                            }).responseText;
                            //===========================================Añadir imagen=====================================//
                        }
                        //====================CLOSE IMAGEN==================
                        const postData = {
                            nombres_admin: $('#nombres_admin').val(),
                            apellidos_admin: $('#apellidos_admin').val(),
                            cedula_admin: $('#cedula_admin').val(),
                            telefono_admin: $('#telefono_admin').val(),
                            celular_admin: $('#celular_admin').val(),
                            correo_admin: $('#correo_admin').val().replace(/\s+/g, ''),
                            direccion_admin: $('#direccion_admin').val(),
                            imagen: url_img,
                            id_usuario: id_usuario
                        };
                        console.log(postData);

                        //Envío de la contraseña al correo
                        const datNotiMail = {
                            nom_ape: $("#nombres_admin").val() + " " + $("#apellidos_admin").val(),
                            correo: $("#correo_admin").val().replace(/\s+/g, ''),
                            rol: 'ADMINISTRADOR/A',
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

                        $.post('../php/administrador/administrador-add.php', postData, (response) => {
                            $('#texto_modal').html(response);
                            $('#modal_icon').attr("class", "fa fa-user-plus fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                            $('#administrador-datos').trigger('reset');
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