$(document).ready(function() {
    const id_administrador = $("#id_admin").val();
    const id_usuario = $("#id_usu").val();
    var estado;


    getAdministrador();


    function getAdministrador() {
        $.post('../php/administrador/administrador-list.php', { id_administrador }, (response) => {
            const administrador = JSON.parse(response);
            let nom_ape = administrador.nombres_admin.split(' ')[0] + " " + administrador.apellidos_admin.split(' ')[0];
            $('#id_administrador').html(administrador.id_administrador);
            $('#cedula_admin').val(administrador.cedula_admin);
            $('#nombres_admin').val(administrador.nombres_admin);
            $('#apellidos_admin').val(administrador.apellidos_admin);
            $('#nom_ape_card').html(nom_ape);
            $('#telefono_admin').val(administrador.telefono_admin);
            $('#celular_admin').val(administrador.celular_admin);
            $('#correo_admin').val(administrador.correo_admin);
            $('#direccion_admin').val(administrador.direccion_admin);

            const usuario = 'A' + administrador.cedula_admin;

            $.post('../php/administrador/administrador-list-usr.php', { usuario }, (response) => {
                const administrador_usr = JSON.parse(response);
                if (administrador_usr.estado_usr == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_admin').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_admin').html('INACTIVO/A');
                }
            });


            $('#imagen').attr("src", "../" + administrador.imagen);
        });
    }

    //RESTABLECER CONTRASEñA
    $('#btn_rpass').click(function(e) {
        e.preventDefault();
        const new_pass = generatePassword();

        const postPass = {
            id_usuario: id_usuario,
            clave: new_pass
        };

        $.ajax({
            type: "POST",
            url: "../php/administrador/password-update.php",
            data: postPass,
            success: function(response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-key fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }
        });

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

    });


    //CAMBIO DE ESTADO
    $('#btn_stat').click(function(e) {
        estado = !estado;

        const postStat = {
            id_usuario: id_usuario,
            estado: estado
        };


        $.ajax({
            type: "POST",
            url: "../php/administrador/estado-update.php",
            data: postStat,
            success: function(response) {
                if (estado == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_admin').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_admin').html('INACTIVO/A');
                }

                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-key fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }
        });

    });


    //ACTUALIZAR DATOS DE USUARIO
    $('#btn_datos').click(function(e) {
        e.preventDefault();
        const postData = {
            id_administrador: id_administrador,
            nombres_admin: $('#nombres_admin').val(),
            apellidos_admin: $('#apellidos_admin').val(),
            cedula_admin: $('#cedula_admin').val(),
            telefono_admin: $('#telefono_admin').val(),
            celular_admin: $('#celular_admin').val(),
            correo_admin: $('#correo_admin').val().replace(/\s+/g, ''),
            direccion_admin: $('#direccion_admin').val(),
            id_usuario: id_usuario
                //imagen: url_img,
        };

        if (postData.nombres_admin == "" || postData.apellidos_admin == "" || postData.cedula_admin == "" || postData.celular_admin == "" || postData.correo_admin == "" || postData.direccion_admin == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.post('../php/administrador/administrador-update.php', postData, (response) => {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                setTimeout(function() { window.location.href = "admin_read.php"; }, 3000);
            });
        }


    });

});