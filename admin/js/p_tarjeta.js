$(document).ready(function () {
    const id_cita = $("#id_cita").val();

    //Limitar caracteres de comision banco
    var com_ban = document.getElementById('comision_ban');
    com_ban.addEventListener('input', function() {
        if (this.value.length > 5)
            this.value = this.value.slice(0, 5);
    });
    
    //Limitar caracteres de retencion cl¨ªnica
    var ret_cli = document.getElementById('retencion_cli');
    ret_cli.addEventListener('input', function() {
        if (this.value.length > 5)
            this.value = this.value.slice(0, 5);
    });

    //==========Cargar otros a la tabla========//
    cargarCbrcPrevios();

    function cargarCbrcPrevios() {
        $.ajax({
            type: "POST",
            url: "../php/p_tarjeta/p_tarjeta-get.php",
            data: { id_cita },
            async:false,
            success: function(response) {
                if (response != false) {
                    $('#btn_add').attr('disabled','disabled');
                    const resp = JSON.parse(response);
                    resp.forEach(r => {
                        const id_p_tarjeta = r.id_p_tarjeta;
                        const comision_ban = r.comision_ban;
                        const retencion_cli = r.retencion_cli;
                        $("#cbrc_table>tbody").append(`<tr idO='${id_p_tarjeta}''>
                                                        <td>$${comision_ban}</td>
                                                        <td>$${retencion_cli}</td>
                                                        <td><button id='eliminar_cbrc' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                    </tr>`);
                    }); 
                }else{
                    $('#btn_add').removeAttr('disabled');
                }     
            }
        });
    }

    //Clic en el boton del modal para aÃ±adir otros
    $('#add_cbrc').click(function(e) {
        e.preventDefault();
        const comision_ban = $('#comision_ban').val();
        const retencion_cli = $('#retencion_cli').val();

        if (comision_ban == "" || retencion_cli == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#comision_ban').val('');
            $('#retencion_cli').val('');
        } else {
           $('#btn_add').attr('disabled','disabled');
            $.ajax({
                type: "POST",
                url: "../php/p_tarjeta/p_tarjeta-add.php",
                data: {
                    comision_ban,
                    retencion_cli,
                    id_cita
                },
                success: function (response) {
                    console.log(response);
                    $.ajax({
                        type: "POST",
                        url: "../php/p_tarjeta/p_tarjeta-get_id.php",
                        data: {
                            comision_ban,
                            retencion_cli
                        },
                        success: function (response) {
                            const id_p_tarjeta = JSON.parse(response).id_p_tarjeta;
                            const comision_ban = JSON.parse(response).comision_ban;
                            const retencion_cli = JSON.parse(response).retencion_cli;
                            addOtro(id_p_tarjeta, comision_ban,retencion_cli);
                        }
                    });
                }
            });
            $('#comision_ban').val('');
            $('#retencion_cli').val('');
        }

    });


    //Funcion para cargar los datos en la tabla
    function addOtro(id,dOt, cOt) {
        const id_p_tarjeta = id;
        const comision_ban = dOt;
        const retencion_cli = cOt;

        $("#cbrc_table>tbody").append(`<tr idO='${id_p_tarjeta}'>
                                                    <td>$${comision_ban}</td>
                                                    <td>$${retencion_cli}</td>
                                                    <td><button id='eliminar_cbrc' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///BotÃ³n de eliminar adicional/////
    $(document).on('click', '#eliminar_cbrc', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_p_tarjeta = $(element).attr('idO');

        $("#cbrc_body > tr").remove();
        $.ajax({
            type: "POST",
            url: "../php/p_tarjeta/p_tarjeta-delete.php",
            data:{id_p_tarjeta},
            success: function (response) {
                console.log(response);
                $('#btn_add').removeAttr('disabled');
                cargarCbrcPrevios();
            }
        });
        
    });


});