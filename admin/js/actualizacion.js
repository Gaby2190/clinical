$(document).ready(function() {
    listarPacientes();

    function listarPacientes() {
        $.ajax({
            type: "POST",
            url: "../php/paciente/pacientes-list-act.php",
            success: function (response) {
                if (response != false) {
                    let pacientes = JSON.parse(response);
                    console.log(pacientes);
                    let template = '';
                    pacientes.forEach(paci => {
                        //========Unión de un nombre y un apellido ===================
                        let nom_ape = paci.nombres_paci1 + " " + paci.nombres_paci2 + " " + paci.apellidos_paci1 + " " + paci.apellidos_paci2;
    
                        template += `
                                        <tr class="bg-blue">
                                            <td class="pt-3" hidden>${paci.id_paciente}</td>
                                            <td class="pt-2">
                                                <img src="../${paci.imagen}" class="rounded-circle" alt="">
                                                <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                            </td>
                                            <td class="pt-3">${paci.cedula_paci}</td>
                                            <td class="pt-3">${paci.celular_paci}</td>
                                            <td class="pt-3"><a href="paci_update_act.php?id_paciente=${paci.id_paciente}&id_usuario=${paci.id_usuario}&id_cita=0"><span class="fa fa-pencil-square-o btn"></span>Actualizar Información</a></td>
                                        </tr>
                                        <tr id="spacing-row">
                                            <td></td>
                                        </tr>
                            `;
    
    
                    });
    
                    $('#pacientes').html(template);
                }else{
                    $('#texto_modal').html('No se encuentran pacientes pendientes por actualizar datos');
                    $('#modal_icon').attr('style', "color: #22445d");
                    $('#modal_icon').attr("class", "fa fa-info-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                }
            }
        });
    }
});