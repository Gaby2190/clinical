$(document).ready(function() {
    listarPagos();

    function listarPagos(){
        $.ajax({
            type: "POST",
            url: "../php/ticket/tickets-get.php",
            success: function (response) {
                if (response == false) {
                    $('#texto_modal').html("No se encuentran tickets realizados");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_table_hpagos').hide();
                    $("#hpagos_body > tr").remove(); 

                } else { 
                    const resp = JSON.parse(response);
                    let template = '';
                    resp.forEach(r => {
                        template += `<tr class="bg-blue" pagoID="${r.id_cita}">
                                        <td class="pt-3">${r.id_cita}</td>
                                        <td class="pt-3">${r.fecha}</td>
                                        <td class="pt-3">${r.hora}</td>
                                        <td class="pt-3">${r.sufijo +" "+ r.apellidos_medi +" "+ r.nombres_medi}</td>
                                        <td class="pt-3">${r.nombres_paci1+" "+r.nombres_paci2+" "+r.apellidos_paci1+" "+r.apellidos_paci2}</td>
                                        <td class="pt-3">$${r.costo}</td>
                                        <td class="pt-3"><a href="../recepcionista/cita_ticket_his.php?id_cita=${r.id_cita}" style="color: #fff" class="btn btn-success btn-sm">Editar</a></td>
                                    </tr>
                                    <tr id="scitang-row">
                                        <td></td>
                                    </tr>`;
                    }); 
                    $('#hpagos_body').html(template);
                    $('#div_table_hpagos').show();
                }
            }
        });
    }

    //Busqueda en la tabla de pacientes
    $("#busc_medi").keyup(function() {
        _this = this;
        $.each($("#hpagos_body tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });

});