$(document).ready(function() {  
    const id_caso = $("#id_caso").val();

    $("#btn_conf_alta").click(function (e) { 
        e.preventDefault();
        $('#texto_modal_a').html('Desea dar de alta el caso');
        $('#modal_icon_a').attr('style', "color: #22445d");
        $('#modal_icon_a').attr("class", "fa fa-question-circle fa-4x animated rotateIn mb-4");
        $("#modalAlta").modal("show");
    });

    $("#btn_alta").click(function (e) { 
        e.preventDefault();
        const select_a = document.getElementById("select_c_alta");
        const c_alta = select_a.options[select_a.selectedIndex].text;

        const select_t = document.getElementById("select_t_tratamiento");
        const t_tratamiento = select_t.options[select_t.selectedIndex].text;

        const proc_cq = $("#proc_cq").val();

        const d = new Date();
        const month = d.getMonth() + 1;
        const day = d.getDate();
        const f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

        const postAlta = {
            id_caso: id_caso,
            c_alta: c_alta,
            t_tratamiento: t_tratamiento,
            proc_cq: proc_cq,
            fecha_alta: f_actual
        }

        console.log(postAlta);
        if (postAlta.proc_cq == "") {
            $('#texto_modal').html('Complete todos los datos solicitados');
            $('#modal_icon').attr('style', "color: #22445d");
            $('#modal_icon').attr("class", "fa fa-info-circle fa-4x animated rotateIn mb-4");
            $('#modalPush').modal("show");
        }else{
            $.ajax({
                type: "POST",
                url: "../php/caso/caso-alta.php",
                data: postAlta,
                success: function (response) {
                        $('#texto_modal').html(response);
                        $('#modal_icon').attr('style', "color: rgb(57, 160, 57)");
                        $('#modal_icon').attr("class", "fa fa-clock-o fa-4x animated rotateIn mb-4");
                        $('#modalPush').modal("show");
                        setTimeout(function() { window.location.href = `reporte_alta.php?id_caso=${id_caso}`; }, 3000);
                }
            });
        }
        
        
    });


});