$(document).ready(function() {
    listarCajeros();

    function listarCajeros() {
        $.post('../php/cajero/cajeros-list.php', (response) => {
            let cajeros = JSON.parse(response);
            console.log(cajeros);
            let template = '';
            cajeros.forEach(caje => {
                //========Separación de un nombre y un apellido ===================
                let nombre = caje.nombres_caje;
                let apellido = caje.apellidos_caje;
                let nom_ape = nombre + " " + apellido;

                template += `
                                <tr class="bg-blue">
                                    <td class="pt-3" hidden>${caje.id_cajero}</td>
                                    <td class="pt-2">
                                        <img src="../${caje.imagen}" class="rounded-circle" alt="">
                                        <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                    </td>
                                    <td class="pt-3">${caje.cedula_caje}</td>
                                    <td class="pt-3">${caje.celular_caje}</td>
                                    <td class="pt-3"><a href="caje_update.php?id_cajero=${caje.id_cajero}&id_usuario=${caje.id_usuario}"><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;


            });

            $('#cajeros').html(template);

        });
    }

    //Busqueda en la tabla de pacientes
    $("#busc_caje").keyup(function() {
        _this = this;
        $.each($("#cajeros tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });

});