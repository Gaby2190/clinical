$(document).ready(function() {
    listarMedicos();

    function listarMedicos() {
        $.post('../php/medico/medicos-list.php', (response) => {
            //console.log(response);
            let medicos = JSON.parse(response);
            //console.log(medicos);
            let template = '';
            medicos.forEach(medi => {
                //========Separación de un nombre y un apellido ===================
                let nombre = medi.nombres_medi;
                let apellido = medi.apellidos_medi;
                let nom_ape = medi.sufijo + " " + nombre + " " + apellido;
                //===================Estado del Médico=============================
                let color;
                let stat;
                if (medi.estado_medi == true) {
                    color = 'green';
                    stat = 'Activo/a';
                } else {
                    color = 'red';
                    stat = 'Inactivo/a';
                }

                template += `
                                <tr class="bg-blue">
                                    <td class="pt-3" hidden>${medi.id_medico}</td>
                                    <td class="pt-2">
                                        <img src="../${medi.imagen}" class="rounded-circle" alt="">
                                        <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                    </td>
                                    <td class="pt-3">${medi.nautorizacion_medi}</td>
                                    <td class="pt-3"><span class="fa fa-circle" style='color: ${color}' pl-3"></span> ${stat}</td>
                                    <td class="pt-3"><a href="med_update.php?id_medico=${medi.id_medico}&id_usuario=${medi.id_usuario}" id="btn_editar" ><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;


            });

            $('#medicos').html(template);

        });
    }

    //Busqueda en la tabla de medicos
    $("#busc_medi").keyup(function() {
        _this = this;
        $.each($("#medicos tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });

});