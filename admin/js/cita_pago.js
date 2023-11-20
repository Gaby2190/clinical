$(document).ready(function () {
    const total = $("#total").val();
    const id_cita = $("#id_cita").val();
    //Limitar caracteres de costo
    var cost = document.getElementById('costo');
    cost.addEventListener('input', function() {
        if (this.value.length > 7)
            this.value = this.value.slice(0, 7);
    });
    
    //Cargar formas de pago
    $.ajax({
        async: false,
        url: '../php/fpago/fpagos-list.php',
        type: 'POST',
        success: function(response) {
            const fpagos = JSON.parse(response);
            let template = '';
            fpagos.forEach(fp => {
                template += `
                <option value="${fp.id}">${fp.nombre}</option>
                `;
            });
            $('#select_fpago').html(template);
        }
    });

    //==========Cargar cita pagos a la tabla========//
    cargarCitasPago();

    function cargarCitasPago() {
        $.ajax({
            type: "POST",
            url: "../php/cita_pago/cita_pago-get.php",
            data: { id_cita },
            async:false,
            success: function(response) {
                if (response != false) {
                    const cpagos = JSON.parse(response);
                    cpagos.forEach(cp => {
                        const id_cita_pago = cp.id_cita_pago;
                        const descripcion = cp.descripcion;
                        const f_pago = cp.nombre;
                        const costo = cp.costo;
                        $("#fp_table>tbody").append(`<tr idCP='${id_cita_pago}' cCP='${costo}'>
                                                        <td>${f_pago}</td>
                                                        <td>${descripcion}</td>
                                                        <td>$${costo}</td>
                                                        <td><button id='eliminar_fp' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                    </tr>`);
                    }); 
                }      
            }
        });
    } 

    //Clic en el boton del modal para añadir otros
    $('#add_fpago').click(function(e) {
        e.preventDefault();
        const id_f_pago = $('#select_fpago').val();
        const f_pago = $('#select_fpago option:selected').html();
        const descripcion = $('#descripcion').val();
        const costo = $('#costo').val();
        const id_usuario = $("#id_usuario").val();
        //======FECHA Y HORAS ACTUALES=====
        var d = new Date();
        var month = d.getMonth() + 1;
        var day = d.getDate();
        //fecha
        var fecha_p = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
        //hora
        const hora_p = d.getHours() + ':' + d.getMinutes();

        if (costo == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#descripcion').val('');
            $('#costo').val('');
        } else {
           
            $.ajax({
                type: "POST",
                url: "../php/cita_pago/cita_pago-add.php",
                data: {
                    id_f_pago,
                    descripcion,
                    costo,
                    id_cita,
                    fecha_p,
                    hora_p,
                    id_usuario
                },
                success: function (response) {
                    console.log(response);
                    $.ajax({
                        type: "POST",
                        url: "../php/cita_pago/cita_pago-get_id.php",
                        data: {
                            id_f_pago,
                            descripcion,
                            costo
                        },
                        success: function (response) {
                            const id_cita_pago = JSON.parse(response).id_cita_pago;
                            const descripcion = JSON.parse(response).descripcion;
                            const costo = JSON.parse(response).costo;
                            addCP(id_cita_pago, f_pago, descripcion,costo);
                        }
                    });
                }
            });
            $('#descripcion').val('');
            $('#costo').val('');
        }

    });


    //Funcion para cargar los datos en la tabla
    function addCP(id,fP,dCP, cCP) {
        const id_cita_pago = id;
        const f_pago = fP;
        const descripcion = dCP;
        const costo = cCP;
        $("#fp_table>tbody").append(`<tr idCP='${id_cita_pago}' cCP='${costo}'>
                                                    <td>${f_pago}</td>
                                                    <td>${descripcion}</td>
                                                    <td>$${costo}</td>
                                                    <td><button id='eliminar_fp' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///Botón de eliminar/////
    $(document).on('click', '#eliminar_fp', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_cita_pago = $(element).attr('idCP');
        const costo = $(element).attr('cCP');
        $("#fp_body > tr").remove();
        $.ajax({
            type: "POST",
            url: "../php/cita_pago/cita_pago-delete.php",
            data:{id_cita_pago},
            success: function (response) {
                console.log(response);
                cargarCitasPago();
            }
        });
        
    });

});