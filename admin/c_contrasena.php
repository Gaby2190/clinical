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

    <title>Cambio de Contraseña</title>


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
        <?php
        $id_usuario = $_SESSION['id_usuario'];
        ?>
        <!-- content -->
        
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-12">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Cambio de contraseña</h6>
                                        <form id="contrasena_datos">
                                            <div class="container">
                                                <div class="row form-group">
                                                    <input type="text" class="form-control" id="id_usuario" value="<?php echo($id_usuario);?>" required hidden>
                                                    <div class="col-sm-4 my-2">
                                                        <label for="cont_ant"><span style="color: red;">*</span>Ingrese la contraseña actual</label>
                                                        <input type="password" class="form-control" id="cont_ant" required>
                                                    </div>
                                                    <div class="col-sm-4 my-2">
                                                        <label for="cont_new"><span style="color: red;">*</span>Ingrese la nueva contraseña</label>
                                                        <input type="password" class="form-control" id="cont_new" required>
                                                    </div>
                                                    <div class="col-sm-4 my-2">
                                                        <label for="cont_new_v"><span style="color: red;">*</span>Verifique la nueva contraseña</label>
                                                        <input type="password" class="form-control" id="cont_new_v" required>
                                                    </div>
                                                    <div class="col-sm-12 my-2">
                                                        <button class="btn btn-primary text-uppercase float-right" type="submit"><span class="fa fa-key"></span> Actualizar contraseña</button>
                                                    </div>
                                                </div>
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

                        <div class="modal-content text-center">

                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Información</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon"></i>
                                <p id="texto_modal"></p>
                            </div>

                            <!--Footer-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" id="btn_a" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
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

    <script src="js/c_contrasena.js"></script>

</body>

</html>