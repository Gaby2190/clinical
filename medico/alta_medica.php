<?php
include_once "../sesion.php";
include_once "../variables.php";
if (trim($_SESSION['rol']) != trim($medi)) {
    echo"<script>window.location.replace('../index.php');</script>";
}
$id_caso=$_GET['id_caso'];
?>
<!doctype html>
<html lang="es">

<head> 
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Alta Médica</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/medi.css">
    <!-- <link rel="stylesheet" href="css/alta_medica.css"> -->


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">
    <section>
       <?php include_once "nav.php";?>
        <!-- main content start -->
        <div class="main-content">
        
            <!-- content -->
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-12"> 
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Alta Médica</h6>
                                        <div class="row justify-content-center">
                                            <input type="text" id="id_caso" value="<?php echo(htmlspecialchars($id_caso));?>" required disabled hidden>
                                            <div class="col-sm-6 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Condición de Alta</p>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <select class="custom-select" id="select_c_alta" required>
                                                    <option selected="selected" value="0">Curado</option>
                                                    <option value="1">Igual</option>
                                                    <option value="2">Peor</option>
                                                    <option value="3">Muerto</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Tipo de Tratamiento</p>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <select class="custom-select" id="select_t_tratamiento" required>
                                                    <option selected="selected" value="0">Clínico</option>
                                                    <option value="1">Quirúrgico</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Procedimientos Clínicos o Quirúrgicos principales</p>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input class="form-control" type="text" id="proc_cq" size="255" maxlength="255">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-12 my-2 justify-content-right">
                                                <button class="btn btn-primary rounded float-right my-4 mx-1" id="btn_conf_alta"><span class="fa fa-user-med"></span> Dar de alta</button>
                                            </div>
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

                <div class="modal fade" id="modalAlta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <div class="modal-content text-center">
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Confirmación</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div> 
                            <div class="modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon_a"></i>

                                <p id="texto_modal_a"></p>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal" id="btn_alta">Aceptar</button>
                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>


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
    <script src="js/medi.js"></script>

    <script src="js/alta_medica.js"></script>

</body>

</html>