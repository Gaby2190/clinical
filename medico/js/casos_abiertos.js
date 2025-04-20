$(document).ready(function() {
    const id_usuario = $("#id_usuario").val();
    
    const id_medico = JSON.parse($.ajax({
        type: "POST",
        glogal: false,
        async: false,
        url: "../php/medico/medico-list-id.php",
        data: {id_usuario},
        success: function (response) {
            $("#select_medico").val(JSON.parse(response).id_medico);
            return response;
        }
    }).responseText).id_medico;
  


    listarCasos();

    function listarCasos(){
        $.ajax({
            type: "POST", 
            data: {id_medico},
            url: "../php/caso/casos-abi-get-med.php",
            success: function (response) {
                console.log(response);
                if (response == false) {
                    $('#texto_modal').html("No se encuentran casos abiertos");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_table_casos').hide();
                    $("#casos_body > tr").remove(); 

                } else { 
                    const resp = JSON.parse(response);
                    let template = '';
                    resp.forEach(r => {
                        template += `<tr class="bg-blue" casoID="${r.id_caso}">
                                        <td class="pt-3">${r.fecha_registro}</td>
                                        <td class="pt-3">${r.sufijo +" "+ r.apellidos_medi +" "+ r.nombres_medi}</td>
                                        <td class="pt-3">${r.apellidos_paci1 +" "+ r.apellidos_paci2 +" "+ r.nombres_paci1 +" "+ r.nombres_paci2}</td>
                                        <td class="pt-3">${r.nombre}</td>
                                        <td class="pt-3"><a href="alta_medica.php?id_caso=${r.id_caso}" style="color: #fff" class="btn btn-success btn-sm">Dar de alta</a></td>
                                    </tr>
                                    <tr id="scitang-row">
                                        <td></td>
                                    </tr>`;
                    }); 
                    $('#casos_body').html(template);
                    $('#div_table_casos').show();
                }
            }
        });
    }

});