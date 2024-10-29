$(document).ready(function() {
    const id_medico = $("#id_med").val();
    const id_usuario = $("#id_usu").val();
    var estado;
    getMedico(); 
    cargarEspe();
    cargarSegu();

    //Limitar caracteres de tarifa normal
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

    //==========Variable de antecedentes personales para tabla=========//
    var esp = [];
    var segu = []; 

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

    // Obtener Seguro
    $.ajax({
        type: "POST",
        async: false,
        url: "../php/aseguradora/segu-get.php",
        success: function (response) {
            const aseguradoras = JSON.parse(response);
                let template = '<option selected="selected"></option>';
                aseguradoras.forEach(segu => {
                    template += `
                    <option value="${segu.id}">${segu.nombre}</option>
                    `;
                });

                $('#select_aseguradoras').html(template);
        }
    });


    function getMedico() {
        $.post('../php/medico/medico-list.php', { id_medico }, (response) => {
 
            const medico = JSON.parse(response);
            let nom_ape = medico.nombres_medi.split(' ')[0] + " " + medico.apellidos_medi.split(' ')[0];
            $('#id_medico').html(medico.id_medico);
            $('#cedula_medi').val(medico.cedula_medi);
            $('#nombres_medi').val(medico.nombres_medi);
            $('#apellidos_medi').val(medico.apellidos_medi);
            $('#nom_ape_medi').val(medico.nom_ape_medi);
            $('#nom_ape_card').html(nom_ape);
            $('#nautorizacion_medi').val(medico.nautorizacion_medi);
            $('#telefono_medi').val(medico.telefono_medi);
            $('#celular_medi').val(medico.celular_medi);
            $('#correo_medi').val(medico.correo_medi);
            $('#direccion_medi').val(medico.direccion_medi); 
            $('#tarifa').val(medico.tarifa); 
            $('#tarifa_control').val(medico.tarifa_control);
            $('#select_pago_i').val(medico.pago_ingreso);
            $('#comision_c').val(medico.comision_c);
            $('#comision_a').val(medico.comision_a);
            $('#tiempo_ap').val(medico.tiempo_ap);

            if (medico.estado_medi == true) {
                estado = true;
                $('#stat').attr('style', 'color: green');
                $('#estado_medi').html('ACTIVO/A');
            } else {
                estado = false;
                $('#stat').attr('style', 'color: red');
                $('#estado_medi').html('INACTIVO/A');
            }
            $('#imagen').attr("src", "../" + medico.imagen);
        });
    }

    function cargarEspe() {
        $.ajax({
            type: "POST",
            url: "../php/medico/especialidad.php",
            async: false,
            data: {id_medico},
            success: function (response) {
                const especialidades = JSON.parse(response);
                especialidades.forEach(especialidad => {
                    $("#especialidades_table>tbody").append(`<tr>
                        <tdhidden></td>
                        <td>${especialidad.nombre}</td>
                        <td>${especialidad.universidad}</td>
                        <td>${especialidad.pais}</td>
                        <td></td>
                    </tr>`);
                });
            } 
        });
    }

    $('#valor_seguro').change(function(e) {
        e.preventDefault();
        valor = document.getElementById("valor_seguro").value;
        id_segu = document.getElementById("valor_seguro").name;

        const postAseguradora = {
            id_segu: id_segu,
            valor: valor,
            id_medico: id_medico
        };  
        $.ajax({
            type: "POST",
            url: "../php/medico/aseguradora-update.php",
            data: postAseguradora,
            success: function (response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }
        });

    });

    function cargarSegu() {
        $.ajax({
            type: "POST",
            url: "../php/medico/aseguradora.php",
            async: false,
            data: {id_medico},
            success: function (response) {
                const aseguradoras = JSON.parse(response);
                aseguradoras.forEach(segu => {
                    $("#seguros_table>tbody").append(`<tr>
                        <td hidden>${segu.id_seguro}</td>
                        <td>${segu.aseguradora}</td>
                        <td><input type="number" class="form-control" id="valor_seguro" size="100" maxlength="3" value="${segu.valor}" name="${segu.id_seguro}"></td>
                        <td></td>
                    </tr>`);
                });
            } 
        });
    }

  

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
                <td><button id='eliminar' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
            </tr>`);
    }

    // ===============================   Añadir Aseguradora ========================
    $('#add_segu').click(function(e) {
        e.preventDefault();

        if ($('#select_aseguradoras').val() == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#select_aseguradoras').val('');
            $('#val_seguro').val('');
        } else {

            //==============================Añadir los datos a la tabla y al arreglo definido arriba===============//
            const select = document.getElementById("select_aseguradoras");
            const aseguradora = select.options[select.selectedIndex].text;

            const dat = {
                id_segu: $('#select_aseguradoras').val(),
                asegu: aseguradora,
                valor: $('#val_seguro').val()
            };

            segu.push(dat);

            addSegu($('#select_aseguradoras').val(), aseguradora ,$('#val_seguro').val());
            console.log(segu);
            $('#select_aseguradoras').val('');
            $('#val_seguro').val('');
        }

    });

    function addSegu(id,as, val) {
        const id_segu = id; 
        const aseguradora = as;
        const valor = val;
        $("#seguros_table>tbody").append(`<tr idS="${id_segu}" asID="${aseguradora}" valor="${valor}">
                <td id='id_segu' hidden >${id_segu}</td>
                <td id='segu'>${aseguradora}</td>
                <td id='val'>${valor}</td>
                <td><button id='eliminar_segu' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
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
        cargarEspe();
        esp.forEach(es => {
            addEsp(es.id_esp, es.especialidad, es.universidad, es.pais);
        });


    });



    ///======== Botón de eliminar seguro=====/////
    $(document).on('click', '#eliminar_segu', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_s = $(element).attr('idS');
        const aseguradora = $(element).attr('asID');
        const valor = $(element).attr('valor');

        const busqueda_segu = JSON.stringify({
            id_segu: id_s,
            asegu: aseguradora,
            valor: valor
        });
        let indice = segu.findIndex(segu => JSON.stringify(segu) === busqueda_segu);
        segu.splice(indice, 1);
        
        $("#seguros_body > tr").remove();
        cargarSegu();
        segu.forEach(seg => {
            addSegu(seg.id_segu, seg.asegu ,seg.valor); 
        });


    });

  


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
            url: "../php/medico/password-update.php",
            data: postPass,
            success: function(response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-key fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }
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

    });


    //CAMBIO DE ESTADO
    $('#btn_stat').click(function(e) {
        estado = !estado;

        const postStat = {
            id_usuario: id_usuario,
            id_medico: id_medico,
            estado: estado
        };


        $.ajax({
            type: "POST",
            url: "../php/medico/estado-update.php",
            data: postStat,
            success: function(response) {
                if (estado == true) {
                    estado = true;
                    $('#stat').attr('style', 'color: green');
                    $('#estado_medi').html('ACTIVO/A');
                } else {
                    estado = false;
                    $('#stat').attr('style', 'color: red');
                    $('#estado_medi').html('INACTIVO/A');
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
            id_medico: id_medico,
            nombres_medi: $('#nombres_medi').val(),
            apellidos_medi: $('#apellidos_medi').val(),
            nom_ape_medi: $('#nom_ape_medi').val(),
            cedula_medi: $('#cedula_medi').val(),
            telefono_medi: $('#telefono_medi').val(),
            celular_medi: $('#celular_medi').val(),
            correo_medi: $('#correo_medi').val().replace(/\s+/g, ''),
            direccion_medi: $('#direccion_medi').val(),
            nautorizacion_medi: $('#nautorizacion_medi').val(),
            tarifa: $('#tarifa').val(),
            tarifa_control: $('#tarifa_control').val(),
            pago_ingreso: $('#select_pago_i').val(), 
            comision_c: $('#comision_c').val(),
            comision_a: $('#comision_a').val(),
            tiempo_ap: $('#tiempo_ap').val(),
            id_usuario: id_usuario
        };

        if (postData.nombres_medi == "" || postData.apellidos_medi == "" || postData.nom_ape_medi == "" || postData.cedula_medi == "" || postData.celular_medi == "" || postData.correo_medi == "" || postData.direccion_medi == "" || postData.nautorizacion_medi == "" || postData.tarifa == "" || postData.tarifa_control == "" || postData.pago_ingreso == "" || postData.comision_c == "" || postData.comision_a == "" || postData.tiempo_ap == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.ajax({
                type: "POST",
                url: "../php/medico/medico-update.php",
                data: postData,
                success: function (response) {
                    console.log(response);
                    esp.forEach(e => {
                        const postEspecialidad = {
                            id_espe: e.id_esp,
                            universidad: e.universidad,
                            pais: e.pais,
                            id_medico: id_medico
                        };
                    

                        $.ajax({
                            type: "POST",
                            url: "../php/especialidad.php",
                            data: postEspecialidad,
                            success: function (response) {
                                console.log(response);
                            }
                        });
                    });
                    esp = [];
                    segu.forEach(s => {
                        const postAseguradora = {
                            id_segu: s.id_segu,
                            valor: s.valor,
                            id_medico: id_medico
                        };
                    

                        $.ajax({
                            type: "POST",
                            url: "../php/aseguradora/aseguradora.php",
                            data: postAseguradora,
                            success: function (response) {
                                console.log(response);
                            }
                        });
                    });
                    esp = [];
                    $('#texto_modal').html("Datos de médico modificados satisfactoriamente");
                    $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                   // setTimeout(function() { window.location.href = "med_read.php"; }, 3000);
                    
                }
            });

        }

    });

});