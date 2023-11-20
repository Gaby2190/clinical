$(document).ready(function() {
    const id_asistente = $("#id_asis").val();
    const id_usuario = $("#id_usu").val();
    var estado;


    getAsistente();
 

    function getAsistente() {
        $.post('../php/asistente/asistente-list.php', { id_asistente }, (response) => {
            const asistente = JSON.parse(response);
            let nom_ape = asistente.nombres_asis.split(' ')[0] + " " + asistente.apellidos_asis.split(' ')[0];
            $('#id_asistente').html(asistente.id_asistente);
            $('#cedula_asis').val(asistente.cedula_asis);
            $('#nombres_asis').val(asistente.nombres_asis);
            $('#apellidos_asis').val(asistente.apellidos_asis);
            $('#nom_ape_card').html(nom_ape);
            $('#telefono_asis').val(asistente.telefono_asis);
            $('#celular_asis').val(asistente.celular_asis);
            $('#correo_asis').val(asistente.correo_asis);
            $('#direccion_asis').val(asistente.direccion_asis);

            const usuario = 'AS' + asistente.cedula_asis;

            $.post('../php/asistente/asistente-list-usr.php', { usuario }, (response) => {
                const asistente_usr = JSON.parse(response);
                if (asistente_usr.estado_usr == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_asis').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_asis').html('INACTIVO/A');
                }
            });


            $('#imagen').attr("src", "../" + asistente.imagen);
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
            url: "../php/asistente/password-update.php",
            data: postPass,
            success: function(response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-key fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }
        });

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
            url: "../php/asistente/estado-update.php",
            data: postStat,
            success: function(response) {
                if (estado == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_asis').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_asis').html('INACTIVO/A');
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
            id_asistente: id_asistente,
            nombres_asis: $('#nombres_asis').val(),
            apellidos_asis: $('#apellidos_asis').val(),
            cedula_asis: $('#cedula_asis').val(),
            telefono_asis: $('#telefono_asis').val(),
            celular_asis: $('#celular_asis').val(),
            correo_asis: $('#correo_asis').val().replace(/\s+/g, ''),
            direccion_asis: $('#direccion_asis').val(),
            id_usuario: id_usuario
                //imagen: url_img,
        };

        if (postData.nombres_asis == "" || postData.apellidos_asis == "" || postData.cedula_asis == "" || postData.celular_asis == "" || postData.correo_asis == "" || postData.direccion_asis == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.post('../php/asistente/asistente-update.php', postData, (response) => {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                setTimeout(function() { window.location.href = "asis_read.php"; }, 3000);
            });
        }


    });

});