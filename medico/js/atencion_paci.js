$(document).ready(function() {
    const id_paciente = $("#id_paciente").val();
    const id_cita = $("#id_cita").val();
    var tipo_cita_g =  null;
    var id_caso_g =  null;

    var array_recetas  = [];
    var array_recetas_g  = [];

     //==========Variable signos vitales y  amtropometria=========//
     var signosva = [];
     var cont_sva = 0;
 
    $("#dias_reposo").val(0);

    $.ajax({
        type: "POST",
        url: "../php/cita/cita-read-id.php",
        async: false,
        data: {id_cita},
        success: function (response) {
            const tipo_cita = Number(JSON.parse(response).tipo_cita);
            tipo_cita_g = tipo_cita;
            if (tipo_cita == 1) {
                
               
                $("#div_evolucion").hide();
            }
            if (tipo_cita == 0) {
                
           
                $("#div_evolucion").show();
            }

                $.ajax({
                    type: "POST",
                    url: "../php/caso/idcaso-idcita-get.php",
                    async: false,
                    data: {id_cita},
                    success: function (response) {
                        const id_caso = JSON.parse(response).id_caso;
                        id_caso_g = id_caso;
                        $.ajax({
                            type: "POST",
                            url: "../php/revision_o_s/revision_o_s-get.php",
                            async: false,
                            data: {id_caso},
                            success: function (response) {
                                const ros = JSON.parse(response);
                                ros.forEach(r => {
                                    console.log(r.orga_sist);
                                    switch (r.orga_sist) {
                                        case "Órganos de los sentidos":
                                            if (r.cp == "1") {
                                                $("#organos_i").removeAttr('disabled');
                                                $("#sp_organos").removeAttr('disabled');
                                                $("#cp_organos").attr('disabled', 'disabled');
                                                $("#organos_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#organos_i").attr('disabled', 'disabled');
                                                $("#cp_organos").removeAttr('disabled');
                                                $("#sp_organos").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Respiratorio":
                                            if (r.cp == "1") {
                                                $("#respiratorio_i").removeAttr('disabled');
                                                $("#sp_respiratorio").removeAttr('disabled');
                                                $("#cp_respiratorio").attr('disabled', 'disabled');
                                                $("#respiratorio_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#respiratorio_i").attr('disabled', 'disabled');
                                                $("#cp_respiratorio").removeAttr('disabled');
                                                $("#sp_respiratorio").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Cardio vascular":
                                            if (r.cp == "1") {
                                                $("#cardiov_i").removeAttr('disabled');
                                                $("#sp_cardiov").removeAttr('disabled');
                                                $("#cp_cardiov").attr('disabled', 'disabled');
                                                $("#cardiov_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#cardiov_i").attr('disabled', 'disabled');
                                                $("#cp_cardiov").removeAttr('disabled');
                                                $("#sp_cardiov").attr('disabled', 'disabled');
                                            }                                            
                                            break;
                                        case "Digestivo":
                                            if (r.cp == "1") {
                                                $("#digestivo_i").removeAttr('disabled');
                                                $("#sp_digestivo").removeAttr('disabled');
                                                $("#cp_digestivo").attr('disabled', 'disabled');
                                                $("#digestivo_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#cardiov_i").attr('disabled', 'disabled');
                                                $("#cp_digestivo").removeAttr('disabled');
                                                $("#sp_digestivo").attr('disabled', 'disabled');
                                            }  
                                            
                                            break;
                                        case "Genito - Urinario":
                                            if (r.cp == "1") {
                                                $("#genital_i").removeAttr('disabled');
                                                $("#sp_genital").removeAttr('disabled');
                                                $("#cp_genital").attr('disabled', 'disabled');
                                                $("#genital_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#genital_i").attr('disabled', 'disabled');
                                                $("#cp_genital").removeAttr('disabled');
                                                $("#sp_genital").attr('disabled', 'disabled');
                                            }
                                            
                                            break;
                                        case "Piel - Anexos":
                                            if (r.cp == "1") {
                                                $("#urinario_i").removeAttr('disabled');
                                                $("#sp_urinario").removeAttr('disabled');
                                                $("#cp_urinario").attr('disabled', 'disabled');
                                                $("#urinario_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#urinario_i").attr('disabled', 'disabled');
                                                $("#cp_urinario").removeAttr('disabled');
                                                $("#sp_urinario").attr('disabled', 'disabled');
                                            }
                                                break;
                                        case "Musculo esqueletico":
                                            if (r.cp == "1") {
                                                $("#musculoe_i").removeAttr('disabled');
                                                $("#sp_musculoe").removeAttr('disabled');
                                                $("#cp_musculoe").attr('disabled', 'disabled');
                                                $("#musculoe_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#musculoe_i").attr('disabled', 'disabled');
                                                $("#cp_musculoe").removeAttr('disabled');
                                                $("#sp_musculoe").attr('disabled', 'disabled');
                                            }
                                            
                                            break;
                                        case "Endocrino":
                                            if (r.cp == "1") {
                                                $("#endocrino_i").removeAttr('disabled');
                                                $("#sp_endocrino").removeAttr('disabled');
                                                $("#cp_endocrino").attr('disabled', 'disabled');
                                                $("#endocrino_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#endocrino_i").attr('disabled', 'disabled');
                                                $("#cp_endocrino").removeAttr('disabled');
                                                $("#sp_endocrino").attr('disabled', 'disabled');
                                            }
                                           
                                            break;
                                        case "Hemo linfático":
                                            if (r.cp == "1") {
                                                $("#hemol_i").removeAttr('disabled');
                                                $("#sp_hemol").removeAttr('disabled');
                                                $("#cp_hemol").attr('disabled', 'disabled');
                                                $("#hemol_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#hemol_i").attr('disabled', 'disabled');
                                                $("#cp_hemol").removeAttr('disabled');
                                                $("#sp_hemol").attr('disabled', 'disabled');
                                            }
                                           
                                            break;
                                        case "Nervioso":
                                            if (r.cp == "1") {
                                                $("#nervioso_i").removeAttr('disabled');
                                                $("#sp_nervioso").removeAttr('disabled');
                                                $("#cp_nervioso").attr('disabled', 'disabled');
                                                $("#nervioso_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#nervioso_i").attr('disabled', 'disabled');
                                                $("#cp_nervioso").removeAttr('disabled');
                                                $("#sp_nervioso").attr('disabled', 'disabled');
                                            }
                                            
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
                                                $("#cabeza_i").removeAttr('disabled');
                                                $("#sp_cabeza").removeAttr('disabled');
                                                $("#cp_cabeza").attr('disabled', 'disabled');
                                                $("#cabeza_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#cabeza_i").attr('disabled', 'disabled');
                                                $("#cp_cabeza").removeAttr('disabled');
                                                $("#sp_cabeza").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Cuello":
                                            if (r.cp == "1") {
                                                $("#cuello_i").removeAttr('disabled');
                                                $("#sp_cuello").removeAttr('disabled');
                                                $("#cp_cuello").attr('disabled', 'disabled');
                                                $("#cuello_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#cuello_i").attr('disabled', 'disabled');
                                                $("#cp_cuello").removeAttr('disabled');
                                                $("#sp_cuello").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Torax":
                                            if (r.cp == "1") {
                                                $("#torax_i").removeAttr('disabled');
                                                $("#sp_torax").removeAttr('disabled');
                                                $("#cp_torax").attr('disabled', 'disabled');
                                                $("#torax_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#torax_i").attr('disabled', 'disabled');
                                                $("#cp_torax").removeAttr('disabled');
                                                $("#sp_torax").attr('disabled', 'disabled');
                                            }                                            
                                            break;
                                        case "Abdomen":
                                            if (r.cp == "1") {
                                                $("#abdomen_i").removeAttr('disabled');
                                                $("#sp_abdomen").removeAttr('disabled');
                                                $("#cp_abdomen").attr('disabled', 'disabled');
                                                $("#abdomen_i").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#abdomen_i").attr('disabled', 'disabled');
                                                $("#cp_abdomen").removeAttr('disabled');
                                                $("#sp_abdomen").attr('disabled', 'disabled');
                                            }   
                                            break;
                                        case "Piel - Faneras":
                                            if (r.cp == "1") {
                                                $("#piel").removeAttr('disabled');
                                                $("#sp_piel").removeAttr('disabled');
                                                $("#cp_piel").attr('disabled', 'disabled');
                                                $("#piel").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#piel").attr('disabled', 'disabled');
                                                $("#cp_piel").removeAttr('disabled');
                                                $("#sp_piel").attr('disabled', 'disabled');
                                            } 
                                            break;
                                        case "Ojos":
                                            if (r.cp == "1") {
                                                $("#ojos").removeAttr('disabled');
                                                $("#sp_ojos").removeAttr('disabled');
                                                $("#cp_ojos").attr('disabled', 'disabled');
                                                $("#ojos").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#ojos").attr('disabled', 'disabled');
                                                $("#cp_ojos").removeAttr('disabled');
                                                $("#sp_ojos").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Oidos":
                                            if (r.cp == "1") {
                                                $("#oidos").removeAttr('disabled');
                                                $("#sp_oidos").removeAttr('disabled');
                                                $("#cp_oidos").attr('disabled', 'disabled');
                                                $("#oidos").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#oidos").attr('disabled', 'disabled');
                                                $("#cp_oidos").removeAttr('disabled');
                                                $("#sp_oidos").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Nariz":
                                            if (r.cp == "1") {
                                                $("#nariz").removeAttr('disabled');
                                                $("#sp_nariz").removeAttr('disabled');
                                                $("#cp_nariz").attr('disabled', 'disabled');
                                                $("#nariz").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#nariz").attr('disabled', 'disabled');
                                                $("#cp_nariz").removeAttr('disabled');
                                                $("#sp_nariz").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Boca":
                                            if (r.cp == "1") {
                                                $("#boca").removeAttr('disabled');
                                                $("#sp_boca").removeAttr('disabled');
                                                $("#cp_boca").attr('disabled', 'disabled');
                                                $("#boca").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#boca").attr('disabled', 'disabled');
                                                $("#cp_boca").removeAttr('disabled');
                                                $("#sp_boca").attr('disabled', 'disabled');
                                            }
                                            break; 
                                        case "Orofaringe":
                                            if (r.cp == "1") {
                                                $("#orofaringe").removeAttr('disabled');
                                                $("#sp_orofaringe").removeAttr('disabled');
                                                $("#cp_orofaringe").attr('disabled', 'disabled');
                                                $("#orofaringe").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#orofaringe").attr('disabled', 'disabled');
                                                $("#cp_orofaringe").removeAttr('disabled');
                                                $("#sp_orofaringe").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Axilas - Mamas":
                                            if (r.cp == "1") {
                                                $("#axilas").removeAttr('disabled');
                                                $("#sp_axilas").removeAttr('disabled');
                                                $("#cp_axilas").attr('disabled', 'disabled');
                                                $("#axilas").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#axilas").attr('disabled', 'disabled');
                                                $("#cp_axilas").removeAttr('disabled');
                                                $("#sp_axilas").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Columna":
                                            if (r.cp == "1") {
                                                $("#columna").removeAttr('disabled');
                                                $("#sp_columna").removeAttr('disabled');
                                                $("#cp_columna").attr('disabled', 'disabled');
                                                $("#columna").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#columna").attr('disabled', 'disabled');
                                                $("#cp_columna").removeAttr('disabled');
                                                $("#sp_columna").attr('disabled', 'disabled');
                                            }
                                            break;
                                        
                                        case "Ingle":
                                            if (r.cp == "1") {
                                                $("#ingle").removeAttr('disabled');
                                                $("#sp_ingle").removeAttr('disabled');
                                                $("#cp_ingle").attr('disabled', 'disabled');
                                                $("#ingle").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#ingle").attr('disabled', 'disabled');
                                                $("#cp_ingle").removeAttr('disabled');
                                                $("#sp_ingle").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Miembros Superiores":
                                            if (r.cp == "1") {
                                                $("#msup").removeAttr('disabled');
                                                $("#sp_msup").removeAttr('disabled');
                                                $("#cp_msup").attr('disabled', 'disabled');
                                                $("#msup").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#msup").attr('disabled', 'disabled');
                                                $("#cp_msup").removeAttr('disabled');
                                                $("#sp_msup").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Miembros Inferiores":
                                            if (r.cp == "1") {
                                                $("#minf").removeAttr('disabled');
                                                $("#sp_minf").removeAttr('disabled');
                                                $("#cp_minf").attr('disabled', 'disabled');
                                                $("#minf").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#minf").attr('disabled', 'disabled');
                                                $("#cp_minf").removeAttr('disabled');
                                                $("#sp_minf").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Organos de los Sentidos":
                                            if (r.cp == "1") {
                                                $("#sorganos").removeAttr('disabled');
                                                $("#sp_sorganos").removeAttr('disabled');
                                                $("#cp_sorganos").attr('disabled', 'disabled');
                                                $("#sorganos").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#sorganos").attr('disabled', 'disabled');
                                                $("#cp_sorganos").removeAttr('disabled');
                                                $("#sp_sorganos").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Respiratorio":
                                            if (r.cp == "1") {
                                                $("#srespiratorio").removeAttr('disabled');
                                                $("#sp_srespiratorio").removeAttr('disabled');
                                                $("#cp_srespiratorio").attr('disabled', 'disabled');
                                                $("#srespiratorio").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#srespiratorio").attr('disabled', 'disabled');
                                                $("#cp_srespiratorio").removeAttr('disabled');
                                                $("#sp_srespiratorio").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Cardio - Vascular":
                                            if (r.cp == "1") {
                                                $("#scardio").removeAttr('disabled');
                                                $("#sp_scardio").removeAttr('disabled');
                                                $("#cp_scardio").attr('disabled', 'disabled');
                                                $("#scardio").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#scardio").attr('disabled', 'disabled');
                                                $("#cp_scardio").removeAttr('disabled');
                                                $("#sp_scardio").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Digestivo":
                                            if (r.cp == "1") {
                                                $("#sdigestivo").removeAttr('disabled');
                                                $("#sp_sdigestivo").removeAttr('disabled');
                                                $("#cp_sdigestivo").attr('disabled', 'disabled');
                                                $("#sdigestivo").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#sdigestivo").attr('disabled', 'disabled');
                                                $("#cp_sdigestivo").removeAttr('disabled');
                                                $("#sp_sdigestivo").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Genital":
                                            if (r.cp == "1") {
                                                $("#sgenital").removeAttr('disabled');
                                                $("#sp_sgenital").removeAttr('disabled');
                                                $("#cp_sgenital").attr('disabled', 'disabled');
                                                $("#sgenital").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#sgenital").attr('disabled', 'disabled');
                                                $("#cp_sgenital").removeAttr('disabled');
                                                $("#sp_sgenital").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Urinario":
                                            if (r.cp == "1") {
                                                $("#surinario").removeAttr('disabled');
                                                $("#sp_surinario").removeAttr('disabled');
                                                $("#cp_surinario").attr('disabled', 'disabled');
                                                $("#surinario").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#surinario").attr('disabled', 'disabled');
                                                $("#cp_surinario").removeAttr('disabled');
                                                $("#sp_surinario").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Musculo Esqueletico":
                                            if (r.cp == "1") {
                                                $("#smusculo").removeAttr('disabled');
                                                $("#sp_smusculo").removeAttr('disabled');
                                                $("#cp_smusculo").attr('disabled', 'disabled');
                                                $("#smusculo").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#smusculo").attr('disabled', 'disabled');
                                                $("#cp_smusculo").removeAttr('disabled');
                                                $("#sp_smusculo").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Endocrino":
                                            if (r.cp == "1") {
                                                $("#sendocrino").removeAttr('disabled');
                                                $("#sp_sendocrino").removeAttr('disabled');
                                                $("#cp_sendocrino").attr('disabled', 'disabled');
                                                $("#sendocrino").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#sendocrino").attr('disabled', 'disabled');
                                                $("#cp_sendocrino").removeAttr('disabled');
                                                $("#sp_sendocrino").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Hemo - Linfatico":
                                            if (r.cp == "1") {
                                                $("#shemo").removeAttr('disabled');
                                                $("#sp_shemo").removeAttr('disabled');
                                                $("#cp_shemo").attr('disabled', 'disabled');
                                                $("#shemo").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#shemo").attr('disabled', 'disabled');
                                                $("#cp_shemo").removeAttr('disabled');
                                                $("#sp_shemo").attr('disabled', 'disabled');
                                            }
                                            break;
                                        case "Neurologico":
                                            if (r.cp == "1") {
                                                $("#sneurologico").removeAttr('disabled');
                                                $("#sp_sneurologico").removeAttr('disabled');
                                                $("#cp_sneurologico").attr('disabled', 'disabled');
                                                $("#sneurologico").val(r.descripcion);
                                            }
                                            if (r.cp == "0") {
                                                $("#sneurologico").attr('disabled', 'disabled');
                                                $("#cp_sneurologico").removeAttr('disabled');
                                                $("#sp_sneurologico").attr('disabled', 'disabled');
                                            }
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
    });

   //Traer los datos del caso
   $.ajax({
    type: "POST",
    url: "../php/cita/cita-pac-dat.php",
    data: {id_cita},
    success: function (response) {
        const motivo_con = JSON.parse(response).motivo_con;
        const problema_act = JSON.parse(response).problema_act;
        const evolucion = JSON.parse(response).evolucion;
        if (motivo_con == "" || motivo_con == null) {
            $("#motivo_consulta").removeAttr('disabled');
        }else{
           // $("#motivo_consulta").attr('disabled', 'disabled');
            $("#motivo_consulta").val(motivo_con);
        }
        if (problema_act == "" || problema_act == null) {
            $("#problema_actual").removeAttr('disabled');
        }else{
          //  $("#problema_actual").attr('disabled', 'disabled');
            $("#problema_actual").val(problema_act);
        }
        
        if (evolucion == "" || evolucion == null) {
            $("#evolucion").removeAttr('disabled');
        }else{
          //  $("#problema_actual").attr('disabled', 'disabled');
            $("#evolucion").val(evolucion);
        }
        $("#signos_alarma").val(JSON.parse(response).signos_a);
        $("#rec_no_far").val(JSON.parse(response).recomendaciones_nf);
        $("#detalle_certificado").val(JSON.parse(response).detalle_certificado);
        $("#semana_embarazo").val(JSON.parse(response).semana_embarazo);
        $("#dias_reposo").val(JSON.parse(response).dias_reposo);
        $("#descuento").val(JSON.parse(response).descuento);
        
       
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
    var horas = d.getHours();
    var minutos = d.getMinutes();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    var h_actual = horas+':'+minutos;
    //==========Variable de antecedentes personales para tabla=========//
    var antecedentes = [];
    //==========Variable de antecedentes familiares para tabla=========//
    var antecedentesf = [];

   

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
        url: "../php/cita/cita-read-id.php",
        data: {id_cita},
        success: function (response) {
                const actualizacion = Number(JSON.parse(response).actualizacion);
                if (actualizacion === 1) {
                    $.ajax({
                        type: "POST",
                        url: "../php/paciente/paciente-list-comp.php",
                        data: { id_paciente },
                        success: function(response) {
                            console.log(response);
                            const paciente = JSON.parse(response);
                            $('#id_paciente').html(paciente.id_paciente);
                            $('#cedula_paci').html(paciente.cedula_paci);
                            $('#nombres_paci1').html(paciente.nombres_paci1);
                            $('#nombres_paci2').html(paciente.nombres_paci2);
                            $('#apellidos_paci1').html(paciente.apellidos_paci1);
                            $('#apellidos_paci2').html(paciente.apellidos_paci2);
                            $('#fechan_paci').html(paciente.fechan_paci);
                            $("#genero_paci").html(paciente.genero);
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
                           
            
                        }
                    });
                }
                if (actualizacion === 0){
                    $.ajax({
                        type: "POST",
                        url: "../php/paciente/paciente-list-comp.php",
                        data: { id_paciente },
                        success: function(response) {
                            console.log(response);
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
                                                                <td>${ante.nombre}</td>
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

        if ($('#descripcion_ante').val() == "" || $('#select_enfermedad_p').val() == "") {
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

                    const select = document.getElementById("select_enfermedad_p");
                    const enfermedad = select.options[select.selectedIndex].text;

                    addAnte(nom_ape, f_actual, $('#descripcion_ante').val(),$('#select_enfermedad_p').val(),enfermedad);

                    //==============================Añadir los datos al arreglo definido arriba===============//
                    const dat = {
                        medico: nom_ape,
                        fecha: f_actual,
                        descripcion: $('#descripcion_ante').val(),
                        id_enfermedad: $('#select_enfermedad_p').val(),
                        enfermedad: enfermedad
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
    function addAnte(me, fe, de, ide, enf) {
        const medico = me;
        const fecha = fe;
        const descripcion = de;
        const id_enfermedad = ide;
        const enfermedad = enf;
        $("#antecedentes_table>tbody").append(`<tr med_ante="${medico}" fech_ante="${fecha}" desc_ante="${descripcion}" idenf_ante="${id_enfermedad}" enf_ante="${enfermedad}">
                                                    <td id='m_a'>${medico}</td>
                                                    <td id='f_a'>${fecha}</td>
                                                    <td id='e_a'>${enfermedad}</td>
                                                    <td id='d_a'>${descripcion}</td>
                                                    <td><button id='eliminar_ante' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///======== Botón de eliminar antecedente=====/////
    $(document).on('click', '#eliminar_ante', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const medico = $(element).attr('med_ante');
        const fecha = $(element).attr('fech_ante');
        const descripcion = $(element).attr('desc_ante');
        const id_enfermedad = $(element).attr('idenf_ante');
        const enfermedad = $(element).attr('enf_ante');

        const busqueda = JSON.stringify({
            medico: medico,
            fecha: fecha,
            descripcion: descripcion,
            id_enfermedad: id_enfermedad,
            enfermedad: enfermedad
        });

        let indice = antecedentes.findIndex(ante => JSON.stringify(ante) === busqueda);
        antecedentes.splice(indice, 1);
        $("#ante_body > tr").remove();

        cargarAntPrevios();
        antecedentes.forEach(ante => {
            addAnte(ante.medico, ante.fecha, ante.descripcion, ante.id_enfermedad, ante.enfermedad);
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
            $('#select_enfermedad_p').html(template);
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
        const perimetro = $('#perimetro').val();
        const p_abdominal = $('#p_abdominal').val();
        const hemo_cap = $('#hemo_cap').val();
        const gluc_cap = $('#gluc_cap').val();
        const pulsio = $('#pulsio').val();
       

        if (temperatura == "" || presion_as == "" || presion_ad == "" || pulso == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {

                addSignosVA(f_actual, h_actual, temperatura, presion_as, presion_ad, pulso, frecuencia_r,frecuencia_c,sat_o, peso, talla, perimetro, p_abdominal, hemo_cap, gluc_cap, pulsio);
                //==============================Añadir los datos al arreglo definido arriba===============//
                const dat = {
                    fecha: f_actual,
                    hora: h_actual,
                    temperatura: temperatura,
                    presion_as: presion_as,
                    presion_ad: presion_ad,
                    pulso: pulso,
                    frecuencia_r: frecuencia_r,
                    frecuencia_c: frecuencia_c,
                    sat_o: sat_o,
                    peso: peso,
                    talla: talla,
                    perimetro: perimetro,
                    p_abdominal: p_abdominal,
                    hemo_cap: hemo_cap,
                    gluc_cap: gluc_cap,
                    pulsio: pulsio
                };
                
                signosva.push(dat);
                console.log(signosva);
                cont_sva += 1;
                
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
                $('#perimetro').val('');
                $('#p_abdominal').val('');
                $('#hemo_cap').val('');
                $('#gluc_cap').val('');
                $('#pulsio').val('');
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
    function imcNinos(imc,edad){
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

    //===========================================Función añadir SIGNOS VITALES a la tabla recibiendo datos=====================================//
    $.ajax({
        type: "POST",
        url: "../php/cita/cita-read-id.php",
        data: {id_cita},
        async: false,
        success: function (response) {
            const id_caso = JSON.parse(response).id_caso;
            $.ajax({
                type: "POST",
                url: "../php/paciente/paciente-list-incomp.php",
                data: { id_paciente },
                success: function(response) {
                    const paciente = JSON.parse(response);
                    var edad=0;
                if (paciente.fechan_paci=="0000-00-00"){
                    edad = 0;
                }
                else
                {
                    edad = Number(calcularEdad(paciente.fechan_paci).substr(0,2));
                }
                    $.ajax({ 
                        type: "POST",
                        url: "../php/signov_ant/signov_ant-get-c.php",
                        data: { id_caso, id_cita },
                        success: function(response) {
                            const signosv_ant = JSON.parse(response);
                            cont_sva += signosv_ant.length;
                            console.log(cont_sva);
                            
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
                                    <td>${sva.fecha} ${sva.hora}</td>
                                    <td>${sva.temperatura} °C</td>
                                    <td>${sva.presion_as}/${sva.presion_ad}</td>
                                    <td>${sva.pulso}</td>
                                    <td>${sva.frecuencia_r}</td>
                                    <td>${sva.frecuencia_c}</td>
                                    <td>${sva.sat_o}%</td>
                                    <td>${sva.peso}kg</td>
                                    <td>${sva.talla}cm</td>
                                    <td style="background-color: ${color}; color: ${c_txt}">${imc}</td>
                                    <td>${sva.p_abdominal}cm</td>
                                    <td>${sva.h_capilar}g/dl</td>
                                    <td>${sva.g_capilar}mg/dl</td>
                                    <td>${sva.pulsio}%</td>
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

    cargarSvaPrevios();

    function cargarSvaPrevios() { 
        $.ajax({
            type: "POST",
            url: "../php/paciente/paciente-list-incomp.php",
            async: false,
            data: { id_paciente },
            success: function(response) {
                const paciente = JSON.parse(response);
                var edad=0;
                if (paciente.fechan_paci=="0000-00-00"){
                    edad = 0;
                }
                else
                {
                    edad = Number(calcularEdad(paciente.fechan_paci).substr(0,2));
                }
                $.ajax({ 
                    type: "POST",
                    url: "../php/signov_ant/signov_ant-get.php",
                    async: false,
                    data: { id_cita },
                    success: function(response) {
                        const signosv_ant = JSON.parse(response);
                        signosv_ant.forEach(sva => {
                                addSignosVA(sva.fecha, sva.hora, sva.temperatura, sva.presion_as, sva.presion_ad, sva.pulso, sva.frecuencia_r, sva.frecuencia_c,sva.sat_o, sva.peso, sva.talla, sva.perimetro, sva.p_abdominal, sva.h_capilar, sva.g_capilar, sva.pulsio);
                                //==============================Añadir los datos al arreglo definido arriba===============//
                                const dat = {
                                    fecha: sva.fecha,
                                    hora: sva.hora,
                                    temperatura: sva.temperatura,
                                    presion_as: sva.presion_as,
                                    presion_ad: sva.presion_ad,
                                    pulso: sva.pulso,
                                    frecuencia_r: sva.frecuencia_r,
                                    frecuencia_c: sva.frecuencia_c,
                                    sat_o: sva.sat_o,
                                    peso: sva.peso,
                                    talla: sva.talla,
                                    perimetro: sva.perimetro,
                                    p_abdominal: sva.p_abdominal,
                                    hemo_cap: sva.h_capilar,
                                    gluc_cap: sva.g_capilar,
                                    pulsio: sva.pulsio
                                };
                                
                                signosva.push(dat);
                                console.log(signosva);
                        });
                    }
                });
            }
        });
    }
    //===========================================Función historial Motivo COnsulta a la tabla recibiendo datos=====================================//
   
    
    $.ajax({
        type: "POST",
        url: "../php/cita/cita-read-id-caso.php",
        data: {id_cita},
        async: false,
        success: function (response) {
                console.log(response);
               
                
                const citas = JSON.parse(response);
                citas.forEach(cita => {
                    const fecha = cita.fecha;
                    const motivo_con = cita.motivo_con;
                    const problema_act = cita.problema_act;
                    const evolucion = cita.evolucion;

                    $("#hmc_table>tbody").append(`<tr>
                        <td>${fecha}</td>
                        <td>${motivo_con}</td>
                        
                    </tr>`);

                    $("#hpa_table>tbody").append(`<tr>
                        <td>${fecha}</td>
                        <td>${problema_act}</td>
                        
                    </tr>`);
                    $("#hevo_table>tbody").append(`<tr>
                        <td>${fecha}</td>
                        <td>${evolucion}</td>
                        
                    </tr>`);
                });


               
                   
                
            
            
        }
    });

    $("#btn_hmc").click(function (e) { 
        e.preventDefault();      
        $("#modalhmc").modal("show");
    });

    $("#btn_hpa").click(function (e) { 
        e.preventDefault();      
        $("#modalhpa").modal("show");
    });

    $("#btn_hevo").click(function (e) { 
        e.preventDefault();      
        $("#modalhevo").modal("show");
    });

    function addSignosVA(fe, ha ,te, pas,pad, pu, fr,fc,so, p, t, perim, p_abdo, hemo_cap, gluc_cap, pulsio) {
        const fecha = fe;
        const hora = ha;
        const temperatura = te;
        const presion_as = pas;
        const presion_ad = pad;
        const pulso = pu;
        const frecuencia_r = fr;
        const frecuencia_c = fc;
        const sat_o = so;

        const p_abdominal = p_abdo;
        const hemo_capilar = hemo_cap;
        const gluc_capilar = gluc_cap;
        const pulsiometria = pulsio;
        
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
        var perimetro = 0;
        if (perim == "" || perim == NaN || perim == null || perim == 0) {
            perimetro = 0;
        }else{
            perimetro = perim;
        }

        const edad = Number($("#edad_paci").html().substr(0,2));
        var imc = 0;
        var color="";
        var c_txt ="";
        if (edad>=20) {
            if (p == "" || p == NaN || p == null || p == 0 || t == "" || t == NaN || t == null || t == 0) {
                imc = 0;
            }else{
                imc = (p/(Math.pow((t/100),2))).toFixed(2);
                color = imcAdultos(imc);
                c_txt ="white";
            }
        }
        else if (edad>=5){
          if (p == "" || p == NaN || p == null || p == 0 || t == "" || t == NaN || t == null || t == 0) {
                imc = 0;
            }else{
                imc =  (p/t/t*10000).toFixed(2);
               // color = imcNinos(imc);
               // c_txt ="white";
            }
        }
        else if (edad>=0){
          if (p == "" || p == NaN || p == null || p == 0 || t == "" || t == NaN || t == null || t == 0) {
                imc = 0;
            }else{
                
                imc =  (p/((t/100)*(t/100))).toFixed(2);
                //    color = imcNinos(imc);
                //c_txt ="white";
            }
        }
        else
        {
            imc=0;
        }
             

        

        $("#signosva_table>tbody").append(`<tr fe_sva="${fecha}" hor_sva="${hora}" te_sva="${temperatura}" pas_sva="${presion_as}" pad_sva="${presion_ad}" pu_sva="${pulso}" fr_sva="${frecuencia_r}" fc_sva="${frecuencia_c}" so_sva="${sat_o}" p_sva="${peso}" t_sva="${talla}" per_sva="${perimetro}" padb_sva="${p_abdominal}" hemoc_sva="${hemo_capilar}" glucc_sva="${gluc_capilar}" pulsio_sva="${pulsiometria}">
                                                    <td id='fe'>${fecha} ${hora}</td>
                                                    <td id='hr' class='d-none'>${hora}</td>
                                                    <td id='te'>${temperatura} °C</td>
                                                    <td id='pa'>${presion_as}/${presion_ad}</td>
                                                    <td id='pu'>${pulso}</td>
                                                    <td id='fr'>${frecuencia_r}</td>
                                                    <td id='fc' >${frecuencia_c}</td>
                                                    <td id='so'>${sat_o}%</td>
                                                    <td id='p'>${peso}kg</td>
                                                    <td id='t'>${talla}cm</td>
                                                    <td id='per'>${perimetro}cm</td>
                                                    <td id='imc' style="background-color: ${color}; color: ${c_txt}">${imc}</td>
                                                    <td id='pabdo'>${p_abdominal}cm</td>
                                                    <td id='hcap'>${hemo_capilar}g/dl</td>
                                                    <td id='gcap'>${gluc_capilar}mg/dl</td>
                                                    <td id='pulsio'>${pulsiometria}%</td>
                                                    <td><button id='eliminar_sva' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///======== Botón de eliminar SIGNOS VITALES=====/////
    $(document).on('click', '#eliminar_sva', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const fecha = $(element).attr('fe_sva');
        const hora = $(element).attr('hor_sva');
        const temperatura = $(element).attr('te_sva');
        const presion_as = $(element).attr('pas_sva');
        const presion_ad = $(element).attr('pad_sva');
        const pulso = $(element).attr('pu_sva');
        const frecuencia_r = $(element).attr('fr_sva');
        const frecuencia_c = $(element).attr('fc_sva');
        const sat_o = $(element).attr('so_sva');
        const peso = $(element).attr('p_sva');
        const talla = $(element).attr('t_sva');
        const p_abdominal = $(element).attr('pabd_sva');
        const hemo_capilar = $(element).attr('hemoc_sva');
        const gluc_capilar = $(element).attr('glucc_sva');
        const pulsiometria = $(element).attr('pulsio_sva');
        const perimetro = $(element).attr('per_sva');

        const busqueda = JSON.stringify({
            fecha: fecha,
            hora: hora,
            temperatura: temperatura,
            presion_as: presion_as,
            presion_ad: presion_ad,
            pulso: pulso,
            frecuencia_r: frecuencia_r,
            frecuencia_c: frecuencia_c,
            sat_o: sat_o,
            peso: peso,
            talla: talla,
            p_abdominal: p_abdominal,
            hemo_capilar: hemo_capilar,
            gluc_capilar: gluc_capilar,
            pulsiometria: pulsiometria,
            perimetro: perimetro
        });

        

        let indice = signosva.findIndex(sva => JSON.stringify(sva) === busqueda);
        console.log(signosva);
        signosva.splice(indice, 1);
        
        $("#signosva_body > tr").remove();
        console.log(signosva);
        cont_sva -= 1;
        
        signosva.forEach(sva => {
         
            addSignosVA(sva.fecha, sva.hora, sva.temperatura, sva.presion_as, sva.presion_ad, sva.pulso, sva.frecuencia_r, sva.frecuencia_c, sva.sat_o, sva.peso, sva.talla, sva.perimetro, sva.p_abdominal, sva.hemo_cap, sva.gluc_cap, sva.pulsio);
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
                        if (cont_diag >= 4) {
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
                                                                            <td>${diag.descripcion + ". " + diag.diagnostico_esp}</td>
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
                                                                            <td>${diag.descripcion + ". " + diag.diagnostico_esp}</td>
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
        //cargarCIE();
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
                    $("#diagnostico_esp").removeAttr("disabled");
                }
            });
        }else{
            $("#cie").val("");
            $("#diagnostico_esp").attr("disabled", "disabled");
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
        if (descripcion.length>4)
        {
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
        }
    });

    $("#busc_cie_cod").keyup(function() {
        $("#select_diagnos").empty();
        const codigo = $("#busc_cie_cod").val();
        $.ajax({
            type: "POST",
            url: "../php/cie-get-like-cod.php",
            data: {codigo},
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
        $('#busc_cie_cod').val("");
        $('#select_t_diagnostico').val(0);
        $('#diagnostico_esp').val("");
        $('#diagnostico_esp').attr("disabled", "disabled");
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
            $('#busc_cie_cod').val("");
            $('#select_t_diagnostico').val(0);
            $('#diagnostico_esp').val("");
            $('#diagnostico_esp').attr("disabled", "disabled");
        } else {

            const select = document.getElementById("select_diagnos");
            const cie10txt = select.options[select.selectedIndex].text;

            addDiagnostico($('#select_diagnos').val(), cie10txt, $('#select_t_diagnostico').val(), $('#cie').val(), $("#diagnostico_esp").val());

            //==============================Añadir los datos al arreglo definido arriba===============//
            const dat = {
                idCie: $('#select_diagnos').val(),
                diagnos: cie10txt,
                t_diagnostico: $('#select_t_diagnostico').val(),
                cie10: $('#cie').val(),
                diagnostico_esp: $("#diagnostico_esp").val()
            };
            console.log(dat);
            diagnosticos.push(dat);
            console.log(diagnosticos);
            //$("#add_diag_modal").attr('disabled', 'disabled');
            $('#select_diagnos').val("");
            $('#cie').val("");
            $('#busc_cie').val("");
            $('#busc_cie_cod').val("");
            $('#select_t_diagnostico').val(0);
            $('#diagnostico_esp').val("");
            $('#diagnostico_esp').attr("disabled", "disabled");
        }
    });


    //===========================================Función añadir antecedente a la tabla recibiendo datos=====================================//
    function addDiagnostico(id, diag, t_diag, cie, d_esp) {
        const id_cie = id;
        const cie10 = cie;
        const t_diagnostico = t_diag;
        const diagnos = diag;
        const diagnos_esp = d_esp;
        $.ajax({
            type: "POST",
            url: "../php/cita/cita-pac-dat.php",
            data: { id_cita },
            success: function(response) {
                const nombre = JSON.parse(response).nombres_medi;
                const apellido = JSON.parse(response).apellidos_medi;
                const nom_ape = JSON.parse(response).sufijo + " " + nombre + " " + apellido;
                if (t_diag == 0) {
                    $("#diagnostico_table>tbody").append(`<tr id_cie="${id_cie}" cie10="${cie10}" t_diagnostico="${t_diagnostico}" diagnos="${diagnos}" diagnos_esp="${diagnos_esp}">
                                                            <td id='n_a'>${nom_ape}</td>
                                                            <td id='f_a'>${f_actual}</td>
                                                            <td id='id_c'>${diagnos + ". " + diagnos_esp}</td>
                                                            <td id='c10'>${cie10}</td>
                                                            <td id='t_d'>X</td>
                                                            <td></td>
                                                            <td><button id='eliminar_diag' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                        </tr>`);
                }
                if (t_diag == 1) {
                    $("#diagnostico_table>tbody").append(`<tr id_cie="${id_cie}" cie10="${cie10}" t_diagnostico="${t_diagnostico}"  diagnos="${diagnos}" diagnos_esp="${diagnos_esp}">
                                                            <td id='n_a'>${nom_ape}</td>  
                                                            <td id='f_a'>${f_actual}</td>                                      
                                                            <td id='id_c'>${diagnos + ". " + diagnos_esp}</td>
                                                            <td id='c10'>${cie10}</td>
                                                            <td></td>
                                                            <td id='t_d'>X</td>
                                                            <td><button id='eliminar_diag' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                        </tr>`);
                }      
                cont_diag += 1;
                console.log(cont_diag);
                if (cont_diag >= 6) {
                    $("#add_diag_modal").hide();
                }else{
                    $("#add_diag_modal").show();
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
        const diagnos_esp = $(element).attr('diagnos_esp');

        const busqueda = JSON.stringify({
            idCie: idCie,
            diagnos: diagnos,
            t_diagnostico: t_diagnostico,
            cie10: cie10,
            diagnostico_esp: diagnos_esp
        });

        let indice = diagnosticos.findIndex(diag => JSON.stringify(diag) === busqueda);
        diagnosticos.splice(indice, 1);
        $("#diagnostico_body > tr").remove();
        cont_diag = 0;
        cargarDiagPrevios();
        //$("#add_diag_modal").removeAttr('disabled');
        
        diagnosticos.forEach(diag => {
            addDiagnostico(diag.idCie, diag.diagnos, diag.t_diagnostico, diag.cie10, diag.diagnostico_esp);
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
    //==========Cargar Recetas del caso al modal si es que existen========//
    cargarReceCaso();
    
    function cargarReceCaso() {
        var val_hex_col = '#D1EAEF';
        $.ajax({
            type: "POST",
            url: "../php/plan_t/planes_t-get-caso.php",
            data: {id_caso_g, id_cita},
            async: false,
            success: function (response) {
                console.log(response);
                if (response != false) {
                    $("#btn_hreceta").removeAttr("disabled");
                    const resp = JSON.parse(response);
                    let template = '';
                    let id_cita_tmp = 0;
                    resp.forEach(r => {

                        if (Number(id_cita_tmp) == 0) {
                            val_hex_col = '#D1EAEF';
                        } else {
                            if ((Number(id_cita_tmp) == Number(r.id_cita)) && (val_hex_col == '#D1EAEF')) {
                                val_hex_col = '#D1EAEF';
                            } else {
                                if ((Number(id_cita_tmp) == Number(r.id_cita)) && (val_hex_col == '#FFFFFF')) {
                                    val_hex_col = '#FFFFFF';
                                } else {
                                    if ((Number(id_cita_tmp) != Number(r.id_cita)) && (val_hex_col == '#D1EAEF')) {
                                        val_hex_col = '#FFFFFF';
                                    } else {
                                        if ((Number(id_cita_tmp) != Number(r.id_cita)) && (val_hex_col == '#FFFFFF')) {
                                            val_hex_col = '#D1EAEF';
                                        }
                                    }
                                }
                            }
                        }

                        id_cita_tmp = r.id_cita;
                        array_recetas.push({
                            'id_plan_t': r.id_plan_t,
                            'datos_m': r.datos_m,
                            'via_a': r.via_a,
                            'cantidad': r.cantidad,
                            'indicaciones': r.indicaciones
                        });
                        template += `
                                    <tr class="bg-blue" recetaID="${r.id_plan_t}" style="background-color: ${val_hex_col}">
                                        <td class="pt-3" hidden>${r.id_plan_t}</td>
                                        <td class="pt-3">${r.fecha}</td>
                                        <td class="pt-3">${r.datos_m}</td>
                                        <td class="pt-3">${r.via_a}</td>
                                        <td class="pt-3">${r.cantidad}</td>
                                        <td class="pt-3">${r.indicaciones}</td>
                                        <td class="pt-3" style="position: relative"><input class="form-check-input" type="checkbox" id="add_h_rece" style="position: absolute; left: 70%"></td>
                                    </tr>
                                    `;
                    });
                    $('#body_h_rece').html(template); 
                }else {
                    $("#btn_hreceta").attr("disabled", "disabled");
                }
            }
        });
        $.ajax({
            type: "POST",
            url: "../php/plan_t/planes_t-get-cita.php",
            data: {id_cita},
            async: false,
            success: function (response) {
                console.log(response);
                if (response != false) {
                    const resp = JSON.parse(response);
                    resp.forEach(r => {

                        array_recetas.push({
                            'id_plan_t': r.id_plan_t,
                            'datos_m': r.datos_m,
                            'via_a': r.via_a,
                            'cantidad': r.cantidad,
                            'indicaciones': r.indicaciones
                        });
                        
                        addPT(r.datos_m, null, r.via_a, r.cantidad, r.indicaciones);
                        
                    })
                }
            }
        });

       
    }

    //Mostrar modal
    $("#btn_hreceta").click(function (e) { 
        e.preventDefault();
        $('#modalHRecetas').modal("show");
    });

    //Verificar Cheaqueado
    $(document).on('click', '#add_h_rece', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_plan_t = $(element).attr('recetaID');
        $(element).toggleClass("checked");
        if( $(element).hasClass("checked") ) {
            for (let i = 0; i < array_recetas.length; i++) {
                if ( Number(array_recetas[i].id_plan_t) == Number(id_plan_t) ) {
                    array_recetas_g.push(array_recetas[i]);
                }             
            }
        } else {
            for (let i = 0; i < array_recetas_g.length; i++) {
                if ( Number(array_recetas_g[i].id_plan_t) == Number(id_plan_t) ) {
                    array_recetas_g.splice(i, i+1);
                }                
            }
        }    
    });

    //Boton siguiente - MODAL HISTORIAL RECETAS
    $("#btn_sig_hreceta").click(function (e) { 
        e.preventDefault();
        let template = "";
        for (let i = 0; i < array_recetas_g.length; i++) {
            template += `
                                    <tr class="bg-blue">
                                        <td class="pt-3" hidden><input type="text" class="form-control" id="id_plan_t-${i}" value="${array_recetas_g[i].id_plan_t}" disabled></td>
                                        <td class="pt-3"><input type="text" class="form-control" id="datos_m-${i}" value="${array_recetas_g[i].datos_m}"></td>
                                        <td class="pt-3"><input type="text" class="form-control" id="via_a-${i}" value="${array_recetas_g[i].via_a}" disabled></td>
                                        <td class="pt-3"><input type="text" class="form-control" id="cantidad-${i}" value="${array_recetas_g[i].cantidad}"></td>
                                        <td class="pt-3"><input type="text" class="form-control" id="indicaciones-${i}" value="${array_recetas_g[i].indicaciones}"></td>
                                    </tr>
                                    `;
        }
        $('#body_h_rece-items').html(template);
        $('#modalHRecetas').modal("hide");
        $('#modalHRecetas-items').modal("show");
    });

    //Añadir los nuevos registros del historial a la tabla
    $("#btn_add_hreceta").click(function (e) { 
        e.preventDefault();
        for (let i = 0; i < array_recetas_g.length; i++) {
            const datos_m = $(`#datos_m-${i}`).val();
            const via_a = $(`#via_a-${i}`).val();   
            const cantidad = $(`#cantidad-${i}`).val();     
            const indicaciones = $(`#indicaciones-${i}`).val();
            if (datos_m == "" || cantidad == "" || indicaciones == "") {
                $('#texto_modal').html('Ingrese datos en los campos obligatorios');
                $('#modal_icon').attr('style', "color: orange");
                $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
            }else {

                addPT(datos_m, null, via_a, cantidad, indicaciones);

                //==============================Añadir los datos al arreglo definido arriba===============//
                const dat = {
                    d_medicamento: datos_m,
                    via_a: null,
                    via_a_txt: via_a,
                    c_medicamento: cantidad,
                    indicaciones: indicaciones
                };
                plan_t.push(dat);
                $('#modalHRecetas-items').modal("hide");
                $("#btn_hreceta").attr("disabled", "disabled");
            }
        }
    });


    $("#add_medicamento").click(function (e) { 
        e.preventDefault();
        $("#modalTratamiento").modal('show');
    });

    $('#recetaCheck').change(function() {
        if(this.checked) {
            $('#d_medicamento').attr('disabled', 'disabled');
            $('#c_medicamento').attr('disabled', 'disabled');
        }else{
            $('#d_medicamento').removeAttr('disabled');
            $('#c_medicamento').removeAttr('disabled');
        }  
    });

    //==========Click en añadir un plan de tratamiento========//
    $('#add_pt').click(function(e) {
        e.preventDefault();
        const d_medicamento = $('#d_medicamento').val();
        const via_a = $('#select_via_a').val();
        const c_medicamento = $('#c_medicamento').val();
        const indicaciones = $('#indicaciones').val();

        if ($('#recetaCheck').prop('checked')) {
            if (indicaciones == "") {
                $('#texto_modal').html('Ingrese las indicaciones del medicamento');
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
        }else{
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
    
    cargarAdicionalesPrevios();

    function cargarAdicionalesPrevios() {
        $.ajax({
            type: "POST",
            url: "../php/adicional-read.php",
            async: false,
            data: { id_cita },
            success: function(response) {
                if (response != false) {
                const res_adi = JSON.parse(response);
                res_adi.forEach(adi => {
                    let servicio="EXAMEN";
                    if (adi.id==2)
                    {
                        servicio = "PROCEDIMIENTO";
                    }
                    const dat = {
                        id_servicio: adi.id,
                        servicio: servicio,
                        descripcion: adi.descripcion,
                        costo: adi.costo
                    };
                    console.log(dat);
                    adicionales.push(dat);
                    console.log(adicionales);
                    addAdic(adi.id, servicio, adi.descripcion, adi.costo);
                    
                });
                }
            }
        });
    }
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
        $('#texto_modal').html('Procesando Información');
        $('#modal_icon').attr('style', "color: orange");
        $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
        $('#modalPush').modal("show");
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

            if($("#motivo_consulta").val()==""){

                $('#texto_modal').html('Por favor, Ingrese motivo de consulta');
                $('#modal_icon').attr('style',"color:orange");
                $('#modal_icon').attr("class","fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                $('#motivo_consulta').trigger( "focus" );

            } else if ($("#problema_actual").val()==""){
                $('#texto_modal').html('Por favor, Ingrese el problema actual');
                $('#modal_icon').attr('style',"color:orange");
                $('#modal_icon').attr("class","fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");  
                $('#problema_actual').trigger( "focus" );
                
            } else if ( cont_diag == 0) {
                $('#texto_modal').html('Por favor, Ingrese minimo un diagnostico ');
                $('#modal_icon').attr('style', "color: orange");
                $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                $('#add_diag_modal').trigger( "focus" );

            } else if (cont_sva == 0){
                $('#texto_modal').html('Por favor, Ingrese minimo una toma de signos vitales ');
                $('#modal_icon').attr('style', "color: orange");
                $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                $('#signosva_body').trigger( "focus" );
            } 
            else {
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
                                        id_enfermedad: a.id_enfermedad,
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
                                id_caso: id_caso,
                                id_cita: id_cita
                            };
                            $.ajax({
                                type: "POST",
                                url: "../php/cita/mc-pa-add.php",
                                data: datCaso,
                                success: function (response) {
                                    console.log(response);
                                }
                            });
                                
                            //Almacenar la revisión actual de órganos y sistemas                                  
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
                                        orga_sist: 'Genito - Urinario',
                                        cp: cp_genital,
                                        descripcion: $("#genital_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_urinario = 0;
                                    if (!$("#urinario_i").attr('disabled')) {
                                        cp_urinario = 1;
                                    }
                                    const dat_urinario = {
                                        orga_sist: 'Piel - Anexos',
                                        cp: cp_urinario,
                                        descripcion: $("#urinario_i").val(),
                                        id_cita: id_cita
                                    }

                                    var cp_musculoe = 0;
                                    if (!$("#musculoe_i").attr('disabled')) {
                                        cp_musculoe = 1;
                                    }
                                    const dat_musculoe = {
                                        orga_sist: 'Musculo esqueletico',
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
                                                                
                            //Almacenar los signos vitales y antropometría
                            signosva.forEach(sva => {
                                const datSVA = {
                                    fecha: sva.fecha,
                                    hora: sva.hora,
                                    temperatura: sva.temperatura,
                                    presion_as: sva.presion_as,
                                    presion_ad: sva.presion_ad,
                                    pulso: sva.pulso,
                                    frecuencia_r: sva.frecuencia_r,
                                    frecuencia_c: sva.frecuencia_c,
                                    sat_o: sva.sat_o,
                                    peso: sva.peso,
                                    talla: sva.talla,
                                    perimetro: sva.perimetro,
                                    p_abdominal: sva.p_abdominal,
                                    hemo_cap: sva.hemo_cap,
                                    gluc_cap: sva.gluc_cap,
                                    pulsio: sva.pulsio,
                                    id_cita: id_cita
                                };
                                console.log(datSVA);
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
                                //================================== PIEL - FANERAS ========================
                                var cp_piel = 0;
                                if (!$("#piel").attr('disabled')) {
                                    cp_piel = 1;
                                }
                                const dat_piel = {
                                    examen_fr: 'Piel - Faneras',
                                    cp: cp_piel,
                                    descripcion: $("#piel").val(),
                                    id_cita: id_cita
                                }
                                //================================== CABEZA ========================
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
                                //================================== OJOS ========================
                                var cp_ojos = 0;
                                if (!$("#ojos").attr('disabled')) {
                                    cp_ojos = 1;
                                }
                                const dat_ojos = {
                                    examen_fr: 'Ojos',
                                    cp: cp_ojos,
                                    descripcion: $("#ojos").val(),
                                    id_cita: id_cita
                                }

                                
                                //================================== OIDOS ========================
                                var cp_oidos = 0;
                                if (!$("#oidos").attr('disabled')) {
                                    cp_oidos = 1;
                                }
                                const dat_oidos = {
                                    examen_fr: 'Oidos',
                                    cp: cp_oidos,
                                    descripcion: $("#oidos").val(),
                                    id_cita: id_cita
                                }
                                //================================== NARIZ ========================
                                var cp_nariz = 0;
                                if (!$("#nariz").attr('disabled')) {
                                    cp_nariz = 1;
                                }
                                const dat_nariz = {
                                    examen_fr: 'Nariz',
                                    cp: cp_nariz,
                                    descripcion: $("#nariz").val(),
                                    id_cita: id_cita
                                }
                                //================================== BOCA ========================
                                var cp_boca = 0;
                                if (!$("#boca").attr('disabled')) {
                                    cp_boca = 1;
                                }
                                const dat_boca = {
                                    examen_fr: 'Boca',
                                    cp: cp_boca,
                                    descripcion: $("#boca").val(),
                                    id_cita: id_cita
                                }
                                //================================== OROFARINGE ========================
                                var cp_orofaringe = 0;
                                if (!$("#orofaringe").attr('disabled')) {
                                    cp_orofaringe = 1;
                                }
                                const dat_orofaringe = {
                                    examen_fr: 'Orofaringe',
                                    cp: cp_orofaringe,
                                    descripcion: $("#orofaringe").val(),
                                    id_cita: id_cita
                                }
                                //================================== CUELLO ========================
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
                                //================================== AXILAS - MAMAS ========================
                                var cp_axilas = 0;
                                if (!$("#axilas").attr('disabled')) {
                                    cp_axilas = 1;
                                }
                                const dat_axilas = {
                                    examen_fr: 'Axilas - Mamas',
                                    cp: cp_axilas,
                                    descripcion: $("#axilas").val(),
                                    id_cita: id_cita
                                }
                                //================================== TORAX ========================
                                var cp_torax = 0;
                                if (!$("#torax_i").attr('disabled')) {
                                    cp_torax = 1;
                                }
                                const dat_torax = {
                                    examen_fr: 'Torax',
                                    cp: cp_torax,
                                    descripcion: $("#torax_i").val(),
                                    id_cita: id_cita
                                }
                                
                            //================================== ABDOMEN ========================
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
                            //================================== COLUMNA VERTEBRAL ========================
                            var cp_columna = 0;
                            if (!$("#columna").attr('disabled')) {
                                cp_columna = 1;
                            }
                            const dat_columna = {
                                examen_fr: 'Columna',
                                cp: cp_columna,
                                descripcion: $("#columna").val(),
                                id_cita: id_cita
                            }
                            //================================== INGLE - PERINE ========================
                            var cp_ingle = 0;
                            if (!$("#ingle").attr('disabled')) {
                                cp_ingle = 1;
                            }
                            const dat_ingle = {
                                examen_fr: 'Ingle',
                                cp: cp_ingle,
                                descripcion: $("#ingle").val(),
                                id_cita: id_cita
                            }

                            
                            //================================== MIEMBROS SUPERIORES ========================
                            var cp_msup = 0;
                            if (!$("#msup").attr('disabled')) {
                                cp_msup = 1;
                            }
                            const dat_msup = {
                                examen_fr: 'Miembros Superiores',
                                cp: cp_msup,
                                descripcion: $("#msup").val(),
                                id_cita: id_cita
                            }
                            //================================== MIEMBROS INFERIORES ========================
                            var cp_minf = 0;
                            if (!$("#minf").attr('disabled')) {
                                cp_minf = 1;
                            }
                            const dat_minf = {
                                examen_fr: 'Miembros Inferiores',
                                cp: cp_minf,
                                descripcion: $("#minf").val(),
                                id_cita: id_cita
                            }

                            //================================== ORGANOS DE LOS SENTIDOS ========================
                            var cp_sorganos = 0;
                            if (!$("#sorganos").attr('disabled')) {
                                cp_sorganos = 1;
                            }
                            const dat_sorganos = {
                                examen_fr: 'Organos de los Sentidos',
                                cp: cp_sorganos,
                                descripcion: $("#sorganos").val(),
                                id_cita: id_cita
                            }
                            //================================== RESPIRATORIO ========================
                            var cp_srespiratorio = 0;
                            if (!$("#srespiratorio").attr('disabled')) {
                                cp_srespiratorio = 1;
                            }
                            const dat_srespiratorio = {
                                examen_fr: 'Respiratorio',
                                cp: cp_srespiratorio,
                                descripcion: $("#srespiratorio").val(),
                                id_cita: id_cita
                            }
                            
                            //================================== CARDIO - VASCULAR ========================
                            var cp_scardio = 0;
                            if (!$("#scardio").attr('disabled')) {
                                cp_scardio = 1;
                            }
                            const dat_scardio = {
                                examen_fr: 'Cardio - Vascular',
                                cp: cp_scardio,
                                descripcion: $("#scardio").val(),
                                id_cita: id_cita
                            }
                            //================================== DIGESTIVO ========================
                            var cp_sdigestivo = 0;
                            if (!$("#sdigestivo").attr('disabled')) {
                                cp_sdigestivo = 1;
                            }
                            const dat_sdigestivo = {
                                examen_fr: 'Digestivo',
                                cp: cp_sdigestivo,
                                descripcion: $("#sdigestivo").val(),
                                id_cita: id_cita
                            }

                            //================================== GENITAL ========================
                            var cp_sgenital = 0;
                            if (!$("#sgenital").attr('disabled')) {
                                cp_sgenital = 1;
                            }
                            const dat_sgenital = {
                                examen_fr: 'Genital',
                                cp: cp_sgenital,
                                descripcion: $("#sgenital").val(),
                                id_cita: id_cita
                            }
                            //================================== URINARIO ========================
                            var cp_surinario = 0;
                            if (!$("#surinario").attr('disabled')) {
                                cp_surinario = 1;
                            }
                            const dat_surinario = {
                                examen_fr: 'Urinario',
                                cp: cp_surinario,
                                descripcion: $("#surinario").val(),
                                id_cita: id_cita
                            }
                            
                            //================================== MUSCULO ESQUELETICO ========================
                            var cp_smusculo = 0;
                            if (!$("#smusculo").attr('disabled')) {
                                cp_smusculo = 1;
                            }
                            const dat_smusculo = {
                                examen_fr: 'Musculo Esqueletico',
                                cp: cp_smusculo,
                                descripcion: $("#smusculo").val(),
                                id_cita: id_cita
                            }
                            //================================== ENDOCRINO ========================
                            var cp_sendocrino = 0;
                            if (!$("#sendocrino").attr('disabled')) {
                                cp_sendocrino = 1;
                            }
                            const dat_sendocrino = {
                                examen_fr: 'Endocrino',
                                cp: cp_sendocrino,
                                descripcion: $("#sendocrino").val(),
                                id_cita: id_cita
                            }
                            
                            //================================== HEMO - LINFATICO ========================
                            var cp_shemo = 0;
                            if (!$("#shemo").attr('disabled')) {
                                cp_shemo = 1;
                            }
                            const dat_shemo = {
                                examen_fr: 'Hemo - Linfatico',
                                cp: cp_shemo,
                                descripcion: $("#shemo").val(),
                                id_cita: id_cita
                            }
                            //================================== NEUROLOGICO ========================
                            var cp_sneurologico = 0;
                            if (!$("#sneurologico").attr('disabled')) {
                                cp_sneurologico = 1;
                            }
                            const dat_sneurologico = {
                                examen_fr: 'Neurologico',
                                cp: cp_sneurologico,
                                descripcion: $("#sneurologico").val(),
                                id_cita: id_cita
                            }

                                const efr = [dat_piel, dat_cabeza, dat_ojos, dat_oidos, dat_nariz, dat_boca, 
                                    dat_orofaringe, dat_cuello, dat_axilas, dat_torax, dat_abdomen, 
                                    dat_columna, dat_ingle, dat_msup, dat_minf, dat_sorganos, 
                                    dat_srespiratorio, dat_scardio, dat_sdigestivo, dat_sgenital, 
                                    dat_surinario, dat_smusculo, dat_sendocrino, dat_shemo, dat_sneurologico];
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

    
                            //Almacenar diagnóstico
                            diagnosticos.forEach(d => {
                                const datDiag = {
                                    descripcion: d.diagnos,
                                    pre_def: d.t_diagnostico,
                                    id_cie: d.idCie,
                                    diagnostico_esp: d.diagnostico_esp,
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

                            if (adicionales.length == 0) {
                                $.ajax({
                                    type: "POST",
                                    url: "../php/adicional-delete.php",
                                    data: {id_cita},
                                    success: function(response) {
                                        console.log(response);
                                    }
                                });
                                
                            }
                            
                            //Guardar el detalle para el certificado médico
                            const detalle_certificado = $("#detalle_certificado").val();
                            $.ajax({
                                type: "POST",
                                url: "../php/detalle-certificado-add.php",
                                data: {id_cita, detalle_certificado},
                                success: function(response) {
                                    console.log(response);
                                }
                            });
    
                            //Establecer la cita como atendida//
                            $.ajax({
                                type: "POST",
                                url: "../php/cita/cita-atendida.php",
                                data: { id_cita },
                                success: function(response) {
                                    console.log(response);
                                    //Mostrar mensaje de Guardado de Datos
                                   
                                    $('#texto_modal').html('La cita ha sido atendida y los datos se han guardado exitosamente');
                                    $('#modal_icon').attr('style', "color: green");
                                    $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                                    $('#modalPush').modal("show");
                                    setTimeout(function() { window.location.href = `reporte_cita.php?id_cita=${id_cita}`; }, 3000);
                                 }
                            });
                            
                            
    
                            
                             
     
                         }
                     }
                 });      
            }
        

        
         

    });

    //===================================================BOTÓN PARA GUARDAR COMO BORRADOR====================================//
    $("#btn_borrador").click(function(e) {
        e.preventDefault();
        $('#texto_modal').html('Procesando Información');
        $('#modal_icon').attr('style', "color: orange");
        $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
        $('#modalPush').modal("show");
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

        if ((($("#motivo_consulta").val() == "")&&(!$("#motivo_consulta").attr('disabled'))) || (($("#problema_actual").val() == "")&&(!$("#problema_actual").attr('disabled'))) ) {
            $('#texto_modal').html('Ingrese los valores obligatorios: Motivo de Consulta, Enfermedad, Signos Vitales');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.ajax({
                type: "POST",
                url: "../php/cita/cita-pac-dat.php",
                data: { id_cita },
                success: function(response) {
                    const tarifa = Number(JSON.parse(response).tarifa);
                    const descuento = Number($("#descuento").val());
                
            

                    if (descuento > tarifa) {//ojo-actual
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
                        id_enfermedad: a.id_enfermedad,
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
                id_caso: id_caso,
                id_cita: id_cita
            };
            
            $.ajax({
                    type: "POST",
                    url: "../php/cita/mc-pa-add.php",
                    data: datCaso,
                    success: function (response) {
                        console.log(response);
                    }
                });

            //Almacenar la revisión actual de órganos y sistemas                                  
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
                orga_sist: 'Genito - Urinario',
                cp: cp_genital,
                descripcion: $("#genital_i").val(),
                id_cita: id_cita
            }

            var cp_urinario = 0;
            if (!$("#urinario_i").attr('disabled')) {
                cp_urinario = 1;
            }
            const dat_urinario = {
                orga_sist: 'Piel - Anexos',
                cp: cp_urinario,
                descripcion: $("#urinario_i").val(),
                id_cita: id_cita
            }

            var cp_musculoe = 0;
            if (!$("#musculoe_i").attr('disabled')) {
                cp_musculoe = 1;
            }
            const dat_musculoe = {
                orga_sist: 'Musculo esqueletico',
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
                                        
    //Almacenar los signos vitales y antropometría
    signosva.forEach(sva => {
        const datSVA = {
            fecha: sva.fecha,
            hora: sva.hora,
            temperatura: sva.temperatura,
            presion_as: sva.presion_as,
            presion_ad: sva.presion_ad,
            pulso: sva.pulso,
            frecuencia_r: sva.frecuencia_r,
            frecuencia_c: sva.frecuencia_c,
            sat_o: sva.sat_o,
            peso: sva.peso,
            talla: sva.talla,
            perimetro: sva.perimetro,
            p_abdominal: sva.p_abdominal,
            hemo_cap: sva.hemo_cap,
            gluc_cap: sva.gluc_cap,
            pulsio: sva.pulsio,
            id_cita: id_cita
        };
        console.log(datSVA);
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
        //================================== PIEL - FANERAS ========================
        var cp_piel = 0;
        if (!$("#piel").attr('disabled')) {
            cp_piel = 1;
        }
        const dat_piel = {
            examen_fr: 'Piel - Faneras',
            cp: cp_piel,
            descripcion: $("#piel").val(),
            id_cita: id_cita
        }
        //================================== CABEZA ========================
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
        //================================== OJOS ========================
        var cp_ojos = 0;
        if (!$("#ojos").attr('disabled')) {
            cp_ojos = 1;
        }
        const dat_ojos = {
            examen_fr: 'Ojos',
            cp: cp_ojos,
            descripcion: $("#ojos").val(),
            id_cita: id_cita
        }

        
        //================================== OIDOS ========================
        var cp_oidos = 0;
        if (!$("#oidos").attr('disabled')) {
            cp_oidos = 1;
        }
        const dat_oidos = {
            examen_fr: 'Oidos',
            cp: cp_oidos,
            descripcion: $("#oidos").val(),
            id_cita: id_cita
        }
        //================================== NARIZ ========================
        var cp_nariz = 0;
        if (!$("#nariz").attr('disabled')) {
            cp_nariz = 1;
        }
        const dat_nariz = {
            examen_fr: 'Nariz',
            cp: cp_nariz,
            descripcion: $("#nariz").val(),
            id_cita: id_cita
        }
        //================================== BOCA ========================
        var cp_boca = 0;
        if (!$("#boca").attr('disabled')) {
            cp_boca = 1;
        }
        const dat_boca = {
            examen_fr: 'Boca',
            cp: cp_boca,
            descripcion: $("#boca").val(),
            id_cita: id_cita
        }
        //================================== OROFARINGE ========================
        var cp_orofaringe = 0;
        if (!$("#orofaringe").attr('disabled')) {
            cp_orofaringe = 1;
        }
        const dat_orofaringe = {
            examen_fr: 'Orofaringe',
            cp: cp_orofaringe,
            descripcion: $("#orofaringe").val(),
            id_cita: id_cita
        }
        //================================== CUELLO ========================
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
        //================================== AXILAS - MAMAS ========================
        var cp_axilas = 0;
        if (!$("#axilas").attr('disabled')) {
            cp_axilas = 1;
        }
        const dat_axilas = {
            examen_fr: 'Axilas - Mamas',
            cp: cp_axilas,
            descripcion: $("#axilas").val(),
            id_cita: id_cita
        }
        //================================== TORAX ========================
        var cp_torax = 0;
        if (!$("#torax_i").attr('disabled')) {
            cp_torax = 1;
        }
        const dat_torax = {
            examen_fr: 'Torax',
            cp: cp_torax,
            descripcion: $("#torax_i").val(),
            id_cita: id_cita
        }
        
    //================================== ABDOMEN ========================
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
    //================================== COLUMNA VERTEBRAL ========================
    var cp_columna = 0;
    if (!$("#columna").attr('disabled')) {
        cp_columna = 1;
    }
    const dat_columna = {
        examen_fr: 'Columna',
        cp: cp_columna,
        descripcion: $("#columna").val(),
        id_cita: id_cita
    }
    //================================== INGLE - PERINE ========================
    var cp_ingle = 0;
    if (!$("#ingle").attr('disabled')) {
        cp_ingle = 1;
    }
    const dat_ingle = {
        examen_fr: 'Ingle',
        cp: cp_ingle,
        descripcion: $("#ingle").val(),
        id_cita: id_cita
    }

    
    //================================== MIEMBROS SUPERIORES ========================
    var cp_msup = 0;
    if (!$("#msup").attr('disabled')) {
        cp_msup = 1;
    }
    const dat_msup = {
        examen_fr: 'Miembros Superiores',
        cp: cp_msup,
        descripcion: $("#msup").val(),
        id_cita: id_cita
    }
    //================================== MIEMBROS INFERIORES ========================
    var cp_minf = 0;
    if (!$("#minf").attr('disabled')) {
        cp_minf = 1;
    }
    const dat_minf = {
        examen_fr: 'Miembros Inferiores',
        cp: cp_minf,
        descripcion: $("#minf").val(),
        id_cita: id_cita
    }

    //================================== ORGANOS DE LOS SENTIDOS ========================
    var cp_sorganos = 0;
    if (!$("#sorganos").attr('disabled')) {
        cp_sorganos = 1;
    }
    const dat_sorganos = {
        examen_fr: 'Organos de los Sentidos',
        cp: cp_sorganos,
        descripcion: $("#sorganos").val(),
        id_cita: id_cita
    }
    //================================== RESPIRATORIO ========================
    var cp_srespiratorio = 0;
    if (!$("#srespiratorio").attr('disabled')) {
        cp_srespiratorio = 1;
    }
    const dat_srespiratorio = {
        examen_fr: 'Respiratorio',
        cp: cp_srespiratorio,
        descripcion: $("#srespiratorio").val(),
        id_cita: id_cita
    }
    
    //================================== CARDIO - VASCULAR ========================
    var cp_scardio = 0;
    if (!$("#scardio").attr('disabled')) {
        cp_scardio = 1;
    }
    const dat_scardio = {
        examen_fr: 'Cardio - Vascular',
        cp: cp_scardio,
        descripcion: $("#scardio").val(),
        id_cita: id_cita
    }
    //================================== DIGESTIVO ========================
    var cp_sdigestivo = 0;
    if (!$("#sdigestivo").attr('disabled')) {
        cp_sdigestivo = 1;
    }
    const dat_sdigestivo = {
        examen_fr: 'Digestivo',
        cp: cp_sdigestivo,
        descripcion: $("#sdigestivo").val(),
        id_cita: id_cita
    }

    //================================== GENITAL ========================
    var cp_sgenital = 0;
    if (!$("#sgenital").attr('disabled')) {
        cp_sgenital = 1;
    }
    const dat_sgenital = {
        examen_fr: 'Genital',
        cp: cp_sgenital,
        descripcion: $("#sgenital").val(),
        id_cita: id_cita
    }
    //================================== URINARIO ========================
    var cp_surinario = 0;
    if (!$("#surinario").attr('disabled')) {
        cp_surinario = 1;
    }
    const dat_surinario = {
        examen_fr: 'Urinario',
        cp: cp_surinario,
        descripcion: $("#surinario").val(),
        id_cita: id_cita
    }
    
    //================================== MUSCULO ESQUELETICO ========================
    var cp_smusculo = 0;
    if (!$("#smusculo").attr('disabled')) {
        cp_smusculo = 1;
    }
    const dat_smusculo = {
        examen_fr: 'Musculo Esqueletico',
        cp: cp_smusculo,
        descripcion: $("#smusculo").val(),
        id_cita: id_cita
    }
    //================================== ENDOCRINO ========================
    var cp_sendocrino = 0;
    if (!$("#sendocrino").attr('disabled')) {
        cp_sendocrino = 1;
    }
    const dat_sendocrino = {
        examen_fr: 'Endocrino',
        cp: cp_sendocrino,
        descripcion: $("#sendocrino").val(),
        id_cita: id_cita
    }
    
    //================================== HEMO - LINFATICO ========================
    var cp_shemo = 0;
    if (!$("#shemo").attr('disabled')) {
        cp_shemo = 1;
    }
    const dat_shemo = {
        examen_fr: 'Hemo - Linfatico',
        cp: cp_shemo,
        descripcion: $("#shemo").val(),
        id_cita: id_cita
    }
    //================================== NEUROLOGICO ========================
    var cp_sneurologico = 0;
    if (!$("#sneurologico").attr('disabled')) {
        cp_sneurologico = 1;
    }
    const dat_sneurologico = {
        examen_fr: 'Neurologico',
        cp: cp_sneurologico,
        descripcion: $("#sneurologico").val(),
        id_cita: id_cita
    }

        const efr = [dat_piel, dat_cabeza, dat_ojos, dat_oidos, dat_nariz, dat_boca, 
            dat_orofaringe, dat_cuello, dat_axilas, dat_torax, dat_abdomen, 
            dat_columna, dat_ingle, dat_msup, dat_minf, dat_sorganos, 
            dat_srespiratorio, dat_scardio, dat_sdigestivo, dat_sgenital, 
            dat_surinario, dat_smusculo, dat_sendocrino, dat_shemo, dat_sneurologico];
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

        //Almacenar diagnóstico
        diagnosticos.forEach(d => {
            const datDiag = {
                descripcion: d.diagnos,
                pre_def: d.t_diagnostico,
                id_cie: d.idCie,
                diagnostico_esp: d.diagnostico_esp,
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

            if (adicionales.length == 0) {
                $.ajax({
                    type: "POST",
                    url: "../php/adicional-delete.php",
                    data: {id_cita},
                    success: function(response) {
                        console.log(response);
                    }
                });
                
            }
                //Guardar el detalle para el certificado médico
                const detalle_certificado = $("#detalle_certificado").val();
                $.ajax({
                    type: "POST",
                    url: "../php/detalle-certificado-add.php",
                    data: {id_cita, detalle_certificado},
                    success: function(response) {
                        console.log(response);
                    }
                });        
            //Establecer la cita como resultado//
            $.ajax({
                type: "POST",
                url: "../php/cita/cita-resultado.php",
                data: { id_cita },
                success: function(response) {
                    console.log(response);
                        
                        $('#texto_modal').html('Información guardada con exito.');
                        $('#modal_icon').attr('style', "color: green");
                        $('#modal_icon').attr("class", "fa fa-check fa-4x animated rotateIn mb-4");
                        $('#modalPush').modal("show");
                     setTimeout(function() { window.location.href = `sala_espera.php`; }, 3000);
                }
            });
            
            

                    }
                }
            });
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
    //====================== 1R PIEL FANERAS ====================================
    $("#cp_piel").click(function(e) {
        e.preventDefault();
        $("#piel").removeAttr('disabled');
        $("#sp_piel").removeAttr('disabled');
        $("#cp_piel").attr('disabled', 'disabled');
    });
    $("#sp_piel").click(function(e) {
        e.preventDefault();
        $("#piel").attr('disabled', 'disabled');
        $("#piel").val('');
        $("#cp_piel").removeAttr('disabled');
        $("#sp_piel").attr('disabled', 'disabled');
    });
    //====================== 2R CABEZA   ========================================
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
    //====================== 3R OJOS   ========================================
    $("#cp_ojos").click(function(e) {
        e.preventDefault();
        $("#ojos").removeAttr('disabled');
        $("#sp_ojos").removeAttr('disabled');
        $("#cp_ojos").attr('disabled', 'disabled');
    });
    $("#sp_ojos").click(function(e) {
        e.preventDefault();
        $("#ojos").attr('disabled', 'disabled');
        $("#ojos").val('');
        $("#cp_ojos").removeAttr('disabled');
        $("#sp_ojos").attr('disabled', 'disabled');
    });
    //====================== 4R OIDOS   ========================================
    $("#cp_oidos").click(function(e) {
        e.preventDefault();
        $("#oidos").removeAttr('disabled');
        $("#sp_oidos").removeAttr('disabled');
        $("#cp_oidos").attr('disabled', 'disabled');
    });
    $("#sp_oidos").click(function(e) {
        e.preventDefault();
        $("#oidos").attr('disabled', 'disabled');
        $("#oidos").val('');
        $("#cp_oidos").removeAttr('disabled');
        $("#sp_oidos").attr('disabled', 'disabled');
    });
    //====================== 5R NARIZ   ========================================
    $("#cp_nariz").click(function(e) {
        e.preventDefault();
        $("#nariz").removeAttr('disabled');
        $("#sp_nariz").removeAttr('disabled');
        $("#cp_nariz").attr('disabled', 'disabled');
    });
    $("#sp_nariz").click(function(e) {
        e.preventDefault();
        $("#nariz").attr('disabled', 'disabled');
        $("#nariz").val('');
        $("#cp_nariz").removeAttr('disabled');
        $("#sp_nariz").attr('disabled', 'disabled');
    });
    //====================== 6R BOCA   ========================================
    $("#cp_boca").click(function(e) {
        e.preventDefault();
        $("#boca").removeAttr('disabled');
        $("#sp_boca").removeAttr('disabled');
        $("#cp_boca").attr('disabled', 'disabled');
    });
    $("#sp_boca").click(function(e) {
        e.preventDefault();
        $("#boca").attr('disabled', 'disabled');
        $("#boca").val('');
        $("#cp_boca").removeAttr('disabled');
        $("#sp_boca").attr('disabled', 'disabled');
    });
    //====================== 7R OROFARINGE   ========================================
    $("#cp_orofaringe").click(function(e) {
        e.preventDefault();
        $("#orofaringe").removeAttr('disabled');
        $("#sp_orofaringe").removeAttr('disabled');
        $("#cp_orofaringe").attr('disabled', 'disabled');
    });
    $("#sp_orofaringe").click(function(e) {
        e.preventDefault();
        $("#orofaringe").attr('disabled', 'disabled');
        $("#orofaringe").val('');
        $("#cp_orofaringe").removeAttr('disabled');
        $("#sp_orofaringe").attr('disabled', 'disabled');
    });
  //============================ 8R CUELLO =======================================
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

  //============================ 9R AXILAS =======================================
    $("#cp_axilas").click(function(e) {
        e.preventDefault();
        $("#axilas").removeAttr('disabled');
        $("#sp_axilas").removeAttr('disabled');
        $("#cp_axilas").attr('disabled', 'disabled');
    });
    $("#sp_axilas").click(function(e) {
        e.preventDefault();
        $("#axilas").attr('disabled', 'disabled');
        $("#axilas").val('');
        $("#cp_axilas").removeAttr('disabled');
        $("#sp_axilas").attr('disabled', 'disabled');
    });
//============================ 10R TORAX =======================================

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

//============================ 11R ABDOMEN =======================================

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
//============================ 12R COLUMNA VERTEBRAL =======================================
    $("#cp_columna").click(function(e) {
        e.preventDefault();
        $("#columna").removeAttr('disabled');
        $("#sp_columna").removeAttr('disabled');
        $("#cp_columna").attr('disabled', 'disabled');
    });
    $("#sp_columna").click(function(e) {
        e.preventDefault();
        $("#columna").attr('disabled', 'disabled');
        $("#columna").val('');
        $("#cp_columna").removeAttr('disabled');
        $("#sp_columna").attr('disabled', 'disabled');
    });
//============================ 13R INGLE =======================================
    $("#cp_ingle").click(function(e) {
        e.preventDefault();
        $("#ingle").removeAttr('disabled');
        $("#sp_ingle").removeAttr('disabled');
        $("#cp_ingle").attr('disabled', 'disabled');
    });
    $("#sp_ingle").click(function(e) {
        e.preventDefault();
        $("#ingle").attr('disabled', 'disabled');
        $("#ingle").val('');
        $("#cp_ingle").removeAttr('disabled');
        $("#sp_ingle").attr('disabled', 'disabled');
    });
//============================ 14R M. SUPERIORES =======================================
$("#cp_msup").click(function(e) {
    e.preventDefault();
    $("#msup").removeAttr('disabled');
    $("#sp_msup").removeAttr('disabled');
    $("#cp_msup").attr('disabled', 'disabled');
});
$("#sp_msup").click(function(e) {
    e.preventDefault();
    $("#msup").attr('disabled', 'disabled');
    $("#msup").val('');
    $("#cp_msup").removeAttr('disabled');
    $("#sp_msup").attr('disabled', 'disabled');
});
//============================ 15R M. INFERIORES =======================================
$("#cp_minf").click(function(e) {
    e.preventDefault();
    $("#minf").removeAttr('disabled');
    $("#sp_minf").removeAttr('disabled');
    $("#cp_minf").attr('disabled', 'disabled');
});
$("#sp_minf").click(function(e) {
    e.preventDefault();
    $("#minf").attr('disabled', 'disabled');
    $("#minf").val('');
    $("#cp_minf").removeAttr('disabled');
    $("#sp_minf").attr('disabled', 'disabled');
});
//============================ 1S ORG SENTIDOS =======================================
$("#cp_sorganos").click(function(e) {
    e.preventDefault();
    $("#sorganos").removeAttr('disabled');
    $("#sp_sorganos").removeAttr('disabled');
    $("#cp_sorganos").attr('disabled', 'disabled');
});
$("#sp_sorganos").click(function(e) {
    e.preventDefault();
    $("#sorganos").attr('disabled', 'disabled');
    $("#sorganos").val('');
    $("#cp_sorganos").removeAttr('disabled');
    $("#sp_sorganos").attr('disabled', 'disabled');
});
//============================ 2S RESPIRATORIO =======================================
$("#cp_srespiratorio").click(function(e) {
    e.preventDefault();
    $("#srespiratorio").removeAttr('disabled');
    $("#sp_srespiratorio").removeAttr('disabled');
    $("#cp_srespiratorio").attr('disabled', 'disabled');
});
$("#sp_srespiratorio").click(function(e) {
    e.preventDefault();
    $("#srespiratorio").attr('disabled', 'disabled');
    $("#srespiratorio").val('');
    $("#cp_srespiratorio").removeAttr('disabled');
    $("#sp_srespiratorio").attr('disabled', 'disabled');
});
//============================ 3S CARDIO-VASCULAR =======================================
$("#cp_scardio").click(function(e) {
    e.preventDefault();
    $("#scardio").removeAttr('disabled');
    $("#sp_scardio").removeAttr('disabled');
    $("#cp_scardio").attr('disabled', 'disabled');
});
$("#sp_scardio").click(function(e) {
    e.preventDefault();
    $("#scardio").attr('disabled', 'disabled');
    $("#scardio").val('');
    $("#cp_scardio").removeAttr('disabled');
    $("#sp_scardio").attr('disabled', 'disabled');
});
//============================ 4S DIGESTIVO =======================================
$("#cp_sdigestivo").click(function(e) {
    e.preventDefault();
    $("#sdigestivo").removeAttr('disabled');
    $("#sp_sdigestivo").removeAttr('disabled');
    $("#cp_sdigestivo").attr('disabled', 'disabled');
});
$("#sp_sdigestivo").click(function(e) {
    e.preventDefault();
    $("#sdigestivo").attr('disabled', 'disabled');
    $("#sdigestivo").val('');
    $("#cp_sdigestivo").removeAttr('disabled');
    $("#sp_sdigestivo").attr('disabled', 'disabled');
});
//============================ 5S GENITAL =======================================
$("#cp_sgenital").click(function(e) {
    e.preventDefault();
    $("#sgenital").removeAttr('disabled');
    $("#sp_sgenital").removeAttr('disabled');
    $("#cp_sgenital").attr('disabled', 'disabled');
});
$("#sp_sgenital").click(function(e) {
    e.preventDefault();
    $("#sgenital").attr('disabled', 'disabled');
    $("#sgenital").val('');
    $("#cp_sgenital").removeAttr('disabled');
    $("#sp_sgenital").attr('disabled', 'disabled');
});
//============================ 6S URINARIO =======================================
$("#cp_surinario").click(function(e) {
    e.preventDefault();
    $("#surinario").removeAttr('disabled');
    $("#sp_surinario").removeAttr('disabled');
    $("#cp_surinario").attr('disabled', 'disabled');
});
$("#sp_surinario").click(function(e) {
    e.preventDefault();
    $("#surinario").attr('disabled', 'disabled');
    $("#surinario").val('');
    $("#cp_surinario").removeAttr('disabled');
    $("#sp_surinario").attr('disabled', 'disabled');
});
//============================ 7S MUSCULO - ESQUELETICO =======================================
$("#cp_smusculo").click(function(e) {
    e.preventDefault();
    $("#smusculo").removeAttr('disabled');
    $("#sp_smusculo").removeAttr('disabled');
    $("#cp_smusculo").attr('disabled', 'disabled');
});
$("#sp_smusculo").click(function(e) {
    e.preventDefault();
    $("#smusculo").attr('disabled', 'disabled');
    $("#smusculo").val('');
    $("#cp_smusculo").removeAttr('disabled');
    $("#sp_smusculo").attr('disabled', 'disabled');
});
//============================ 8S ENDOCRINO =======================================
$("#cp_sendocrino").click(function(e) {
    e.preventDefault();
    $("#sendocrino").removeAttr('disabled');
    $("#sp_sendocrino").removeAttr('disabled');
    $("#cp_sendocrino").attr('disabled', 'disabled');
});
$("#sp_sendocrino").click(function(e) {
    e.preventDefault();
    $("#sendocrino").attr('disabled', 'disabled');
    $("#sendocrino").val('');
    $("#cp_sendocrino").removeAttr('disabled');
    $("#sp_sendocrino").attr('disabled', 'disabled');
});
//============================ 9S HEMO - LINFATICO =======================================
$("#cp_shemo").click(function(e) {
    e.preventDefault();
    $("#shemo").removeAttr('disabled');
    $("#sp_shemo").removeAttr('disabled');
    $("#cp_shemo").attr('disabled', 'disabled');
});
$("#sp_shemo").click(function(e) {
    e.preventDefault();
    $("#shemo").attr('disabled', 'disabled');
    $("#shemo").val('');
    $("#cp_shemo").removeAttr('disabled');
    $("#sp_shemo").attr('disabled', 'disabled');
});
//============================ 10S NEUROLOGICO =======================================
$("#cp_sneurologico").click(function(e) {
    e.preventDefault();
    $("#sneurologico").removeAttr('disabled');
    $("#sp_sneurologico").removeAttr('disabled');
    $("#cp_sneurologico").attr('disabled', 'disabled');
});
$("#sp_sneurologico").click(function(e) {
    e.preventDefault();
    $("#sneurologico").attr('disabled', 'disabled');
    $("#sneurologico").val('');
    $("#cp_sneurologico").removeAttr('disabled');
    $("#sp_sneurologico").attr('disabled', 'disabled');
});

    $("#ros_normal").hide();
    $("#o_rev_org").hide();
    $("#efr_normal").hide();
    $("#o_efr").hide();
    //------------------------- Control de visibilidad de bloques -----------------
    $("#v_rev_org").click(function(e) {
        e.preventDefault();
        $("#v_rev_org").hide();
        $("#o_rev_org").show();
        $("#ros_normal").show();
    });
    $("#o_rev_org").click(function(e) {
        e.preventDefault();
        $("#o_rev_org").hide();
        $("#v_rev_org").show();
        $("#ros_normal").hide();
    });

    $("#v_efr").click(function(e) {
        e.preventDefault();
        $("#v_efr").hide();
        $("#o_efr").show();
        $("#efr_normal").show();
    });
    $("#o_efr").click(function(e) {
        e.preventDefault();
        $("#o_efr").hide();
        $("#v_efr").show();
        $("#efr_normal").hide();
    });


    $("#revision_de_organos").hide();
    $("#signos_vitales").hide();
    $("#examen_fisico").hide();
   
});