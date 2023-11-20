$(document).ready(function() {
    getGenero();
    getNacionalidad();
    getSangre();


    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    var rol = 'P';



    $('#fechan_paci').attr('max', f_actual);
    $('#fechan_paci').attr('value', f_actual);

    // Obtener Genero
    function getGenero() {
        $.ajax({
            url: '../php/genero.php',
            type: 'POST',
            success: function(response) {
                const generos = JSON.parse(response);
                let template = '<option selected="selected"></option>';
                generos.forEach(genero => {
                    template += `
                    <option value="${genero.id}">${genero.nombre}</option>
                    `;
                });

                $('#select_genero').html(template);

            }
        });

    }

    // Obtener Nacionalidad
    function getNacionalidad() {
        $.ajax({
            url: '../php/nacionalidad.php',
            type: 'POST',
            success: function(response) {
                const nacionalidades = JSON.parse(response);
                let template = '';
                nacionalidades.forEach(nacionalidad => {
                    template += `
                    <option value="${nacionalidad.id}">${nacionalidad.nombre}</option>
                    `;
                });

                $('#select_nacionalidad').html(template);
                $("#select_nacionalidad").val('53');
            }
        });
    }

    // Obtener Sangre
    function getSangre() {
        $.ajax({
            url: '../php/sangre.php',
            type: 'POST',
            success: function(response) {
                const sangres = JSON.parse(response);
                let template = '<option selected="selected"></option>';
                sangres.forEach(sangre => {
                    template += `
                    <option value="${sangre.id}">${sangre.nombre}</option>
                    `;
                });
                $('#select_sangre').html(template);
            }
        });
    }

    function guardar() {
        const new_pass = generatePassword();

        const postUsr = {
            usuario: rol + $('#cedula_paci').val(),
            clave: new_pass,
            fecha_registro: f_actual,
            estado_usr: 1,
            id_rol: 3
        };
        const usuario = rol + $('#cedula_paci').val();

        $.post('../php/paciente/paciente-list-usr.php', { usuario }, (response) => {
            if (response != false) {
                $('#texto_modal').html(`Usuario para PACIENTE con cédula: ${$('#cedula_paci').val()} ya se encuentra registrado`);
                $('#modal_icon').attr('style', "color: orange");
                $('#modal_icon').attr("class", "fa fa-id-card fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            } else {
                $.post('../php/paciente/paciente-add-usr.php', postUsr, (response) => {
                    console.log(response);
                    const usuario = rol + $('#cedula_paci').val();
                    let id_usuario = 0;
                    $.post('../php/paciente/paciente-list-usr.php', { usuario }, (response) => {
                        id_usuario = JSON.parse(response).id_usuario;
                        //====================IMAGEN==================
                        let url_img = '';
                        if ($('#imagen').val() == '') {
                            url_img = 'assets/images/perfil.png';
                        } else {
                            //===========================================Añadir imagen=====================================//
                            const form_data = new FormData(document.getElementById("paciente-datos"));
                            url_img = 'assets/images/paciente/';
                            url_img += $.ajax({
                                type: "POST",
                                url: "../php/paciente/upload-img-paci.php",
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
                        const select = document.getElementById("select_gcultural");
                        const gcultural_paci = select.options[select.selectedIndex].text;
                        
                        const postData = {
                            nombres_paci1: $('#nombres_paci1').val(),
                            nombres_paci2: $('#nombres_paci2').val(),
                            apellidos_paci1: $('#apellidos_paci1').val(),
                            apellidos_paci2: $('#apellidos_paci2').val(),
                            cedula_paci: $('#cedula_paci').val(),
                            fechan_paci: $('#fechan_paci').val(),
                            telefono_paci: $('#telefono_paci').val(),
                            celular_paci: $('#celular_paci').val(),
                            correo_paci: $('#correo_paci').val().replace(/\s+/g, ''),
                            direccion_paci: $('#direccion_paci').val(),
                            imagen: url_img,
                            contacto_nom: $('#contacto_nom').val(),
                            contacto_ape: $('#contacto_ape').val(),
                            contacto_num: $('#contacto_num').val(),
                            contacto_par: $('#contacto_par').val(),
                            san_id: $('#select_sangre').val(),
                            nac_id: $('#select_nacionalidad').val(),
                            gen_id: $('#select_genero').val(),
                            barrio_paci: $('#barrio_paci').val(),
                            parroquia_paci: $('#parroquia_paci').val(),
                            canton_paci: $('#canton_paci').val(),
                            provincia_paci: $('#provincia_paci').val(),
                            zona_paci: $('#select_zona').val(),
                            lnacimiento_paci: $('#lnacimiento_paci').val(),
                            gcultural_paci: gcultural_paci,
                            ecivil_paci: $('#select_ecivil option:selected').html(),
                            instruccion_paci: $('#instruccion_paci').val(),
                            ocupacion_paci: $('#ocupacion_paci').val(),
                            empresat_paci: $('#empresat_paci').val(),
                            ssalud_paci: $('#ssalud_paci').val(),
                            referido_paci: $('#referido_paci').val(),
                            contacto_dir: $('#contacto_dir').val(),
                            id_usuario: id_usuario 
                        };
                        console.log(postData); 

                        //Envío de la contraseña al correo 
                        const datNotiMail = {
                            nom_ape: $("#nombres_paci1").val() + " " + $("#apellidos_paci1").val(),
                            correo: $("#correo_paci").val().replace(/\s+/g, ''),
                            rol: 'PACIENTE',
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

                        $.post('../php/paciente/paciente-add.php', postData, (response) => {
                            $('#texto_modal').html(response);
                            $('#modal_icon').attr("class", "fa fa-user-plus fa-4x animated rotateIn mb-4");
                            $('#modalPush').modal("show");
                            $('#paciente-datos').trigger('reset');
                            $("#select_nacionalidad").val('53');
                        });
                    });
                });
            }

        });
    }

    //Verificar cedula, existencia de usuario y generar usuario y password

    $('#paciente-datos').submit(e => {
        e.preventDefault();
        if ($('#select_nacionalidad').val() == '53') {

            if (validarCedula($('#cedula_paci').val()) == true) {
                guardar();
            } else {
                $('#texto_modal').html(validarCedula($('#cedula_paci').val()));
                $('#modal_icon').attr('style', "color: orange");
                $('#modal_icon').attr("class", "fa fa-id-card fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }
        } else {
            guardar();
        }




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