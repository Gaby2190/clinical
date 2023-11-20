$(document).ready(function() {
    listarAsistentes();

    function listarAsistentes() {
        $.post('../php/asistente/asistentes-list.php', (response) => {
            let asistentes = JSON.parse(response);
            console.log(asistentes);
            let template = '';
            asistentes.forEach(asis => {
                //========Separación de un nombre y un apellido ===================
                let nombre = asis.nombres_asis;
                let apellido = asis.apellidos_asis;
                let nom_ape = nombre + " " + apellido;

                template += `
                                <tr class="bg-blue">
                                    <td class="pt-3" hidden>${asis.id_asistente}</td>
                                    <td class="pt-2">
                                        <img src="../${asis.imagen}" class="rounded-circle" alt="">
                                        <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                    </td>
                                    <td class="pt-3">${asis.cedula_asis}</td>
                                    <td class="pt-3">${asis.celular_asis}</td>
                                    <td class="pt-3"><a href="asis_update.php?id_asistente=${asis.id_asistente}&id_usuario=${asis.id_usuario}"><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;

            });

            $('#asistentes').html(template);

        });
    }

    //Busqueda en la tabla de pacientes
    $("#busc_asis").keyup(function() {
        _this = this;
        $.each($("#asistentes tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });

});