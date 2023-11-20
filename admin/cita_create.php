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

    <title>Nueva Cita</title>
 

    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/cita_create.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">

    <section>
        <?php include_once("nav.php") ?>

        <div class="main-content">
        <?php
        $id_caso=$_GET['id_caso'];
        $id=$_GET['id'];
        ?>
        <!-- content -->
        
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-12">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">registro de citas</h6>
                                        <form id="cita-datos">
                                            <div class="container">
                                                <div class="row form-group">
                                                    <div class="col-sm-8 my-2">
                                                        <input type="text" class="form-control" id="id_caso" value="<?php echo($id_caso);?>" required hidden>
                                                        <input type="text" class="form-control" id="id" value="<?php echo($id);?>" required hidden>
                                                        <p class="m-b-10 f-w-600">Fecha de Citas:</p>
                                                        <input type="date" class="form-control" id="fecha_cita" required>
                                                    </div>
                                                    <div class="col-sm-4 mt-4 pt-3 my-2 pb-0 d-flex">
                                                        <a style="color: #fff;" class="btn btn-primary" id="gen_citas"><span class="fa fa-calendar-check-o"></span> Generar Citas</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="container" id="div_table">
                                                <div class="row form-group">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-12 table-responsive">
                                                                <table class="table table-striped" id="citas_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">FECHA</th>
                                                                            <th scope="col">Hora de ingreso a cita</th>
                                                                            <th scope="col">Estado</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="citas_body"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
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
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Modal: modalPush-->

                <!--Modal: mConfirmación de cita creacion-->
                <div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">

                        <div class="modal-content text-center">

                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Confirmación</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon_c"></i>

                                <p id="texto_modal_c"></p>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="crear">Aceptar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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

    <script src="js/cita_create.js"></script>
    <script src="../lib/gen-pass.js"></script>

</body>

</html>