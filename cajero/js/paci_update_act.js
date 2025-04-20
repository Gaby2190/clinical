$(document).ready(function() {
    const id_paciente = $("#id_paci").val();
    const id_usuario = $("#id_usu").val();
    const id_cita = $("#id_cita").val();
    var estado;

    getGenero();
    getNacionalidad();
    getSangre();

    getPaciente();

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    $('#fechan_paci').attr('max', f_actual);


    // Obtener Genero
    function getGenero() {
        $.ajax({
            async: false,
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
            async: false,
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
            async: false,
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

    function getPaciente() {
        $.ajax({
            type: "POST",
            url: "../php/paciente/paciente-list.php",
            data: { id_paciente }, 
            success: function(response) {
                const paciente = JSON.parse(response);
                $('#id_paciente').html(paciente.id_paciente);
                $('#cedula_paci').val(paciente.cedula_paci);
                $('#nombres_paci1').val(paciente.nombres_paci1);
                $('#nombres_paci2').val(paciente.nombres_paci2);
                $('#apellidos_paci1').val(paciente.apellidos_paci1);
                $('#apellidos_paci2').val(paciente.apellidos_paci2);
                // $('#fechan_paci').attr('value', paciente.fechan_paci);
               //alert(paciente.fechan_paci);
                $('#fechan_paci').val(paciente.fechan_paci);
                $("#select_genero").val(paciente.gen_id);
                $("#select_nacionalidad").val(paciente.nac_id);
                $("#select_sangre").val(paciente.san_id);
                $('#telefono_paci').val(paciente.telefono_paci);
                $('#celular_paci').val(paciente.celular_paci);
                $('#correo_paci').val(paciente.correo_paci);
                $('#direccion_paci').val(paciente.direccion_paci);
                $('#contacto_nom').val(paciente.contacto_nom);
                $('#contacto_ape').val(paciente.contacto_ape);
                $('#contacto_par').val(paciente.contacto_par);
                $('#contacto_num').val(paciente.contacto_num);

                $('#barrio_paci').val(paciente.barrio_paci);
                $('#parroquia_paci').val(paciente.parroquia_paci);
                $('#canton_paci').val(paciente.canton_paci);
                $('#provincia_paci').val(paciente.provincia_paci);
                $('#select_zona').val(paciente.zona_paci);
                $('#lnacimiento_paci').val(paciente.lnacimiento_paci);
                //$('#gcultural_paci').val(paciente.gcultural_paci);
                switch (paciente.gcultural_paci) {
                    case "Indígena":
                        $('#select_gcultural').val("0");
                        break;
                    case "Afroecuatoriano/a":
                        $('#select_gcultural').val("1");
                        break;
                    case "Montubio/a":
                        $('#select_gcultural').val("2");
                        break;
                    case "Mestizo/a":
                        $('#select_gcultural').val("3");
                        break;
                    case "Blanco/a":
                        $('#select_gcultural').val("4");
                        break;
                    case "Otro/a":
                        $('#select_gcultural').val("5");
                        break;
                }
                
                switch (paciente.ecivil_paci) {
                    case "Soltero/a":
                        $('#select_ecivil').val("0");
                        break;
                    case "Casado/a":
                        $('#select_ecivil').val("1");
                        break;
                    case "Divorciado/a":
                        $('#select_ecivil').val("2");
                        break;
                    case "Viudo/a":
                        $('#select_ecivil').val("3");
                        break;
                    case "Unión Libre":
                        $('#select_ecivil').val("4");
                        break;
                }
                $('#instruccion_paci').val(paciente.instruccion_paci);
                $('#ocupacion_paci').val(paciente.ocupacion_paci);
                $('#empresat_paci').val(paciente.empresat_paci);
                $('#ssalud_paci').val(paciente.ssalud_paci);
                $('#referido_paci').val(paciente.referido_paci);
                $('#contacto_dir').val(paciente.contacto_dir);
                const usuario = 'P' + paciente.cedula_paci;

                $.ajax({
                    type: "POST",
                    url: "../php/paciente/paciente-list-usr.php",
                    data: { usuario },
                    success: function(response) {
                        const paciente_usr = JSON.parse(response);
                        if (paciente_usr.estado_usr === true) {
                            estado = true;
                            $('#stat').attr('style', 'color: green');
                            $('#estado_paci').html('ACTIVO/A');
                        } else {
                            estado = false;
                            $('#stat').attr('style', 'color: red');
                            $('#estado_paci').html('INACTIVO/A');
                        }
                    }
                });

                $('#imagen').attr("src", "../" + paciente.imagen);
            }
        });
    }

    //ACTUALIZAR DATOS DE USUARIO
    $('#btn_datos').click(function(e) {
        e.preventDefault();
        const select = document.getElementById("select_gcultural");
        const gcultural_paci = select.options[select.selectedIndex].text;

        const postData = {
            id_paciente: id_paciente,
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

        if (postData.nombres_paci1 == "" || postData.apellidos_paci1 == "" || postData.cedula_paci == "" || postData.celular_paci == "" || postData.correo_paci == "" || postData.direccion_paci == "" || postData.contacto_nom == "" || postData.contacto_ape == "" || postData.contacto_num == "" || postData.contacto_par == "" || postData.san_id == "" || postData.nac_id == "" || postData.gen_id == "" || postData.parroquia_paci == "" || postData.canton_paci == "" || postData.provincia_paci == "" || postData.zona_paci == "" || postData.lnacimiento_paci == "" || postData.gcultural_paci == "" || postData.ecivil_paci == "" || postData.instruccion_paci == "" || postData.ocupacion_paci == "" || postData.empresat_paci == "" || postData.ssalud_paci == "" || postData.contacto_dir == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else { 
            $.ajax({
                type: "POST",
                url: "../php/paciente/paciente-update.php",
                data: postData,
                success: function (response) {
                    console.log(response);
                    const postAct = {
                        id_paciente: id_paciente,
                        fecha: f_actual
                    };
                    $.ajax({
                        type: "POST",
                        url: "../php/cita_no_actualizada.php",
                        data: postAct,
                        success: function (response) {
                            if (response != false) {
                                const citas = JSON.parse(response);
                                citas.forEach(c => {
                                    const id_cita = c.id_cita;
                                    $.ajax({
                                        type: "POST",
                                        url: "../php/cita_actualizada.php",
                                        data: {id_cita},
                                        success: function (response) {
                                            console.log(response);
                                        }
                                    });
                                });
                                $('#texto_modal').html("Datos del paciente actualizados con éxito");
                                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                                $('#modalPush').modal("show");
                                setTimeout(function() { window.location.href = `caja.php?id_cita=${id_cita}`; }, 3000);
                            }
                        }
                    });
                }
            });
        }
    });

});