$(document).ready(function() {

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    
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

    listarCitas();

    function listarCitas(){
        $.ajax({
            type: "POST",
            data: {f_actual, id_medico},
            url: "../php/citas_atendidas/citas_atendidas-med-get.php",
            success: function (response) {
                if (response == false) {
                    $('#texto_modal').html("No se encuentran citas atendidas para el paciente indicado");
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
                                        <td class="pt-3"><a href="#" style="color: #fff" class="btn btn-success btn-sm" id="m_cita">Modificar cita</a><br><a href="#" style="color: #fff" class="btn btn-primary btn-sm" id="certificado_m">Certificado</a><a href="#" style="color: #fff" class="btn btn-secondary btn-sm" id="receta_m">Receta</a></td>
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
        window.open(`../php/reportes/certificado_medico.php?id_cita=${id_cita}`, '_blank');
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
        window.open(`m_cita.php?id_paciente=${id_paciente}&id_cita=${id_cita}`, '_blank');
    });
});