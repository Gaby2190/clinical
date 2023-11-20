$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();
    $.post('../php/asistente/asistente-list-id.php', { id_usuario }, (response) => { 
        const asistente = JSON.parse(response);
        let nombree = asistente.nombres_asis.split(' ')[0];
        let apellidoe = asistente.apellidos_asis.split(' ')[0];
        $('#imagen-perfil').attr("src", "../" + asistente.imagen);
        $('#nom_usr').html(nombree + " " + apellidoe);
    });

});