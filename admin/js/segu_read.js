$(document).ready(function() {
    listarAseguradoras();

    function listarAseguradoras() {
        $.post('../php/aseguradora/aseguradoras-list.php', (response) => {
            let aseguradoras = JSON.parse(response);
            console.log(aseguradoras);
            let template = '';
            aseguradoras.forEach(segu => {
                template += `
                                <tr class="bg-blue">
                                    <td class="pt-3" hidden>${segu.id}</td>
                                    <td class="pt-3">${segu.nombre}</td>
                                    <td class="pt-3"><a href="segu_update.php?id_segu=${segu.id}"><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;


            });

            $('#aseguradoras').html(template);

        });
    }

});