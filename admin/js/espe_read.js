$(document).ready(function() {
    listarEspecialidades();

    function listarEspecialidades() {
        $.post('../php/especialidad/especialidades-list.php', (response) => {
            let especialidades = JSON.parse(response);
            console.log(especialidades);
            let template = '';
            especialidades.forEach(espe => {
                template += `
                                <tr class="bg-blue">
                                    <td class="pt-3" hidden>${espe.id}</td>
                                    <td class="pt-3">${espe.nombre}</td>
                                    <td class="pt-3"><a href="espe_update.php?id_espe=${espe.id}"><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;


            });

            $('#especialidades').html(template);

        });
    }

});