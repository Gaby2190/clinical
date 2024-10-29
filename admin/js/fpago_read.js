$(document).ready(function() {
    listarFpago();

    function listarFpago() {
        $.post('../php/fpago/fpagos-list.php', (response) => {
            let fpagos = JSON.parse(response);
            let template = '';
            fpagos.forEach(fp => {
                template += `
                                <tr class="bg-blue">
                                    <td class="pt-3" hidden>${fp.id}</td>
                                    <td class="pt-3">${fp.nombre}</td>
                                    <td class="pt-3">${fp.aseguradora}</td>
                                    <td class="pt-3"><a href="fpago_update.php?id_fpago=${fp.id}"><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;


            });

            $('#fpagos').html(template);

        });
    }

});