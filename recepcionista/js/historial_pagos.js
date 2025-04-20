$(document).ready(function() {
    listarPagos();

    function listarPagos(){
        $.ajax({
            type: "POST",
            url: "../php/pago/pagos-get.php",
            success: function (response) {
                if (response == false) {
                    $('#texto_modal').html("No se encuentran cobros realizados");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_table_hpagos').hide();
                    $("#hpagos_body > tr").remove(); 

                } else { 
                    const resp = JSON.parse(response);
                    let template = '';
                    resp.forEach(r => {
                        template += `<tr class="bg-blue" pagoID="${r.id_pago}">
                                        <td class="pt-3">${r.id_pago}</td>
                                        <td class="pt-3">${r.fecha_gen}</td>
                                        <td class="pt-3">${r.sufijo +" "+ r.apellidos_medi +" "+ r.nombres_medi}</td>
                                        <td class="pt-3">${r.usuario}</td>
                                        <td class="pt-3">$${r.valor_total}</td>
                                        <td class="pt-3"><a href="../php/reportes/reporte_comp_p.php?id_medico=${r.id_medico}&id_usuario=${r.id_usuario}&id_pago=${r.id_pago}" target="_blank" style="color: #fff" class="btn btn-success btn-sm">VER</a></td>
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