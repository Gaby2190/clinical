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

    <title>Cuadre de caja diario</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/admin.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
    
    
    <!-- links para exportar a excel -->
    <script src="https://unpkg.com/xlsx@0.16.9/dist/xlsx.full.min.js"></script>
    <script src="https://unpkg.com/file-saverjs@latest/FileSaver.min.js"></script>
    <script src="https://unpkg.com/tableexport@latest/dist/js/tableexport.min.js"></script>
</head>

<body class="sidebar-menu-collapsed">

    <section>
       <?php include_once("nav.php") ?>
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
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Cuadre de caja diario</h6>
                                        <div class="container">
                                            <div class="row form-group">
                                                <div class="col-sm-4 mb-4">
                                                    <p class="m-b-10 f-w-600">Seleccione una fecha:</p>
                                                    <input type="date" class="form-control" id="fecha_cc" required>
                                                </div>
                                                <div class="col-sm-4 mb-4">
                                                    <p class="m-b-10 f-w-600">Seleccione un rol:</p>
                                                    <select class="custom-select" id="select_rol">
                                                        <option selected="selected"></option>
                                                        <option value="1">Administrador</option>
                                                        <option value="2">Cajero/a</option>
                                                        <option value="3">Recepcionista</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-4 mb-4">
                                                    <p class="m-b-10 f-w-600">Seleccione un usuario:</p>
                                                    <select class="custom-select" id="select_usuario"></select>
                                                </div>
                                                <div class="col-sm-12 mb-4 justify-content-right">
                                                    <a style="color: #fff;" class="btn btn-primary float-right" id="gen_reporte"><span class="fa fa-file-text-o"></span> Generar reporte</a>
                                                </div>
                                                <br>
                                                
                                                <div class="container my-2" id="div_cci_table">
                                                    <div class="row form-group">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-12 table-responsive">
                                                                    <table class="table table-striped" id="cci_table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col"></th>
                                                                                <th scope="col"></th>
                                                                                <th scope="col"></th>
                                                                                <th scope="col"></th>
                                                                                <th scope="col">INGRESOS</th>
                                                                                <th scope="col"></th>
                                                                                <th scope="col"></th>
                                                                                <th scope="col"></th>
                                                                                <th scope="col"></th>
                                                                                <th scope="col"></th>
                                                                            </tr> 
                                                                            <tr>
                                                                                <th scope="col">Fecha</th>
                                                                                <th scope="col">Hora</th>
                                                                                <th scope="col">Paciente</th>
                                                                                <th scope="col">Médico</th>
                                                                                <th scope="col">Consulta</th>
                                                                                <th scope="col">TOTAL COBRADO</th>
                                                                                <th scope="col">Descuento</th>
                                                                                <th scope="col">Adicionales</th>
                                                                                <th scope="col">Otros</th>
                                                                                <th scope="col">Forma de Pago</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="cci_body"></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <br><hr><br>
                                                
                                                <div class="container my-2" id="div_cce_table">
                                                    <div class="row form-group">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-12 table-responsive">
                                                                    <table class="table table-striped" id="cce_table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th colspan="6" style="text-align: center">EGRESOS</th>
                                                                            </tr> 
                                                                            <tr>
                                                                                <th scope="col">Fecha</th>
                                                                                <th scope="col">Hora</th>
                                                                                <th scope="col">Comprobante de pago</th>
                                                                                <th scope="col">Médico</th>
                                                                                <th scope="col">TOTAL PAGADO</th>
                                                                                <th scope="col">Descuento</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="cce_body"></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <br><hr><br>
                                                
                                                <div class="container my-2" id="div_ciet_table">
                                                    <div class="row form-group">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-12 table-responsive">
                                                                    <table class="table table-striped" id="ciet_table">
                                                                        <thead>
                                                                            <tr>
                                                                                <th scope="col"><B>CUENTAS</B></th>
                                                                                <th scope="col"><B>INGRESOS</B></th>
                                                                                <th scope="col"><B>EGRESOS</B></th>
                                                                                <th scope="col"><B>TOTAL</B></th>
                                                                            </tr> 
                                                                        </thead>
                                                                        <tbody id="ciet_body"></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <br><hr><br>
                                                    
                                                    
                                                    <div class="row form-group">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-12 table-responsive">
                                                                    <table class="table table-striped" id="tot_table">
                                                                        <tbody id="tot_body"></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!--<button id="btn_exportar">Exportar a Excel</button>-->
                                                <div class="col-sm-12 my-2 justify-content-right" id="div_btn_pdf">
                                                    <button class="btn btn-danger rounded float-right" id="btn_pdf"><span class="fa fa-file-pdf-o"></span> DESCARGAR PDF</button>
                                                </div>
                                            </div>
                                        </div>
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

                <!--Modal: Confirmación-->
                <div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <!--Content-->
                        <div class="modal-content text-center">
                            <!--Header-->
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Confirmación</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <!--Body-->
                            <div class="modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon_conf"></i>

                                <p id="texto_modal_conf"></p>

                            </div>

                            <!--Footer-->
                            <div class="modal-footer">
                                <button id="btn_cancelar" type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
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
    <script src="js/admin.js"></script>

    <script src="js/cuadre_caja.js"></script>

</body>

</html>