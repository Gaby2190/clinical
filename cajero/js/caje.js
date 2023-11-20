$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();
    $.post('../php/cajero/cajero-list-id.php', { id_usuario }, (response) => { 
        const cajero = JSON.parse(response);
        let nombree = cajero.nombres_caje.split(' ')[0];
        let apellidoe = cajero.apellidos_caje.split(' ')[0];
        $('#imagen-perfil').attr("src", "../" + cajero.imagen);
        $('#nom_usr').html(nombree + " " + apellidoe);
    });

});