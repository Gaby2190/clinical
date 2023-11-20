$(document).ready(function() {

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    var esp = [];

    $('#tiempo_ap').val(20);
    $('#comision_c').val(0);
    $('#comision_a').val(0);

    var rol = 'M';

    // Obtener Especialidades
    $.ajax({
        type: "POST",
        async: false,
        url: "../php/espe-get.php",
        success: function (response) {
            const especialidades = JSON.parse(response);
                let template = '<option selected="selected"></option>';
                especialidades.forEach(espe => {
                    template += `
                    <option value="${espe.id}">${espe.nombre}</option>
                    `;
                });

                $('#select_especialidad').html(template);
        }
    });

    //Obtener Géneros
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

 
    //Limitar caracteres de tarifa 
    var tar = document.getElementById('tarifa');
    tar.addEventListener('input', function() {
        if (this.value.length > 5)
            this.value = this.value.slice(0, 5);
    }); 

    //Limitar caracteres de tarifa control
    var tar = document.getElementById('tarifa_control');
    tar.addEventListener('input', function() {
        if (this.value.length > 5)
            this.value = this.value.slice(0, 5);
    }); 

    //Limitar caracteres de comisión consulta
    var tar = document.getElementById('comision_c');
    tar.addEventListener('input', function() {
        if (this.value.length > 3)
            this.value = this.value.slice(0, 3);
    });

    //Limitar caracteres de comisión adicionales
    var tar = document.getElementById('comision_a');
    tar.addEventListener('input', function() {
        if (this.value.length > 3)
            this.value = this.value.slice(0, 3);
    });

    //Verificar existencia de usuario y generar usuario y password

    $('#medico_datos').submit(e => {
        e.preventDefault();
        const new_pass = generatePassword();
        const comp_table = document.querySelectorAll('#especialidades_table tbody tr').length;
        if (comp_table >= 1) {
            const postUsr = {
                usuario: rol + $('#cedula_medi').val(),
                clave: new_pass,
                fecha_registro: f_actual,
                estado_usr: 1,
                id_rol: 4
            };

            const usuario = rol + $('#cedula_medi').val();

            $.post('../php/medico/medico-list-usr.php', { usuario }, (response) => {
                if (response != false) {
                    $('#texto_modal').html(`Usuario para MÉDICO con cédula: ${$('#cedula_medi').val()} ya se encuentra registrado`);
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-id-card fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                } else {
                    $.post('../php/medico/medico-add-usr.php', postUsr, (response) => {
                        console.log(response);
                        const usuario = rol + $('#cedula_medi').val();
                        let id_usuario = 0;
                        $.post('../php/medico/medico-list-usr.php', { usuario }, (response) => {
                            id_usuario = JSON.parse(response).id_usuario;
                            //====================IMAGEN==================
                            let url_img = '';
                            if ($('#imagen').val() == '') {
                                url_img = 'assets/images/perfil.png';
                            } else {
                                //===========================================Añadir imagen=====================================//
                                const form_data = new FormData(document.getElementById("medico_datos"));
                                url_img = 'assets/images/medico/';
                                url_img += $.ajax({
                                    type: "POST",
                                    url: "../php/medico/upload-img-medi.php",
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
                                nombres_medi: $('#nombres_medi').val(),
                                apellidos_medi: $('#apellidos_medi').val(),
                                nom_ape_medi: $('#nom_ape_medi').val(),
                                cedula_medi: $('#cedula_medi').val(),
                                telefono_medi: $('#telefono_medi').val(),
                                celular_medi: $('#celular_medi').val(),
                                correo_medi: $('#correo_medi').val().replace(/\s+/g, ''),
                                direccion_medi: $('#direccion_medi').val(),
                                nautorizacion_medi: $('#nautorizacion_medi').val(),
                                estado_medi: 1,
                                imagen: url_img,
                                tarifa: $('#tarifa').val(),
                                tarifa_control: $('#tarifa_control').val(),
                                pago_ingreso: $('#select_pago_i').val(),
                                comision_c: $('#comision_c').val(),
                                comision_a: $('#comision_a').val(),
                                tiempo_ap: $('#tiempo_ap').val(),
                                gen_id: $('#select_genero').val(),
                                id_usuario: id_usuario
                            }; 
                            console.log(postData);
                            $.post('../php/medico/medico-add.php', postData, (response) => {
                                $('#texto_modal').html(response);
                                $('#modal_icon').attr("class", "fa fa-user-plus fa-4x animated rotateIn mb-4");
                                $('#modalPush').modal("show");
                            });

                            //Envío de la contraseña al correo
                            const datNotiMail = {
                                nom_ape: $("#nombres_medi").val() + " " + $("#apellidos_medi").val(),
                                correo: $("#correo_medi").val().replace(/\s+/g, ''),
                                rol: 'MÉDICO',
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


                            // Ejecutamos inserts de especialidades
                            let id_medico = 0;
                            $.post('../php/medico/medico-list-dat.php', { id_usuario }, (response) => {
                                id_medico = JSON.parse(response).id_medico;
                                document.querySelectorAll('#especialidades_table tbody tr').forEach(function(e) {
                                    let postEspecialidad = {
                                        id_espe: e.querySelector('#id_es').innerText,
                                        universidad: e.querySelector('#univ').innerText,
                                        pais: e.querySelector('#upais').innerText,
                                        id_medico: id_medico
                                    };


                                    $.post('../php/especialidad.php', postEspecialidad, (response) => {
                                        $('#medico_datos').trigger('reset');
                                        $("#espe_body tr").remove(); 
                                        //Vaciar array definido arriba
                                        esp = [];
                                    });

                                });

                            });

                        });

                    });
                }

            });
        } else {
            $('#texto_modal').html('Registre al menos una especialidad');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-graduation-cap fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        }


    });

    $('#add_espe').click(function(e) {
        e.preventDefault();

        if ($('#select_especialidad').val() == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#select_especialidad').val('');
            $('#universidad').val('');
            $('#epais').val('');
        } else {

            //==============================Añadir los datos a la tabla y al arreglo definido arriba===============//
            const select = document.getElementById("select_especialidad");
            const especialidad = select.options[select.selectedIndex].text;

            const dat = {
                id_esp: $('#select_especialidad').val(),
                especialidad: especialidad,
                universidad: $('#universidad').val(),
                pais: $('#epais').val()
            };

            esp.push(dat);

            addEsp($('#select_especialidad').val(),especialidad, $('#universidad').val(), $('#epais').val());
            console.log(esp);
            $('#select_especialidad').val('');
            $('#universidad').val('');
            $('#epais').val('');
        }

    });


    //===========================================Función añadir especialidad a la tabla recibiendo datos=====================================//
    function addEsp(id,es, un, pa) {
        const id_esp = id;
        const especialidad = es;
        const universidad = un;
        const pais = pa;
        $("#especialidades_table>tbody").append(`<tr idE="${id_esp}" espeID="${especialidad}" univID="${universidad}" paisID="${pais}">
                                                        <td id='id_es' hidden>${id_esp}</td>
                                                        <td id='espe'>${especialidad}</td>
                                                        <td id='univ'>${universidad}</td>
                                                        <td id='upais'>${pais}</td>
                                                        <td><a href="#" id='eliminar' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</a></td>
                                                    </tr>`);
    }


    ///======== Botón de eliminar especialidad=====/////
    $(document).on('click', '#eliminar', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_e = $(element).attr('idE');
        const id_especialidad = $(element).attr('espeID');
        const id_universidad = $(element).attr('univID');
        const id_pais = $(element).attr('paisID');

        const busqueda = JSON.stringify({
            id_esp: id_e,
            especialidad: id_especialidad,
            universidad: id_universidad,
            pais: id_pais
        });
        let indice = esp.findIndex(espe => JSON.stringify(espe) === busqueda);
        esp.splice(indice, 1);
        $("#espe_body > tr").remove();
        esp.forEach(es => {
            addEsp(es.id_esp, es.especialidad, es.universidad, es.pais);
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