$(document).ready(function() {
    getadministrador();

    // Obtener administrador por ID
    function getadministrador() {
        const id_usuario = $("#id_usuario").val();
        $.post('../php/administrador/administrador-list-id.php', { id_usuario }, (response) => {
            const administrador = JSON.parse(response);
            let nombree = administrador.nombres_admin.split(' ')[0];
            let apellidoe = administrador.apellidos_admin.split(' ')[0];
            $('#id_administrador').html(administrador.id_administrador);
            $('#cedula_admin').html(administrador.cedula_admin);
            $('#nombres_admin').html(administrador.nombres_admin);
            $('#apellidos_admin').html(administrador.apellidos_admin);
            $('#nom_card').html(nombree + " " + apellidoe);
            if (administrador.telefono_admin == "" || administrador.telefono_admin == null) {
                $('#telefono_admin').html("N/A");
            } else {
                $('#telefono_admin').html(administrador.telefono_admin);
            }
            $('#celular_admin').html(administrador.celular_admin);
            $('#correo_admin').html(administrador.correo_admin);
            $('#direccion_admin').html(administrador.direccion_admin);
            $('#imagen').attr("src", "../" + administrador.imagen);
        });
    }

});