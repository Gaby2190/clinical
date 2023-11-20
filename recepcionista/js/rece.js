$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();
    $.post('../php/recepcionista/recepcionista-list-id.php', { id_usuario }, (response) => { 
        const recepcionista = JSON.parse(response);
        let nombree = recepcionista.nombres_rece.split(' ')[0];
        let apellidoe = recepcionista.apellidos_rece.split(' ')[0];
        $('#imagen-perfil').attr("src", "../" + recepcionista.imagen);
        $('#nom_usr').html(nombree + " " + apellidoe);
    });

});