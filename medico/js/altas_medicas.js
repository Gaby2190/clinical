$(document).ready(function() {
    $('#div_table_altas').hide();
    const id_usuario = $("#id_usuario").val();
    
    const id_medico = JSON.parse($.ajax({
        type: "POST",
        glogal: false,
        async: false,
        url: "../php/medico/medico-list-id.php",
        data: {id_usuario},
        success: function (response) {
            $("#select_medico").val(JSON.parse(response).id_medico);
            return response;
        }
    }).responseText).id_medico;
    
    function listarPacientes() {
        $.ajax({
            type: "POST",
            data: {id_medico},
            url: '../php/paciente/pacientes-list-medico.php',
            success: function(response) {
                const pacientes = JSON.parse(response);
                let template = '';
                pacientes.forEach(paci => {
                    //========Unión de un nombre y un apellido ===================
                    const nom_ape = paci.nombres_paci1 + " " + paci.nombres_paci2 + " " + paci.apellidos_paci1 + " " + paci.apellidos_paci2;

                    template += `
                                    <tr class="bg-blue" pacienteID="${paci.id_paciente}" pacienteUSR="${paci.id_usuario}">
                                        <td class="pt-3" hidden>${paci.id_paciente}</td>
                                        <td class="pt-2">
                                            <img src="../${paci.imagen}" class="rounded-circle" alt="">
                                            <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                        </td>
                                        <td class="pt-3">${paci.cedula_paci}</td>
                                        <td class="pt-3">${paci.celular_paci}</td>
                                        <td class="pt-3"><a href="#" id='add_item'><span class="fa fa-plus btn"></span>Seleccionar</a></td>
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
    
    $(document).on('click', '#add_item', (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        const id_paciente = $(elemento).attr('pacienteID');
        $.ajax({
            type: "POST",
            data: {id_paciente,id_medico},
            url: "../php/caso/casos-cerr-get-m.php",
            success: function (response) {
                console.log(response); 
                if (response == false) {
                    $('#modalBusqueda').modal("hide");
                    $('#texto_modal').html("No se encuentran altas médicas para el paciente seleccionado");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_table_altas').hide();
                    $("#altas_body > tr").remove(); 

                } else {
                    $('#modalBusqueda').modal("hide");
                    const resp = JSON.parse(response);
                    let template = '';
                    resp.forEach(r => {
                        template += `<tr class="bg-blue" casoID="${r.id_caso}">
                                        <td class="pt-3">${r.fecha_alta}</td>
                                        <td class="pt-3">${r.sufijo +" "+ r.apellidos_medi +" "+ r.nombres_medi}</td>
                                        <td class="pt-3">${r.apellidos_paci1 +" "+ r.apellidos_paci2 +" "+ r.nombres_paci1 +" "+ r.nombres_paci2}</td>
                                        <td class="pt-3">${r.nombre}</td>
                                        <td class="pt-3"><a href="reporte_alta.php?id_caso=${r.id_caso}" target="_blank" style="color: #fff" class="btn btn-success btn-sm">Reportes</a></td>
                                    </tr>
                                    <tr id="scitang-row">
                                        <td></td>
                                    </tr>`;
                    }); 
                    $('#altas_body').html(template);
                    $('#div_table_altas').show();
                }
            }
        });
        
        e.preventDefault();

    }); 
    
    
    $('#list_paci').click(function(e) {
        e.preventDefault();
        $('#modalBusqueda').modal("show");
        listarPacientes();
    });
    
    //Busqueda en la tabla de pacientes
    $("#busc_paci").keyup(function() {
        _this = this;
        $.each($("#tabla_pac tbody tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });
    
    

});