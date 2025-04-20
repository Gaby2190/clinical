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
    <title>Cobros Realizados</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/rece.css">
    <link rel="stylesheet" href="css/cobros_realizados.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">

    <section>
       <?php include_once("nav.php") ?>
        <!-- main content start -->
        <div class="main-content">
        <?php
        $id_usuario=$_SESSION['id_usuario'];
        ?>
            <!-- content -->
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-12">
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Cobros realizados</h6>
                                        <form id="cobros-datos">
                                            <div class="container"> 
                                                <div class="row form-group">
                                                <input type="text" id="id_usuario" value="<?php echo($id_usuario);?>" required hidden>
                                                <input type="number" step="any" id="total_val" disabled hidden>

                                                    <div class="col-sm-4 my-2 pt-2">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione un Médico:</p>
                                                    </div>
                                                    <div class="col-sm-8 my-2 pt-1">
                                                        <select class="custom-select" id="select_medico" required></select>
                                                    </div>
                                                    <div class="col-sm-4 my-2 pt-2">
                                                        <p class="m-b-10 f-w-600 text-uppercase"><span style="color: red;">*</span>Seleccione Fecha:</p>
                                                    </div>
                                                    <div class="col-sm-8 my-2 pt-1">
                                                        <select class="custom-select" id="select_fecha" required></select>
                                                    </div>
                                                    <br>
                                                     <div class="container" id="respuesta">
                                                    
                                                    </div>
                                                    <div class="container" id="div_table_cobros">
                                                        <div class="row form-group">
                                                            <div class="container">
                                                                <div class="row" style="margin-bottom: 2em">
                                                                    <div class="col-12 table-responsive">
                                                                        <table class="table table-striped" id="cobros_table">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th scope="col" hidden>ID</th>
                                                                                    <th scope="col"></th>
                                                                                    <th scope="col">Referencia</th>
                                                                                    <th scope="col">Fecha - Hora</th>
                                                                                    <th scope="col">Paciente</th>
                                                                                    <th scope="col">Consulta</th>
                                                                                    <th scope="col">Tarifa</th>
                                                                                    <th scope="col">Descuento</th>
                                                                                    <th scope="col">Adicionales</th>
                                                                                    <th scope="col">Transferencia Bancaria</th>
                                                                                    <th scope="col">Comisión banco</th>
                                                                                    <th scope="col">Retención clínica</th>
                                                                                    <th scope="col">Total cobrado</th>
                                                                                    <th scope="col">Opciones</th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="cobros_body"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3 mx-1">
                                                                        (C) Consultas: 
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="consultas">0</label>
                                                                    </div>
                                                                    <div class="col-sm-4 mx-1">
                                                                        (NC) Número de Citas: 
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="n_citas">0</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3 mx-1">
                                                                        (D) Descuentos: 
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="descuentos">0</label>
                                                                    </div>
                                                                    <div class="col-sm-4 mx-1">
                                                                        (TC) Total Consultas (C-D): 
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="t_consultas">0</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3 mx-1">
                                                                        (A) Adicionales: 
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="adicionales">0</label>
                                                                    </div>
                                                                    <div class="col-sm-4 mx-1">
                                                                        <label id="lbl_c_consulta">
                                                                            (CC) Comisión Consulta:
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="c_consulta">0</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3 mx-1">
                                                                        (CB) Comisión Banco:
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="lbl_comision_ban">0</label>
                                                                    </div>
                                                                    <div class="col-sm-4 mx-1">
                                                                        <label id="lbl_c_adicional">
                                                                            (CA) Comisión Adicional:
                                                                        </label>
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="c_adicional">0</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3 mx-1">
                                                                         (RC) Retención Clínica:
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="lbl_retencion_cli">0</label>
                                                                    </div>
                                                                    <div class="col-sm-4 mx-1">
                                                                        Total (TC-CC-CA+A-CB-RC-TB): 
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="total">0</label>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-sm-3 mx-1">
                                                                         (TB) Trancferencias Bancarias:
                                                                    </div>
                                                                    <div class="col-sm-2 mx-1">
                                                                        <label id="transferencias_b">0</label>
                                                                    </div>
                                                                    <div class="col-sm-4 mx-1"></div>
                                                                    <div class="col-sm-2 mx-1"></div>
                                                                </div>
                                                                <div class="col-sm-12 div-btn-gcp">
                                                                    <button class="btn btn-primary text-uppercase float-right my-2" id="gen_reporte"><span class="fa fa-file-text-o"></span> Generar Comprobante de Pago</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!--Modal: Tabla de Añadir formas de pago-->
                                    <div class="card-block" id="div_f_pago">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Añadir forma de pago</h6>
                                        <div class="card-block">
                                            <p align="center" style="font-size: 25px;color: #22445d;" id="total_cobrar"></p>     
                                            <br>
                                            <div class="col-12 table-responsive">
                                                <table class=" table table-striped" id="fp_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Forma de pago</th>
                                                            <th scope="col">Descripción</th>
                                                            <th scope="col">Cantidad ($)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="fp_body"></tbody>
                                                </table>
                                                <a class="btn btn-success" data-toggle="modal" style="color: #fff" data-target="#modalFp"><span class="fa fa-plus"></span> Añadir</a>
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

                <!--Modal: ADICIONALES-->
                <div class="modal fade" id="modalAdicionales" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <!--Content-->
                        <div class="modal-content text-center">
                            <!--Header-->
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Información - Adicionales</p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>


                            <!--Body-->
                            <div class="modal-body">

                                <i class="" style="color: rgb(57, 160, 57)" id="modal_a_icon"></i>

                                <p id="modal_a_text"></p>

                            </div>

                            <!--Footer-->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <!--Modal: ADICIONALES-->

                <!--Modal: Confirmación-->
                <div class="modal fade" id="modalConfirmacion" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-notify modal-info modal-dialog-centered" role="document">
                        <!--Content-->
                        <div class="modal-content text-center">
                            <!--Header-->
                            <div class="modal-header d-flex justify-content-center">
                                <p class="heading text-uppercas">Confirmación - Generación de Reporte</p>
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
                                <button id="btn_gen_rep" type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                        <!--/.Content-->
                    </div>
                </div>
                <!--Modal: modalPush-->
                
                <!--Modal: Modal de forma de pago-->
                <div class="modal fade" id="modalFp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir forma de pago</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">
                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Forma de pago:</p>
                                    <select class="custom-select" id="select_fpago" required></select>
                                </div>
                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12">Descripción:</p>
                                    <textarea id="descripcion" class="form-control validate" size="255" maxlength="255" rows="4" required></textarea>
                                </div>

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Cantidad:</p>
                                    <input placeholder="Dólares ($)" step="any" type="number" class="text-muted f-w-400 form-control" id="costo" required>
                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_fpago" data-dismiss="modal">Añadir</button>
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

    <script src="js/cobros_realizados.js"></script>

</body>

</html>