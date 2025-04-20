<?php
include_once("../sesion.php");
include_once("../variables.php");
if (trim($_SESSION['rol']) != trim($medi)) {
    echo"<script>window.location.replace('../index.php');</script>";
} 
?>
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Disponibilidad Médicos</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/medi.css">
    <link rel="stylesheet" href="css/cita_age_read.css">
    <link rel="stylesheet" href="css/cita_create.css">
    <link rel="stylesheet" href="css/caso_create.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
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
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Disponibilidad de Atención</h6>
                                        <form id="disponibilidad-datos">
                                           
                                                <div class="row form-group">
                                                     <div class="col-sm-4 my-2 pt-2">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione una Especialidad:</p>
                                                    </div>
                                                    <div class="col-sm-8 col-xs-4 my-2 pt-1">
                                                        <select class="custom-select" id="select_especialidad" required></select>
                                                    </div>
                                                    
                                                    <!-- Elegir fecha de la cita -->
                                                    <div class="col-sm-4 my-2 pt-2" id="div_lfecha">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccionar Fecha:</p>
                                                    </div>
                                                    <div class="col-sm-8 my-2 pt-1" id="div_fecha">
                                                        <input type="date" class="form-control" id="fecha_cita" required>
                                                    </div>
                                                    <!-- Elementos del control de Rango 1 mediante un Select -->
                                                    <div class="col-sm-4 my-2 pt-2" id="div_ran1">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione Rango 1:</p>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-1" id="div_ran1_i">
                                                        <label class="text-muted f-w-400"> Desde:</label>
                                                        <select class="custom-select" id="select_rango1_ini" required>
                                                            <option value="0" selected>Seleccione una hora</option>
                                                            <option value="08:00">08:00</option>
                                                            <option value="08:30">08:30</option>
                                                            <option value="09:00">09:00</option>
                                                            <option value="09:30">09:30</option>
                                                            <option value="10:00">10:00</option>
                                                            <option value="10:30">10:30</option>
                                                            <option value="11:00">11:00</option>
                                                            <option value="11:30">11:30</option>
                                                            <option value="12:00">12:00</option>
                                                            <option value="12:30">12:30</option>
                                                            <option value="13:00">13:00</option>
                                                            <option value="13:30">13:30</option>
                                                            <option value="14:00">14:00</option>
                                                            <option value="14:30">14:30</option>
                                                            <option value="15:00">15:00</option>
                                                            <option value="15:30">15:30</option>
                                                            <option value="16:00">16:00</option>
                                                            <option value="16:30">16:30</option>
                                                            <option value="17:00">17:00</option>
                                                            <option value="17:30">17:30</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-1" id="div_ran1_f">
                                                        <label class="text-muted f-w-400"> Hasta:</label>
                                                        <select class="custom-select" id="select_rango1_fin" required> </select>
                                                    </div>

                                                    <!-- Elementos del control de Rango 2 mediante un Select -->
                                                    <div class="col-sm-4 my-2 pt-2" id="div_ran2">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione Rango 2:</p>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-1" id="div_ran2_i">
                                                        <label class="text-muted f-w-400"> Desde:</label>
                                                        <select class="custom-select" id="select_rango2_ini"></select>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-1" id="div_ran2_f">
                                                        <label class="text-muted f-w-400"> Hasta:</label>
                                                        <select class="custom-select" id="select_rango2_fin"> </select>
                                                    </div>

                                                    <!-- Elementos del control de Rango 3 mediante un Select -->
                                                    <div class="col-sm-4 my-2 pt-2" id="div_ran3">
                                                        <p class="m-b-10 f-w-600 text-uppercase">Seleccione Rango 3:</p>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-1" id="div_ran3_i">
                                                        <label class="text-muted f-w-400"> Desde:</label>
                                                        <select class="custom-select" id="select_rango3_ini"></select>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-1" id="div_ran3_f">
                                                        <label class="text-muted f-w-400"> Hasta:</label>
                                                        <select class="custom-select" id="select_rango3_fin"> </select>
                                                    </div>
                                                    
                                                </div>
                                                <div id="respuesta"></div>
                                                <div class="row form-group">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-12 table-responsive">
                                                                <table class="table table-striped" id="rangos_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Fecha</th>
                                                                            <th scope="col">Hora Inicio</th>
                                                                            <th scope="col">Hora Fin</th>
                                                                            
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="rangos_body"></tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                             
                                           
                                            <!-- Boton de registrar la cita. -->
                                            <div class="col-sm-12 my-2">
                                            <button class="btn btn-primary text-uppercase btn-lg float-right my-4" type="submit" id="datos_btn"><span class="fa fa-floppy-o"></span> Registrar</button>
                                            </div>
                                            </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="col-sm-12 my-2">
                                            <button class="btn btn-primary text-uppercase btn-lg float-right my-4" type="button" id="eliminar_rango"><span class="fa fa-trash"></span> Eliminar Disponibilidad</button>
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

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_icon"><img id="progreso" src='../assets/images/progreso.gif'/></i>

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
                                <button id="crear" type="button" class="btn btn-danger" data-dismiss="modal">Aceptar</button>
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                        <!--/.Content-->
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

    <script src="js/disp_med.js"></script>
    
</body>

</html>