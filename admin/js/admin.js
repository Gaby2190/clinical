$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();
    
    $.post('../php/administrador/administrador-list-id.php', { id_usuario }, (response) => {
        const administrador = JSON.parse(response);
        let nombree = administrador.nombres_admin.split(' ')[0];
        let apellidoe = administrador.apellidos_admin.split(' ')[0];
        $('#imagen-perfil').attr("src", "../" + administrador.imagen);
        $('#nom_usr').html(nombree + " " + apellidoe);
    });

});