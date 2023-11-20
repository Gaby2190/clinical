<?php
include_once("../sesion.php");
include_once("../variables.php");
if (trim($_SESSION['rol']) != trim($admin)) {
    echo"<script>window.location.replace('../index.php');</script>";
}
?>
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nuevo Médico</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/admin.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">

    <section>
        <?php include_once("nav.php") ?>

        <div class="main-content">

        <!-- content -->
        
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                        <div class="col-xl-12 col-md-12">
                            <div class="card user-card-full">
                                <div class="row m-l-0 m-r-0"> 
                                    <div class="col-sm-12">
                                        <div class="card-block">
                                            <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">datos personales - medico</h6>
                                            <form id="medico_datos" enctype="multipart/form-data">
                                                <div class="row form-group">
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Nombres Completos:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="nombres_medi" size="50" maxlength="50" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Apellidos Completos:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="apellidos_medi" size="50" maxlength="50" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Nombre y Apellido:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="nom_ape_medi" size="50" maxlength="50" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Cédula:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="cedula_medi" name="cedula_medi" ondrop=" return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="10" maxlength="10" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Género:</p>
                                                        <select class="custom-select" id="select_genero" required></select>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Número de Autorización:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="nautorizacion_medi" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="15" maxlength="15" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600">Teléfono:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="telefono_medi" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="15" maxlength="15">
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Celular:</p>
                                                        <input type="tel" class="text-muted f-w-400 form-control" id="celular_medi" pattern="[0-9]{10}" size="10" maxlength="10" autocomplete="of" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Correo:</p>
                                                        <input type="email" class="text-muted f-w-400 form-control" id="correo_medi" size="50" maxlength="50" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Dirección:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="direccion_medi" size="100" maxlength="100" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Tiempo de atención promedio (minutos):</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="tiempo_ap" ondrop=" return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="2" maxlength="2" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Tarifa de Consulta Normal:</p>
                                                        <input placeholder="Dólares ($)" step="any" type="number" class="text-muted f-w-400 form-control" id="tarifa" required>
                                                    </div> 
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Tarifa de Consulta Control:</p>
                                                        <input placeholder="Dólares ($)" step="any" type="number" class="text-muted f-w-400 form-control" id="tarifa_control" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2"> 
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Cobro de tarifa al ingreso</p>
                                                        <select id="select_pago_i" class="custom-select" required>
                                                            <option value="0" selected>NO</option>
                                                            <option value="1">SÍ</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600">Comisión de la clínica - Consulta (%):</p>
                                                        <input step="any" type="number" class="text-muted f-w-400 form-control" id="comision_c" required>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600">Comisión de la clínica - Adicionales (%):</p>
                                                        <input step="any" type="number" class="text-muted f-w-400 form-control" id="comision_a" required> 
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <p class="m-b-10 f-w-600">Seleccionar una imagen de perfil:</p>
                                                        <input type="file" class="form-control-file" name="imagen" id="imagen">
                                                    </div>
                                                </div>
                                                <div class="row form-group">

                                                    <div class="col-sm-12 my-2">
                                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">ESPECIALIDAD/ES</h6>
                                                    </div>

                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-12 table-responsive">
                                                                <table class=" table table-striped" id="especialidades_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Especialidad</th>
                                                                            <th scope="col">Universidad</th>
                                                                            <th scope="col">País</th>
                                                                            <th scope="col">Opciones</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="espe_body"></tbody>
                                                                </table>
                                                                <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalEspecialidad"><span class="fa fa-plus"></span> Añadir</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 my-4">
                                                    <button class="btn btn-primary btn-lg text-uppercase float-right my-4" type="submit"><span class="fa fa-floppy-o"></span> Registrar</button>
                                                </div>
                                            </form>
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


                    <!--Modal: Especialidad-->
                    <div class="modal fade" id="modalEspecialidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content"> 
                                <div class="modal-header text-center">
                                    <h4 class="modal-title w-100 font-weight-bold">Añadir Especialidad</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                                </div>
                                <div class="modal-body mx-3">

                                    <div class="input-group my-3">
                                        <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Especialidad:</p>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-graduation-cap prefix grey-text"></i></span>
                                        </div>
                                        <select class="custom-select" id="select_especialidad" required></select>
                                    </div>

                                    <div class="input-group mb-3">
                                        <p class="f-w-600 text-uppercase col-sm-12">Universidad:</p>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-university prefix grey-text"></i></span>
                                        </div>
                                        <input type="text" id="universidad" class="form-control validate" size="100" maxlength="100">
                                    </div>

                                    <div class="input-group mb-3">
                                        <p class="f-w-600 text-uppercase col-sm-12">País:</p>
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-globe prefix grey-text"></i></span>
                                        </div>
                                        <input type="text" id="epais" class="form-control validate" size="100" maxlength="100">
                                    </div>

                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button class="btn btn-primary" id="add_espe" data-dismiss="modal">Añadir</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <script src="js/admin.js"></script>

    <script src="js/med_create.js"></script>
    <script src="../lib/gen-pass.js"></script>

</body>

</html>