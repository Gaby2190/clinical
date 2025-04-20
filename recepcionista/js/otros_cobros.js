$(document).ready(function () {
    const id_cita = $("#id_cita").val();

    //Limitar caracteres de costo
    var cost = document.getElementById('costo');
    cost.addEventListener('input', function() {
        if (this.value.length > 5)
            this.value = this.value.slice(0, 5);
    });

    //==========Cargar otros a la tabla========//
    cargarOtPrevios();

    function cargarOtPrevios() {
        $.ajax({
            type: "POST",
            url: "../php/otros_c/otros_c-get.php",
            data: { id_cita },
            async:false,
            success: function(response) {
                if (response != false) {
                    const otros = JSON.parse(response);
                    otros.forEach(otro => {
                        const id_otro_c = otro.id_otro_c;
                        const descripcion = otro.descripcion;
                        const costo = otro.costo;
                        $("#otros_table>tbody").append(`<tr idO='${id_otro_c}' dOt='${descripcion}' cOt='${costo}'>
                                                        <td>${descripcion}</td>
                                                        <td>${costo}</td>
                                                        <td><button id='eliminar_otros' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                    </tr>`);
                    }); 
                }      
            }
        });
    }

    //Clic en el boton del modal para añadir otros
    $('#add_otros').click(function(e) {
        e.preventDefault();
        const descripcion = $('#descripcion').val();
        const costo = $('#costo').val();

        if (descripcion == "" || costo == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
            $('#descripcion').val('');
            $('#costo').val('');
        } else {
           
            $.ajax({
                type: "POST",
                url: "../php/otros_c/otros_c-add.php",
                data: {
                    descripcion,
                    costo,
                    id_cita
                },
                success: function (response) {
                    console.log(response);
                    $.ajax({
                        type: "POST",
                        url: "../php/otros_c/otros_c-get_id.php",
                        data: {
                            descripcion,
                            costo
                        },
                        success: function (response) {
                            const id_otro_c = JSON.parse(response).id_otro_c;
                            const descripcion = JSON.parse(response).descripcion;
                            const costo = JSON.parse(response).costo;
                            addOtro(id_otro_c, descripcion,costo);
                        }
                    });
                }
            });
            $('#descripcion').val('');
            $('#costo').val('');
        }

    });


    //Funcion para cargar los datos en la tabla
    function addOtro(id,dOt, cOt) {
        const id_otro_c = id;
        const descripcion = dOt;
        const costo = cOt;

        $("#otros_table>tbody").append(`<tr idO='${id_otro_c}' dOt='${descripcion}' cOt='${costo}'>
                                                    <td>${descripcion}</td>
                                                    <td>${costo}</td>
                                                    <td><button id='eliminar_otros' style="color: #fff" class="btn btn-danger btn-sm">Eliminar</button></td>
                                                </tr>`);
    }

    ///Botón de eliminar adicional/////
    $(document).on('click', '#eliminar_otros', (e) => {
        const element = $(this)[0].activeElement.parentElement.parentElement;
        const id_otro_c = $(element).attr('idO');

        $("#otros_body > tr").remove();
        $.ajax({
            type: "POST",
            url: "../php/otros_c/otros_c-delete.php",
            data:{id_otro_c},
            success: function (response) {
                console.log(response);
                cargarOtPrevios();
            }
        });
        
    });


});