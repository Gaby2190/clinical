$(document).ready(function() {
    const id_recepcionista = $("#id_rece").val();
    console.log(id_recepcionista);
    const id_usuario = $("#id_usu").val();
    console.log(id_usuario);
    var estado;

    getRecepcionista();


    function getRecepcionista() {
        $.post('../php/recepcionista/recepcionista-list.php', { id_recepcionista }, (response) => {
            const recepcionista = JSON.parse(response);
            let nom_ape = recepcionista.nombres_rece.split(' ')[0] + " " + recepcionista.apellidos_rece.split(' ')[0];
            $('#id_recepcionista').html(recepcionista.id_recepcionista);
            $('#cedula_rece').val(recepcionista.cedula_rece);
            $('#nombres_rece').val(recepcionista.nombres_rece);
            $('#apellidos_rece').val(recepcionista.apellidos_rece);
            $('#nom_ape_card').html(nom_ape);
            $('#telefono_rece').val(recepcionista.telefono_rece);
            $('#celular_rece').val(recepcionista.celular_rece);
            $('#correo_rece').val(recepcionista.correo_rece);
            $('#direccion_rece').val(recepcionista.direccion_rece);

            const usuario = 'R' + recepcionista.cedula_rece;

            $.post('../php/recepcionista/recepcionista-list-usr.php', { usuario }, (response) => {
                const recepcionista_usr = JSON.parse(response);
                if (recepcionista_usr.estado_usr == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_rece').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_rece').html('INACTIVO/A');
                }
            });


            $('#imagen').attr("src", "../" + recepcionista.imagen);
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
            url: "../php/recepcionista/password-update.php",
            data: postPass,
            success: function(response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-key fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }
        });
        
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
            url: "../php/recepcionista/estado-update.php",
            data: postStat,
            success: function(response) {
                if (estado == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_rece').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_rece').html('INACTIVO/A');
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
            id_recepcionista: id_recepcionista,
            nombres_rece: $('#nombres_rece').val(),
            apellidos_rece: $('#apellidos_rece').val(),
            cedula_rece: $('#cedula_rece').val(),
            telefono_rece: $('#telefono_rece').val(),
            celular_rece: $('#celular_rece').val(),
            correo_rece: $('#correo_rece').val().replace(/\s+/g, ''),
            direccion_rece: $('#direccion_rece').val(),
            id_usuario: id_usuario
                //imagen: url_img,
        };

        $.post('../php/recepcionista/recepcionista-update.php', postData, (response) => {
            $('#texto_modal').html(response);
            $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            setTimeout(function() { window.location.href = "rece_read.php"; }, 3000);
        });
    });

});