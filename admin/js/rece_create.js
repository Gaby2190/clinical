$(document).ready(function() {

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    var rol = 'R';

    //Verificar cedula, existencia de usuario y generar usuario y password

    $('#recepcionista-datos').submit(e => {
        e.preventDefault();
        const new_pass = generatePassword();

        const postUsr = {
            usuario: rol + $('#cedula_rece').val(),
            clave: new_pass,
            fecha_registro: f_actual,
            estado_usr: 1,
            id_rol: 2
        };

        const usuario = rol + $('#cedula_rece').val();

        $.post('../php/recepcionista/recepcionista-list-usr.php', { usuario }, (response) => {
            if (response != false) {
                $('#texto_modal').html(`Usuario para RECEPCIONISTA con cédula: ${$('#cedula_rece').val()} ya se encuentra registrado`);
                $('#modal_icon').attr('style', "color: orange");
                $('#modal_icon').attr("class", "fa fa-id-card fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            } else {
                $.post('../php/recepcionista/recepcionista-add-usr.php', postUsr, (response) => {
                    console.log(response);
                    const usuario = rol + $('#cedula_rece').val();
                    let id_usuario = 0;
                    $.post('../php/recepcionista/recepcionista-list-usr.php', { usuario }, (response) => {
                        id_usuario = JSON.parse(response).id_usuario;
                        //====================IMAGEN==================
                        let url_img = '';
                        if ($('#imagen').val() == '') {
                            url_img = 'assets/images/perfil.png';
                        } else {
                            //===========================================Añadir imagen=====================================//
                            const form_data = new FormData(document.getElementById("recepcionista-datos"));
                            url_img = 'assets/images/recepcionista/';
                            url_img += $.ajax({
                                type: "POST",
                                url: "../php/recepcionista/upload-img-rece.php",
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
                            nombres_rece: $('#nombres_rece').val(),
                            apellidos_rece: $('#apellidos_rece').val(),
                            cedula_rece: $('#cedula_rece').val(),
                            telefono_rece: $('#telefono_rece').val(),
                            celular_rece: $('#celular_rece').val(),
                            correo_rece: $('#correo_rece').val().replace(/\s+/g, ''),
                            direccion_rece: $('#direccion_rece').val(),
                            imagen: url_img,
                            id_usuario: id_usuario
                        };
                        console.log(postData);

                        //Envío de la contraseña al correo
                        const datNotiMail = {
                            nom_ape: $("#nombres_rece").val() + " " + $("#apellidos_rece").val(),
                            correo: $("#correo_rece").val().replace(/\s+/g, ''),
                            rol: 'RECEPCIONISTA',
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

                        $.post('../php/recepcionista/recepcionista-add.php', postData, (response) => {
                            $('#texto_modal').html(response);
                            $('#modal_icon').attr("class", "fa fa-user-plus fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                            $('#recepcionista-datos').trigger('reset');
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