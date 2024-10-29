$(document).ready(function() {
    const id = $("#id_fpago").val();
    getFpago();
   
   function get_aseguradoras(seguro){
        $.ajax({
            type: "POST",
            async: false,
            url: "../php/aseguradora/segu-get.php",
            success: function (response) {
                const aseguradoras = JSON.parse(response);
                    let template = '';
                    aseguradoras.forEach(segu => {
                        if(segu.id==seguro)
                        {
                            template += `
                            <option value="${segu.id}" selected="selected">${segu.nombre}</option>
                            `;
                        }
                        else
                        {
                            template += `
                            <option value="${segu.id}">${segu.nombre}</option>
                            `;
                        }
                    
                    });

                    $('#select_segu').html(template);
            }
        });
    }


    function getFpago() {
        $.post('../php/fpago/fpago-list.php', { id }, (response) => {
            const fpago = JSON.parse(response).nombre;
            const seguro = JSON.parse(response).aseguradora;
            $('#fpago').val(fpago);
            get_aseguradoras(seguro);
        });
    }


    //ACTUALIZAR DATOS DE USUARIO
    $('#btn_datos').click(function(e) {
        e.preventDefault();
        const postData = {
            id: id,
            nombre: $('#fpago').val(),
            aseguradora: $('#select_segu').val()
        };

        if (postData.nombre == "") {
            $('#texto_modal').html('Ingrese datos en los campos obligatorios');
            $('#modal_icon').attr('style', "color: orange");
            $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        } else {
            $.post('../php/fpago/fpago-update.php', postData, (response) => {
                $('#texto_modal').html(response);
                $('#modal_icon').attr("class", "fa fa-pencil-square fa-4x animated rotateIn mb-4");
                $('#modalPush').modal("show");
                setTimeout(function() { window.location.href = "fpago_read.php"; }, 3000);
            });
        }


    });

});