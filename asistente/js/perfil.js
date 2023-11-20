$(document).ready(function() {
    getasistente();

    // Obtener asistente por ID
    function getasistente() {
        const id_usuario = $("#id_usuario").val();
        $.post('../php/asistente/asistente-list-id.php', { id_usuario }, (response) => {
            const asistente = JSON.parse(response);
            let nombree = asistente.nombres_asis.split(' ')[0];
            let apellidoe = asistente.apellidos_asis.split(' ')[0];
            $('#id_asistente').html(asistente.id_asistente);
            $('#cedula_asis').html(asistente.cedula_asis);
            $('#nombres_asis').html(asistente.nombres_asis);
            $('#apellidos_asis').html(asistente.apellidos_asis);
            $('#nom_card').html(nombree + " " + apellidoe);
            if (asistente.telefono_asis == "" || asistente.telefono_asis == null) {
                $('#telefono_asis').html("N/A");
            } else {
                $('#telefono_asis').html(asistente.telefono_asis);
            }
            $('#celular_asis').html(asistente.celular_asis);
            $('#correo_asis').html(asistente.correo_asis);
            $('#direccion_asis').html(asistente.direccion_asis);
            $('#imagen').attr("src", "../" + asistente.imagen);
        });
    }

});