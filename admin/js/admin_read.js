$(document).ready(function() {
    listarAdministradores();

    function listarAdministradores() {
        $.post('../php/administrador/administradores-list.php', (response) => {
            let administradores = JSON.parse(response);
            //console.log(administradores);
            let template = '';
            administradores.forEach(admin => {
                //========Separación de un nombre y un apellido ===================
                let nombre = admin.nombres_admin;
                let apellido = admin.apellidos_admin;
                let nom_ape = nombre + " " + apellido;

                template += `
                                <tr class="bg-blue">
                                    <td class="pt-3" hidden>${admin.id_administrador}</td>
                                    <td class="pt-2">
                                        <img src="../${admin.imagen}" class="rounded-circle" alt="">
                                        <div class="pl-lg-5 pl-md-3 pl-1 name">${nom_ape}</div>
                                    </td>
                                    <td class="pt-3">${admin.cedula_admin}</td>
                                    <td class="pt-3">${admin.celular_admin}</td>
                                    <td class="pt-3"><a href="admin_update.php?id_administrador=${admin.id_administrador}&id_usuario=${admin.id_usuario}"><span class="fa fa-pencil-square-o btn"></span>Editar</a></td>
                                </tr>
                                <tr id="spacing-row">
                                    <td></td>
                                </tr>
                    `;


            });

            $('#administradores').html(template);

        });
    }

    //Busqueda en la tabla de pacientes
    $("#busc_admin").keyup(function() {
        _this = this;
        $.each($("#administradores tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });

});