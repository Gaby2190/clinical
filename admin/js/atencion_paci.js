$(document).ready(function() { 
    const id_paciente = $("#id_paciente").val();
    const id_cita = $("#id_cita").val();

    $("#dias_reposo").val(0);

    $.ajax({
        type: "POST",
        url: "../php/cita/cita-read-id.php",
        async: false,
        data: {id_cita},
        success: function (response) {
            const tipo_cita = Number(JSON.parse(response).tipo_cita);
            if (tipo_cita == 1) {
                $("#ros_control").remove();
                $("#efr_control").remove();
                $("#div_evolucion").hide();
            }
            if (tipo_cita == 0) {
                $("#ros_normal").remove();
                $("#efr_normal").remove();
                $("#div_evolucion").show();
                $.ajax({
                    type: "POST",
                    url: "../php/caso/idcaso-idcita-get.php",
                    async: false,
                    data: {id_cita},
                    success: function (response) {
                        const id_caso = JSON.parse(response).id_caso;
                        $.ajax({
                            type: "POST",
                            url: "../php/revision_o_s/revision_o_s-get.php",
                            async: false,
                            data: {id_caso},
                            success: function (response) {
                                const ros = JSON.parse(response);
                                ros.forEach(r => {
                                    switch (r.orga_sist) {
                                        case "Órganos de los sentidos":
                                            if (r.cp == "1") {
                                                $("#sp_organos").hide();
                                                $("#cp_organos").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_organos").hide();
                                                $("#sp_organos").show();
                                            }
                                            $("#organos_i").val(r.descripcion);
                                            break;
                                        case "Respiratorio":
                                            if (r.cp == "1") {
                                                $("#sp_respiratorio").hide();
                                                $("#cp_respiratorio").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_respiratorio").hide();
                                                $("#sp_respiratorio").show();
                                            }
                                            $("#respiratorio_i").val(r.descripcion);
                                            break;
                                        case "Cardio vascular":
                                            if (r.cp == "1") {
                                                $("#sp_cardiov").hide();
                                                $("#cp_cardiov").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_cardiov").hide();
                                                $("#sp_cardiov").show();
                                            }
                                            $("#cardiov_i").val(r.descripcion);
                                            break;
                                        case "Digestivo":
                                            if (r.cp == "1") {
                                                $("#sp_digestivo").hide();
                                                $("#cp_digestivo").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_digestivo").hide();
                                                $("#sp_digestivo").show();
                                            }
                                            $("#digestivo_i").val(r.descripcion);
                                            break;
                                        case "Genital":
                                            if (r.cp == "1") {
                                                $("#sp_genital").hide();
                                                $("#cp_genital").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_genital").hide();
                                                $("#sp_genital").show();
                                            }
                                            $("#genital_i").val(r.descripcion);
                                            break;
                                        case "Urinario":
                                            if (r.cp == "1") {
                                                $("#sp_urinario").hide();
                                                $("#cp_urinario").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_urinario").hide();
                                                $("#sp_urinario").show();
                                            }
                                            $("#urinario_i").val(r.descripcion);
                                            break;
                                        case "Músculo esquelético":
                                            if (r.cp == "1") {
                                                $("#sp_musculoe").hide();
                                                $("#cp_musculoe").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_musculoe").hide();
                                                $("#sp_musculoe").show();
                                            }
                                            $("#musculoe_i").val(r.descripcion);
                                            break;
                                        case "Endocrino":
                                            if (r.cp == "1") {
                                                $("#sp_endocrino").hide();
                                                $("#cp_endocrino").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_endocrino").hide();
                                                $("#sp_endocrino").show();
                                            }
                                            $("#endocrino_i").val(r.descripcion);
                                            break;
                                        case "Hemo linfático":
                                            if (r.cp == "1") {
                                                $("#sp_hemol").hide();
                                                $("#cp_hemol").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_hemol").hide();
                                                $("#sp_hemol").show();
                                            }
                                            $("#hemol_i").val(r.descripcion);
                                            break;
                                        case "Nervioso":
                                            if (r.cp == "1") {
                                                $("#sp_nervioso").hide();
                                                $("#cp_nervioso").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_nervioso").hide();
                                                $("#sp_nervioso").show();
                                            }
                                            $("#nervioso_i").val(r.descripcion);
                                            break;
                                        default:
                                            break;
                                    }
                                });
                            }
                        });
                        $.ajax({
                            type: "POST",
                            url: "../php/examen_fr/examen_fr-get.php",
                            async: false,
                            data: {id_caso},
                            success: function (response) {
                                const efr = JSON.parse(response);
                                efr.forEach(r => {
                                    switch (r.examen_fr) {
                                        case "Cabeza":
                                            if (r.cp == "1") {
                                                $("#sp_cabeza").hide();
                                                $("#cp_cabeza").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_cabeza").hide();
                                                $("#sp_cabeza").show();
                                            }
                                            $("#cabeza_i").val(r.descripcion);
                                            break;
                                        case "Cuello":
                                            if (r.cp == "1") {
                                                $("#sp_cuello").hide();
                                                $("#cp_cuello").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_cuello").hide();
                                                $("#sp_cuello").show();
                                            }
                                            $("#cuello_i").val(r.descripcion);
                                            break;
                                        case "Tórax":
                                            if (r.cp == "1") {
                                                $("#sp_torax").hide();
                                                $("#cp_torax").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_torax").hide();
                                                $("#sp_torax").show();
                                            }
                                            $("#torax_i").val(r.descripcion);
                                            break;
                                        case "Abdomen":
                                            if (r.cp == "1") {
                                                $("#sp_abdomen").hide();
                                                $("#cp_abdomen").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_abdomen").hide();
                                                $("#sp_abdomen").show();
                                            }
                                            $("#abdomen_i").val(r.descripcion);
                                            break;
                                        case "Pelvis":
                                            if (r.cp == "1") {
                                                $("#sp_pelvis").hide();
                                                $("#cp_pelvis").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_pelvis").hide();
                                                $("#sp_pelvis").show();
                                            }
                                            $("#pelvis_i").val(r.descripcion);
                                            break;
                                        case "Extremidades":
                                            if (r.cp == "1") {
                                                $("#sp_extremidades").hide();
                                                $("#cp_extremidades").show();
                                            }
                                            if (r.cp == "0") {
                                                $("#cp_extremidades").hide();
                                                $("#sp_extremidades").show();
                                            }
                                            $("#extremidades_i").val(r.descripcion);
                                            break;
                                        default:
                                            break;
                                    }
                                });
                            }
                        });
                    }
                });
            }
        }
    });

   //Traer los datos del caso
   $.ajax({
    type: "POST",
    url: "../php/cita/cita-pac-dat.php",
    data: {id_cita},
    success: function (response) {
        const motivo_con = JSON.parse(response).motivo_con;
        const problema_act = JSON.parse(response).problema_act;
        if (motivo_con == "" || motivo_con == null) {
            $("#motivo_consulta").removeAttr('disabled');
        }else{
            $("#motivo_consulta").attr('disabled', 'disabled');
            $("#motivo_consulta").val(motivo_con);
        }
        if (problema_act == "" || problema_act == null) {
            $("#problema_actual").removeAttr('disabled');
        }else{
            $("#problema_actual").attr('disabled', 'disabled');
            $("#problema_actual").val(problema_act);
        }
    }
   });

    //Limitar caracteres de descuento
    var tar = document.getElementById('descuento');
    tar.addEventListener('input', function() {
        if (this.value.length > 5)
            this.value = this.value.slice(0, 5);
    });

    //Limitar caracteres de costo
    var cost = document.getElementById('costo');
    cost.addEventListener('input', function() {
        if (this.value.length > 5)
            this.value = this.value.slice(0, 5);
    });

    //Limitar caracteres de temperatura
    var cost = document.getElementById('temperatura');
    cost.addEventListener('input', function() {
        if (this.value.length > 4)
            this.value = this.value.slice(0, 4);
    });

    //Limitar caracteres de peso
    var cost = document.getElementById('peso');
    cost.addEventListener('input', function() {
        if (this.value.length > 5)
            this.value = this.value.slice(0, 5);
    });

    //Limitar caracteres de saturación de oxígeno
    var cost = document.getElementById('sat_o');
    cost.addEventListener('input', function() {
        if (this.value.length > 4)
            this.value = this.value.slice(0, 4);
    });

    //Limitar caracteres de cantidad de medicamento
    var cost = document.getElementById('c_medicamento');
    cost.addEventListener('input', function() {
        if (this.value.length > 6)
            this.value = this.value.slice(0, 6);
    });

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    getPaciente();
    getTarifa();
    getServicio();

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    //==========Variable de antecedentes personales para tabla=========//
    var antecedentes = [];
    //==========Variable de antecedentes familiares para tabla=========//
    var antecedentesf = [];

    //==========Variable signos vitales y  amtropometria=========//
    var signosva = [];
    var cont_sva = 0;

    //==========Variable Diagnosticoa=========//
    var diagnosticos = [];
    var cont_diag = 0;

    //==========Variable Planes de tratamiento=========//
    var plan_t = [];

    //==========Variable Adicionales=========//
    var adicionales = [];

    //==========Variable de alergias para tabla=========//
    var alergias = [];


    function getPaciente() {
        $.ajax({
            type: "POST",
            url: "../php/paciente/paciente-list-comp.php",
            data: { id_paciente },
            success: function(response) {
                const paciente = JSON.parse(response);
                $('#id_paciente').html(paciente.id_paciente);
                $('#cedula_paci').html(paciente.cedula_paci);
                $('#nombres_paci1').html(paciente.nombres_paci1);
                $('#nombres_paci2').html(paciente.nombres_paci2);
                $('#apellidos_paci1').html(paciente.apellidos_paci1);
                $('#apellidos_paci2').html(paciente.apellidos_paci2);
                $('#fechan_paci').html(paciente.fechan_paci);
                $("#genero_paci").html(paciente.genero);
            
                if (Number(paciente.id_gen) == 1) {
                    $("#div_semana_embarazo").hide();
                    $("#semana_embarazo").val(0);

                }
                if (Number(paciente.id_gen) == 2) {
                    $("#div_semana_embarazo").show();
                    $.ajax({
                        type: "POST",
                        url: "../php/cita/cita-read-id.php",
                        data: {id_cita},
                        success: function (response) {
                            const semana_embarazo = Number(JSON.parse(response).semana_embarazo);
                            const id_caso = JSON.parse(response).id_caso;    
                            var new_sem_e = 0;

                            if (semana_embarazo == 0) {
                                $("#semana_embarazo").val(0);
                            }else{
                                $.ajax({
                                    type: "POST",
                                    url: "../php/cita/cita-ult-se.php",
                                    data: {id_caso},
                                    success: function (response) {
                                        const dat_fecha = JSON.parse(response).fecha;
                                        fecha_actual = new Date();
                                        fecha_new = new Date(dat_fecha);
                                        const dias = Math.floor((fecha_actual - fecha_new) / (24 * 60 * 60 * 1000));
                                        var semanas = Number(Math.ceil(( fecha_actual.getDay() + 1 + dias) / 7));
                                        if (Math.sign(Number(semanas)) == (-1)) {
                                            semanas = semanas * (-1);
                                        }

                                        new_sem_e = semana_embarazo + semanas;

                                        if (new_sem_e >= 40) {
                                            $("#semana_embarazo").val(0);
                                            $.ajax({
                                                type: "POST",
                                                url: "../php/update_sem_e.php",
                                                data: {
                                                    id_caso: id_caso,
                                                    semana_embarazo: 0
                                                },
                                                success: function (response) {
                                                    console.log(response);
                                                }
                                            });
                                        }
                                        if ((new_sem_e > 0) && (new_sem_e < 40)) {
                                            $("#semana_embarazo").val(new_sem_e);
                                            $.ajax({
                                                type: "POST",
                                                url: "../php/update_sem_e.php",
                                                data: {
                                                    id_caso: id_caso,
                                                    semana_embarazo: new_sem_e
                                                },
                                                success: function (response) {
                                                    console.log(response);
                                                }
                                            });
                                        }
                                    }
                                });  
                            }
                                                 
                        }
                    });
                }

                $("#nacionalidad_paci").html(paciente.nacionalidad);
                $("#sangre_paci").html(paciente.sangre);
                $('#telefono_paci').html(paciente.telefono_paci);
                $('#celular_paci').html(paciente.celular_paci);
                $('#correo_paci').html(paciente.correo_paci);
                $('#direccion_paci').html(paciente.direccion_paci);
                $('#contacto_nom').html(paciente.contacto_nom);
                $('#contacto_ape').html(paciente.contacto_ape);
                $('#contacto_par').html(paciente.contacto_par);
                $('#contacto_num').html(paciente.contacto_num);
                $('#edad_paci').html(calcularEdad(paciente.fechan_paci));

            }
        });
    }

    function getTarifa() {
        $.ajax({
            type: "POST",
            url: "../php/cita/cita-pac-dat.php",
            data: { id_cita },
            success: function(response) {
                const cita = JSON.parse(response);
                var tarifa = 0;
                if (cita.tipo_cita == "1") {
                    tarifa = cita.tarifa;
                }else{
                    if (cita.tipo_cita == "0") {
                        tarifa = cita.tarifa_control;
                    }
                } 

                console.log(Number(tarifa));
                $("#tarifa").html(`$ ${tarifa}`);
                if (Number(tarifa) == 0) {
                    $("#descuento").attr('disabled', 'disabled');
                }else{
                    $("#descuento").removeAttr('disabled');
                }
            }
        });
    }

    function getServicio() {
        $.ajax({
            async: false,
            url: '../php/servicio.php',
            type: 'POST',
            success: function(response) {
                const servicios = JSON.parse(response);
                let template = '<option selected="selected"></option>';
                servicios.forEach(servicio => {
                    template += `
                    <option value="${servicio.id}">${servicio.nombre}</option>
                    `;
                });
                $('#select_servicio').html(template);
            }
        });
    }

    function calcularEdad(fechaNac) {
        if(!fechaNac || isNaN(new Date(fechaNac))) return;
        const hoy = new Date();
        const dateNac = new Date(fechaNac);
        if(hoy - dateNac < 0) return;
        let dias = hoy.getUTCDate() - dateNac.getUTCDate();
        let meses = hoy.getUTCMonth() - dateNac.getUTCMonth();
        let years = hoy.getUTCFullYear() - dateNac.getUTCFullYear();
        if(dias < 0) {
          meses--;
          dias = 30 + dias;
        } 
        if(meses < 0) {
          years--;
          meses = 12 + meses;
        }
        console.log(years + meses + dias);
        const edad = years + " años, " + meses + " meses"
        return edad;
      }


    //==========================================================FUNCIONES DE LOS ANTECEDENTES Personales======================================//
    //==========Cargar antecedentes a la tabla========//
    cargarAntPrevios();

    function cargarAntPrevios() {
        $.ajax({
            type: "POST",
            url: "../php/antecedente_p/antecedente_p-get.php",
            async: false,
            data: { id_paciente },
            success: function(response) {
                const antecedentes = JSON.parse(response);
                antecedentes.forEach(ante => {
                    const nombre = ante.nombres_medi;
                    const apellido = ante.apellidos_medi;
                    const nom_ape = ante.sufijo + " " + nombre + " " + apellido;
                    $("#antecedentes_table>tbody").append(`<tr>
                                                                <td>${nom_ape}</td>
                                                                <td>${ante.fecha}</td>
                                                                <td>${ante.descripcion}</td>
                                                                <td></td>
                                                            </tr>`);
                });
            }
        });
    }


    //==========Click en añadir un antecedente========//
    $('#add_ante').click(function(e) {
        $("#descripcion_ante").removeAttr('style');
        e.preventDefault();

        if ($('#descripcion_ante').val() == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            
        } else {
            $.ajax({
                type: "POST",
                url: "../php/cita/cita-pac-dat.php",
                data: { id_cita },
                success: function(response) {

                    const nombre = JSON.parse(response).nombres_medi;
                    const apellido = JSON.parse(response).apellidos_medi;
                    const nom_ape = JSON.parse(response).sufijo + " " + nombre + " " + apellido;

                    addAnte(nom_ape, f_actual, $('#descripcion_ante').val());

                    //==============================Añadir los datos al arreglo definido arriba===============//
                    const dat = {
                        medico: nom_ape,
                        fecha: f_actual,
                        descripcion: $('#descripcion_ante').val()
                    };
                    console.log(dat);
                    antecedentes.push(dat);
                    console.log(antecedentes);
                    $('#descripcion_ante').val('');
                }
            });
        }

    });

 
    //===========================================Función añadir antecedente a la tabla recibiendo datos=====================================//
    function addAnte(me, fe, de) {
        const medico = me;
        const fecha = fe;
        const descripcion = de;
        $("#antecedentes_table>tbody").append(`<tr med_ante="${medico}" fech_ante="${fecha}" desc_ante="${descripcion}">
                                                    <td id='m_a'>${medico}</td>
                                                    <td id='f_a'>${fecha}</td>
                                                    <td id='d_a'>${descripcion}</td>
                                                    <td><button id='eliminar_ante' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///======== Botón de eliminar eantecedente=====/////
    $(document).on('click', '#eliminar_ante', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const medico = $(element).attr('med_ante');
        const fecha = $(element).attr('fech_ante');
        const descripcion = $(element).attr('desc_ante');

        const busqueda = JSON.stringify({
            medico: medico,
            fecha: fecha,
            descripcion: descripcion
        });

        let indice = antecedentes.findIndex(ante => JSON.stringify(ante) === busqueda);
        antecedentes.splice(indice, 1);
        $("#ante_body > tr").remove();

        cargarAntPrevios();
        antecedentes.forEach(ante => {
            addAnte(ante.medico, ante.fecha, ante.descripcion);
        });



    });
    //========================================================== CLOSE FUNCIONES DE LOS ANTECEDENTES======================================//


    //==========================================================FUNCIONES DE LOS ANTECEDENTES FAMILIARES======================================//
    //==========Cargar antecedentes a la tabla========//
    $.ajax({
        type: "POST",
        url: "../php/enfermedades-get.php",
        success: function(response) {
            const enfermedades = JSON.parse(response);
            let template = '<option selected="selected"></option>';
            enfermedades.forEach(enfermedad => {
                template += `
                    <option value="${enfermedad.id}">${enfermedad.nombre}</option>
                    `;
            });
            $('#select_enfermedad').html(template);
        }
    });

    cargarAntPreviosF();

    function cargarAntPreviosF() {
        $.ajax({
            type: "POST",
            url: "../php/antecedente_f/antecedente_f-get.php",
            async: false,
            data: { id_paciente },
            success: function(response) {
                const antecedentes = JSON.parse(response);
                antecedentes.forEach(ante => {
                    var desc;
                    if ((ante.descripcion) == null || (ante.descripcion) == null) {
                        desc = "N/A";
                    } else {
                        desc = ante.descripcion;
                    }

                    $("#antecedentesf_table>tbody").append(`<tr>
                                                                <td>${ante.nombre}</td>
                                                                <td>${ante.parentesco}</td>
                                                                <td>${desc}</td>
                                                                <td></td>
                                                            </tr>`);
                });
            }
        });
    }


    //==========Click en añadir un antecedente========//
    $('#add_antef').click(function(e) {
        e.preventDefault();

        if (($('#select_enfermedad').val() == 10 && $('#descripcion_antef').val() == "") || $('#select_enfermedad').val() == "" || $('#parentesco_antef').val() == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#select_enfermedad').val("");
            $('#descripcion_antef').val("");
            $('#parentesco_antef').val("");
        } else {

            const select = document.getElementById("select_enfermedad");
            const enfermedad = select.options[select.selectedIndex].text;

            addAnteF($('#select_enfermedad').val(), enfermedad, $('#parentesco_antef').val(), $('#descripcion_antef').val());

            //==============================Añadir los datos al arreglo definido arriba===============//
            const dat = {
                idEnf: $('#select_enfermedad').val(),
                enfermedad: enfermedad,
                parentesco: $('#parentesco_antef').val(),
                descripcion: $('#descripcion_antef').val()
            };
            console.log(dat);
            antecedentesf.push(dat);
            console.log(antecedentesf);
            $('#select_enfermedad').val("");
            $('#descripcion_antef').val("");
            $('#parentesco_antef').val("");
        }

    });


    //===========================================Función añadir antecedente a la tabla recibiendo datos=====================================//
    function addAnteF(id, en, pa, de) {
        const id_enf = id;
        const enfermedad = en;
        const parentesco = pa;
        const descripcion = de;
        $("#antecedentesf_table>tbody").append(`<tr idEnf="${id_enf}" enf_antef="${enfermedad}" paren_antef="${parentesco}" desc_antef="${descripcion}">
                                                    <td id='m_a'>${enfermedad}</td>
                                                    <td id='f_a'>${parentesco}</td>
                                                    <td id='d_a'>${descripcion}</td>
                                                    <td><button id='eliminar_antef' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///======== Botón de eliminar eantecedente=====/////
    $(document).on('click', '#eliminar_antef', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id = $(element).attr('idEnf');
        const enfermedad = $(element).attr('enf_antef');
        const parentesco = $(element).attr('paren_antef');
        const descripcion = $(element).attr('desc_antef');

        const busqueda = JSON.stringify({
            idEnf: id,
            enfermedad: enfermedad,
            parentesco: parentesco,
            descripcion: descripcion
        });

        let indice = antecedentesf.findIndex(ante => JSON.stringify(ante) === busqueda);
        antecedentesf.splice(indice, 1);
        $("#antef_body > tr").remove();

        cargarAntPreviosF();
        antecedentesf.forEach(ante => {
            addAnteF(ante.idEnf, ante.enfermedad, ante.parentesco, ante.descripcion);
        });
        console.log(antecedentesf);



    });
    //========================================================== CLOSE FUNCIONES DE LOS ANTECEDENTES FAMILIARES======================================//



    //==========================================================FUNCIONES DE LOS SIGNOS VITALES===================================================//

    //==========Click en añadir un antecedente========//
    $('#add_signosva').click(function(e) {
        e.preventDefault();
        const temperatura = $('#temperatura').val();
        const presion_as = $('#presion_as').val();
        const presion_ad = $('#presion_ad').val();
        const pulso = $('#pulso').val();
        const frecuencia_r = $('#frecuencia_r').val();
        const frecuencia_c = $('#frecuencia_c').val();
        const sat_o = $('#sat_o').val();
        const peso = $('#peso').val();
        const talla = $('#talla').val();

        if (temperatura == "" || presion_as == "" || presion_ad == "" || pulso == "" || frecuencia_r == "" || frecuencia_c == "" || sat_o == "" || peso == "" || talla == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {

                addSignosVA(f_actual, temperatura, presion_as, presion_ad, pulso, frecuencia_r,frecuencia_c,sat_o, peso, talla);
                //==============================Añadir los datos al arreglo definido arriba===============//
                const dat = {
                    fecha: f_actual,
                    temperatura: temperatura,
                    presion_as: presion_as,
                    presion_ad: presion_ad,
                    pulso: pulso,
                    frecuencia_r: frecuencia_r,
                    frecuencia_c: frecuencia_c,
                    sat_o: sat_o,
                    peso: peso,
                    talla: talla
                };
                console.log(dat);
                signosva.push(dat);
                console.log(signosva);
                cont_sva += 1;
                if (cont_sva == 4) {
                    $("#btn_sva").hide();
                }else{
                    $("#btn_sva").show();
                }
                console.log(cont_sva);
                $('#temperatura').val('');
                $('#presion_as').val('');
                $('#presion_ad').val('');
                $('#pulso').val('');
                $('#frecuencia_r').val('');
                $('#frecuencia_c').val('');
                $('#sat_o').val('');
                $('#peso').val('');
                $('#talla').val('');
        }

    });

    //==========Función IMC========//
    function imcAdultos(imc){
        const imcA = Number(imc);
        var color;
        if (imcA < 18.5) {
            color = "#3a859a";
        }
        if ((imcA >= 18.5) && (imcA <= 24.9)) {
            color = "#2ec6b7";
        }
        if ((imcA >= 25) && (imcA <= 29.9)) {
            color = "#f39f95";
        }
        if (imcA >= 30) {
            color = "#d34b4d";
        }
        console.log(color + ' funcion');
        return color;
    } 


    //===========================================Función añadir antecedente a la tabla recibiendo datos=====================================//
    $.ajax({
        type: "POST",
        url: "../php/cita/cita-read-id.php",
        data: {id_cita},
        async: false,
        success: function (response) {
            const id_caso = JSON.parse(response).id_caso;
            $.ajax({
                type: "POST",
                url: "../php/paciente/paciente-list-comp.php",
                data: { id_paciente },
                success: function(response) {
                    const paciente = JSON.parse(response);
                    const edad = Number(calcularEdad(paciente.fechan_paci).substr(0,2));
                    console.log(edad);
                    $.ajax({ 
                        type: "POST",
                        url: "../php/signov_ant/signov_ant-get-c.php",
                        data: { id_caso },
                        success: function(response) {
                            const signosv_ant = JSON.parse(response);
                            cont_sva += signosv_ant.length;
                            console.log(cont_sva);
                            if (cont_sva == 4) {
                                $("#btn_sva").hide();
                            }else{
                                $("#btn_sva").show();
                            }
                            signosv_ant.forEach(sva => {
                                var imc = 0;
                                var color="";
                                var c_txt ="";
                                if (edad>=18) {
                                    if (sva.peso == "" || sva.peso == NaN || sva.peso == null || sva.peso == 0 || sva.talla == "" || sva.talla == NaN || sva.talla == null || sva.talla == 0) {
                                        imc = 0;
                                    }else{
                                        imc = imc = (sva.peso/(Math.pow((sva.talla/100),2))).toFixed(2);
                                        color = imcAdultos(imc);
                                        c_txt ="white";
                                    }
                                }else{
                                    imc = 0;
                                }
                                $("#hsva_table>tbody").append(`<tr>
                                                                <td>${sva.fecha}</td>
                                                                <td>${sva.temperatura} °C</td>
                                                                <td>${sva.presion_as}/${sva.presion_ad}</td>
                                                                <td>${sva.pulso}</td>
                                                                <td>${sva.frecuencia_r}</td>
                                                                <td>${sva.frecuencia_c}</td>
                                                                <td>${sva.sat_o}%</td>
                                                                <td>${sva.peso}kg</td>
                                                                <td>${sva.talla}cm</td>
                                                                <td style="background-color: ${color}; color: ${c_txt}">${imc}</td>
                                                            </tr>`);
                            });
                        }
                    });
                }
            });
        }
    });

    $("#btn_hsva").click(function (e) { 
        e.preventDefault();      
        $("#modalSva").modal("show");
    });

    function addSignosVA(fe, te, pas,pad, pu, fr,fc,so, p, t) {
        const fecha = fe;
        const temperatura = te;
        const presion_as = pas;
        const presion_ad = pad;
        const pulso = pu;
        const frecuencia_r = fr;
        const frecuencia_c = fc;
        const sat_o = so;
        var peso = 0;
        if (p == "" || p == NaN || p == null || p == 0) {
            peso = 0;
        }else{
            peso = p;
        }
        var talla = 0;
        if (t == "" || t == NaN || t == null || t == 0) {
            talla = 0;
        }else{
            talla = t;
        }

        const edad = Number($("#edad_paci").html().substr(0,2));
        var imc = 0;
        var color="";
        var c_txt ="";
        if (edad>=18) {
            if (p == "" || p == NaN || p == null || p == 0 || t == "" || t == NaN || t == null || t == 0) {
                imc = 0;
            }else{
                imc = imc = (p/(Math.pow((t/100),2))).toFixed(2);
                color = imcAdultos(imc);
                c_txt ="white";
            }
        }else{
            imc = 0;
        }

        

        

        $("#signosva_table>tbody").append(`<tr fe_sva="${fecha}" te_sva="${temperatura}" pas_sva="${presion_as}" pad_sva="${presion_ad}" pu_sva="${pulso}" fr_sva="${frecuencia_r}" fc_sva="${frecuencia_c}" so_sva="${sat_o}" p_sva="${peso}" t_sva="${talla}">
                                                    <td id='fe'>${fecha}</td>
                                                    <td id='te'>${temperatura} °C</td>
                                                    <td id='pa'>${presion_as}/${presion_ad}</td>
                                                    <td id='pu'>${pulso}</td>
                                                    <td id='fr'>${frecuencia_r}</td>
                                                    <td id='fc'>${frecuencia_c}</td>
                                                    <td id='so'>${sat_o}%</td>
                                                    <td id='p'>${peso}kg</td>
                                                    <td id='t'>${talla}cm</td>
                                                    <td id='imc' style="background-color: ${color}; color: ${c_txt}">${imc}</td>
                                                    <td><button id='eliminar_sva' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///======== Botón de eliminar eantecedente=====/////
    $(document).on('click', '#eliminar_sva', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const fecha = $(element).attr('fe_sva');
        const temperatura = $(element).attr('te_sva');
        const presion_as = $(element).attr('pas_sva');
        const presion_ad = $(element).attr('pad_sva');
        const pulso = $(element).attr('pu_sva');
        const frecuencia_r = $(element).attr('fr_sva');
        const frecuencia_c = $(element).attr('fc_sva');
        const sat_o = $(element).attr('so_sva');
        const peso = $(element).attr('p_sva');
        const talla = $(element).attr('t_sva');

        const busqueda = JSON.stringify({
            fecha: fecha,
            temperatura: temperatura,
            presion_as: presion_as,
            presion_ad: presion_ad,
            pulso: pulso,
            frecuencia_r: frecuencia_r,
            frecuencia_c: frecuencia_c,
            sat_o: sat_o,
            peso: peso,
            talla: talla
        });

        let indice = signosva.findIndex(sva => JSON.stringify(sva) === busqueda);
        signosva.splice(indice, 1);
        $("#signosva_body > tr").remove();
        cont_sva -= 1;
        if (cont_sva == 4) {
            $("#btn_sva").hide();
        }else{
            $("#btn_sva").show();
        }
        signosva.forEach(sva => {
            addSignosVA(sva.fecha, sva.temperatura, sva.presion_as, sva.presion_ad, sva.pulso, sva.frecuencia_r, sva.frecuencia_c, sva.sat_o, sva.peso, sva.talla);
        });



    });
    //========================================================== CLOSE FUNCIONES DE LOS SIGNOS VITALES======================================//


    //==========================================================FUNCIONES DIAGNOSTICO===================================================//
    //==========Cargar alergias a la tabla========//
    cargarDiagPrevios();

    function cargarDiagPrevios() {
        $.ajax({
            type: "POST",
            url: "../php/cita/cita-read-id.php",
            data: {id_cita},
            async: false,
            success: function (response) {
                const id_caso = JSON.parse(response).id_caso;
                $.ajax({
                    type: "POST",
                    url: "../php/diagnostico/diagnostico-get.php",
                    async: false,
                    data: { id_caso },
                    success: function(response) {
                        const diagnosticos = JSON.parse(response);
                        cont_diag += diagnosticos.length;
                        if (cont_diag == 4) {
                            $("#add_diag_modal").hide();
                        }else{
                            $("#add_diag_modal").show();
                        }
                        if (diagnosticos.length != 0 ) {                        
                            diagnosticos.forEach(diag => {
                                if (diag.pre_def == 0) {
                                    $("#diagnostico_table>tbody").append(`<tr>
                                                                            <td>${diag.sufijo} ${diag.nombres_medi} ${diag.apellidos_medi}</td>
                                                                            <td>${diag.fecha}</td>
                                                                            <td>${diag.descripcion}</td>
                                                                            <td>${diag.clave}</td>
                                                                            <td>X</td>
                                                                            <td></td>
                                                                            <td></td>
                                                                        </tr>`);
                                }
                                if (diag.pre_def == 1) {
                                    $("#diagnostico_table>tbody").append(`<tr>
                                                                            <td>${diag.sufijo} ${diag.nombres_medi} ${diag.apellidos_medi}</td>
                                                                            <td>${diag.fecha}</td>
                                                                            <td>${diag.descripcion}</td>
                                                                            <td>${diag.clave}</td>
                                                                            <td></td>
                                                                            <td>X</td>
                                                                            <td></td>
                                                                        </tr>`);
                                }
                            });
                        }
                    }
                });
            }
        });
    }

    //==========Cargar cie10 a la tabla========//
    $("#add_diag_modal").click(function (e) { 
        e.preventDefault();
        $("#modalDiagnostico").modal('show');;
        cargarCIE();
    });

    $("#select_diagnos").change(function() {
        var id = $(this).val();
        if (id!=0) {
            $.ajax({
                type: "POST",
                url: "../php/cie-get-id.php",
                data: {id},
                success: function (response) {
                    const clave = JSON.parse(response).clave;
                    $("#cie").val(clave);
                }
            });
        }else{
            $("#cie").val("");
        }
        
    });

    function cargarCIE(){
        $.ajax({
            async: false,
            url: '../php/cie10diag-get.php',
            type: 'POST',
            success: function(response) {
                const cie10 = JSON.parse(response);
                let template = '<option selected="selected" value="0">Seleccione una opción</option>';
                cie10.forEach(c => {
                    template += `
                                <option value="${c.id}">${c.descripcion}</option>
                                `;
                });
                $('#select_diagnos').html(template);
            }
        });
    }
    
    //========Busqueda en la tabla de CIE=====
    $("#busc_cie").keyup(function() {
        $("#select_diagnos").empty();
        const descripcion = $("#busc_cie").val();
        $.ajax({
            type: "POST",
            url: "../php/cie-get-like.php",
            data: {descripcion},
            success: function (response) {
                const cies = JSON.parse(response);
                let template = '<option selected="selected" value="0">Seleccione una opción</option>';
                cies.forEach(c => {
                    template += `
                                <option value="${c.id}">${c.descripcion}</option>
                                `;
                });
                $('#select_diagnos').html(template);
            }
        });
    });

    $('#modalDiagnostico').on('hidden.bs.modal', function (e) {
        $('#select_diagnos').val(0);
        $('#cie').val("");
        $('#busc_cie').val("");
        $('#select_t_diagnostico').val(0);
    })

    //==========Click en añadir un diagnostico========//
    $('#add_diag').click(function(e) {
        e.preventDefault(); 
        if (($('#select_diagnos').val() == "" || $('#select_diagnos').val() == 0) || $('#cie').val() == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#select_diagnos').val("");
            $('#cie').val("");
            $('#busc_cie').val("");
            $('#select_t_diagnostico').val(0);
        } else {

            const select = document.getElementById("select_diagnos");
            const cie10txt = select.options[select.selectedIndex].text;

            addDiagnostico($('#select_diagnos').val(), cie10txt, $('#select_t_diagnostico').val(), $('#cie').val());

            //==============================Añadir los datos al arreglo definido arriba===============//
            const dat = {
                idCie: $('#select_diagnos').val(),
                diagnos: cie10txt,
                t_diagnostico: $('#select_t_diagnostico').val(),
                cie10: $('#cie').val()
            };
            console.log(dat);
            diagnosticos.push(dat);
            console.log(diagnosticos);
            cont_diag += 1;
            $("#add_diag_modal").attr('disabled', 'disabled');
            if (cont_diag == 4) {
                $("#add_diag_modal").hide();
            }else{
                $("#add_diag_modal").show();
            }
            $('#select_diagnos').val("");
            $('#cie').val("");
            $('#busc_cie').val("");
            $('#select_t_diagnostico').val(0);
        }
    });


    //===========================================Función añadir antecedente a la tabla recibiendo datos=====================================//
    function addDiagnostico(id, diag, t_diag, cie) {
        const id_cie = id;
        const cie10 = cie;
        const t_diagnostico = t_diag;
        const diagnos = diag;
        $.ajax({
            type: "POST",
            url: "../php/cita/cita-pac-dat.php",
            data: { id_cita },
            success: function(response) {
                const nombre = JSON.parse(response).nombres_medi;
                const apellido = JSON.parse(response).apellidos_medi;
                const nom_ape = JSON.parse(response).sufijo + " " + nombre + " " + apellido;
                if (t_diag == 0) {
                    $("#diagnostico_table>tbody").append(`<tr id_cie="${id_cie}" cie10="${cie10}" t_diagnostico="${t_diagnostico}" diagnos="${diagnos}">
                                                            <td id='n_a'>${nom_ape}</td>
                                                            <td id='f_a'>${f_actual}</td>
                                                            <td id='id_c'>${diagnos}</td>
                                                            <td id='c10'>${cie10}</td>
                                                            <td id='t_d'>X</td>
                                                            <td></td>
                                                            <td><button id='eliminar_diag' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                        </tr>`);
                }
                if (t_diag == 1) {
                    $("#diagnostico_table>tbody").append(`<tr id_cie="${id_cie}" cie10="${cie10}" t_diagnostico="${t_diagnostico}"  diagnos="${diagnos}">
                                                            <td id='n_a'>${nom_ape}</td>  
                                                            <td id='f_a'>${f_actual}</td>                                      
                                                            <td id='id_c'>${diagnos}</td>
                                                            <td id='c10'>${cie10}</td>
                                                            <td></td>
                                                            <td id='t_d'>X</td>
                                                            <td><button id='eliminar_diag' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                        </tr>`);
                }           
            }
        });

    }

    ///======== Botón de eliminar diagnostico=====/////
    $(document).on('click', '#eliminar_diag', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const idCie = $(element).attr('id_cie');
        const cie10 = $(element).attr('cie10');
        const t_diagnostico = $(element).attr('t_diagnostico');
        const diagnos = $(element).attr('diagnos');

        const busqueda = JSON.stringify({
            idCie: idCie,
            diagnos: diagnos,
            t_diagnostico: t_diagnostico,
            cie10: cie10
        });

        let indice = diagnosticos.findIndex(diag => JSON.stringify(diag) === busqueda);
        diagnosticos.splice(indice, 1);
        $("#diagnostico_body > tr").remove();

        cargarDiagPrevios();
        cont_diag -= 1;
        $("#add_diag_modal").removeAttr('disabled');
        if (cont_diag == 4) {
            $("#add_diag_modal").hide();
        }else{
            $("#add_diag_modal").show();
        }
        diagnosticos.forEach(diag => {
            addDiagnostico(diag.idCie, diag.diagnos, diag.t_diagnostico, diag.cie10);
        });
        console.log(diagnosticos);



    });

    //========================================================== CLOSE DIAGNOSTICO======================================//



    //==========================================================FUNCIONES DE LAS ALERGIAS======================================//
    //==========Cargar alergias a la tabla========//
    cargarAlePrevias();

    function cargarAlePrevias() {
        $.ajax({
            type: "POST",
            url: "../php/alergia/alergia-get.php",
            async: false,
            data: { id_paciente },
            success: function(response) {
                const alergias = JSON.parse(response);
                if (alergias.length != 0 ) {
                    $("#alergias_table > tbody").attr('style', 'background: #e82727; color: white;');
                }
                alergias.forEach(aler => {
                    const nombre = aler.nombres_medi;
                    const apellido = aler.apellidos_medi;
                    const nom_ape = aler.sufijo + " " + nombre + " " + apellido;
                    $("#alergias_table>tbody").append(`<tr>
                                                                <td>${nom_ape}</td>
                                                                <td>${aler.fecha}</td>
                                                                <td>${aler.descripcion}</td>
                                                                <td></td>
                                                            </tr>`);
                });
            }
        });
    }


    //==========Click en añadir una alergia========//
    $('#add_aler').click(function(e) {
        $("#descripcion_aler").removeAttr('style');
        e.preventDefault();

        if ($('#descripcion_aler').val() == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            
        } else {
            $.ajax({
                type: "POST",
                url: "../php/cita/cita-pac-dat.php",
                data: { id_cita },
                success: function(response) {

                    const nombre = JSON.parse(response).nombres_medi;
                    const apellido = JSON.parse(response).apellidos_medi;
                    const nom_ape = JSON.parse(response).sufijo + " " + nombre + " " + apellido;

                    addAler(nom_ape, f_actual, $('#descripcion_aler').val());

                    //==============================Añadir los datos al arreglo definido arriba===============//
                    const dat = {
                        medico: nom_ape,
                        fecha: f_actual,
                        descripcion: $('#descripcion_aler').val()
                    };
                    console.log(dat);
                    alergias.push(dat);
                    console.log(alergias);
                    $('#descripcion_aler').val('');
                }
            });
        }

    });

 
    //===========================================Función añadir alergias la tabla recibiendo datos=====================================//
    function addAler(me, fe, de) {
        const medico = me;
        const fecha = fe;
        const descripcion = de;
        $("#alergias_table>tbody").append(`<tr med_aler="${medico}" fech_aler="${fecha}" desc_aler="${descripcion}">
                                                    <td id='m_a'>${medico}</td>
                                                    <td id='f_a'>${fecha}</td>
                                                    <td id='d_a'>${descripcion}</td>
                                                    <td><button id='eliminar_aler' style="color: #fff" class="btn btn-primary btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///======== Botón de eliminar alergia=====/////
    $(document).on('click', '#eliminar_aler', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const medico = $(element).attr('med_aler');
        const fecha = $(element).attr('fech_aler');
        const descripcion = $(element).attr('desc_aler');

        const busqueda = JSON.stringify({
            medico: medico,
            fecha: fecha,
            descripcion: descripcion
        });

        let indice = alergias.findIndex(aler => JSON.stringify(aler) === busqueda);
        alergias.splice(indice, 1);
        $("#aler_body > tr").remove();

        cargarAlePrevias();
        alergias.forEach(aler => {
            addAler(aler.medico, aler.fecha, aler.descripcion);
        });



    });
    //========================================================== CLOSE FUNCIONES DE LAS ALERGIAS======================================//




    //==========================================================FUNCIONES DE PLANES DE TRATAMIENTO===================================================//

    $("#add_medicamento").click(function (e) { 
        e.preventDefault();
        $("#modalTratamiento").modal('show');
    });

    //==========Click en añadir un plan de tratamiento========//
    $('#add_pt').click(function(e) {
        e.preventDefault();
        const d_medicamento = $('#d_medicamento').val();
        const via_a = $('#select_via_a').val();
        const c_medicamento = $('#c_medicamento').val();
        const indicaciones = $('#indicaciones').val();

        if (d_medicamento == "" || (c_medicamento == "" || c_medicamento == 0 || c_medicamento == NaN) || indicaciones == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
                /* Para obtener el texto */
                const select = document.getElementById("select_via_a");
                const via_a_txt = select.options[select.selectedIndex].text;

                addPT(d_medicamento, via_a, via_a_txt, c_medicamento, indicaciones);

                //==============================Añadir los datos al arreglo definido arriba===============//
                const dat = {
                    d_medicamento: d_medicamento,
                    via_a: via_a,
                    via_a_txt: via_a_txt,
                    c_medicamento: c_medicamento,
                    indicaciones: indicaciones
                };
                console.log(dat);
                plan_t.push(dat);
                console.log(plan_t);
                $('#d_medicamento').val('');
                $('#select_via_a').val(0);
                $('#c_medicamento').val('');
                $('#indicaciones').val('');
        }

    });


    //===========================================Función añadir plan de tratamiento a la tabla recibiendo datos=====================================//
    function addPT(dm, va, vat,cm, i) {
        const d_medicamento = dm;
        const via_a = va;
        const via_a_txt = vat;
        const c_medicamento = cm;
        const indicaciones = i;

        $("#medicamento_table>tbody").append(`<tr dm="${d_medicamento}" va="${via_a}" vat="${via_a_txt}" cm="${c_medicamento}" in="${indicaciones}">
                                                    <td>${d_medicamento}</td>
                                                    <td>${via_a_txt}</td>
                                                    <td>${c_medicamento}</td>
                                                    <td>${indicaciones}</td>
                                                    <td><button id='eliminar_pt' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///======== Botón de eliminar eantecedente=====/////
    $(document).on('click', '#eliminar_pt', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const d_medicamento = $(element).attr('dm');
        const via_a = $(element).attr('va');
        const via_a_txt = $(element).attr('vat');
        const c_medicamento = $(element).attr('cm');
        const indicaciones = $(element).attr('in');

        const busqueda = JSON.stringify({
            d_medicamento: d_medicamento,
            via_a: via_a,
            via_a_txt: via_a_txt,
            c_medicamento: c_medicamento,
            indicaciones: indicaciones
        });

        let indice = plan_t.findIndex(sva => JSON.stringify(sva) === busqueda);
        plan_t.splice(indice, 1);
        $("#medicamento_body > tr").remove();

        plan_t.forEach(pt => {
            addPT(pt.d_medicamento, pt.via_a, pt.via_a_txt, pt.c_medicamento, pt.indicaciones);
        });
    });
    //========================================================== CLOSE FUNCIONES DE PLANES DE TRATAMIENTO======================================//



    //===================================================Click en añadir un adicional====================================//
    $('#add_adicional').click(function(e) {
        e.preventDefault();
        const id_servicio = $('#select_servicio').val();
        const descripcion = $('#descripcion').val();
        const costo = $('#costo').val();

        if (id_servicio == "" || descripcion == "" || costo == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#select_servicio').val('');
            $('#descripcion').val('');
            $('#costo').val('');
        } else {
            /* Para obtener el texto */
            const select = document.getElementById("select_servicio");
            const servicio = select.options[select.selectedIndex].text;
            
            addAdic(id_servicio,servicio,descripcion,costo);
            //==============================Añadir los datos al arreglo definido arriba===============//
            const dat = {
                id_servicio: id_servicio,
                servicio: servicio,
                descripcion: descripcion,
                costo: costo
            };
            console.log(dat);
            adicionales.push(dat);
            console.log(adicionales);

            $('#select_servicio').val('');
            $('#descripcion').val('');
            $('#costo').val('');
        }

    });
    
    //===========================================Función añadir plan de tratamiento a la tabla recibiendo datos=====================================//
    function addAdic(idS, tS, dAdd, cAdd) {
        const id_servicio = idS;
        const servicio = tS;
        const descripcion = dAdd;
        const costo = cAdd;

        $("#adicionales_table>tbody").append(`<tr idS='${id_servicio}' tS='${servicio}' dAdd='${descripcion}' cAdd='${costo}'>
                                                    <td>${servicio}</td>
                                                    <td>${descripcion}</td>
                                                    <td>${costo}</td>
                                                    <td><button id='eliminar_adic' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///======== Botón de eliminar adicional=====/////
    $(document).on('click', '#eliminar_adic', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_servicio = $(element).attr('idS');
        const servicio = $(element).attr('tS');
        const descripcion = $(element).attr('dAdd');
        const costo = $(element).attr('cAdd');

        const busqueda = JSON.stringify({
            id_servicio: id_servicio,
            servicio: servicio,
            descripcion: descripcion,
            costo: costo
        });

        let indice = adicionales.findIndex(adic => JSON.stringify(adic) === busqueda);
        adicionales.splice(indice, 1);
        $("#adicionales_body > tr").remove();

        adicionales.forEach(a => {
            addAdic(a.id_servicio, a.servicio, a.descripcion, a.costo);
        });
    });
    
    
    //===================================================BOTÓN PARA GUARDAR TODOS LOS DATOS EN LA BASE DE DATOS====================================//
    $("#btn_guardar").click(function(e) {
        e.preventDefault();
        //Almacenar el id del médico en variable
        const id_medico = JSON.parse($.ajax({
            type: "POST",
            url: '../php/cita/cita-pac-dat.php',
            data: { id_cita },
            global: false,
            async: false,
            success: function(response) {
                return response;
            }
        }).responseText).id_medico;
 
        //Almacenar el id del caso en variable
        const id_caso = JSON.parse($.ajax({
            type: "POST",
            url: '../php/cita/cita-pac-dat.php',
            data: { id_cita },
            global: false,
            async: false,
            success: function(response) {
                return response;
            }
        }).responseText).id_caso;

        if ((($("#motivo_consulta").val() == "")&&(!$("#motivo_consulta").attr('disabled'))) || (($("#problema_actual").val() == "")&&(!$("#problema_actual").attr('disabled'))) || signosva.length == 0 || cont_diag == 0) {
            $('#texto_modal').html('Ingrese los valores obligatorios: Motivo de Consulta, Enfermedad, Signos Vitales, Diagnóstico');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
             //Guardar datos del descuento
             $.ajax({
                 type: "POST",
                 url: "../php/cita/cita-pac-dat.php",
                 data: { id_cita },
                 success: function(response) {
                     const tarifa = Number(JSON.parse(response).tarifa);
                     const descuento = Number($("#descuento").val());

                     if (descuento > tarifa) {
                         $('#texto_modal').html('El descuento no puede ser mayor que la tarifa');
                         $('#modal_icon').attr('style', "color: orange");
                         $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                         $('#modalPush').modal("show");
                     } else {
                         //====Añadir el descuento a la cita=====//
                         if (descuento != "") {
                             const dataDesc = {
                                 id_cita: id_cita,
                                 descuento: descuento
                             };
                             $.ajax({
                                 type: "POST",
                                 url: "../php/cita/cita-descuento.php",
                                 data: dataDesc,
                                 success: function(response) {
                                     console.log(response);
                                 }
                             });
                         }

                         //Guardar Antecedentes personales si existen
                        if (antecedentes.length > 0) {
                            antecedentes.forEach(a => {
                                const anteP = {
                                    descripcion: a.descripcion,
                                    fecha: a.fecha,
                                    id_paciente: id_paciente,
                                    id_medico: id_medico
                                };

                                $.ajax({
                                    type: "POST",
                                    url: "../php/antecedente_p/antecedente_p-add.php",
                                    data: anteP,
                                    success: function (response) {
                                        console.log(response);
                                    }
                                });
                            });
                        }
                        //Guardar Antecedentes familiares si existen
                        if (antecedentesf.length > 0) {
                            antecedentesf.forEach(af => {
                                const anteF = {
                                    parentesco: af.parentesco,
                                    descripcion: af.descripcion,
                                    id_paciente: id_paciente,
                                    id_enfermedad: af.idEnf
                                };

                                $.ajax({
                                    type: "POST",
                                    url: "../php/antecedente_f/antecedente_f-add.php",
                                    data: anteF,
                                    success: function (response) {
                                        console.log(response);
                                    }
                                });
                            });
                        }

                        //Guardar datos del caso (Motivo de la Consulta, Problema Actual)
                        const datCaso = {
                            motivo_con: $("#motivo_consulta").val(),
                            problema_act: $("#problema_actual").val(),
                            id_caso: id_caso
                        };

                        $.ajax({
                            type: "POST",
                            url: "../php/caso/mc-pa-add.php",
                            data: datCaso,
                            success: function (response) {
                                console.log(response);
                            }
                        });

                        //Almacenar la revisión actual de órganos y sistemas
                        $.ajax({
                            type: "POST",
                            url: "../php/cita/cita-read-id.php",
                            async: false,
                            data: {id_cita},
                            success: function (response) {
                                const tipo_cita = Number(JSON.parse(response).tipo_cita);
                                if (tipo_cita == 1) {
                                    var cp_organos = 0;
                                    if (!$("#organos_i").attr('disabled')) {
                                        cp_organos = 1;
                                    }
                                    const dat_organos = {
                                        orga_sist: 'Órganos de los sentidos',
                                        cp: cp_organos,
                                        descripcion: $("#organos_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_respiratorio = 0;
                                    if (!$("#respiratorio_i").attr('disabled')) {
                                        cp_respiratorio = 1;
                                    }
                                    const dat_respiratorio = {
                                        orga_sist: 'Respiratorio',
                                        cp: cp_respiratorio,
                                        descripcion: $("#respiratorio_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_cardiov = 0;
                                    if (!$("#cardiov_i").attr('disabled')) {
                                        cp_cardiov = 1;
                                    }
                                    const dat_cardiov = {
                                        orga_sist: 'Cardio vascular',
                                        cp: cp_cardiov,
                                        descripcion: $("#cardiov_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_digestivo = 0;
                                    if (!$("#digestivo_i").attr('disabled')) {
                                        cp_digestivo = 1;
                                    }
                                    const dat_digestivo = {
                                        orga_sist: 'Digestivo',
                                        cp: cp_digestivo,
                                        descripcion: $("#digestivo_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_genital = 0;
                                    if (!$("#genital_i").attr('disabled')) {
                                        cp_genital = 1;
                                    }
                                    const dat_genital = {
                                        orga_sist: 'Genital',
                                        cp: cp_genital,
                                        descripcion: $("#genital_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_urinario = 0;
                                    if (!$("#urinario_i").attr('disabled')) {
                                        cp_urinario = 1;
                                    }
                                    const dat_urinario = {
                                        orga_sist: 'Urinario',
                                        cp: cp_urinario,
                                        descripcion: $("#urinario_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_musculoe = 0;
                                    if (!$("#musculoe_i").attr('disabled')) {
                                        cp_musculoe = 1;
                                    }
                                    const dat_musculoe = {
                                        orga_sist: 'Músculo esquelético',
                                        cp: cp_musculoe,
                                        descripcion: $("#musculoe_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_endocrino = 0;
                                    if (!$("#endocrino_i").attr('disabled')) {
                                        cp_endocrino = 1;
                                    }
                                    const dat_endocrino = {
                                        orga_sist: 'Endocrino',
                                        cp: cp_endocrino,
                                        descripcion: $("#endocrino_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_hemol = 0;
                                    if (!$("#hemol_i").attr('disabled')) {
                                        cp_hemol = 1;
                                    }
                                    const dat_hemol = {
                                        orga_sist: 'Hemo linfático',
                                        cp: cp_hemol,
                                        descripcion: $("#hemol_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_nervioso = 0;
                                    if (!$("#nervioso_i").attr('disabled')) {
                                        cp_nervioso = 1;
                                    }
                                    const dat_nervioso = {
                                        orga_sist: 'Nervioso',
                                        cp: cp_nervioso,
                                        descripcion: $("#nervioso_i").val(),
                                        id_cita: id_cita
                                    }

                                    const revision_os = [dat_organos,dat_respiratorio,dat_cardiov,dat_digestivo,dat_genital,dat_urinario,dat_musculoe,dat_endocrino,dat_hemol,dat_nervioso];

                                    revision_os.forEach(os => {
                                        const datOS = {
                                            orga_sist: os.orga_sist,
                                            cp: os.cp,
                                            descripcion: os.descripcion,
                                            id_cita: id_cita
                                        };

                                        $.ajax({
                                            type: "POST",
                                            url: "../php/revision_o_s/revision_o_s-add.php",
                                            data: datOS,
                                            success: function (response) {
                                                console.log(response);
                                            }
                                        });
                                    });
                                }
                            }
                        });
                        
                        //Almacenar los signos vitales y antropometría
                        signosva.forEach(sva => {
                            const datSVA = {
                                fecha: f_actual,
                                temperatura: sva.temperatura,
                                presion_as: sva.presion_as,
                                presion_ad: sva.presion_ad,
                                pulso: sva.pulso,
                                frecuencia_r: sva.frecuencia_r,
                                frecuencia_c: sva.frecuencia_c,
                                sat_o: sva.sat_o,
                                peso: sva.peso,
                                talla: sva.talla,
                                id_cita: id_cita
                            };
                            $.ajax({
                                type: "POST",
                                url: "../php/signov_ant/signov_ant-add.php",
                                data: datSVA,
                                success: function (response) {
                                    console.log(response);
                                }
                            });
                        });

                        //Almacenar lo del Exámen físico regional
                        $.ajax({
                            type: "POST",
                            url: "../php/cita/cita-read-id.php",
                            async: false,
                            data: {id_cita},
                            success: function (response) {
                                const tipo_cita = Number(JSON.parse(response).tipo_cita);
                                if (tipo_cita == 1) {
                                    var cp_cabeza = 0;
                                    if (!$("#cabeza_i").attr('disabled')) {
                                        cp_cabeza = 1;
                                    }
                                    const dat_cabeza = {
                                        examen_fr: 'Cabeza',
                                        cp: cp_cabeza,
                                        descripcion: $("#cabeza_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_cuello = 0;
                                    if (!$("#cuello_i").attr('disabled')) {
                                        cp_cuello = 1;
                                    }
                                    const dat_cuello = {
                                        examen_fr: 'Cuello',
                                        cp: cp_cuello,
                                        descripcion: $("#cuello_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_torax = 0;
                                    if (!$("#torax_i").attr('disabled')) {
                                        cp_torax = 1;
                                    }
                                    const dat_torax = {
                                        examen_fr: 'Tórax',
                                        cp: cp_torax,
                                        descripcion: $("#torax_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_abdomen = 0;
                                    if (!$("#abdomen_i").attr('disabled')) {
                                        cp_abdomen = 1;
                                    }
                                    const dat_abdomen = {
                                        examen_fr: 'Abdomen',
                                        cp: cp_abdomen,
                                        descripcion: $("#abdomen_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_pelvis = 0;
                                    if (!$("#pelvis_i").attr('disabled')) {
                                        cp_pelvis = 1;
                                    }
                                    const dat_pelvis = {
                                        examen_fr: 'Pelvis',
                                        cp: cp_pelvis,
                                        descripcion: $("#pelvis_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_extremidades = 0;
                                    if (!$("#extremidades_i").attr('disabled')) {
                                        cp_extremidades = 1;
                                    }
                                    const dat_extremidades = {
                                        examen_fr: 'Extremidades',
                                        cp: cp_extremidades,
                                        descripcion: $("#extremidades_i").val(),
                                        id_cita: id_cita
                                    }

                                    const efr = [dat_cabeza,dat_cuello,dat_torax,dat_abdomen,dat_pelvis,dat_extremidades];

                                    efr.forEach(e => {
                                        const datEfr = {
                                            examen_fr: e.examen_fr,
                                            cp: e.cp,
                                            descripcion: e.descripcion,
                                            id_cita: id_cita
                                        };
                                        $.ajax({
                                            type: "POST",
                                            url: "../php/examen_fr/examen_fr-add.php",
                                            data: datEfr,
                                            success: function (response) {
                                                console.log(response);
                                            }
                                        });
                                    });
                                }
                            }
                        });

                        //Almacenar diagnóstico
                        diagnosticos.forEach(d => {
                            const datDiag = {
                                descripcion: d.diagnos,
                                pre_def: d.t_diagnostico,
                                id_cie: d.idCie,
                                id_cita: id_cita
                            };
                            $.ajax({
                                type: "POST",
                                url: "../php/diagnostico/diagnostico-add.php",
                                data: datDiag,
                                success: function (response) {
                                    console.log(response);
                                }
                            });
                        });

                        //Almacenar alergias
                        if (alergias.length > 0) {
                            alergias.forEach(a => {
                                const datAler = {
                                    fecha: a.fecha,
                                    descripcion: a.descripcion,
                                    id_medico: id_medico,
                                    id_paciente: id_paciente
                                };

                                $.ajax({
                                    type: "POST",
                                    url: "../php/alergia/alergia-add.php",
                                    data: datAler,
                                    success: function (response) {
                                        console.log(response);
                                    }
                                });
                            });
                        }

                        //Almacenar plan de tratamiento
                        if (plan_t.length > 0) {
                            plan_t.forEach(p => {
                                const datPT = {
                                    datos_m: p.d_medicamento,
                                    via_a: p.via_a_txt,
                                    cantidad: p.c_medicamento,
                                    indicaciones: p.indicaciones,
                                    id_cita: id_cita
                                };
                                console.log(datPT);

                                $.ajax({
                                    type: "POST",
                                    url: "../php/plan_t/plan_t-add.php",
                                    data: datPT,
                                    success: function (response) {
                                        console.log(response);
                                    }
                                });
                            });
                            $.ajax({
                                type: "POST",
                                url: "../php/plan_t/plan_t-cod.php",
                                data: {id_cita,id_medico},
                                success: function (response) {
                                    console.log(response);
                                }
                            });
                        }

                        const select = document.getElementById("select_contingencia");
                        const contingencia = select.options[select.selectedIndex].text;
                        //Guardar datos de la cita (Signos de alarma, Recomendaciones no farmacológicas, evolución, días reposo y t_contingencia)
                        const datCita = {
                            signos_a: $("#signos_alarma").val(),
                            recomendaciones_nf: $("#rec_no_far").val(),
                            evolucion: $("#evolucion").val(),
                            t_contingencia: contingencia,
                            dias_reposo: $("#dias_reposo").val(),
                            id_cita: id_cita
                        }; 

                        $.ajax({ 
                            type: "POST",
                            url: "../php/cita/sa-rnf-add.php",
                            data: datCita,
                            success: function (response) {
                                console.log(response);
                            }
                        });

                        //Añadir los exámenes o procemientos en base a la cita//
                        if (adicionales.length > 0) {
                            adicionales.forEach(a => {
                                const datAdic = {
                                    descripcion: a.descripcion,
                                    costo: a.costo,
                                    id_cita: id_cita,
                                    id: a.id_servicio

                                };
                                console.log(datAdic);

                                $.ajax({
                                    type: "POST",
                                    url: "../php/adicional.php",
                                    data: datAdic,
                                    success: function(response) {
                                        console.log(response);
                                    }
                                });
                            });
                        }


                        //Establecer la cita como atendida//
                        $.ajax({
                            type: "POST",
                            url: "../php/cita/cita-atendida.php",
                            data: { id_cita },
                            success: function(response) {
                                console.log(response);
                            }
                        });
                        

                        //Mostrar mensaje de Guardado de Datos
                        $('#texto_modal').html('La cita ha sido atendida y los datos se han guardado exitosamente');
                        $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                        $('#modalPush').modal("show");
                        setTimeout(function() { window.location.href = `reporte_cita.php?id_cita=${id_cita}`; }, 3000);

                        antecedentes = [];
                        antecedentesf = [];
                        signosva = [];
                        cont_sva = 0;
                        diagnosticos = [];
                        cont_diag = 0;
                        plan_t = [];
                        alergias = [];
                        adicionales = [];
                         
 
                     }
                 }
             });

            
        }
    });

    //===================================================BOTÓN PARA GUARDAR COMO BORRADOR====================================//
    $("#btn_borrador").click(function(e) {
        e.preventDefault();
        //Almacenar el id del médico en variable
        const id_medico = JSON.parse($.ajax({
            type: "POST",
            url: '../php/cita/cita-pac-dat.php',
            data: { id_cita },
            global: false,
            async: false,
            success: function(response) {
                return response;
            }
        }).responseText).id_medico;

        //Almacenar el id del caso en variable
        const id_caso = JSON.parse($.ajax({
            type: "POST",
            url: '../php/cita/cita-pac-dat.php',
            data: { id_cita },
            global: false,
            async: false,
            success: function(response) {
                return response;
            }
        }).responseText).id_caso;

        if ((($("#motivo_consulta").val() == "")&&(!$("#motivo_consulta").attr('disabled'))) || (($("#problema_actual").val() == "")&&(!$("#problema_actual").attr('disabled'))) || signosva.length == 0) {
            $('#texto_modal').html('Ingrese los valores obligatorios: Motivo de Consulta, Enfermedad, Signos Vitales');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
           //Guardar Antecedentes personales si existen
           if (antecedentes.length > 0) {
               antecedentes.forEach(a => {
                   const anteP = {
                       descripcion: a.descripcion,
                       fecha: a.fecha,
                       id_paciente: id_paciente,
                       id_medico: id_medico
                   };

                   $.ajax({
                       type: "POST",
                       url: "../php/antecedente_p/antecedente_p-add.php",
                       data: anteP,
                       success: function (response) {
                           console.log(response);
                       }
                   });
               });
           }
           //Guardar Antecedentes familiares si existen
           if (antecedentesf.length > 0) {
               antecedentesf.forEach(af => {
                   const anteF = {
                       parentesco: af.parentesco,
                       descripcion: af.descripcion,
                       id_paciente: id_paciente,
                       id_enfermedad: af.idEnf
                   };

                   $.ajax({
                       type: "POST",
                       url: "../php/antecedente_f/antecedente_f-add.php",
                       data: anteF,
                       success: function (response) {
                           console.log(response);
                       }
                   });
               });
           }
           //Guardar datos del caso (Motivo de la Consulta, Problema Actual)
           const datCaso = {
               motivo_con: $("#motivo_consulta").val(),
               problema_act: $("#problema_actual").val(),
               id_caso: id_caso
           };
           $.ajax({
               type: "POST",
               url: "../php/caso/mc-pa-add.php",
               data: datCaso,
               success: function (response) {
                   console.log(response);
               }
           });

           //Almacenar la revisión actual de órganos y sistemas
           $.ajax({
                type: "POST",
                url: "../php/cita/cita-read-id.php",
                async: false,
                data: {id_cita},
                success: function (response) {
                    const tipo_cita = Number(JSON.parse(response).tipo_cita);
                    if (tipo_cita == 1) {
                        var cp_organos = 0;
                        if (!$("#organos_i").attr('disabled')) {
                            cp_organos = 1;
                        }
                        const dat_organos = {
                            orga_sist: 'Órganos de los sentidos',
                            cp: cp_organos,
                            descripcion: $("#organos_i").val(),
                            id_cita: id_cita
                        }

                        var cp_respiratorio = 0;
                        if (!$("#respiratorio_i").attr('disabled')) {
                            cp_respiratorio = 1;
                        }
                        const dat_respiratorio = {
                            orga_sist: 'Respiratorio',
                            cp: cp_respiratorio,
                            descripcion: $("#respiratorio_i").val(),
                            id_cita: id_cita
                        }

                        var cp_cardiov = 0;
                        if (!$("#cardiov_i").attr('disabled')) {
                            cp_cardiov = 1;
                        }
                        const dat_cardiov = {
                            orga_sist: 'Cardio vascular',
                            cp: cp_cardiov,
                            descripcion: $("#cardiov_i").val(),
                            id_cita: id_cita
                        }

                        var cp_digestivo = 0;
                        if (!$("#digestivo_i").attr('disabled')) {
                            cp_digestivo = 1;
                        }        
                        const dat_digestivo = {
                            orga_sist: 'Digestivo',
                            cp: cp_digestivo,
                            descripcion: $("#digestivo_i").val(),
                            id_cita: id_cita
                        }

                        var cp_genital = 0;
                        if (!$("#genital_i").attr('disabled')) {
                            cp_genital = 1;
                        }
                        const dat_genital = {
                            orga_sist: 'Genital',
                            cp: cp_genital,
                            descripcion: $("#genital_i").val(),
                            id_cita: id_cita
                        }

                        var cp_urinario = 0;
                        if (!$("#urinario_i").attr('disabled')) {
                            cp_urinario = 1;
                        }
                        const dat_urinario = {
                            orga_sist: 'Urinario',
                            cp: cp_urinario,
                            descripcion: $("#urinario_i").val(),
                            id_cita: id_cita
                        }

                        var cp_musculoe = 0;
                        if (!$("#musculoe_i").attr('disabled')) {
                            cp_musculoe = 1;
                        }
                        const dat_musculoe = {
                            orga_sist: 'Músculo esquelético',
                            cp: cp_musculoe,
                            descripcion: $("#musculoe_i").val(),
                            id_cita: id_cita
                        }

                        var cp_endocrino = 0;
                        if (!$("#endocrino_i").attr('disabled')) {
                            cp_endocrino = 1;
                        }
                        const dat_endocrino = {
                            orga_sist: 'Endocrino',
                            cp: cp_endocrino,
                            descripcion: $("#endocrino_i").val(),
                            id_cita: id_cita
                        }

                        var cp_hemol = 0;
                        if (!$("#hemol_i").attr('disabled')) {
                            cp_hemol = 1;
                        }
                        const dat_hemol = {
                            orga_sist: 'Hemo linfático',
                            cp: cp_hemol,
                            descripcion: $("#hemol_i").val(),
                            id_cita: id_cita
                        }

                        var cp_nervioso = 0;
                        if (!$("#nervioso_i").attr('disabled')) {
                            cp_nervioso = 1;
                        }
                        const dat_nervioso = {
                            orga_sist: 'Nervioso',
                            cp: cp_nervioso,
                            descripcion: $("#nervioso_i").val(),
                            id_cita: id_cita
                        }

                        const revision_os = [dat_organos,dat_respiratorio,dat_cardiov,dat_digestivo,dat_genital,dat_urinario,dat_musculoe,dat_endocrino,dat_hemol,dat_nervioso];

                        revision_os.forEach(os => {
                            const datOS = {
                                orga_sist: os.orga_sist,
                                cp: os.cp,
                                descripcion: os.descripcion,
                                id_cita: id_cita
                            };

                            $.ajax({
                                type: "POST",
                                url: "../php/revision_o_s/revision_o_s-add.php",
                                data: datOS,
                                success: function (response) {
                                    console.log(response);
                                }
                            });
                        });
                    }
                }
            });
           
           //Almacenar los signos vitales y antropometría
           if (signosva.length > 0) {
                signosva.forEach(sva => {
                    const datSVA = {
                        fecha: f_actual,
                        temperatura: sva.temperatura,
                        presion_as: sva.presion_as,
                        presion_ad: sva.presion_ad,
                        pulso: sva.pulso,
                        frecuencia_r: sva.frecuencia_r,
                        frecuencia_c: sva.frecuencia_c,
                        sat_o: sva.sat_o,
                        peso: sva.peso,
                        talla: sva.talla,
                        id_cita: id_cita
                    };
                    $.ajax({
                        type: "POST",
                        url: "../php/signov_ant/signov_ant-add.php",
                        data: datSVA,
                        success: function (response) {
                            console.log(response);
                        }
                    });
                });
           }

           //Almacenar lo del Exámen físico regional
           $.ajax({
            type: "POST",
            url: "../php/cita/cita-read-id.php",
            async: false,
            data: {id_cita},
            success: function (response) {
                const tipo_cita = Number(JSON.parse(response).tipo_cita);
                if (tipo_cita == 1) {
                    var cp_cabeza = 0;
                    if (!$("#cabeza_i").attr('disabled')) {
                        cp_cabeza = 1;
                    }
                    const dat_cabeza = {
                        examen_fr: 'Cabeza',
                        cp: cp_cabeza,
                        descripcion: $("#cabeza_i").val(),
                        id_cita: id_cita
                    }

                    var cp_cuello = 0;
                    if (!$("#cuello_i").attr('disabled')) {
                        cp_cuello = 1;
                    }
                    const dat_cuello = {
                        examen_fr: 'Cuello',
                        cp: cp_cuello,
                        descripcion: $("#cuello_i").val(),
                        id_cita: id_cita
                    }

                    var cp_torax = 0;
                    if (!$("#torax_i").attr('disabled')) {
                        cp_torax = 1;
                    }
                    const dat_torax = {
                        examen_fr: 'Tórax',
                        cp: cp_torax,
                        descripcion: $("#torax_i").val(),
                        id_cita: id_cita
                    }

                    var cp_abdomen = 0;
                    if (!$("#abdomen_i").attr('disabled')) {
                        cp_abdomen = 1;
                    }
                    const dat_abdomen = {
                        examen_fr: 'Abdomen',
                        cp: cp_abdomen,
                        descripcion: $("#abdomen_i").val(),
                        id_cita: id_cita
                    }

                    var cp_pelvis = 0;
                    if (!$("#pelvis_i").attr('disabled')) {
                        cp_pelvis = 1;
                    }
                    const dat_pelvis = {
                        examen_fr: 'Pelvis',
                        cp: cp_pelvis,
                        descripcion: $("#pelvis_i").val(),
                        id_cita: id_cita
                    }

                    var cp_extremidades = 0;
                    if (!$("#extremidades_i").attr('disabled')) {
                        cp_extremidades = 1;
                    }
                    const dat_extremidades = {
                        examen_fr: 'Extremidades',
                        cp: cp_extremidades,
                        descripcion: $("#extremidades_i").val(),
                        id_cita: id_cita
                    }

                    const efr = [dat_cabeza,dat_cuello,dat_torax,dat_abdomen,dat_pelvis,dat_extremidades];

                    efr.forEach(e => {
                        const datEfr = {
                            examen_fr: e.examen_fr,
                            cp: e.cp,
                            descripcion: e.descripcion,
                            id_cita: id_cita
                        };
                        $.ajax({
                            type: "POST",
                            url: "../php/examen_fr/examen_fr-add.php",
                            data: datEfr,
                            success: function (response) {
                                console.log(response);
                            }
                        });
                    });
                }
            }
        });
 

           //Establecer la cita como resultado//
           $.ajax({
               type: "POST",
               url: "../php/cita/cita-resultado.php",
               data: { id_cita },
               success: function(response) {
                   console.log(response);
               }
           });
           
 
           //Mostrar mensaje de Guardado de Datos
           $('#texto_modal').html('Los datos de la cita se han guardado exitosamente como borrador');
           $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
           $('#modalPush').modal("show");
           setTimeout(function() { window.location.href = 'admin.php'; }, 3000);

           antecedentes = [];
           antecedentesf = [];
           signosva = [];
           cont_sva = 0;
           diagnosticos = [];
           cont_diag = 0;
           plan_t = [];
           alergias = [];
           adicionales = [];

            
        }

    });


    //======================Botones de revision actual de órganos y sistemas=========================================
    $("#cp_organos").click(function(e) {
        e.preventDefault();
        $("#organos_i").removeAttr('disabled');
        $("#sp_organos").removeAttr('disabled');
        $("#cp_organos").attr('disabled', 'disabled');
    });
    $("#sp_organos").click(function(e) {
        e.preventDefault();
        $("#organos_i").attr('disabled', 'disabled');
        $("#organos_i").val("");
        $("#cp_organos").removeAttr('disabled');
        $("#sp_organos").attr('disabled', 'disabled');
    });

    $("#cp_respiratorio").click(function(e) {
        e.preventDefault();
        $("#respiratorio_i").removeAttr('disabled');
        $("#sp_respiratorio").removeAttr('disabled');
        $("#cp_respiratorio").attr('disabled', 'disabled');
    });
    $("#sp_respiratorio").click(function(e) {
        e.preventDefault();
        $("#respiratorio_i").attr('disabled', 'disabled'); 
        $("#respiratorio_i").val('');
        $("#cp_respiratorio").removeAttr('disabled');
        $("#sp_respiratorio").attr('disabled', 'disabled');
    });

    $("#cp_cardiov").click(function(e) {
        e.preventDefault();
        $("#cardiov_i").removeAttr('disabled');
        $("#sp_cardiov").removeAttr('disabled');
        $("#cp_cardiov").attr('disabled', 'disabled');
    });
    $("#sp_cardiov").click(function(e) {
        e.preventDefault();
        $("#cardiov_i").attr('disabled', 'disabled');
        $("#cardiov_i").val('');
        $("#cp_cardiov").removeAttr('disabled');
        $("#sp_cardiov").attr('disabled', 'disabled');
    });

    $("#cp_digestivo").click(function(e) {
        e.preventDefault();
        $("#digestivo_i").removeAttr('disabled');
        $("#sp_digestivo").removeAttr('disabled');
        $("#cp_digestivo").attr('disabled', 'disabled');
    });
    $("#sp_digestivo").click(function(e) {
        e.preventDefault();
        $("#digestivo_i").attr('disabled', 'disabled');
        $("#digestivo_i").val('');
        $("#cp_digestivo").removeAttr('disabled');
        $("#sp_digestivo").attr('disabled', 'disabled');
    });

    $("#cp_genital").click(function(e) {
        e.preventDefault();
        $("#genital_i").removeAttr('disabled');
        $("#sp_genital").removeAttr('disabled');
        $("#cp_genital").attr('disabled', 'disabled');
    });
    $("#sp_genital").click(function(e) {
        e.preventDefault();
        $("#genital_i").attr('disabled', 'disabled');
        $("#genital_i").val('');
        $("#cp_genital").removeAttr('disabled');
        $("#sp_genital").attr('disabled', 'disabled');
    });

    $("#cp_urinario").click(function(e) {
        e.preventDefault();
        $("#urinario_i").removeAttr('disabled');
        $("#sp_urinario").removeAttr('disabled');
        $("#cp_urinario").attr('disabled', 'disabled');
    });
    $("#sp_urinario").click(function(e) {
        e.preventDefault();
        $("#urinario_i").attr('disabled', 'disabled');
        $("#urinario_i").val('');
        $("#cp_urinario").removeAttr('disabled');
        $("#sp_urinario").attr('disabled', 'disabled');
    });

    $("#cp_musculoe").click(function(e) {
        e.preventDefault();
        $("#musculoe_i").removeAttr('disabled');
        $("#sp_musculoe").removeAttr('disabled');
        $("#cp_musculoe").attr('disabled', 'disabled');
    });
    $("#sp_musculoe").click(function(e) {
        e.preventDefault();
        $("#musculoe_i").attr('disabled', 'disabled');
        $("#musculoe_i").val('');
        $("#cp_musculoe").removeAttr('disabled');
        $("#sp_musculoe").attr('disabled', 'disabled');
    });

    $("#cp_endocrino").click(function(e) {
        e.preventDefault();
        $("#endocrino_i").removeAttr('disabled');
        $("#sp_endocrino").removeAttr('disabled');
        $("#cp_endocrino").attr('disabled', 'disabled');
    });
    $("#sp_endocrino").click(function(e) {
        e.preventDefault();
        $("#endocrino_i").attr('disabled', 'disabled');
        $("#endocrino_i").val('');
        $("#cp_endocrino").removeAttr('disabled');
        $("#sp_endocrino").attr('disabled', 'disabled');
    });

    $("#cp_hemol").click(function(e) {
        e.preventDefault();
        $("#hemol_i").removeAttr('disabled');
        $("#sp_hemol").removeAttr('disabled');
        $("#cp_hemol").attr('disabled', 'disabled');
    });
    $("#sp_hemol").click(function(e) {
        e.preventDefault();
        $("#hemol_i").attr('disabled', 'disabled');
        $("#hemol_i").val('');
        $("#cp_hemol").removeAttr('disabled');
        $("#sp_hemol").attr('disabled', 'disabled');
    });

    $("#cp_nervioso").click(function(e) {
        e.preventDefault();
        $("#nervioso_i").removeAttr('disabled');
        $("#sp_nervioso").removeAttr('disabled');
        $("#cp_nervioso").attr('disabled', 'disabled');
    });
    $("#sp_nervioso").click(function(e) {
        e.preventDefault();
        $("#nervioso_i").attr('disabled', 'disabled');
        $("#nervioso_i").val('');
        $("#cp_nervioso").removeAttr('disabled');
        $("#sp_nervioso").attr('disabled', 'disabled');
    });

    //======================Botones de Exámen físico regional=========================================
    $("#cp_cabeza").click(function(e) {
        e.preventDefault();
        $("#cabeza_i").removeAttr('disabled');
        $("#sp_cabeza").removeAttr('disabled');
        $("#cp_cabeza").attr('disabled', 'disabled');
    });
    $("#sp_cabeza").click(function(e) {
        e.preventDefault();
        $("#cabeza_i").attr('disabled', 'disabled');
        $("#cabeza_i").val('');
        $("#cp_cabeza").removeAttr('disabled');
        $("#sp_cabeza").attr('disabled', 'disabled');
    });

    $("#cp_cuello").click(function(e) {
        e.preventDefault();
        $("#cuello_i").removeAttr('disabled');
        $("#sp_cuello").removeAttr('disabled');
        $("#cp_cuello").attr('disabled', 'disabled');
    });
    $("#sp_cuello").click(function(e) {
        e.preventDefault();
        $("#cuello_i").attr('disabled', 'disabled');
        $("#cuello_i").val('');
        $("#cp_cuello").removeAttr('disabled');
        $("#sp_cuello").attr('disabled', 'disabled');
    });

    $("#cp_torax").click(function(e) {
        e.preventDefault();
        $("#torax_i").removeAttr('disabled');
        $("#sp_torax").removeAttr('disabled');
        $("#cp_torax").attr('disabled', 'disabled');
    });
    $("#sp_torax").click(function(e) {
        e.preventDefault();
        $("#torax_i").attr('disabled', 'disabled');
        $("#torax_i").val('');
        $("#cp_torax").removeAttr('disabled');
        $("#sp_torax").attr('disabled', 'disabled');
    });

    $("#cp_abdomen").click(function(e) {
        e.preventDefault();
        $("#abdomen_i").removeAttr('disabled');
        $("#sp_abdomen").removeAttr('disabled');
        $("#cp_abdomen").attr('disabled', 'disabled');
    });
    $("#sp_abdomen").click(function(e) {
        e.preventDefault();
        $("#abdomen_i").attr('disabled', 'disabled');
        $("#abdomen_i").val('');
        $("#cp_abdomen").removeAttr('disabled');
        $("#sp_abdomen").attr('disabled', 'disabled');
    });

    $("#cp_pelvis").click(function(e) {
        e.preventDefault();
        $("#pelvis_i").removeAttr('disabled');
        $("#sp_pelvis").removeAttr('disabled');
        $("#cp_pelvis").attr('disabled', 'disabled');
    });
    $("#sp_pelvis").click(function(e) {
        e.preventDefault();
        $("#pelvis_i").attr('disabled', 'disabled');
        $("#pelvis_i").val('');
        $("#cp_pelvis").removeAttr('disabled');
        $("#sp_pelvis").attr('disabled', 'disabled');
    });

    $("#cp_extremidades").click(function(e) {
        e.preventDefault();
        $("#extremidades_i").removeAttr('disabled');
        $("#sp_extremidades").removeAttr('disabled');
        $("#cp_extremidades").attr('disabled', 'disabled');
    });
    $("#sp_extremidades").click(function(e) {
        e.preventDefault();
        $("#extremidades_i").attr('disabled', 'disabled');
        $("#extremidades_i").val('');
        $("#cp_extremidades").removeAttr('disabled');
        $("#sp_extremidades").attr('disabled', 'disabled');
    });
});