$(document).ready(function() {
    getrecepcionista();

    // Obtener recepcionista por ID
    function getrecepcionista() {
        const id_usuario = $("#id_usuario").val();
        $.post('../php/recepcionista/recepcionista-list-id.php', { id_usuario }, (response) => {
            const recepcionista = JSON.parse(response);
            let nombree = recepcionista.nombres_rece.split(' ')[0];
            let apellidoe = recepcionista.apellidos_rece.split(' ')[0];
            $('#id_recepcionista').html(recepcionista.id_recepcionista);
            $('#cedula_rece').html(recepcionista.cedula_rece);
            $('#nombres_rece').html(recepcionista.nombres_rece);
            $('#apellidos_rece').html(recepcionista.apellidos_rece);
            $('#nom_card').html(nombree + " " + apellidoe);
            if (recepcionista.telefono_rece == "" || recepcionista.telefono_rece == null) {
                $('#telefono_rece').html("N/A");
            } else {
                $('#telefono_rece').html(recepcionista.telefono_rece);
            }
            $('#celular_rece').html(recepcionista.celular_rece);
            $('#correo_rece').html(recepcionista.correo_rece);
            $('#direccion_rece').html(recepcionista.direccion_rece);
            $('#imagen').attr("src", "../" + recepcionista.imagen);
        });
    }

});