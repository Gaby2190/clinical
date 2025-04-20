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
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache"> 
    <title>Citas Agendadas</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/rece.css">
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
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Agenda Medicos</h6>
                                        <form id="citas-datos">
                                           
                                                <div class="row form-group">
                                                     <div class="col-sm-4 my-2 pt-2">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione una Especialidad:</p>
                                                    </div>
                                                    <div class="col-sm-8 col-xs-4 my-2 pt-1">
                                                        <select class="custom-select" id="select_especialidad" required></select>
                                                    </div>
                                                    <!-- Elementos del control de Medico mediante un Select -->
                                                    <div class="col-sm-4 my-2 pt-2" id="div_tmed">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione un Médico:</p>
                                                    </div>
                                                    <div class="col-sm-8 my-2 pt-1" id="div_smed">
                                                        <select class="custom-select" id="select_medico" required></select>
                                                    </div>
                                                    <!-- Elegir fecha de la cita -->
                                                    <div class="col-sm-4 my-2 pt-2" id="div_lfecha">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Búscar por Fecha de Citas:</p>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-1" id="div_fecha">
                                                        
                                                        <select class="custom-select" id="fecha_cita" required></select>
                                                    </div>
                                                    <div class="col-sm-2 my-2 pt-1" id="btn_listar">
                                                        <a style="color: #fff;" class="btn btn-primary" id="list_citas"><span class="fa fa-search"></span> Buscar Citas</a>
                                                    </div>
                                                </div>
                                            
                                            
                                            
                                            
                                                <div id="div_table" class="col-md-12">
                                                <div class="row form-group">
                                                    <div class="container">
                                                        <div class="row">
                                                            <div class="col-md-12 col-lg-12 table-responsive">
                                                                <table class="table table-striped" id="citas_table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th scope="col">Fecha</th>
                                                                            <th scope="col">Hora cita</th>
                                                                            <th scope="col">Estado</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="citas_body"></tbody>
                                                                </table>
                                                                


                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                <!-- Cita seleccionada --->
                                                <div class="col-sm-4 my-2 pt-2" id="div_lturno">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Turno Seleccionado:</p>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-1" id="div_turno">
                                                        <input type="text" class="form-control" id="turno" size="50" maxlength="50" required disabled>
                                                    </div>
                                                <div class="row form-group" id="div_datos_paciente">
                                                <div class="col-sm-12 mb-1 mt-4">
                                                    <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit">Datos del paciente</h6>
                                                </div>
                                                <!-- Elementos del control de Nacionalidad mediante un Select -->
                                                <div class="col-sm-4 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Nacionalidad:</p>
                                                    <select class="custom-select" id="select_nacionalidad" required></select>
                                                </div>
                                                <!-- Elementos del control de cedula del paciente mediante un input -->
                                                <div class="col-sm-4 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Cédula:</p>
                                                <input type="text" class="text-muted f-w-400 form-control" id="cedula_paci" ondrop="return false;" onpaste="return false;" onkeypress="return event.charCode>=48 && event.charCode<=57" size="10" maxlength="10" required>
                                                </div>
                                                 <!-- Elementos del control de sin cedula del paciente mediante un input -->
                                                 <div class="col-sm-2 my-2">
                                                        <input class="form-check-input" type="checkbox" value="" id="sin_ced">
                                                        <label class="form-check-label m-b-10 f-w-600" for="sin_ced">
                                                            Sin Cédula
                                                        </label>
                                                    </div>
                                                <!-- Boton para abrir un modal de busqueda por nombre -->
                                                <div class="col-sm-2 my-2">
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
                                                <div class="col-sm-6 my-2">
                                                    <p class="m-b-10 f-w-600"><span style="color: red;">*</span>Seguro Médico:</p>
                                                    <select class="custom-select" id="select_seguros" required></select>
                                                </div>
                                           
                                            <!-- Boton de registrar la cita. -->
                                            <div class="col-sm-12 my-2">
                                            <button class="btn btn-primary text-uppercase btn-lg float-right my-4" type="submit" id="datos_btn"><span class="fa fa-floppy-o"></span> Registrar</button>
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
    <script src="js/rece.js"></script>

    <script src="js/cita_age_med.js"></script>
    <script src="../lib/val_ced.js"></script>
    <script src="../lib/gen-pass.js"></script>
</body>

</html>