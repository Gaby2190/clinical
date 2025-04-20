$(document).ready(function() {//----- Ejecutar funciones una vez cargar la pagina HTML

   
    var d = new Date(); 
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var id_disponibilidad = 0;
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    $('#fecha_cita').attr('value', f_actual);

    $('#list_citas').click(function(e) {
        e.preventDefault();
        $("#citas_body > tr").remove();
        const fecha = $('#fecha_cita').val();
        console.log(fecha);
        if(fecha == 0)
        {
            let hora_act = new Date().getHours();
            let minutos_act = new Date().getMinutes();
          
            $('#turno').val(hora_act+":"+minutos_act);
            $("#div_lturno").show();
            $("#div_turno").show();
            $("#div_datos_paciente").show();
            location.hash = "#div_lturno";
            $('#div_table').show();
        }
        else
        {
            generarTabla();
            $('#div_table').show();
        }

    });

  
    function generarTabla() {
       
        //=====Tomar datos del id del caso y de la fecha=====//
        const id_medico = $("#select_medico").val();
        const fecha_cita = $('#fecha_cita').val();      
        var tap = 0;

        $.ajax({
            type: "POST",
            url: '../php/medico/medico-list.php',
            data: { id_medico },
            success: function(response) {
                tap = Number(JSON.parse(response).tiempo_ap);
            }
        });

        
        //==========Listar horarios de medico segun fecha (citas)
        const postDatCas = {
            id_medico: id_medico,
            fecha: fecha_cita
        };

        // Buscar horarios de citas para la fecha seleccionada en base al medico y fecha y almacenar en array
        const resp = $.ajax({
            type: "POST",
            url: '../php/cita/cita-med-list.php',
            data: postDatCas,
            global: false,
            async: false,
            success: function(response) {
                console.log(response);
                return response;
                
            }
        }).responseText;

        //=====Guarda en un array las citas en las cuales el médico tiene citas para la fecha =======//
        const horas = [];
        if (resp != false) {
            const resp_citas = JSON.parse(resp);
            resp_citas.forEach(r_cita => {
                var h_cita = r_cita.hora.slice(0, -3);
                horas.push(`${h_cita}`);
                console.log(horas);
            });
        }

        // Buscar horarios de citas para la fecha seleccionada en base al medico y fecha y almacenar en array (PACIENTE EN ESPERA)
        const resp_esp = $.ajax({
            type: "POST",
            url: '../php/cita/cita-med-list-esp.php',
            data: postDatCas,
            global: false,
            async: false,
            success: function(response) {
                console.log(response);
                return response;
            }
        }).responseText;

        //=====Guarda en un array las citas en las cuales el médico tiene citas para la fecha(PACIENTE EN ESPERA) =======//
        const horas_esp = [];
        if (resp_esp != false) {
            const resp_citas = JSON.parse(resp_esp);
            resp_citas.forEach(r_cita => {
                var h_cita = r_cita.hora.slice(0, -3)
                horas_esp.push(`${h_cita}`);
                console.log(horas_esp);
            });
        }


        $.ajax({
            url: '../php/rango/rango-list-med_fec.php', 
            type: 'POST',
            data: postDatCas,
            success: function(response) {
                console.log(response);
                const rangos = JSON.parse(response); //Recibo una cade Json 
                console.log(rangos);
                let template = '<option selected="selected"></option>';//creo el html para la opcion preselccionada
                rangos.forEach(rango => {
                    //========Separación de un nombre y un apellido ===================
                    let hora_ini = rango.hora_ini;
                    let hora_fin = rango.hora_fin;
                    console.log(hora_ini);
                    console.log(hora_fin);

                    var fecha_ini= (fecha_cita+" "+hora_ini);
                    var fecha_fin= (fecha_cita+" "+hora_fin);
                    
                    var turno = new Date(fecha_ini);
                    console.log(turno);
                    var turno_fin = new Date(fecha_fin);
                    while(turno<=turno_fin)
                    {
                       
                        
                        var nuevahora = turno.getHours();
                        
                        var nuevamin = turno.getMinutes();

                       
    
                        if(nuevahora < 10) { nuevahora ="0"+nuevahora;}
                        if(nuevamin==0) { nuevamin ="00";}

                        var fecha_ciclo= new Date(fecha_cita+" "+nuevahora+":"+nuevamin);
                        if (fecha_ciclo > d)
                            {
                                //======Comprobar si en el arreglo general de horarios están incluido los calores de las citas ocupadas=========
                                
                                    if (horas.includes(`${nuevahora}:${nuevamin}`)) {
                                        $("#citas_table>tbody").append(`<tr  idT="${nuevahora}:${nuevamin}"><td>${$('#fecha_cita').val()}</td><td>${nuevahora}:${nuevamin}</td><td><a class="btn btns_agendamiento" id="agendado_btn"><span class="fa fa-calendar"></span> RESERVADO</a></td></tr>`);
                                    } else {
                                        if (horas_esp.includes(`${nuevahora}:${nuevamin}`)) {
                                            $("#citas_table>tbody").append(`<tr idT="${nuevahora}:${nuevamin}"><td>${$('#fecha_cita').val()}</td><td>${nuevahora}:${nuevamin}</td><td><a style="cursor: default;" class="btn  btns_agendamiento" id="espera_btn"><span class="fa fa-clock-o"></span> EN SALA DE ESPERA</a></td></tr>`);
                                        } else {
                                            $("#citas_table>tbody").append(`<tr idT="${nuevahora}:${nuevamin}"  fecha="${$('#fecha_cita').val()}"><td>${$('#fecha_cita').val()}</td><td>${nuevahora}:${nuevamin}</td><td><a href="#" class="btn btn-primary btns_agendamiento" id="disponible_btn"><span class="fa fa-check"></span> DISPONIBLE</a></td></tr>`);
                                        }
                                    }
                            }
               

                       // $("#citas_table>tbody").append(`<tr idT="${nuevahora}:${nuevamin}"  fecha="${$('#fecha_cita').val()}"><td>${$('#fecha_cita').val()}</td><td>${nuevahora}:${nuevamin}</td><td><a href="#" class="btn btn-primary btns_agendamiento" id="disponible_btn"><span class="fa fa-check"></span> DISPONIBLE</a></td></tr>`);
                        var fechamilsegundos = turno.getTime();
                        var milsegadd = tap * 60000;
                        var turno = new Date(fechamilsegundos + milsegadd);
                    }
                   
                });

               

            }
        });


    }

   //Oculta visualmente los div t_med y s_med
   $("#div_tmed").hide();
   $("#div_smed").hide();
   $("#div_lfecha").hide();
   $("#div_fecha").hide();
   $("#div_lturno").hide();
   $("#div_turno").hide();
   $("#btn_listar").hide();
   $("#div_datos_paciente").hide();
   
   
 
   getEspecialidades();   //Llama a la funcion get especialidades - carga las especialidades en el SELECT_ESPECIALIDADES
   getNacionalidad(); //Llama a la funcion get nacionalidad - carga las nacionalidades en el SELECT_NACIONALIDAD
   $('#nombres_paci1').attr('disabled', 'disabled'); //deshabilita en objeto input nombres_paci1
   $('#nombres_paci2').attr('disabled', 'disabled');
   $('#apellidos_paci1').attr('disabled', 'disabled');
   $('#apellidos_paci2').attr('disabled', 'disabled');
   $('#celular_paci').attr('disabled', 'disabled');
   //$('#select_nacionalidad').attr('disabled', 'disabled');
  
   $('#datos_btn').attr('disabled', 'disabled'); //deshabilita el objeto boton datos_btn

   var id_paciente = 0; //establece una variable global id_paciente
   var id_caso = 0; //establece una variable global id_caso

   var d = new Date(); //se obtiene la fecha actual
   var month = d.getMonth() + 1; //se extrae de la fecha actual el mes
   var day = d.getDate(); // se extrae de la fecha actual el dia
   var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
   // se da un nuevo formato a la fecha actual
   var rol = 'P'; // se establece el rol en P de paciente
   var stat_verif = false; // stat_verif se utiliza para verificar si los datos del paciente son correctos, 
                           //se establece por defecto en false

   $('#cedula_paci').keyup(function() {//mediante jQuery se ejecutar una funcion cuando el 
                                       //usuario ingresa un caracter en el objeto input cedula_paci
       $('#nombres_paci1').attr('disabled', 'disabled'); //Deshabilita el input nombres_paci1
       $('#nombres_paci2').attr('disabled', 'disabled');
       $('#apellidos_paci1').attr('disabled', 'disabled');
       $('#apellidos_paci2').attr('disabled', 'disabled');
       $('#celular_paci').attr('disabled', 'disabled');
       $('#datos_btn').attr('disabled', 'disabled');
       $('#nombres_paci1').val(""); // Pone el valor en vacio del input nombres paci1
       $('#apellidos_paci1').val("");
       $('#nombres_paci2').val("");
       $('#apellidos_paci2').val("");
       $('#celular_paci').val("");
       // se realiza una deshabilitacion de los input y se vacia el contenido que hayan tendido

       if ($('#cedula_paci').val()) {// se evalua si hay un valor en cedula_paci
           let cedula = $('#cedula_paci').val(); //se toma el valor de cedula_paci y se almacena en la variable cedula
           // Se evalua Si el valor del select_nacionalidad  es igual a 53 Y el largo del valor de cedula_paci es igual a 10
           if (($('#select_nacionalidad').val() == '53') && ($('#cedula_paci').val().length == 10)) {
               // se evalua la validez de la cedula enviandole el valor a la funcion validarCedula
               if (validarCedula(cedula) == true) {
                   //si la cedula es valida se ejecuta la funcion verificarUsr
                   verificarUsr(); //la funcion modificara el estado del stat_verif sea como true o como false
               } else {// Si la nacionalidad es ecuatoriana y la cedula tiene 10 digitos pero no pasa la validacion 
                       // se emite un mensaje en un modal indicando que la cedula no es valida
                   $('#texto_modal').html(validarCedula(cedula));
                   $('#modal_icon').attr('style', "color: orange");
                   $('#modal_icon').attr("class", "fa fa-id-card fa-4x animated rotateIn mb-4");
                   $('#progreso').attr('style',"visibility:hidden");
                   $('#modalPush').modal("show");
               }
           } else {//Si la cedula no tiene 10 digitos o no es ecuatoriana
               if ($('#select_nacionalidad').val() != '53') {// se evalua si la cedula no es ecuatoriana
                   //aqui se evalua si ya existe el paciente de nacionalidad extranjero
                   verificarUsr();// se llama a la funcion verificarUsr
               }
           }
       } else {
           //desahibilita los objetos que recoplian la informacion del paciente.
           $('#nombres_paci1').attr('disabled', 'disabled');
           $('#nombres_paci2').attr('disabled', 'disabled');
           $('#apellidos_paci1').attr('disabled', 'disabled');
           $('#apellidos_paci2').attr('disabled', 'disabled');
           $('#celular_paci').attr('disabled', 'disabled');
           $('#datos_btn').attr('disabled', 'disabled');
       }
   });

   //Comprobar nacionalidad para habilitar número maximo de caracteres
   $("#select_nacionalidad").change(function (e) { 
       e.preventDefault();
       //Evalua si el valor del select nacionalidad es Ecuatoriano
       if ($('#select_nacionalidad').val() != '53') {
           //Si no es ecuatoriano el atributo maxlength(maximo de caracteres permitido en el input) sea 20
           $("#cedula_paci").attr('maxlength', '20');
       } else {
           //Si es ecuatoriano el atributo maxlength(maximo de caracteres permitido en el input) sea 10
           $("#cedula_paci").attr('maxlength', '10');
       }
   });

   //Busqueda en la tabla de pacientes del modal cuando ingresa un indicio del paciente que busca y dar ENTER
   $('#busc_paci').keypress(function (e) {
       const key = e.which; //toma el codigo ascii de la tecla presionada
       if(key == 13)  // Evalua que el codigo ascci presionado sea igual a 13 que corresponde a la tecla ENTER
        {
          const txt__search = $("#busc_paci").val();//toma el valor del objeto busca_paci y almacena en txt_search
          listarPacientes(txt__search);//llama a la funcion listarPacientes y le entrega el parametro de busqueda
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
   function getEspecialidades() {//declara la funcion especialidades
       $.ajax({
           url: '../php/especialidad/especialidades-list.php',//abrir el archivo especialidades-list.php sin parametro
           type: 'POST',
           async: false,
           success: function(response) {
               const especialidades = JSON.parse(response);//toma una cadena JSON y la transforma en un objeto de JavaScript
               let template = '<option selected="selected"></option>';
               especialidades.forEach(espe => {//recorre las filas del resultado de la consulta
                   template += `
                       <option value="${espe.id}">${espe.nombre}</option>
                       `;// agrega el registro mediante un option al select
               });

               $('#select_especialidad').html(template);// carga en el select todos los option generados

           }
       });
   } 

   $("#select_medico").change(function (e) { 
    e.preventDefault();
    $("#div_lfecha").show();
    $("#div_fecha").show();
    $("#btn_listar").show();
    const id_medico = $("#select_medico").val();
       getDisponibilidad(id_medico);//llama a la función y se envia el parametro 
});


function getDisponibilidad(id_med) {
    const id_medico = id_med;

        $.ajax({
            url: '../php/disponibilidad/disponibilidad-list-id.php', 
            type: 'POST',
            data: {id_medico, f_actual},
            success: function(response) {
                const disponibilidad = JSON.parse(response); //Recibo una cade Json 
                let template = '<option selected="selected"></option>';//creo el html para la opcion preselccionada
                disponibilidad.forEach(dis => {
                    //========Separación de un nombre y un apellido ===================
                    id_disponibilidad = dis.id_disponibilidad;
                    fecha_dis = dis.fecha;
                    template += `
                        <option value="${fecha_dis}">${fecha_dis}</option>
                        `;//concateno y creo el codigo html para una nueva opción con los datos del medioco en la posición que voy recorriendo de cada array
                });
                template += '<option value="0">Turno de Emergencia</option>';//creo el html para la opcion preselccionada
                $('#fecha_cita').html(template);//cargo el selec con el html de template

            }
        });
   
    
} 

   $("#select_especialidad").change(function (e) { 
       e.preventDefault();
       const id_esp = $("#select_especialidad").val();
       getMedicos(id_esp);//llama a la función y se envia el parametro 
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
                   const medicos = JSON.parse(response); //Recibo una cade Json 
                   let template = '<option selected="selected"></option>';//creo el html para la opcion preselccionada
                   medicos.forEach(medico => {
                       //========Separación de un nombre y un apellido ===================
                       let nombre = medico.nombres_medi;
                       let apellido = medico.apellidos_medi;
                       let nom_ape = apellido + " " + nombre;
                       template += `
                           <option value="${medico.id_medico}">${nom_ape}</option>
                           `;//concateno y creo el codigo html para una nueva opción con los datos del medioco en la posición que voy recorriendo de cada array
                   });
   
                   $('#select_medico').html(template);//cargo el selec con el html de template
   
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
               //console.log(pacientes);
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
       const usuario = $('#cedula_paci').val(); //toma el rol y contatena con el valor de cedula_paci 
       $.ajax({ //mediante AJAX hacemos una consulta hacia la base de datos mediante un archivo php
           type: "POST", //metodo por el cual se envian los datos al archivo php
           url: '../php/paciente/paciente-list-ced.php', //Archivo PHP de destino
           data: { usuario }, //datos que se envian al archivo php de destino
           success: function(response) { //Cuando el archivo de destino responde de manera positiva se recibe un resultado response
               if (response != false) {//Evalua si el response no es false
                   const paciente = JSON.parse(response);//toma una cadena JSON y 
                                                         //la transforma en un objeto de JavaScript
                                                         //y lo almacena en paciente
                   id_paciente = paciente.id_paciente; //En la variable global id_paciente almacena del 
                                                       //objeto paciente la id_paciente que retorno la consulta SQL
                   $('#nombres_paci1').val(paciente.nombres_paci1);//en el valor del objeto nombres_pac1 le asigna el valor del 
                                                                   //objeto paciente el nombres_paci1 que retorno la consulta SQL
                   $('#nombres_paci2').val(paciente.nombres_paci2); //Mismo proceso del nombres_paci2 se realiza con el nombres_paci2
                   $('#apellidos_paci1').val(paciente.apellidos_paci1);
                   $('#apellidos_paci2').val(paciente.apellidos_paci2);
                   $('#celular_paci').val(paciente.celular_paci);
                   $('#datos_btn').removeAttr('disabled'); //remueve el atributo deshabilitado del boton datos_btn, quedando habilitado
                   stat_verif = true; // el estado de la verificacion se devuelve true
               } else { //si el valor de response devuelto por la consulta sql es vacio
                   //Se habilita todos los objeto que llevan la informacion del paciente 
                   //para que se puedan ingresar los datos del paciente nuevo
                   $('#nombres_paci1').removeAttr('disabled');
                   $('#apellidos_paci1').removeAttr('disabled');
                   $('#nombres_paci2').removeAttr('disabled');
                   $('#apellidos_paci2').removeAttr('disabled');
                   $('#celular_paci').removeAttr('disabled');
                   $('#datos_btn').removeAttr('disabled');
                   stat_verif = false;// y el estado de la verificacion del usuario se devuelve false
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
            //   console.log(response);
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
                              // console.log(response);
                               $.ajax({
                                   type: "POST",
                                   url: '../php/paciente/paciente-list-dat.php',
                                   data: { id_usuario },
                                   success: function(response) {
                                       var paciente = JSON.parse(response);
                                       id_paciente = paciente.id_paciente;
                                       
                                       
                                       
//Una vez preparada la DATA a enviar                                   
                                       const postCaso = {
                                           fecha_registro: f_actual,
                                           id_medico: id_medico,
                                           id_especialidad: id_especialidad,
                                           id_paciente: id_paciente,
                                           id: 1
                                       };

                                       $.ajax({//se guarda el caso en la bd
                                           type: "POST",

                                           url: '../php/caso/caso-add.php',
                                           data: postCaso,
                                           success: function(response) {
                                               //console.log(response);// se imprime en la consola el mesnaje devuelto
                                               const datosCaso = {
                                                   fecha_registro: f_actual,
                                                   id_paciente: id_paciente,
                                                   id_medico: id_medico
                                               };
                                               $.ajax({//Realizo otra Consulta para saber cual es la id del caso guardado
                                                   type: "POST",
                                                   url: '../php/caso/caso-list.php', 
                                                   data: datosCaso,
                                                   success: function(response) {
                                                       const datos = JSON.parse(response);
                                                       id_caso = datos.id_caso;

                                                       //redirige al form cita_create.php con la id del caso
                                                       //OJO
                                                       //$(location).attr('href', `cita_create.php?id_caso=${id_caso}&id=1`);
                                                      
                                                       
                                                       const hora = $("#turno").val();
                                                       const fecha = $("#fecha_cita").val();
                                                                                                     
                                                       const dataCita = {
                                                           fecha: fecha,
                                                           hora: hora,
                                                           tipo_cita: 1,
                                                           id_caso: id_caso
                                                       };
                                                       
                                
                                                        $.ajax({ 
                                                            type: "POST",
                                                            url: '../php/cita/cita-add.php',
                                                            data: dataCita,
                                                            success: function(response) {
                                                                $('#texto_modal').html(response);
                                                                $('#modal_icon').attr('style', "color: rgb(57, 160, 57)");
                                                                $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                                                                $('#progreso').attr('style',"visibility:hidden");
                                                                $('#modalPush').modal("show");
                                                                $.ajax({
                                                                    type: "POST",
                                                                    url: "../php/caso/caso-get.php",
                                                                    data: {id_caso},
                                                                    success: function (response) {
                                                                        const paci = JSON.parse(response);
                                                                        const datMail = {
                                                                            medico: paci.sufijo + " " + paci.nombres_medi + " " + paci.apellidos_medi,
                                                                            tipo_cita: 0,
                                                                            nom_ape: paci.nombres_paci1 + " " + paci.nombres_paci2 + " " + paci.apellidos_paci1 + " " + paci.apellidos_paci2,
                                                                            correo: paci.correo_paci,
                                                                            fecha: fecha,
                                                                            hora: hora
                                                                        };
                                                                        $.ajax({
                                                                            type: "POST",
                                                                            url: "../php/notificacion/mail/cita-mail.php",
                                                                            data: datMail,
                                                                            success: function (response) {
                                                                                console.log(response);                                                                                
                                                                            }
                                                                        });

                                                                        //---------------- Envio Mensajes Pacientes -----------------------
                                                                const datos_msn = paci.nombres_paci1 + " " + paci.apellidos_paci1 + "," + fecha + "," + hora + "," + paci.nom_ape_medi;
                                                                const num_paci = paci.celular_paci;
                                                                const cedula_paci = paci.cedula_paci;
                                                                
                                                                var settings = {
                                                                    "url": "https://api.massend.com/api/sms",
                                                                    "method": "POST",
                                                                    "timeout": 0,
                                                                    "headers": {
                                                                        "Content-Type": "application/json"
                                                                    },
                                                                    "data": JSON.stringify({
                                                                        "user": "cesmed@massend.com",
                                                                        "pass": "cesmed123",
                                                                        "mensajeid": "44967",
                                                                        "campana": "CLINICAL CESMED S.C.",
                                                                        "telefono": num_paci,
                                                                        "dni": cedula_paci,
                                                                        "tipo": "1",
                                                                        "ruta": "0",
                                                                        "datos": datos_msn
                                                                    }),
                                                                    };
                                                                    
                                                                    $.ajax(settings).done(function (response) {
                                                                    console.log(response);
                                                                    });
                                                                    //-------------- Envio Mensajes Medicos ---------------------
                                                                    const datos_msn_doc = paci.nom_ape_medi + ","+ fecha + "," + hora;
                                                                    const num_doc = paci.celular_medi;
                                                                    const cedula_doc = paci.cedula_medi;

                                                                    var settings = {
                                                                        "url": "https://api.massend.com/api/sms",
                                                                        "method": "POST",
                                                                        "timeout": 0,
                                                                        "headers": {
                                                                            "Content-Type": "application/json"
                                                                        },
                                                                        "data": JSON.stringify({
                                                                            "user": "cesmed@massend.com",
                                                                            "pass": "cesmed123",
                                                                            "mensajeid": "44937",
                                                                            "campana": "CLINICAL CESMED S.C.",
                                                                            "telefono": num_doc,
                                                                            "dni": cedula_doc,
                                                                            "tipo": "1",
                                                                            "ruta": "0",
                                                                            "datos": datos_msn_doc
                                                                        }),
                                                                        };
                                                                        
                                                                        $.ajax(settings).done(function (response) {
                                                                        console.log(response);
                                                                        });

                                                                        
                                                                        setTimeout(function() { window.location.href = "rece.php"; }, 1000);
                                                                    }
                                                                });
                                                                
                                                                    
                                                               
                                                            } 
                                                        });                                                     
                                                       
                                                       //agendamiento
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
       id_paciente = id_p;
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
               //console.log(response);
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
                       guardarCita(id_caso,1);//invoca a la funcion guardarCita
                   }
               });
           }
       });
       
   }

//============================ REGISTRAR CASO ===================================
   $('#citas-datos').submit(function(e) {//click en el boton registrar del formulario
       e.preventDefault();// se previene el llamado del evento
            $('#texto_modal').html('Registrando Cita...');
            $('#modal_icon').attr('style', "color:orange");
            $('#progreso').attr('style',"visibility:visible");
            $('#modalPush').modal("show");
       const id_medico = $("#select_medico").val();// Toma el valor del select_medico
       const id_especialidad = $("#select_especialidad").val();// Toma el valor del select_especialidad
       
       $.ajax({// se define ajax para enviar valores a un php
           type: "POST", //define el metodo de envio de los datos
           url: "../php/caso/caso-paci-verif.php", //se indica el destino 
           data: {id_medico, id_especialidad, id_paciente}, //se definen los datos a enviar
           
           success: function (response) { //en caso la respuesta de la ejecucion se exitosa.
               if (response != false) {// evalua su la respuesta es falsa
                   
                   $('#pregunta_modal').html("El paciente tiene un Caso Abierto para el médico y especialidad indicados. <br/> Consulte al paciente si es una cita de control. <br/> Porfavor Seleccione el tipo de cita que desea el paciente.");
                   $('#modal_icono').attr('style', "color: #22445d");
                   $('#modal_icono').attr("class", "fa fa-clock-o fa-4x animated rotateIn mb-4");
                   $('#modalConfirm').modal("show");
                 //  fin del modal de confirmacion en caso de que ya exista con el mismo medico y especialidad
               $("#cita_nueva").click(function (e) {// si da clic en cita nueva
                    $('#modalConfirm').modal("hide");
                     if (stat_verif == false) {//verifica si el paciente existe en la base
                       guardarPaci(); //invoca a la funcion guardarPaci.
                   } 
                       guardarCaso(id_paciente); //invoca a la funcion guardarCaso
                      
                                   
                })
               
               
               $("#cita_control").click(function (e) {// si da clic en cita control
                    $('#modalConfirm').modal("hide");
                    const nombres1 = $('#nombres_paci1').val();//toma el valor de nombres_paci1
                    const nombres2 = $('#nombres_paci2').val();//toma el valor de nombres_paci2
                    const apellidos1 = $('#apellidos_paci1').val();//toma el valor de apellidos_paci1
                    const apellidos2 = $('#apellidos_paci2').val();//toma el valor de apellidos_paci2
                    const turno = $('#turno').val();//toma el valor de apellidos_paci2
                    let fecha_cita = $('#fecha_cita').val();//toma el valor de fecha_cita
                    if (fecha_cita==0)
                    {
                        fecha_cita= f_actual;
                    }
                    console.log("cita control");
                    // redirecciona al registro por cita de control
                    window.location.href = `cita_control-det.php?id_paciente=${id_paciente}&id_medico=${id_medico}&id_especialidad=${id_especialidad}&nombres1=${nombres1}&nombres2=${nombres2}&apellidos1=${apellidos1}&apellidos2=${apellidos2}&fecha_cita=${fecha_cita}&turno=${turno}`;
                   })
                 

                 
               }else {// cuando la verificaicon de caso es afirmativa
                   
                   if (stat_verif == false) {// verifica estado
                       guardarPaci();//invoca a guardar Paci
                   } 
                   guardarCaso(id_paciente); //invoca a la funcion guardarCaso
                   
                   //al final de la funciones hay las redirecciones    
                  
               }
           }
       });
       
   });

   $(document).on('click', '#disponible_btn', (e) => {
        e.preventDefault();
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const hora = $(elemento).attr('idT');
        $('#turno').val(hora);
        $("#div_lturno").show();
        $("#div_turno").show();
        $("#div_datos_paciente").show();
        location.hash = "#div_lturno";
        

    });
//============================  REGISTRAR CITA =================================
    function guardarCita(id_caso,tipo_cita) {
          
        const hora = $('#turno').val();
       
        let fecha = $('#fecha_cita').val();//toma el valor de fecha_cita
            if (fecha==0)
            {
                fecha = f_actual;
            }
        const numeroDia = new Date(fecha).getDay();
        const dias = [
            'domingo',
            'lunes',
            'martes',
            'miércoles',
            'jueves',
            'viernes',
            'sábado',
        ];
        const nombreDia = dias[numeroDia+1];
        const dataCita = {
            fecha: fecha,
            hora: hora,
            tipo_cita: tipo_cita,
            id_caso: id_caso
        };
        
      
            
            $.ajax({ 
                type: "POST",
                url: '../php/cita/cita-add.php',
                data: dataCita,
                success: function(response) {
                    $('#texto_modal').html(response);
                    $('#modal_icon').attr('style', "color: rgb(57, 160, 57)");
                    $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                    $('#progreso').attr('style',"visibility:hidden");
                    $('#modalPush').modal("show");
                    $.ajax({
                        type: "POST",
                        url: "../php/caso/caso-get.php",
                        data: {id_caso},
                        success: function (response) {
                            const paci = JSON.parse(response);
                            const datMail = {
                                medico: paci.sufijo + " " + paci.nombres_medi + " " + paci.apellidos_medi,
                                tipo_cita: tipo_cita,
                                nom_ape: paci.nombres_paci1 + " " + paci.nombres_paci2 + " " + paci.apellidos_paci1 + " " + paci.apellidos_paci2,
                                correo: paci.correo_paci,
                                fecha: fecha,
                                hora: hora
                            };
                            $.ajax({
                                type: "POST",
                                url: "../php/notificacion/mail/cita-mail.php",
                                data: datMail,
                                success: function (response) {
                                    console.log(response);
                                }
                            });
                           
                            var dia = fecha.getDay();
                            var mes = fecha.getMonth();
                            var year = fecha.getFullYear();

                            const meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Setiembre", "Octubre", "Noviembre", "Diciembre"];
                            mes = (meses[mes]);

                            fecha_msn=$dia+" de "+$mes+" del "+$year;
                            //---------------- Envio Mensajes Pacientes -----------------------
                            const datos_msn = paci.nombres_paci1 + " " + paci.apellidos_paci1 + "," + fecha_msn + "," + hora + "," + paci.nom_ape_medi;
                            const num_paci = paci.celular_paci;
                            const cedula_paci = paci.cedula_paci;
                            
                            var settings = {
                                "url": "https://api.massend.com/api/sms",
                                "method": "POST",
                                "timeout": 0,
                                "headers": {
                                    "Content-Type": "application/json"
                                },
                                "data": JSON.stringify({
                                    "user": "cesmed@massend.com",
                                    "pass": "cesmed123",
                                    "mensajeid": "44967",
                                    "campana": "CLINICAL CESMED S.C.",
                                    "telefono": num_paci,
                                    "dni": cedula_paci,
                                    "tipo": "1",
                                    "ruta": "0",
                                    "datos": datos_msn
                                }),
                                };
                                
                                $.ajax(settings).done(function (response) {
                                   console.log(response);
                                });
                                //-------------- Envio Mensajes Medicos ---------------------
                                const datos_msn_doc = paci.nom_ape_medi + ","+ fecha_msn + "," + hora;
                                const num_doc = paci.celular_medi;
                                const cedula_doc = paci.cedula_medi;

                                var settings = {
                                    "url": "https://api.massend.com/api/sms",
                                    "method": "POST",
                                    "timeout": 0,
                                    "headers": {
                                        "Content-Type": "application/json"
                                    },
                                    "data": JSON.stringify({
                                        "user": "cesmed@massend.com",
                                        "pass": "cesmed123",
                                        "mensajeid": "44937",
                                        "campana": "CLINICAL CESMED S.C.",
                                        "telefono": num_doc,
                                        "dni": cedula_doc,
                                        "tipo": "1",
                                        "ruta": "0",
                                        "datos": datos_msn_doc
                                    }),
                                    };
                                    
                                    $.ajax(settings).done(function (response) {
                                       console.log(response);
                                    });
                                
                        }
                    });
                    setTimeout(function() { window.location.href = "rece.php"; }, 3000);
                }
            });
        

    }

    $(document).on('click', '#sin_ced', (e) => {
        
        if ($('#sin_ced').is(":checked"))
            {
               // Buscar horarios de citas para la fecha seleccionada en base al medico y fecha y almacenar en array (PACIENTE EN ESPERA)
                let maximo = 0;
                $.ajax({
                    type: "POST",
                    url: '../php/cita/cita-max.php',
                    global: false,
                    async: false,
                    success: function(response) {
                        const datos_max = JSON.parse(response);
                        maximo = Number(datos_max.maximo)+1;
                    }
                });
                console.log(maximo);
                $('#cedula_paci').val(maximo);
                $('#cedula_paci').attr('disabled', 'disabled');

                $('#nombres_paci1').removeAttr('disabled');
                $('#apellidos_paci1').removeAttr('disabled');
                $('#nombres_paci2').removeAttr('disabled');
                $('#apellidos_paci2').removeAttr('disabled');
                $('#celular_paci').removeAttr('disabled');
                $('#datos_btn').removeAttr('disabled');
                $('#celular_paci').removeAttr('disabled');
            }
            else
            {
                $('#cedula_paci').val('');
                $('#cedula_paci').removeAttr('disabled');
                $('#nombres_paci1').val('');
                $('#nombres_paci1').attr('disabled', 'disabled');
                $('#apellidos_paci1').val('');
                $('#apellidos_paci1').attr('disabled', 'disabled');
                $('#nombres_paci2').val('');
                $('#nombres_paci2').attr('disabled', 'disabled');
                $('#apellidos_paci2').val('');
                $('#apellidos_paci2').attr('disabled', 'disabled');
                $('#celular_paci').val('');
                $('#celular_paci').attr('disabled', 'disabled');
               
                $('#datos_btn').attr('disabled', 'disabled');
                $('#celular_paci').attr('disabled', 'disabled');
                
            }
    });


});