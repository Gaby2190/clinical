$(document).ready(function() {
    listarRecepcionistas();

    function listarRecepcionistas() {
        $.post('../php/recepcionista/recepcionistas-list.php', (response) => {
            let recepcionistas = JSON.parse(response);
            console.log(recepcionistas);
            let template = '';
            recepcionistas.forEach(rece => {
                //========Separación de un nombre y un apellido ===================
                let nombre = rece.nombres_rece;
                let apellido = rece.apellidos_rece;
                let nom_ape = nombre + " " + apellido;

                template += `
                                <tr class="bg-blue">
                                    <td class="pt-3" hidden>${rece.id_recepcionista}</td>
                                    <td class="pt-2">
                                        <img src="../${rece.imagen}" class="rounded-circle" alt="">
                                        <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                    </td>
                                    <td class="pt-3">${rece.cedula_rece}</td>
                                    <td class="pt-3">${rece.celular_rece}</td>
                                    <td class="pt-3"><a href="rece_update.php?id_recepcionista=${rece.id_recepcionista}&id_usuario=${rece.id_usuario}"><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;


            });

            $('#recepcionistas').html(template);

        });
    }

    //Busqueda en la tabla de recepcionistas
    $("#busc_rece").keyup(function() {
        _this = this;
        $.each($("#recepcionistas tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });

});