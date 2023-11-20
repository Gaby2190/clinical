$(document).ready(function() {
    const id_cajero = $("#id_caje").val();
    const id_usuario = $("#id_usu").val();
    var estado;


    getCajero();


    function getCajero() {
        $.post('../php/cajero/cajero-list.php', { id_cajero }, (response) => {
            const cajero = JSON.parse(response);
            let nom_ape = cajero.nombres_caje.split(' ')[0] + " " + cajero.apellidos_caje.split(' ')[0];
            $('#id_cajero').html(cajero.id_cajero);
            $('#cedula_caje').val(cajero.cedula_caje);
            $('#nombres_caje').val(cajero.nombres_caje);
            $('#apellidos_caje').val(cajero.apellidos_caje);
            $('#nom_ape_card').html(nom_ape);
            $('#telefono_caje').val(cajero.telefono_caje);
            $('#celular_caje').val(cajero.celular_caje);
            $('#correo_caje').val(cajero.correo_caje);
            $('#direccion_caje').val(cajero.direccion_caje);

            const usuario = 'C' + cajero.cedula_caje;

            $.post('../php/cajero/cajero-list-usr.php', { usuario }, (response) => {
                const cajero_usr = JSON.parse(response);
                if (cajero_usr.estado_usr == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_caje').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_caje').html('INACTIVO/A');
                }
            });


            $('#imagen').attr("src", "../" + cajero.imagen);
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
            url: "../php/cajero/password-update.php",
            data: postPass,
            success: function(response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-key fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }
        });

        //Envío de la contraseña al correo
        const datNotiMail = {
            nom_ape: $("#nombres_caje").val() + " " + $("#apellidos_caje").val(),
            correo: $("#correo_caje").val().replace(/\s+/g, ''),
            rol: 'CAJERO/A',
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
            url: "../php/cajero/estado-update.php",
            data: postStat,
            success: function(response) {
                if (estado == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_caje').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_caje').html('INACTIVO/A');
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
            id_cajero: id_cajero,
            nombres_caje: $('#nombres_caje').val(),
            apellidos_caje: $('#apellidos_caje').val(),
            cedula_caje: $('#cedula_caje').val(),
            telefono_caje: $('#telefono_caje').val(),
            celular_caje: $('#celular_caje').val(),
            correo_caje: $('#correo_caje').val().replace(/\s+/g, ''),
            direccion_caje: $('#direccion_caje').val(),
            id_usuario: id_usuario
                //imagen: url_img,
        };

        if (postData.nombres_caje == "" || postData.apellidos_caje == "" || postData.cedula_caje == "" || postData.celular_caje == "" || postData.correo_caje == "" || postData.direccion_caje == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.post('../php/cajero/cajero-update.php', postData, (response) => {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                setTimeout(function() { window.location.href = "caje_read.php"; }, 3000);
            });
        }


    });

});