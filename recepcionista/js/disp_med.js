$(document).ready(function() {//----- Ejecutar funciones una vez cargada la pagina HTML

    var id_medico=1;
    var d = new Date(); 
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

    var tap = 0;
    var id_disponibilidad = 0;
   

    $('#fecha_cita').attr('value', f_actual);
    $('#fecha_cita').attr('min', f_actual);

    $('#list_citas').click(function(e) {
        e.preventDefault();
        $("#citas_body > tr").remove();
        generarTabla();
        $('#div_table').show();
    });
  
   //Oculta visualmente los div t_med y s_med
   $("#div_tmed").hide();
   $("#div_smed").hide();
   $("#div_lfecha").hide();
   $("#div_fecha").hide();
   $("#div_lturno").hide();
   $("#div_turno").hide();
   $("#btn_listar").hide();
   $("#datos_btn").hide();
   $("#eliminar_rango").hide();
   

   $("#div_ran1").hide();
   $("#div_ran1_i").hide();
   $("#div_ran1_f").hide();

   $("#div_ran2").hide();
   $("#div_ran2_i").hide();
   $("#div_ran2_f").hide();

   $("#div_ran3").hide();
   $("#div_ran3_i").hide();
   $("#div_ran3_f").hide();
   
   
   
 
   getEspecialidades();   //Llama a la funcion get especialidades - carga las especialidades en el SELECT_ESPECIALIDADES
  
    // Obtener Especialidades
   function getEspecialidades() {//declara la funcion especialidades
       $.ajax({
           url: '../php/especialidad/especialidades-list.php',//abrir el archivo especialidades-list.php sin parametro
           type: 'POST',
           async: false,
           success: function(response) {
               const especialidades = JSON.parse(response);//toma una cadena JSON y la transforma en un objeto de JavaScript
               let template = '<option value="" selected="selected">Seleccione especialidad</option>';
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

       
        id_medico=$("#select_medico").val();
        console.log(id_medico);

        $.ajax({
            type: "POST",
            url: '../php/medico/medico-list.php',
            data: { id_medico },
            success: function(response) {
                tap = Number(JSON.parse(response).tiempo_ap);
                }
            });
        listarRangos();
    });


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
                   let template = '<option selected="selected">Seleccione un médico</option>';
                   medicos.forEach(medico => {
                       //========Separación de un nombre y un apellido ===================
                       let nombre = medico.nombres_medi;
                       let apellido = medico.apellidos_medi;
                       let nom_ape = apellido + " " + nombre;
                       id_medico=medico.id_medico;
                       template += `
                           <option value="${medico.id_medico}">${nom_ape}</option>
                           `;
                   });
   
                   $('#select_medico').html(template);
   
               }
           });
       }
       
   } 
 


   $("#select_rango1_ini").change(function (e) { 
        e.preventDefault();
        const rango_ini = $("#select_rango1_ini").val();
        const fecha_cita = $("#fecha_cita").val();
        
                var fecha_ini= (fecha_cita+" "+rango_ini);
                var fecha_fin= (fecha_cita+" 23:40");
                var turno = new Date(fecha_ini);
                var turno_fin = new Date(fecha_fin);
                var milsegadd = 0;
                template ='<option value="0">Seleccione una hora</option>';
                while(turno<turno_fin)
                {
                   
                    var fechamilsegundos = turno.getTime();
                    
                    var turno = new Date(fechamilsegundos + milsegadd);
                    var nuevahora = turno.getHours();
                    
                    var nuevamin = turno.getMinutes();

                   if(nuevahora <= 9) { nuevahora ="0"+nuevahora;}
                    if(nuevamin==0) { nuevamin ="00";}

                    template += `
                            <option value="${nuevahora}:${nuevamin}">${nuevahora}:${nuevamin}</option>
                            `;
                    milsegadd = tap * 60000;
                }
                $('#select_rango1_fin').html(template);
                
            
        
    });

    $("#select_rango1_fin").change(function (e) { 
        e.preventDefault();
        const rango_ini = $("#select_rango1_fin").val();
        const fecha_cita = $("#fecha_cita").val();
                var fecha_ini= (fecha_cita+" "+rango_ini);
                var fecha_fin= (fecha_cita+" 23:40");
                var turno = new Date(fecha_ini);
                var turno_fin = new Date(fecha_fin);
                var milsegadd = 0;
                template ='<option value="0">Seleccione una hora</option>';
                while(turno<turno_fin)
                {
                   
                    var fechamilsegundos = turno.getTime();
                    milsegadd = tap * 60000;
                    var turno = new Date(fechamilsegundos + milsegadd);
                    var nuevahora = turno.getHours();
                    
                    var nuevamin = turno.getMinutes();

                    if(nuevahora <= 9) { nuevahora ="0"+nuevahora;}
                    if(nuevamin==0) { nuevamin ="00";}

                    template += `
                            <option value="${nuevahora}:${nuevamin}">${nuevahora}:${nuevamin}</option>
                            `;
                   
                }
                $('#select_rango2_ini').html(template);       
    });
    $("#select_rango2_ini").change(function (e) { 
        e.preventDefault();
        const rango_ini = $("#select_rango2_ini").val();
        const fecha_cita = $("#fecha_cita").val();
                var fecha_ini= (fecha_cita+" "+rango_ini);
                var fecha_fin= (fecha_cita+" 23:40");
                var turno = new Date(fecha_ini);
                var turno_fin = new Date(fecha_fin);
                var milsegadd = 0;
                template ='<option value="0">Seleccione una hora</option>';
                while(turno<turno_fin)
                {
                   
                    var fechamilsegundos = turno.getTime();
                    
                    var turno = new Date(fechamilsegundos + milsegadd);
                    var nuevahora = turno.getHours();
                    
                    var nuevamin = turno.getMinutes();

                    if(nuevahora <= 9) { nuevahora ="0"+nuevahora;}
                    if(nuevamin==0) { nuevamin ="00";}

                    template += `
                            <option value="${nuevahora}:${nuevamin}">${nuevahora}:${nuevamin}</option>
                            `;
                    milsegadd = tap * 60000;
                }
                $('#select_rango2_fin').html(template);       
    });

    $("#select_rango2_fin").change(function (e) { 
        e.preventDefault();
        const rango_ini = $("#select_rango2_fin").val();
        const fecha_cita = $("#fecha_cita").val();
                var fecha_ini= (fecha_cita+" "+rango_ini);
                var fecha_fin= (fecha_cita+" 23:40");
                var turno = new Date(fecha_ini);
                var turno_fin = new Date(fecha_fin);
                var milsegadd = 0;
                template ='<option value="0">Seleccione una hora</option>';
                while(turno<turno_fin)
                {
                   
                    var fechamilsegundos = turno.getTime();
                    milsegadd = tap * 60000;
                    var turno = new Date(fechamilsegundos + milsegadd);
                    var nuevahora = turno.getHours();
                    
                    var nuevamin = turno.getMinutes();

                    if(nuevahora <= 9) { nuevahora ="0"+nuevahora;}
                    if(nuevamin==0) { nuevamin ="00";}

                    template += `
                            <option value="${nuevahora}:${nuevamin}">${nuevahora}:${nuevamin}</option>
                            `;
                    
                }
                $('#select_rango3_ini').html(template);       
    });
    $("#select_rango3_ini").change(function (e) { 
        e.preventDefault();
        const rango_ini = $("#select_rango3_ini").val();
        const fecha_cita = $("#fecha_cita").val();
                var fecha_ini= (fecha_cita+" "+rango_ini);
                var fecha_fin= (fecha_cita+" 23:40");
                var turno = new Date(fecha_ini);
                var turno_fin = new Date(fecha_fin);
                var milsegadd = 0;
                template ='<option value="0">Seleccione una hora</option>';
                while(turno<turno_fin)
                {
                   
                    var fechamilsegundos = turno.getTime();
                    var milsegadd = tap * 60000;
                    var turno = new Date(fechamilsegundos + milsegadd);
                    var nuevahora = turno.getHours();
                    
                    var nuevamin = turno.getMinutes();

                    if(nuevahora <= 9) { nuevahora ="0"+nuevahora;}
                    if(nuevamin==0) { nuevamin ="00";}

                    template += `
                            <option value="${nuevahora}:${nuevamin}">${nuevahora}:${nuevamin}</option>
                            `;
                    milsegadd = tap * 60000;
                }
                $('#select_rango3_fin').html(template);       
    });

    //=================== Guardar Datos Disponibilidad =========================

    $('#disponibilidad-datos').submit(function(e) {//click en el boton registrar del formulario
        e.preventDefault();// se previene el llamado del evento
             $('#texto_modal').html('Registrando Disponibilidad...');
             $('#modal_icon').attr('style', "color:orange");
             $('#progreso').attr('style',"visibility:visible");
             $('#modalPush').modal("show");
        const id_medico = $("#select_medico").val();// Toma el valor del select_medico       
        const fecha_cita = $("#fecha_cita").val();
        const rango1_ini = $("#select_rango1_ini").val();
        const rango1_fin = $("#select_rango1_fin").val();
        const rango2_ini = $("#select_rango2_ini").val();
        const rango2_fin = $("#select_rango2_fin").val();
        const rango3_ini = $("#select_rango3_ini").val();
        const rango3_fin = $("#select_rango3_fin").val();

        $.ajax({
            type: "POST",
            url: '../php/disponibilidad/disponibilidad-add.php',
            data: { id_medico, fecha_cita },
            success: function(response) {
                    if(response == 'Consulta Fallida')
                    {
                        $('#texto_modal').html(response);
                        $('#modal_icon').attr('style', "color:orange");
                        $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                        $('#progreso').attr('style',"visibility:hidden");
                        $('#modalPush').modal("show");
                    }
                    else
                    {
                        id_disponibilidad=response;
                        
                                                

                        if ((rango1_ini.length> 4)&&(rango1_fin.length>4)) { add_rango(id_disponibilidad, rango1_ini,rango1_fin); }
                        if ((rango2_ini.length> 4)&&(rango2_fin.length>4)) { add_rango(id_disponibilidad, rango2_ini,rango2_fin); }
                        if ((rango3_ini != null)&&(rango3_fin != null))
                        {
                            if ((rango3_ini.length> 4)&&(rango3_fin.length>4)) 
                                { 
                                    add_rango(id_disponibilidad, rango3_ini,rango3_fin);  
                                }
                           
                        }
                        
                        
                        
                        
                    }
                }
            });

    });

    function add_rango(id_disponibilidad, ini,fin)
    {
        $.ajax({
            type: "POST",
            url: '../php/rango/rango-add.php',
            data: { id_disponibilidad, ini, fin },
            success: function(response) {
                $('#texto_modal').html(response);
                $('#modal_icon').attr('style', "color:orange");
                $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                $('#progreso').attr('style',"visibility:hidden");
                $('#modalPush').modal("show");

                listarRangos();
            }
        });
    }


    $("#fecha_cita").change(function (e) { 
        e.preventDefault();
        listarRangos();
    });


    function listarRangos(){
        id_medico=$("#select_medico").val();
        fecha_cita=$("#fecha_cita").val();
        
        
        $.ajax({
            type: "POST",
            data: {id_medico, fecha_cita},
            url: "../php/disponibilidad/disponibilidad-get.php",
            beforeSend: function() {
            
               $('#respuesta').html('<div class="d-flex align-items-center"><strong>Espere porfavor estamos buscando las coincidencias...           </strong><div class="spinner-border text-info ml-auto" role="status" aria-hidden="true"></div></div>');
               $('#rangos_table').hide();
              
            },
            success: function (response) {
                 $("#respuesta").html('');
                if (response == false) {
                    console.log('no hay disponibilidad registrada');
                    $("#div_ran1").show();
                    $("#div_ran1_i").show();
                    $("#div_ran1_f").show();
                 
                    $("#div_ran2").show();
                    $("#div_ran2_i").show();
                    $("#div_ran2_f").show();
                 
                    $("#div_ran3").show();
                    $("#div_ran3_i").show();
                    $("#div_ran3_f").show();
                    $('#rangos_table').hide();
                    $("#datos_btn").show();
                    $("#eliminar_rango").hide();
                    
                } 
                else 
                { 
                    console.log('Si hay disponibilidad registrada');
                    $("#rangos_body > tr").remove(); 
                    $("#div_ran1").hide();
                    $("#div_ran1_i").hide();
                    $("#div_ran1_f").hide();

                    $("#div_ran2").hide();
                    $("#div_ran2_i").hide();
                    $("#div_ran2_f").hide();

                    $("#div_ran3").hide();
                    $("#div_ran3_i").hide();
                    $("#div_ran3_f").hide();
                    $("#datos_btn").hide();
                    $("#eliminar_rango").show();

                  
                    const resp = JSON.parse(response);                  
                    let template = '';
                    resp.forEach(r => {
                        id_disponibilidad = r.id_disponibilidad;
                        console.log(id_disponibilidad)
                        $.ajax({
                            type: "POST",
                            url: '../php/rango/rango-list-id.php',
                            data: { id_disponibilidad },
                            global: false,
                            async: false,
                            success: function(response) {
                                    console.log(response); 
                                    const rangos = JSON.parse(response); 
                                    rangos.forEach(rango => {
                                       
                                        template += `<tr class="bg-blue">
                                                    <td class="pt-3">${fecha_cita}</td>
                                                    <td class="pt-3">${rango.hora_ini}h</td>
                                                    <td class="pt-3">${rango.hora_fin}</td>
                                                    </tr>
                                                <tr id="scitang-row">
                                                    <td></td>
                                                </tr>`;
                                    });                                                                
                                    
                            }
                        });
                        
                    }); 
                    $('#rangos_body').html(template);
                    $('#rangos_table').show();
                }
            }
        });
    }


    $('#eliminar_rango').click(function(e) {
        e.preventDefault();
        
        $.ajax({
            type: "POST",
            url: '../php/cita/cita-agendada.php',
            data: { id_medico, fecha_cita},
            success: function(response) {
                if (response == false) 
                {
                    console.log('No hay citas registradas');
                    $.ajax({
                        type: "POST",
                        url: '../php/disponibilidad/disponibilidad-del.php',
                        data: { id_disponibilidad},
                        success: function(response) {
                            $('#texto_modal').html(response);
                            $('#modal_icon').attr('style', "color:orange");
                            $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                            $('#progreso').attr('style',"visibility:hidden");
                            $('#modalPush').modal("show");
                            listarRangos();
                        }
                    });
                }
                else
                {
                    $('#texto_modal').html('Existen citas agendadas, reagende las citas porfavor...');
                    $('#modal_icon').attr('style', "color:orange");
                    $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                    $('#progreso').attr('style',"visibility:hidden");
                    $('#modalPush').modal("show");

                    
                }
            }
        });


        
    });

});