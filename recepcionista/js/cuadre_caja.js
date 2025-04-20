$(document).ready(function() {
    $('#div_cci_table').hide();
    $('#div_cce_table').hide();
    $('#div_ciet_table').hide();
    $('#div_btn_pdf').hide(); 

    

    var d = new Date();
    var month = d.getMonth() + 1;
    var day = d.getDate();
    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;
    
    $('#fecha_cc').attr('value', f_actual);
    $('#fecha_cc').attr('max', f_actual);
    
    var c_ingresos = [];
    var c_egresos = [];

    function listarIngresos(id_u){
        const fecha = $('#fecha_cc').val();
        const id_usuario = id_u;
        $.ajax({
            type: "POST", 
            data: {fecha, id_usuario},
            url: '../php/cuadre_caja/citas_ingresos.php',
            success: function(response) {
                $("#cci_body tr").remove();
                if (response == false) {
                    $('#texto_modal').html("No se encuentran citas en ingresos");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_cci_table').hide();
                } else { 
                    const citas = JSON.parse(response);
                    
                   
                    var contador=0;
                    let template = '';
                    citas.forEach(cita => {
                        const id_cita = cita.id_cita;
                        var adicionales = 0;
                        var otros = 0;
                        
                       
                        if (contador == 0)
                        {
                            contador++;
                            const r = $.ajax({
                                type: "POST",
                                url: "../php/adicional-read.php",
                                data: { id_cita },
                                global: false,
                                async: false,
                                success: function(response) {
                                    return response;
                                    
                                }
                            }).responseText;
                            if (r != false) {
                                const resp = JSON.parse(r);
                                    resp.forEach(r => {
                                    adicionales += Number(r.costo);
                                });
                            }
        
                            const o = $.ajax({
                                type: "POST",
                                url: "../php/otros_c/otros_c-get.php",
                                data: { id_cita },
                                global: false,
                                async: false,
                                success: function(response) {
                                    return response;
                                }
                            }).responseText;
                            if (o != false) {
                                const ot = JSON.parse(o);
                                    ot.forEach(o => {
                                    otros += Number(o.costo);
                                });
                            }
                        }                 
                        const hora = cita.hora_p.slice(0, -3);
                        var tipo_cita = "";
                        var tarifa = 0;
                        
                        
                       
                            if (cita.tipo_cita == "1") {
                                tipo_cita = "Normal";
                                tarifa = cita.costo;
                            }else{
                                if (cita.tipo_cita == "0") {
                                    tipo_cita = "Control";
                                    tarifa = cita.costo;
                                }
                            }
                       
                        
                           
    
                        //========Separaci贸n de un nombre y un apellido MEDICO ===================
                        const nombrem = cita.nombres_medi;
                        const apellidom = cita.apellidos_medi;
                        const nom_apem = cita.sufijo + " " + nombrem + " " + apellidom;
                        //========Uni贸n de un nombre y un apellido PACIENTE ===================
                        const nom_apep = cita.nombres_paci1 + " " + cita.nombres_paci2 + " " + cita.apellidos_paci1 + " " + cita.apellidos_paci2;
                        const total = tarifa - cita.descuento + adicionales + otros;
                        
                        template += `
                                    <tr class="bg-blue" citaID="${cita.id_cita}" citaTotal="${total}">
                                        <td class="pt-3">${cita.fecha_p}</td>
                                        <td class="pt-3">${hora}h</td>
                                        <td class="pt-3">${nom_apep}</td>
                                        <td class="pt-3">${nom_apem}</td>
                                        <td class="pt-3">${tipo_cita}</td>
                                        <td class="pt-3"><B>$${tarifa}</B></td>
                                        <td class="pt-3">$${cita.descuento}</td>
                                        <td class="pt-3">$${Number(adicionales).toFixed(2)}</td>
                                        <td class="pt-3">$${Number(otros).toFixed(2)}</td>
                                        <td class="pt-3"><B>${cita.nombre}</B></td>`;

                        template += `</tr>`;
    
                    });
                    
                    $('#cci_body').html(template);
                    $('#div_cci_table').show();
                    listarEgresos(id_usuario);
                }
            }
        });
    }
    
    function listarEgresos(id_u) {
        const fecha = $('#fecha_cc').val();
        const id_usuario = id_u;
        $.ajax({
            type: "POST",
            url: "../php/cuadre_caja/medico_pago-get.php",
            data: {fecha, id_usuario},
            success: function (response) {
                if(response==false){
                     $('#texto_modal').html("No se encuentran citas en egresos");
                    $('#modal_icon').attr('style', "color: orange");
                    $('#modal_icon').attr("class", "fa fa-exclamation-circle fa-4x animated rotateIn mb-4");
                    $('#modalPush').modal("show");
                    $('#div_cce_table').hide();
                } else {
                    $('#div_cce_table').show();
                    const pagos = JSON.parse(response);
                    var template = '';
                    
                    pagos.forEach(p => {
                        //Variables que se usarán de forma global para cargar los totales y cargarlos posteriormente al template
                        const fecha_p = p.fecha_p;
                        const hora_p = p.hora_p.slice(0, -3);
                        const id_pago = p.id_pago;
                        const nombre = p.nombre;
                        const sufijo = p.sufijo;
                        const nom_ape_medi = p.nom_ape_medi;
                        const costo = p.costo;
                                              
                        template += `
                        <tr class="bg-blue">
                            <td class="pt-3">${fecha_p}</td>
                            <td class="pt-3">${hora_p}h</td>
                            <td class="pt-3">${id_pago}</td>
                            <td class="pt-3">${sufijo} ${nom_ape_medi}</td>
                            <td class="pt-3"><B>$${Number(costo).toFixed(2)}</B></td>
                            <td class="pt-3"><B>${nombre}</B></td>
                        </tr>
                            `;


                        //Consulta las citas de cada id_pago
                        
                    });
                                       
                    $('#cce_body').html(template);
                    listarCiet(id_usuario);
                  
                }
            }
        });
    }
    
    function listarCiet(id_u){
        var template = '';
        const fecha = $('#fecha_cc').val();
        const id_usuario = id_u;
        //=================== BUSCAR FORMAS DE PAGO REGISTRADAS =================
        $.ajax({
            type: "POST", 
            data: {fecha, id_usuario},
            url: '../php/cuadre_caja/buscar_fpago.php',
            success: function(response) {
                const formas_p = JSON.parse(response);
                    
                formas_p.forEach(f_pago => {
                    const id_fpago = f_pago.id;
                    const nombre = f_pago.nombre;
                    const aseguradora = f_pago.aseguradora;
                    
                    //==================== AÑADIR TOTALES INGRESOS =======================
                    var ingreso=0;
                    var egreso=0;
                    $.ajax({
                        type: "POST", 
                        data: {fecha, id_usuario, id_fpago},
                        url: '../php/cuadre_caja/total_ingresos.php',
                        success: function(response) {                   
                                const t_ingresos = JSON.parse(response);
                                
                                t_ingresos.forEach(t_ingreso => {
                                    ingreso=t_ingreso.total;                                    
                                    if(ingreso === null)
                                    {
                                        ingreso=0;                                        
                                    }                                        
                                })

                                //======================= AÑADIR TOTALES EGRESOS ==================
                  
                                $.ajax({
                                    type: "POST", 
                                    data: {fecha, id_usuario, id_fpago},
                                    url: '../php/cuadre_caja/total_egresos.php',
                                        success: function(response) {
                                
                                            const t_egresos = JSON.parse(response);
                                            
                                            t_egresos.forEach(t_egreso => {
                                                egreso=t_egreso.total;
                                                console.log("Egreso: "+nombre+" "+egreso);
                                                
                                                if (egreso === null)
                                                {        
                                                    egreso = 0;
                                                }
                                            
                                                template += '<tr class="bg-blue">';
                                                template += `<td class="pt-3">${nombre}</td><td class="pt-3">$${ingreso}</td>`;
                                                template += `<td class="pt-3">$${egreso}</td>`;
                                                template += `<td class="pt-3">$${ingreso-egreso}</td></tr>`;                        
                                                console.log(template);
                                                $('#ciet_body').html(template);

                                            });
                                        }                            
                                });
                        }
                    });
                    
                });
                
            }
        });   
        
        $('#div_ciet_table').show();
        $('#div_btn_pdf').show();
    }
    
    $("#gen_reporte").on("click", function () {
        
            const id_usuario = $("#id_usuario").val();
            c_ingresos = [];
            c_egresos = [];
            $('#div_cci_table').hide();
            $('#div_cce_table').hide();
            $('#div_ciet_table').hide();
            $('#div_btn_pdf').hide();
            listarIngresos(id_usuario);        
    });
    
    $("#btn_pdf").on("click", function () {
        const fecha = $('#fecha_cc').val();
        const id_usuario = $("#id_usuario").val();
        window.open(`../php/reportes/reporte_cuadre_c.php?fecha=${fecha}&id_usuario=${id_usuario}`, '_blank');
    });
    
    
    $("#btn_exportar").on("click", function () {
        //exportTableToExcel("cci_table", filename = 'cuadre_caja');
        $tabla = document.querySelector("#cci_table");
        //var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        let tableExport = new TableExport($tabla, {
            exportButtons: false, // No queremos botones
            filename: "Cuadre_caja", //Nombre del archivo de Excel
            sheetname: "Cuadre_caja", //Título de la hoja
        });
        let datos = tableExport.getExportData();
        let preferenciasDocumento = datos.cci_table.xlsx;
        tableExport.export2file(preferenciasDocumento.data, preferenciasDocumento.mimeType, preferenciasDocumento.filename, preferenciasDocumento.fileExtension, preferenciasDocumento.merges, preferenciasDocumento.RTL, preferenciasDocumento.sheetname);
    });
    
});