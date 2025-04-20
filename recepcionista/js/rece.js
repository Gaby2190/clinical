$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();
    $.post('../php/recepcionista/recepcionista-list-id.php', { id_usuario }, (response) => { 
        const recepcionista = JSON.parse(response);
        let nombree = recepcionista.nombres_rece.split(' ')[0];
        let apellidoe = recepcionista.apellidos_rece.split(' ')[0];
        $('#imagen-perfil').attr("src", "../" + recepcionista.imagen);
        $('#nom_usr').html(nombree + " " + apellidoe);
    });
  //---------------- Cargar Dashborad ----------------
  $.ajax({// carga citas agendadas
    type: "POST",
    url: "../php/administrador/dashboard/citas_pendientes.php",
    success: function (response) {
        if (response != false) {
            const citas = JSON.parse(response);
            const num_cita = citas.length;
            $('#total_cp').html(num_cita);
        }else{
            $('#total_cp').html(0);
        }
        
    }
});
$.ajax({//carga citas en sala de espera
type: "POST",
url: "../php/administrador/dashboard/citas_sala.php",
success: function (response) {
    if (response != false) {
        const citas = JSON.parse(response);
        const num_cita = citas.length;
        $('#total_sala').html(num_cita);
    }else{
        $('#total_sala').html(0);
    }
    
}
});
$.ajax({//carga citas por cobrar
type: "POST",
url: "../php/administrador/dashboard/citas_cobrar.php",
success: function (response) {
    if (response != false) {
        const citas = JSON.parse(response);
        const num_cita = citas.length;
        $('#cobrar').html(num_cita);
    }else{
        $('#cobrar').html(0);
    }
    
}
});
$.ajax({//carga citas por pagar
type: "POST",
url: "../php/administrador/dashboard/citas_pagar.php",
success: function (response) {
    if (response != false) {
        const citas = JSON.parse(response);
        const num_cita = citas.length;
        $('#pagar').html(num_cita);
    }else{
        $('#pagar').html(0);
    }
    
}
});
//--------------------------------------------------

}); 