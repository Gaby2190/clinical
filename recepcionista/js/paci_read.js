$(document).ready(function() {
    listarPacientes();

    function listarPacientes() {
        $.post('../php/paciente/pacientes-list.php', (response) => {
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
                                    <td class="pt-3"><a href="paci_update.php?id_paciente=${paci.id_paciente}&id_usuario=${paci.id_usuario}"><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;


            });

            $('#pacientes').html(template);

        });
    } 

    //Busqueda en la tabla de pacientes
    $("#busc_paci").keyup(function() {
        _this = this;
        $.each($("#pacientes tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });

});