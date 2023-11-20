
$(document).ready(function() {
    listarcitas();
    function listarcitas(){
        $.ajax({
            type: "POST", 
            url: '../php/cita/cita-cobro.php',
            success: function(response) { 
                $("#cobros_body tr").remove();
                if (response == false) {
                    $('#texto_modal').html("No se encuentran citas pendientes por cobrar");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                } else { 
                    const citas = JSON.parse(response);
                    let template = '';
                    citas.forEach(cita => {
                        const id_cita = cita.id_cita;

                        const hora = cita.hora.slice(0, -3);
                        var tipo_cita = "";

                        if (cita.tipo_cita == "1") {
                            tipo_cita = "Normal";
                        }else{
                            if (cita.tipo_cita == "0") {
                                tipo_cita = "Control";
                            }
                        }          
    
                        //========Separación de un nombre y un apellido MEDICO ===================
                        const nom_apem = cita.sufijo + " " + cita.nombres_medi + " " + cita.apellidos_medi;
                        //========Unión de un nombre y un apellido PACIENTE ===================
                        const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
    
                        template += `
                                            <tr class="bg-blue" citaID="${cita.id_cita}">
                                                <td class="pt-3" hidden>${cita.id_cita}</td>
                                                <td class="pt-3">${cita.fecha}</td>
                                                <td class="pt-3">${hora}h</td>
                                                <td class="pt-3">${nom_apep}</td>
                                                <td class="pt-3">${nom_apem}</td>
                                                <td class="pt-3">${tipo_cita}</td>
                                                <td class="pt-3"><a href="caja.php?id_cita=${cita.id_cita}" style="color: #fff" class="btn btn-primary btn-sm">Gestionar Cobro</a></td>
                                            </tr>
                                            <tr id="scitang-row">
                                                <td></td>
                                            </tr>
                                            `;
    
                    }); 
                    $('#cobros_body').html(template);
                    $('#div_table_cobros').show();
                }
            }
        });
    }
    

    //Busqueda en la tabla de pacientes
    $("#busc_paci").keyup(function() {
        _this = this;
        $.each($("#cobros_table tbody tr"), function() {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                {
                    $(this).hide();
                }
            else
                {
                    $(this).show();
                }
        });
    });

});