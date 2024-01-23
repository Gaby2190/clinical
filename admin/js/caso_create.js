$(document).ready(function() {
    $("#div_tmed").hide();
    $("#div_smed").hide();
     
    getEspecialidades();
    getNacionalidad();
    $('#nombres_paci1').attr('disabled', 'disabled');
    $('#nombres_paci2').attr('disabled', 'disabled');
    $('#apellidos_paci1').attr('disabled', 'disabled');
    $('#apellidos_paci2').attr('disabled', 'disabled');
    $('#celular_paci').attr('disabled', 'disabled');
    $('#datos_btn').attr('disabled', 'disabled');
 
    var id_paciente = 0;
    var id_caso = 0;

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    var rol = 'P';

    var stat_verif = false;
    

    // Buscar en base a la cedula ingresada
    $('#cedula_paci').keyup(function() {
        $('#nombres_paci1').attr('disabled', 'disabled');
        $('#nombres_paci2').attr('disabled', 'disabled');
        $('#apellidos_paci1').attr('disabled', 'disabled');
        $('#apellidos_paci2').attr('disabled', 'disabled');
        $('#celular_paci').attr('disabled', 'disabled');
        $('#datos_btn').attr('disabled', 'disabled');
        $('#nombres_paci1').val("");
        $('#apellidos_paci1').val("");
        $('#nombres_paci2').val("");
        $('#apellidos_paci2').val("");
        $('#celular_paci').val("");
        if ($('#cedula_paci').val()) {
            let cedula = $('#cedula_paci').val();
            if (($('#select_nacionalidad').val() == '53') && ($('#cedula_paci').val().length == 10)) {
                if (validarCedula(cedula) == true) {
                    verificarUsr();
                } else {
                    $('#texto_modal').html(validarCedula(cedula));
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-id-card fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                }
            } else {
                if ($('#select_nacionalidad').val() != '53') {
                    verificarUsr();
                }
            }
        } else {
            $('#nombres_paci1').attr('disabled', 'disabled');
            $('#nombres_paci2').attr('disabled', 'disabled');
            $('#apellidos_paci1').attr('disabled', 'disabled');
            $('#apellidos_paci2').attr('disabled', 'disabled');
            $('#celular_paci').attr('disabled', 'disabled');
            $('#datos_btn').attr('disabled', 'disabled');
        }
    });

    //Comprobar nacionalidad para habilitar número
    $("#select_nacionalidad").change(function (e) { 
        e.preventDefault();
        if ($('#select_nacionalidad').val() != '53') {
            $("#cedula_paci").attr('maxlength', '20');
        } else {
            $("#cedula_paci").attr('maxlength', '10');
        }
    });

    //Busqueda en la tabla de pacientes
    $('#busc_paci').keypress(function (e) {
        const key = e.which;
        if(key == 13)  // the enter key code
         {
           const txt__search = $("#busc_paci").val();
           listarPacientes(txt__search);
         }
    });


    $(document).on('click', '#add_item', (e) => {
        e.preventDefault();

        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(elemento).attr('pacienteID');
        id_paciente = id;
        const id_usuario = $(elemento).attr('pacienteUSR');
        $.ajax({
            type: "POST",
            url: '../php/paciente/paciente-list-dat.php',
            data: { id_usuario },
            success: function(response) {
                const paciente = JSON.parse(response);
                $('#select_nacionalidad').val(paciente.nac_id);
                $('#cedula_paci').val(paciente.cedula_paci);
                $('#nombres_paci1').val(paciente.nombres_paci1);
                $('#nombres_paci2').val(paciente.nombres_paci2);
                $('#apellidos_paci1').val(paciente.apellidos_paci1);
                $('#apellidos_paci2').val(paciente.apellidos_paci2);
                $('#celular_paci').val(paciente.celular_paci);
                $('#datos_btn').removeAttr('disabled');
                stat_verif = true;
                $('#modalBusqueda').modal("hide");
            }
        });

    });


    $('#buscar_btn').click(function(e) {
        e.preventDefault();
        $('#modalBusqueda').modal("show");
    });

    // Obtener Especialidades
    function getEspecialidades() {
        $.ajax({
            url: '../php/especialidad/especialidades-list.php',
            type: 'POST',
            async: false,
            success: function(response) {
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
    } 

    $("#select_especialidad").change(function (e) { 
        e.preventDefault();
        const id_esp = $("#select_especialidad").val();
        getMedicos(id_esp);
    });

    // Obtener Médicos
    function getMedicos(id_e) {
        const id_esp = id_e;

        if (id_esp == "") {
            $("#div_tmed").hide();
            $("#div_smed").hide();
        }else{
            $("#div_tmed").show();
            $("#div_smed").show();
            $.ajax({
                url: '../php/medico/medicos-list-act-esp.php', 
                type: 'POST',
                data: {id_esp},
                success: function(response) {
                    const medicos = JSON.parse(response);
                    let template = '<option selected="selected"></option>';
                    medicos.forEach(medico => {
                        //========Separación de un nombre y un apellido ===================
                        let nombre = medico.nombres_medi;
                        let apellido = medico.apellidos_medi;
                        let nom_ape = apellido + " " + nombre;
                        template += `
                            <option value="${medico.id_medico}">${nom_ape}</option>
                            `;
                    });
    
                    $('#select_medico').html(template);
    
                }
            });
        }
        
    } 

    

    function listarPacientes(txt) {
        const txt_search = txt;
        $.ajax({
            type: "POST",
            url: "../php/paciente/pacientes-list-cc.php",
            data: {txt_search},
            success: function (response) {
                let pacientes = JSON.parse(response);
                console.log(pacientes);
                let template = '';
                pacientes.forEach(paci => {
                    //========Unión de un nombre y un apellido ===================
                    let nom_ape = paci.nombres_paci1 + " " + paci.nombres_paci2 + " " + paci.apellidos_paci1 + " " + paci.apellidos_paci2;
    
                    template += `
                                    <tr class="bg-blue" pacienteID="${paci.id_paciente}" pacienteUSR="${paci.id_usuario}">
                                        <td class="pt-3" hidden>${paci.id_paciente}</td>
                                        <td class="pt-2">
                                            <img src="../${paci.imagen}" class="rounded-circle" alt="">
                                            <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                        </td>
                                        <td class="pt-3">${paci.cedula_paci}</td>
                                        <td class="pt-3">${paci.celular_paci}</td>
                                        <td class="pt-3"><a href="#" id='add_item'><span class="fa fa-plus btn"></span>Añadir</a></td>
                                    </tr>
                                    <tr id="spacing-row">
                                        <td></td>
                                    </tr>
                        `;
    
    
                });
    
                $('#pacientes').html(template); 
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

    function verificarUsr() {
        const usuario = rol + $('#cedula_paci').val();
        $.ajax({
            type: "POST",
            url: '../php/paciente/paciente-list-usr.php',
            data: { usuario },
            success: function(response) {
                if (response != false) {
                    const id_usuario = JSON.parse(response).id_usuario;
                    $.ajax({
                        type: "POST",
                        url: '../php/paciente/paciente-list-dat.php',
                        data: { id_usuario },
                        success: function(response) { 
                            const paciente = JSON.parse(response);
                            id_paciente = paciente.id_paciente;
                            $('#nombres_paci1').val(paciente.nombres_paci1);
                            $('#nombres_paci2').val(paciente.nombres_paci2);
                            $('#apellidos_paci1').val(paciente.apellidos_paci1);
                            $('#apellidos_paci2').val(paciente.apellidos_paci2);
                            $('#celular_paci').val(paciente.celular_paci);
                            $('#datos_btn').removeAttr('disabled');
                            stat_verif = true;
                        }
                    });
                } else {
                    $('#nombres_paci1').removeAttr('disabled');
                    $('#apellidos_paci1').removeAttr('disabled');
                    $('#nombres_paci2').removeAttr('disabled');
                    $('#apellidos_paci2').removeAttr('disabled');
                    $('#celular_paci').removeAttr('disabled');
                    $('#datos_btn').removeAttr('disabled');
                    stat_verif = false;
                }
            }
        });
    }

    function guardarPaci() {
        const usuario = rol + $('#cedula_paci').val();
        const nombres1 = $('#nombres_paci1').val();
        const nombres2 = $('#nombres_paci2').val();
        const apellidos1 = $('#apellidos_paci1').val();
        const apellidos2 = $('#apellidos_paci2').val();
        const cedula = $('#cedula_paci').val();
        const celular = $('#celular_paci').val();
        const nacionalidad = $('#select_nacionalidad').val();
        const id_medico = $('#select_medico').val();
        const id_especialidad = $('#select_especialidad').val();

        const postUsr = {
            usuario: usuario,
            clave: generatePassword(),
            fecha_registro: f_actual,
            estado_usr: 1,
            id_rol: 3
        };

        $.ajax({
            type: "POST",
            url: '../php/paciente/paciente-add-usr.php',
            data: postUsr,
            success: function(response) {
                console.log(response);
                $.ajax({
                    type: "POST",
                    url: '../php/paciente/paciente-list-usr.php',
                    data: { usuario },
                    success: function(response) {
                        const id_usuario = JSON.parse(response).id_usuario;
                        const url_img = 'assets/images/perfil.png';
                        const postData = {
                            nombres_paci1: nombres1,
                            nombres_paci2: nombres2,
                            apellidos_paci1: apellidos1,
                            apellidos_paci2: apellidos2,
                            cedula_paci: cedula,
                            celular_paci: celular,
                            imagen: url_img,
                            nac_id: nacionalidad,
                            id_usuario: id_usuario
                        };

                        $.ajax({
                            type: "POST",
                            data: postData,
                            url: "../php/paciente/paciente-add-c.php",
                            success: function(response) {
                                console.log(response);
                                $.ajax({
                                    type: "POST",
                                    url: '../php/paciente/paciente-list-dat.php',
                                    data: { id_usuario },
                                    success: function(response) {
                                        var paciente = JSON.parse(response);
                                        id_paciente = paciente.id_paciente;
                                        const postCaso = {
                                            fecha_registro: f_actual,
                                            id_medico: id_medico,
                                            id_especialidad: id_especialidad,
                                            id_paciente: id_paciente,
                                            id: 1
                                        };

                                        $.ajax({
                                            type: "POST",
                                            url: '../php/caso/caso-add.php',
                                            data: postCaso,
                                            success: function(response) {
                                                console.log(response);
                                                const datosCaso = {
                                                    fecha_registro: f_actual,
                                                    id_paciente: id_paciente,
                                                    id_medico: id_medico
                                                };
                                                $.ajax({
                                                    type: "POST",
                                                    url: '../php/caso/caso-list.php',
                                                    data: datosCaso,
                                                    success: function(response) {
                                                        const datos = JSON.parse(response);
                                                        id_caso = datos.id_caso;
                                                        $(location).attr('href', `cita_create.php?id_caso=${id_caso}&id=1`);
                                                    }
                                                });
                                            }
                                        });
                                    }
                                });
                            }
                        });

                    }
                });
            }
        });
    }
 
    function guardarCaso(id_p) {
        const id_medico = $('#select_medico').val();
        const id_paciente = id_p;
        const postCaso = {
            fecha_registro: f_actual,
            id_medico: $('#select_medico').val(),
            id_especialidad: $('#select_especialidad').val(),
            id_paciente: id_paciente,
            id: 1
        };
 
        $.ajax({
            type: "POST",
            url: '../php/caso/caso-add.php',
            data: postCaso,
            success: function(response) {
                console.log(response);
                const datosCaso = {
                    fecha_registro: f_actual,
                    id_paciente: id_paciente,
                    id_medico: id_medico
                };
                //console.log(datosCaso);
                $.ajax({
                    type: "POST",
                    url: '../php/caso/caso-list.php',
                    data: datosCaso,
                    success: function(response) {
                        const datos = JSON.parse(response);
                        id_caso = datos.id_caso;
                        $(location).attr('href', `cita_create.php?id_caso=${id_caso}&id=1`);
                    }
                });
            }
        });
    }


    $('#caso-datos').submit(function(e) {//click en el boton registrar del formulario
        e.preventDefault();// se previene el llamado del evento
        const id_medico = $("#select_medico").val();// Toma el valor del select_medico
        const id_especialidad = $("#select_especialidad").val();// Toma el valor del select_especialidad
        $.ajax({// se define ajax para enviar valores a un php
            type: "POST", //define el metodo de envio de los datos
            url: "../php/caso/caso-paci-verif.php", //se indica el destino 
            data: {id_medico, id_especialidad, id_paciente}, //se definen los datos a enviar
            success: function (response) { //en caso la respuesta de la ejecucion se axitosa.
                if (response != false) {// evalua su la respuesta es falsa
                    const id_caso = JSON.parse(response).id_caso; //toma el valor de id_caso de la respues
                    $('#pregunta_modal').html("El paciente tiene un Caso Abierto para el médico y especialidad indicados. <br/> Consulte al paciente si es una cita de control. <br/> Porfavor Seleccione el tipo de cita que desea el paciente.");
                    $('#modal_icono').attr('style', "color: #22445d");
                    $('#modal_icono').attr("class", "fa fa-clock-o fa-4x animated rotateIn mb-4");
                    $('#modalConfirm').modal("show");
                  //  fin del modal de confirmacion en caso de que ya exista con el mismo medico y especialidad
                $("#cita_nueva").click(function (e) {// si da clic en cita nueva
                      if (stat_verif == false) {//verifica si el paciente existe en la base
                        guardarPaci(); //invoca a la funcion guardarPaci.
                    } else {
                        guardarCaso(id_paciente); //invoca a la funcion guardarCaso
                    }
                    //dentro de cualquiera de la dos funciones al final redirecciona al formulario de registo cita normal
                    id_paciente = 0; // se resetea el formulario
                    id_caso = 0;            
                    $('#caso-datos').trigger('reset');
                    $('#nombres_paci1').attr('disabled', 'disabled');
                    $('#nombres_paci2').attr('disabled', 'disabled');
                    $('#apellidos_paci1').attr('disabled', 'disabled');
                    $('#apellidos_paci2').attr('disabled', 'disabled');
                    $('#celular_paci').attr('disabled', 'disabled');
                    $('#datos_btn').attr('disabled', 'disabled');
                    $("#select_nacionalidad").val('53');                    
                    })
                
                
                $("#cita_control").click(function (e) {// si da clic en cita control
                     const nombres1 = $('#nombres_paci1').val();//toma el valor de nombres_paci1
                     const nombres2 = $('#nombres_paci2').val();//toma el valor de nombres_paci2
                     const apellidos1 = $('#apellidos_paci1').val();//toma el valor de apellidos_paci1
                     const apellidos2 = $('#apellidos_paci2').val();//toma el valor de apellidos_paci2
                     // redirecciona al registro por cita de control
                      window.location.href = `cita_control-det.php?id_paciente=${id_paciente}&id_medico=${id_medico}&id_especialidad=${id_especialidad}&nombres1=${nombres1}&nombres2=${nombres2}&apellidos1=${apellidos1}&apellidos2=${apellidos2}`;
                    })
                  

                  
                }else {// cuando la verificaicon de caso es afirmativa
                    
                    if (stat_verif == false) {// verifica estado
                        guardarPaci();//invoca a guardar Paci
                    } else {
                        guardarCaso(id_paciente);//invoca a guardarCaso
                    }
                    //al final de la funciones hay las redirecciones
                    // se resetea el formulario
                    id_paciente = 0;
                    id_caso = 0;
            
                    $('#caso-datos').trigger('reset');
                    $('#nombres_paci1').attr('disabled', 'disabled');
                    $('#nombres_paci2').attr('disabled', 'disabled');
                    $('#apellidos_paci1').attr('disabled', 'disabled');
                    $('#apellidos_paci2').attr('disabled', 'disabled');
                    $('#celular_paci').attr('disabled', 'disabled');
                    $('#datos_btn').attr('disabled', 'disabled');
                    $("#select_nacionalidad").val('53'); 
                }
            }
        });
    });
});