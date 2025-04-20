$(document).ready(function() {
    getmedico();

    // Obtener medico por ID
    function getmedico() {
        const id_usuario = $("#id_usuario").val();
        $.post('../php/medico/medico-list-id.php', { id_usuario }, (response) => {
            const medico = JSON.parse(response);
            let nombree = medico.nombres_medi.split(' ')[0];
            let apellidoe = medico.apellidos_medi.split(' ')[0];
            $('#id_medico').html(medico.id_medico);
            $('#cedula_medi').html(medico.cedula_medi);
            $('#nombres_medi').html(medico.nombres_medi);
            $('#apellidos_medi').html(medico.apellidos_medi);
            $('#nom_card').html(nombree + " " + apellidoe);
            if (medico.telefono_medi == "" || medico.telefono_medi == null) {
                $('#telefono_medi').html("N/A");
            } else {
                $('#telefono_medi').html(medico.telefono_medi);
            }
            $('#celular_medi').html(medico.celular_medi);
            $('#correo_medi').html(medico.correo_medi);
            $('#direccion_medi').html(medico.direccion_medi);
            $('#imagen').attr("src", "../" + medico.imagen);
        });
    }

});