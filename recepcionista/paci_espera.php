<?php
include_once("../sesion.php");
include_once("../variables.php");
if (trim($_SESSION['rol']) != trim($rece)) {
    echo"<script>window.location.replace('../index.php');</script>";
}
?> 
<!doctype html>
<html lang="es">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Ingreso sala de espera</title>

 
    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/rece.css">
    <link rel="stylesheet" href="css/paci_espera.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">

    <!-- datetimepicker -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css"/>
</head>

<body class="sidebar-menu-collapsed">
    <section>
       <?php include_once("nav.php") ?>
        <!-- main content start -->
        <div class="main-content">
        <?php
        $id_cita=$_GET['id_cita'];
        ?>
            <!-- content -->
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-12"> 
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">DATOS PERSONALES - paciente</h6>
                                        <div class="row">
                                        <input type="text" id="id_cita" value="<?php echo($id_cita);?>" required hidden>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Apellido paterno:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="apellidos_paci1" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Apellido materno:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="apellidos_paci2" size="50" maxlength="50">
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Primer nombre:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="nombres_paci1" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Segundo nombre:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="nombres_paci2" size="50" maxlength="50">
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>N° Cédula de ciudadanía:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="cedula_paci" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="10" maxlength="10" required>
                                            </div>
                                            <!-- <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Dirección de residencia habitual (Calle y N° - Manzana y Casa):</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="direccion_paci" size="100" maxlength="100" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Barrio:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="barrio_paci" size="50" maxlength="50">
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Parroquia:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="parroquia_paci" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Cantón:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="canton_paci" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Provincia:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="provincia_paci" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Zona:</p>
                                                <select class="custom-select" id="select_zona" required>
                                                    <option value="0">Rural</option>
                                                    <option value="1">Urbana</option> 
                                                </select>
                                            </div> -->
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Teléfono:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="telefono_paci" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="15" maxlength="15">
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Celular:</p>
                                                <input type="tel" class="text-muted f-w-400 form-control" id="celular_paci" pattern="[0-9]{10}" size="10" maxlength="10" autocomplete="of" required>
                                            </div>
                                            <!-- <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Tipo de sangre:</p>
                                                <select class="custom-select" id="select_sangre" required></select>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Correo:</p>
                                                <input type="email" class="text-muted f-w-400 form-control" id="correo_paci" size="50" maxlength="50" required>
                                            </div> -->
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Fecha de nacimiento:</p>
                                                <input class="form-control datepicker" id="fechan_paci" required>
                                                <script>
                                                    var d = new Date(); 
                                                    var month = d.getMonth() + 1;
                                                    var day = d.getDate();
                                                    var f_actual = d.getFullYear() + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

                                                    $('#fechan_paci').attr('value', f_actual);

                                                    $('.datepicker').datepicker({
                                                        uiLibrary: 'bootstrap4',
                                                        format: 'yyyy-mm-dd',
                                                        maxDate: f_actual
                                                    });
                                                </script>
                                            </div>
                                            <!-- <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Lugar de nacimiento:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="lnacimiento_paci" size="100" maxlength="100" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Nacionalidad:</p>
                                                <select class="custom-select" id="select_nacionalidad" required></select>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Grupo cultural:</p>
                                                <select class="custom-select" id="select_gcultural" required>
                                                        <option value="0">Indígena</option>
                                                        <option value="1">Afroecuatoriano/a</option>
                                                        <option value="2">Montubio/a</option>
                                                        <option value="3">Mestizo/a</option>
                                                        <option value="4">Blanco/a</option>
                                                        <option value="5">Otro/a</option>                                                        
                                                    </select>
                                            </div> -->
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Género:</p>
                                                <select class="custom-select" id="select_genero" required></select>
                                            </div>
                                            <div class="col-sm-6 my-2"> 
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Dirección de residencia habitual (Calle y N° - Manzana y Casa):</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="direccion_paci" size="100" maxlength="100" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Ocupación:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="ocupacion_paci" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Empresa donde trabaja:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="empresat_paci" size="50" maxlength="50" required>
                                            </div>
                                            <!-- <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Estado civil:</p>
                                                <select class="custom-select" id="select_ecivil" required>
                                                    <option value="0">Soltero/a</option>
                                                    <option value="1">Casado/a</option>
                                                    <option value="2">Divorciado/a</option>
                                                    <option value="3">Viudo/a</option>
                                                    <option value="4">Unión Libre</option>                                                        
                                                </select>
                                            </div> 
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Instrucción - Último año aprobado:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="instruccion_paci" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Ocupación:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="ocupacion_paci" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Empresa donde trabaja:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="empresat_paci" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Tipo de seguro de salud:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="ssalud_paci" size="50" maxlength="50" required>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Referido de:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="referido_paci" size="50" maxlength="50">
                                            </div> -->
                                            
                                            
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-sm-12">
                                    <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 tit">Referencia personal del paciente</h6>
                                    <div class="row">
                                        <div class="col-sm-6 my-2">
                                            <p class="m-b-10 f-w-600">Nombres:</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="contacto_nom" size="50" maxlength="50" required>
                                        </div>
                                        <div class="col-sm-6 my-2">
                                            <p class="m-b-10 f-w-600">Apellidos:</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="contacto_ape" size="50" maxlength="50" required>
                                        </div>
                                        <div class="col-sm-6 my-2">
                                            <p class="m-b-10 f-w-600">Parentesco - Afinidad:</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="contacto_par" size="50" maxlength="50" required>
                                        </div>
                                        <div class="col-sm-6 my-2">
                                            <p class="m-b-10 f-w-600">Celular:</p>
                                            <input type="tel" class="text-muted f-w-400 form-control" id="contacto_num" pattern="[0-9]{10}" size="10" maxlength="10" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" autocomplete="of" required>
                                        </div>
                                        <div class="col-sm-12 my-2">
                                            <p class="m-b-10 f-w-600">Dirección:</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="contacto_dir" size="100" maxlength="100" required>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 my-2 justify-content-right" id="vi">
                                            <button class="btn btn-secondary rounded float-right my-4 mx-1" id="btn_act_conf"><span class="fa fa-check"></span> Verificar e ingresar a sala de espera</button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: INFORMACION-->
                <div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <div class="modal-content text-center">
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Información</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class=" modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon"></i>

                                <p id="texto_modal"></p>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Modal: modalPush-->
                <!-- Modal: INFORMACION--> 
                <div class="modal fade" id="modalEspera" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <div class="modal-content text-center">
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Confirmación</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div> 
                            <div class=" modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon_e"></i>

                                <p id="texto_modal_e"></p>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_espera">Aceptar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Modal: modalPush -->

            </div>
            <!-- //content -->
        </div>
        <!-- main content end-->
    </section>



    <!----------------------------------------------------------------------------footer section start--------------------------------------------------------->
    <?php include_once("footer.php") ?>
    <!--footer section end-->


    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../assets/js/jquery-1.10.2.min.js"></script>


    <script src="../assets/js/jquery.nicescroll.js"></script>
    <script src="../assets/js/scripts.js"></script>

    <script>
        var closebtns = document.getElementsByClassName("close-grid");
        var i;

        for (i = 0; i < closebtns.length; i++) {
            closebtns[i].addEventListener("click", function() {
                this.parentElement.style.display = 'none';
            });
        }
    </script>
    <!-- //close script -->

    <!-- disable body scroll when navbar is in active -->
    <script>

        $(function() {
            $('.sidebar-menu-collapsed').click(function() {
                $('body').toggleClass('noscroll');
            })
        });
    </script>
    <!-- disable body scroll when navbar is in active -->

    <!-- loading-gif Js -->
    <script src="../assets/js/modernizr.js"></script>
    <script>
        $(window).load(function() {
            // Animate loader off screen
            $(".se-pre-con").fadeOut("slow");;
        });
    </script>
    <!--// loading-gif Js -->

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="js/rece.js"></script>

    <script src="js/paci_espera.js"></script>
    <script src="../lib/gen-pass.js"></script>

</body>

</html>