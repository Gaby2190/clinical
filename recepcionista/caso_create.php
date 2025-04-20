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

    <title>Nuevo Caso</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/rece.css">
    <link rel="stylesheet" href="css/caso_create.css">


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
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">caso nuevo</h6>
                                        <form id="caso-datos">
                                            <div class="row form-group">
                                                <div class="col-sm-4 my-2 pt-2">
                                                    <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione una Especialidad:</p>
                                                </div>
                                                <div class="col-sm-8 my-2 pt-1">
                                                    <select class="custom-select" id="select_especialidad" required></select>
                                                </div>
                                                <div class="col-sm-4 my-2 pt-2" id="div_tmed">
                                                    <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione un Médico:</p>
                                                </div>
                                                <div class="col-sm-8 my-2 pt-1" id="div_smed">
                                                    <select class="custom-select" id="select_medico" required></select>
                                                </div>
                                                <div class="col-sm-12 mb-1 mt-4">
                                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit">Datos del paciente</h6>
                                                </div>
                                                <div class="col-sm-4 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Nacionalidad:</p>
                                                    <select class="custom-select" id="select_nacionalidad" required></select>
                                                </div>
                                                <div class="col-sm-4 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Cédula:</p>
                                                    <input type="text" class="text-muted f-w-400 form-control" id="cedula_paci" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="10" maxlength="10" required>
                                                </div>
                                                <div class="col-sm-4 mt-4 pt-3 my-2 pb-0 text-center">
                                                    <a style="color: #fff;" class="btn" id="buscar_btn"><span class="fa fa-search"></span> Realizar busqueda por nombres</a>
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
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Primer apellido:</p>
                                                    <input type="text" class="text-muted f-w-400 form-control" id="apellidos_paci1" size="50" maxlength="50" required>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600">Segundo apellido:</p>
                                                    <input type="text" class="text-muted f-w-400 form-control" id="apellidos_paci2" size="50" maxlength="50">
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Celular:</p>
                                                    <input type="tel" class="text-muted f-w-400 form-control" id="celular_paci" pattern="[0-9]{10}" size="10" maxlength="10" autocomplete="of" required>
                                                </div>
                                                <div class="col-sm-6 my-2" id="notificacion">
                                                   
                                                </div>
                                            </div>

                                            <div class="col-sm-12 my-2">
                                                <button class="btn btn-primary text-uppercase btn-lg float-right my-4" type="submit" id="datos_btn"><span class="fa fa-floppy-o"></span> Registrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: modalPush-->
                <div class="modal fade" id="modalPush" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <!--Content-->
                        <div class="modal-content text-center">
                            <!--Header-->
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Información</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <!--Body-->
                            <div class=" modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon"></i>

                                <p id="texto_modal"></p>

                            </div>

                            <!--Footer-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <!--Modal: modalPush-->
                 <!--Modal: modal_confirmar-->
                <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <!--Content-->
                        <div class="modal-content text-center">
                            <!--Header-->
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Información</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <!--Body-->
                            <div class=" modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icono"></i>

                                <p id="pregunta_modal"></p>

                            </div>

                            <!--Footer-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="cita_nueva">Agendar Cita Nueva</button>
                                <button type="button" class="btn btn-primary" id="cita_control">Agendar Cita de Control</button>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <!--Modal: modal_confirmar-->
                <!--Modal: Busqueda-->
                <div class="modal fade" id="modalBusqueda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Búsqueda por nombres</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="form-group">
                                    <input type="text" class="form-control" style="width:30%" id="busc_paci" placeholder="Ingrese el nombre del paciente...">
                                </div>


                                <div class="table-responsive">
                                    <table class="table" id="tabla_pac">
                                        <thead>
                                            <tr>
                                                <th scope="col" hidden>ID</th>
                                                <th scope="col">Nombres y Apellidos</th>
                                                <th scope="col">Cédula</th>
                                                <th scope="col">Celular</th>
                                            </tr>
                                        </thead>
                                        <tbody id="pacientes"> </tbody>
                                    </table>
                                    <div class="col-md-12 text-center">
                                        <ul class="pagination pager" id="myPager"></ul>
                                    </div>
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
    <script src="js/rece.js"></script>

    <script src="js/caso_create.js"></script>
    <script src="../lib/gen-pass.js"></script>
    <script src="../lib/val_ced.js"></script>
</body>

</html>