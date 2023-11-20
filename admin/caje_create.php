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

    <title>Nuevo Cajero</title>


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
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">datos personales - cajero/a</h6>
                                        <form id="cajero-datos" enctype="multipart/form-data">
                                            <div class="row form-group">
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Nombres:</p>
                                                    <input type="text" class="text-muted f-w-400 form-control" id="nombres_caje" size="50" maxlength="50" required>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Apellidos:</p>
                                                    <input type="text" class="text-muted f-w-400 form-control" id="apellidos_caje" size="50" maxlength="50" required>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Cédula:</p>
                                                    <input type="text" class="text-muted f-w-400 form-control" id="cedula_caje" name="cedula_caje" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="10" maxlength="10" required>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600">Teléfono:</p>
                                                    <input type="text" class="text-muted f-w-400 form-control" id="telefono_caje" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="15" maxlength="15">
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Celular:</p>
                                                    <input type="tel" class="text-muted f-w-400 form-control" id="celular_caje" pattern="[0-9]{10}" size="10" maxlength="10" autocomplete="of" required>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Correo:</p>
                                                    <input type="email" class="text-muted f-w-400 form-control" id="correo_caje" size="50" maxlength="50" required>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Dirección:</p>
                                                    <input type="text" class="text-muted f-w-400 form-control" id="direccion_caje" size="100" maxlength="100" required>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600">Seleccionar una imagen de perfil:</p>
                                                    <input type="file" class="form-control-file" name="imagen" id="imagen">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 my-4">
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
                            <div class=" modal-body ">

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

    <script src="js/caje_create.js"></script>
    <script src="../lib/gen-pass.js"></script>

</body>

</html>