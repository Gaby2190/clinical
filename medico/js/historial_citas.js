$(document).ready(function() {
    
     $('#div_table_hcitas').hide();
     
    const id_usuario = $("#id_usuario").val();
    const id_medico = JSON.parse($.ajax({
        type: "POST",
        glogal: false,
        async: false,
        url: "../php/medico/medico-list-id.php",
        data: {id_usuario},
        success: function (response) {
            return response;
        }
    }).responseText).id_medico;

    function listarCitas(txt){
        const txt_search = txt;
        $.ajax({
            type: "POST",
            data: {txt_search, id_medico},
            url: "../php/historial_citas/historial_citas-med-get.php",
            beforeSend: function() {
            
               $('#respuesta').html('<div class="d-flex align-items-center"><strong>Espere porfavor estamos buscando las coincidencias...           </strong><div class="spinner-border text-info ml-auto" role="status" aria-hidden="true"></div></div>');
               $('#div_table_hcitas').hide();
              
            },
            success: function (response) {
                 $("#respuesta").html('');
                if (response == false) {
                    $('#texto_modal').html("No se encuentran historial de citas para el paciente indicado");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $("#hcitas_body > tr").remove();
                     $('#div_table_hcitas').hide();

                } else { 
                    const resp = JSON.parse(response);
                    let template = '';
                    resp.forEach(r => {
                        const id_cita = r.id_cita;
                        const id_paciente = r.id_paciente;
                        const descripcion = JSON.parse($.ajax({
                            type: "POST",
                            url: '../php/historial_citas/cita_diagnostico.php',
                            data: { id_cita },
                            global: false,
                            async: false,
                            success: function(response) {
                                    return response;
                            }
                        }).responseText).descripcion;
                        const hora = r.hora.slice(0, -3);
                        template += `<tr class="bg-blue" citaID="${id_cita}" pacienteID="${id_paciente}">
                                        <td class="pt-3">${r.fecha}</td>
                                        <td class="pt-3">${hora}h</td>
                                        <td class="pt-3">${r.apellidos_paci1 + " "+r.apellidos_paci2 +" "+ r.nombres_paci1 +" "+ r.nombres_paci2}</td>
                                        <td class="pt-3">${r.sufijo +" "+ r.apellidos_medi +" "+ r.nombres_medi}</td>
                                        <td class="pt-3">${descripcion}</td>
                                        <td class="pt-3"><a href="#" style="color: #fff" class="btn btn-success btn-sm" id="m_cita">Modificar cita</a><br/>
                                        <a href="#" style="color: #fff" class="btn btn-primary btn-sm" id="certificado_m">Certificado</a><br/>
                                        <a href="#" style="color: #fff" class="btn btn-secondary btn-sm" id="receta_m">Receta</a><br/>
                                        <a href="reporte_alta.php?id_caso=${r.id_caso}" target="_blank" style="color: #fff" class="btn btn-success btn-sm">Formularios</a></td>
                                    </tr>
                                    <tr id="scitang-row">
                                        <td></td>
                                    </tr>`;
                    }); 
                    $('#hcitas_body').html(template);
                    $('#div_table_hcitas').show();
                }
            }
        });
    }
    
    
    $(document).on('click', '#certificado_m', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita = $(element).attr('citaID');
        window.open(`../php/reportes/word/certificado_word.php?id_cita=${id_cita}`, '_blank');
    });
    
    $(document).on('click', '#receta_m', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita = $(element).attr('citaID');
        window.open(`../php/reportes/reporte_receta.php?id_cita=${id_cita}`, '_blank');
    });
    
    $(document).on('click', '#m_cita', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita = $(element).attr('citaID');
        const id_paciente = $(element).attr('pacienteID');
        window.open(`atencion_paci.php?id_paciente=${id_paciente}&id_cita=${id_cita}`, '_blank');
    });

    //Busqueda en la tabla de pacientes
    $('#busc_paci').keypress(function (e) {
        const key = e.which;
        if(key == 13)  // the enter key code
         {
           const txt__search = $("#busc_paci").val();
           listarCitas(txt__search);
         }
    });


});