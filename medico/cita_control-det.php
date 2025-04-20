<?php
include_once("../sesion.php");
include_once("../variables.php");
if (trim($_SESSION['rol']) != trim($medi)) {
    echo"<script>window.location.replace('../index.php');</script>";
}
$id_paciente=$_GET['id_paciente'];
$id_medico=$_GET['id_medico'];
$id_especialidad=$_GET['id_especialidad'];
$nombres1=$_GET['nombres1'];
$nombres2=$_GET['nombres2'];
$apellidos1=$_GET['apellidos1'];
$apellidos2=$_GET['apellidos2'];




?>
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Nueva Cita de Control</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/medi.css">
    <link rel="stylesheet" href="css/cita_control.css">


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
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">citas de control</h6>
                                        <form id="control-datos">
                                            <div class="container">
                                                <div class="row form-group">
                                                    <div class="col-sm-3 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Primer nombre:</p>
                                                         <input type="hidden" class="text-muted f-w-400 form-control" id="id_paciente" value="<?php echo $id_paciente; ?>" required>
                                                         <input type="hidden" class="text-muted f-w-400 form-control" id="id_medico" value="<?php echo $id_medico; ?>" required>
                                                         <input type="hidden" class="text-muted f-w-400 form-control" id="id_especialidad" value="<?php echo $id_especialidad; ?>" required>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="nombres_paci1"  value="<?php echo $nombres1; ?>" size="50" maxlength="50" required>
                                                    </div>
                                                    <div class="col-sm-3 my-2">
                                                        <p class="m-b-10 f-w-600">Segundo nombre:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="nombres_paci2" value="<?php echo $nombres2; ?>" size="50" maxlength="50">
                                                    </div>
                                                    <div class="col-sm-3 my-2">
                                                        <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Primer apellido:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="apellidos_paci1" value="<?php echo $apellidos1; ?>" size="50" maxlength="50" required>
                                                    </div>
                                                    <div class="col-sm-3 my-2">
                                                        <p class="m-b-10 f-w-600">Segundo apellido:</p>
                                                        <input type="text" class="text-muted f-w-400 form-control" id="apellidos_paci2" value="<?php echo $apellidos2; ?>" size="50" maxlength="50">
                                                    </div>
                                                    <div class="col-sm-12 mt-4 pt-3 my-2 pb-0">
                                                        <a style="color: #fff;" class="btn btn-primary float-right" id="buscar_btn"><span class="fa fa-search"></span> Realizar busqueda de paciente</a>
                                                    </div>
                                                    <br>

                                                    <div class="container" id="div_table_casos">
                                                        <div class="row form-group">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-12 table-responsive">
                                                                        <table class="table table-striped" id="casos_pac_table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col" hidden>ID</th>
                                                                                    <th scope="col">Médico</th>
                                                                                    <th scope="col">Motivo Consulta</th>
                                                                                    <th scope="col">Fecha ult. cita</th>
                                                                                    <th scope="col">Opciones</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="casos_body"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
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
                            <div class="modal-body">

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


                <div class="modal fade" id="modalBusqueda" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1000px!important;" role="document">
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
    <script src="js/medi.js"></script>

    <script src="js/cita_control-det.js"></script>
    <script src="../lib/val_ced.js"></script>

</body>