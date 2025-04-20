$(document).ready(function() {
    getcajero();

    // Obtener cajero por ID
    function getcajero() {
        const id_usuario = $("#id_usuario").val();
        $.post('../php/cajero/cajero-list-id.php', { id_usuario }, (response) => {
            const cajero = JSON.parse(response);
            let nombree = cajero.nombres_caje.split(' ')[0];
            let apellidoe = cajero.apellidos_caje.split(' ')[0];
            $('#id_cajero').html(cajero.id_cajero);
            $('#cedula_caje').html(cajero.cedula_caje);
            $('#nombres_caje').html(cajero.nombres_caje);
            $('#apellidos_caje').html(cajero.apellidos_caje);
            $('#nom_card').html(nombree + " " + apellidoe);
            if (cajero.telefono_caje == "" || cajero.telefono_caje == null) {
                $('#telefono_caje').html("N/A");
            } else {
                $('#telefono_caje').html(cajero.telefono_caje);
            }
            $('#celular_caje').html(cajero.celular_caje);
            $('#correo_caje').html(cajero.correo_caje);
            $('#direccion_caje').html(cajero.direccion_caje);
            $('#imagen').attr("src", "../" + cajero.imagen);
        });
    }

});