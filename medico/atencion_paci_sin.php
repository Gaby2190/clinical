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

    <title>Atención al Paciente</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/medi.css">
    <link rel="stylesheet" href="css/atencion_paci.css">


    <!-- //google fonts -->
    <link href="//fonts.googleapis.com/css?family=Nunito:300,400,600,700,800,900&display=swap" rel="stylesheet">
</head>

<body class="sidebar-menu-collapsed">
    <section>
       <?php include_once("nav.php") ?>
        <!-- main content start -->
        <div class="main-content">
        <?php
        $id_paciente=$_GET['id_paciente'];
        $id_cita=$_GET['id_cita'];
        ?>
            <!-- content -->
            <div class="container-fluid content-top-gap">
                <div class="d-flex justify-content-center">
                    <div class="col-xl-12 col-md-12">
                        <div class="card user-card-full">
                            <div class="row m-l-0 m-r-0">
                                <div class="col-sm-12"> 
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">DATOS del paciente</h6>
                                        <div class="row">
                                            <input type="text" id="id_paciente" value="<?php echo($id_paciente);?>" required hidden>
                                            <input type="text" id="id_cita" value="<?php echo($id_cita);?>" required hidden>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Primer nombre:</p>
                                                <label class="text-muted f-w-400" id="nombres_paci1"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Segundo nombre:</p>
                                                <label class="text-muted f-w-400" id="nombres_paci2"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Primer apellido:</p>
                                                <label class="text-muted f-w-400" id="apellidos_paci1"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Segundo apellido:</p>
                                                <label class="text-muted f-w-400" id="apellidos_paci2"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Cédula:</p>
                                                <label class="text-muted f-w-400" id="cedula_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Fecha de nacimiento:</p>
                                                <label class="text-muted f-w-400" id="fechan_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Edad:</p>
                                                <label class="text-muted f-w-400" id="edad_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Género:</p>
                                                <label class="text-muted f-w-400" id="genero_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Nacionalidad:</p>
                                                <label class="text-muted f-w-400" id="nacionalidad_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2"> 
                                                <p class="m-b-10 f-w-600">Teléfono:</p>
                                                <label class="text-muted f-w-400" id="telefono_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Celular:</p>
                                                <label class="text-muted f-w-400" id="celular_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Correo:</p>
                                                <label class="text-muted f-w-400" id="correo_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Dirección:</p>
                                                <label class="text-muted f-w-400" id="direccion_paci"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Tipo de sangre:</p>
                                                <label class="text-muted f-w-400" id="sangre_paci"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <h6 class="m-b-20 m-t-40 p-b-5 b-b-default f-w-600 tit">Referencia personal del paciente</h6>
                                        <div class="row">
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Nombres:</p>
                                                <label class="text-muted f-w-400" id="contacto_nom"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Apellidos:</p>
                                                <label class="text-muted f-w-400" id="contacto_ape"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Celular:</p>
                                                <label class="text-muted f-w-400" id="contacto_num"></label>
                                            </div>
                                            <div class="col-sm-3 my-2">
                                                <p class="m-b-10 f-w-600">Parentesco:</p>
                                                <label class="text-muted f-w-400" id="contacto_par"></label>
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="card-block bg-light">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit">Antecedentes personales</h6>
                                        <label style="font-size:15px" class="m-b-20">(Campo opcional)</label>
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class=" table table-striped" id="antecedentes_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Médico</th>
                                                            <th scope="col">Fecha</th>
                                                            <th scope="col">Enfermedad</th>
                                                            <th scope="col">Descripción</th>
                                                            <th scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ante_body"></tbody>
                                                </table>
                                                <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalAntecedente"><span class="fa fa-plus"></span> Añadir antecedente personal</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit">Antecedentes familiares</h6>
                                        <label style="font-size:15px" class="m-b-20">(Campo opcional)</label>
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class=" table table-striped" id="antecedentesf_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Enfermedad</th>
                                                            <th scope="col">Parentesco</th>
                                                            <th scope="col">Descripción</th>
                                                            <th scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="antef_body"></tbody>
                                                </table>
                                                <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalAntecedenteF"><span class="fa fa-plus"></span> Añadir antecedente familiar</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block bg-light">
                                       
                                            <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>motivo de consulta</h6>
                                            <label style="font-size:15px" class="m-b-20">(CAMPO OBLIGATORIO, Se requiere el motivo por el cual el paciente acude a la cita)</label>
                                            <br>
                                            <label class="text-muted f-w-400">Ingrese máximo 2000 caracteres</label>

                                        <div class="row">
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="motivo_consulta" size="2000" maxlength="2000" rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-2 jutify-content-center">
                                                <button class="btn btn-secondary rounded float-right my-4 mx-1" id="btn_hmc"><span class="fa fa-file-text-o"></span> Historial</button>
                                            </div>
                                        </div>
                                       
                                    </div> 

                                    <div class="card-block">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>enfermedad o problema actual</h6>
                                        <label style="font-size:15px" class="m-b-20">(CAMPO OBLIGATORIO, Se refiere al estado en el que el Médico encuentra al paciente)</label>
                                        <br>
                                        <label class="text-muted f-w-400">Ingrese máximo 2000 caracteres</label>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="problema_actual" size="2000" maxlength="2000" rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-2 jutify-content-center">
                                                <button class="btn btn-secondary rounded float-right my-4 mx-1" id="btn_hpa"><span class="fa fa-file-text-o"></span> Historial</button>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!------- Bloque de REVISON ACTUAL DE ORGANOS -->
                                    <div class="card-block bg-light" id="revision_de_organos">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase">revisión actual de órganos y sistemas 
                                            <a href="#" id="v_rev_org" title="Mostar Bloque"> <i class="fa fa-chevron-down" ></i></a>
                                            <a href="#" id="o_rev_org" title="Ocultar Bloque"><i class="fa fa-chevron-up" ></i></a>
                                        </h6>
                                        <label style="font-size:15px" class="m-b-20">(CAMPO OPCIONAL) Despligue en caso de necesitar el bloque</label>
                                        <div id="ros_normal">
                                            <div class="row">
                                                <div class="col-sm-6 my-2"></div>
                                                <div class="col-sm-3 my-2">
                                                    <p class="f-w-400" style="font-size: 15px;">CP = Con evidencia de patología</p>
                                                </div>
                                                <div class="col-sm-3 my-2">
                                                    <p class="f-w-400" style="font-size: 15px;">SP = Sin evidencia de patología</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Órganos de los sentidos</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_organos' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_organos' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="organos_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Respiratorio</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_respiratorio' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_respiratorio' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="respiratorio_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Cardio vascular</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_cardiov' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_cardiov' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="cardiov_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Digestivo</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_digestivo' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_digestivo' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="digestivo_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Genito - Urinario</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_genital' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_genital' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="genital_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Piel y Anexos</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_urinario' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_urinario' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="urinario_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Músculo esquelético</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_musculoe' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_musculoe' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="musculoe_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Endocrino</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_endocrino' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_endocrino' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="endocrino_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Hemo linfático</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_hemol' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_hemol' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="hemol_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Nervioso</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_nervioso' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_nervioso' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="nervioso_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block" id="signos_vitales">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>signos vitales y antropometría</h6>
                                        <label style="font-size:15px" class="m-b-20">(CAMPO OBLIGATORIO)</label>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-6 mb-4">
                                                <p class="f-w-400 mb-1" style="font-size: 20px;">Indice de Masa Corporal (IMC)</p>
                                                <div id="divIMC">
                                                    <span class="fa fa-square" style="color:#3a859a; font-size:15px;">
                                                    </span>
                                                    <span id="imc_txt">Bajo peso</span>
                                                </div>
                                                <div id="divIMC">
                                                    <span class="fa fa-square" style="color:#2ec6b7; font-size:15px;">
                                                    </span>
                                                    <span id="imc_txt">Normal</span>
                                                </div>
                                                <div id="divIMC">
                                                    <span class="fa fa-square" style="color:#f39f95; font-size:15px;">
                                                    </span>
                                                    <span id="imc_txt">Sobrepeso</span>
                                                </div>
                                                <div id="divIMC">
                                                    <span class="fa fa-square" style="color:#d34b4d; font-size:15px;">
                                                    </span>
                                                    <span id="imc_txt">Obesidad</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 my-2 jutify-content-center">
                                                <button class="btn btn-secondary rounded float-right my-4 mx-1" id="btn_hsva"><span class="fa fa-file-text-o"></span> Historial</button>
                                            </div> 
                                        </div>
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class=" table table-striped" id="signosva_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Fecha</th>
                                                            <th scope="col">Temp.</th>
                                                            <th scope="col">Presión arterial</th>
                                                            <th scope="col">Pulso </th>
                                                            <th scope="col">Frec. Resp.</th> 
                                                            <th scope="col">Frec. Card.</th>
                                                            <th scope="col">Sat. O2</th>
                                                            <th scope="col">Peso</th>
                                                            <th scope="col">Talla</th>
                                                            <th scope="col">P.Cefal</th>
                                                            <th scope="col">IMC</th>
                                                            <th scope="col">P. Abdomi.</th>
                                                            <th scope="col">Hemo. Cap</th>
                                                            <th scope="col">Gulc. Cap</th>
                                                            <th scope="col">Pulsio ximetria</th>
                                                            <th scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="signosva_body"></tbody>
                                                </table>
                                                <a class="btn btn-secondary" id="btn_sva" data-toggle="modal" style="color: #fff" data-target="#modalSignosVA"><span class="fa fa-plus"></span> Añadir signos vitales y antropometría</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block bg-light" id="examen_fisico">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase">Examen físico regional
                                            <a href="#" id="v_efr" title="Mostar Bloque"> <i class="fa fa-chevron-down" ></i></a>
                                            <a href="#" id="o_efr" title="Ocultar Bloque"><i class="fa fa-chevron-up" ></i></a>
                                        </h6>
                                        <label style="font-size:15px" class="m-b-20">(CAMPO OPCIONAL) Despligue en caso de necesitar el bloque</label>
                                        <div id="efr_normal">
                                            <div class="row">
                                                <div class="col-sm-6 my-2"></div>
                                                <div class="col-sm-3 my-2">
                                                    <p class="f-w-400" style="font-size: 15px;">CP = Con evidencia de patología</p>
                                                </div>
                                                <div class="col-sm-3 my-2">
                                                    <p class="f-w-400" style="font-size: 15px;">SP = Sin evidencia de patología</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Piel - Faneras</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_piel' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_piel' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="piel" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Cabeza</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_cabeza' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_cabeza' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="cabeza_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Ojos</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_ojos' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_ojos' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="ojos" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Oídos</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_oidos' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_oidos' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="oidos" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Nariz</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_nariz' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_nariz' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="nariz" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Boca</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_boca' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_boca' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="boca" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Orofaringe</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_orofaringe' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_orofaringe' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="orofaringe" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Cuello</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_cuello' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_cuello' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="cuello_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Axilas - Mamas</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_axilas' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_axilas' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="axilas" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Tórax</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_torax' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_torax' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="torax_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Abdomen</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_abdomen' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_abdomen' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="abdomen_i" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Columna Vertebral</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_columna' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_columna' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="columna" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Ingle - Periné</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_ingle' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_ingle' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="ingle" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Miembros Superiores</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_msup' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_msup' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="msup" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Miembros Inferiores</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_minf' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_minf' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="minf" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <!-------------------------- SISTEMICO ---------------------->
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Organos de los sentidos</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_sorganos' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_sorganos' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="sorganos" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Respiratorio</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_srespiratorio' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_srespiratorio' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="srespiratorio" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Cardio - Vascular</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_scardio' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_scardio' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="scardio" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Digestivo</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_sdigestivo' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_sdigestivo' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="sdigestivo" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Genital</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_sgenital' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_sgenital' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="sgenital" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Urinario</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_surinario' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_surinario' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="surinario" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Músculo - Esquelético</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_smusculo' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_smusculo' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="smusculo" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Endócrino</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_sendocrino' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_sendocrino' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="sendocrino" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Hemo - Linfático</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_shemo' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_shemo' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="shemo" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4 my-2">
                                                <p class="f-w-400" style="font-size: 20px;">Neurológico</p>
                                                </div>
                                                <div class="col-sm-2 my-2">
                                                    <button id='cp_sneurologico' style="color: #fff" class="btn btn-primary btn-sm">CP</button> / <button id='sp_sneurologico' style="color: #fff" class="btn btn-primary btn-sm" disabled>SP</button>
                                                </div>
                                                <div class="col-sm-6 my-2">
                                                    <input type="text" class="form-control" id="sneurologico" size="255" maxlength="255" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                   

                                    <div class="card-block" id="div_evolucion">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>Evolución</h6>
                                        <label style="font-size:15px" class="m-b-20">(CAMPO OBLIGATORIO)</label>
                                        <br>
                                        <label class="text-muted f-w-400">Ingrese máximo 10000 caracteres</label>
                                        <div class="row">
                                            <div class="col-sm-10">
                                                <textarea class="form-control" id="evolucion" size="10000" maxlength="10000" rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-2 jutify-content-center">
                                                <button class="btn btn-secondary rounded float-right my-4 mx-1" id="btn_hevo"><span class="fa fa-file-text-o"></span> Historial</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block bg-light">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>Tipo de Contingencia</h6>
                                        <label style="font-size:15px" class="m-b-20">(CAMPO OBLIGATORIO)</label>
                                        <br>
                                        <div class="row">
                                        <div class="col-sm-12">
                                            <select class="custom-select" id="select_contingencia" required>
                                                <option selected="selected" value="0">Enfermedad General</option>
                                                <option value="1">Enfermedad Catastrófica</option>
                                            </select>
                                        </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>diagnóstico</h6>
                                        <label style="font-size:15px" class="m-b-20">(CAMPO OBLIGATORIO)</label>
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class=" table table-striped" id="diagnostico_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Médico</th>
                                                            <th scope="col">Fecha</th>    
                                                            <th scope="col">Diagnóstico</th>
                                                            <th scope="col">CIE</th>
                                                            <th scope="col">Presuntivo</th></th>
                                                            <th scope="col">Definitivo</th>
                                                            <th scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="diagnostico_body"></tbody>
                                                </table>
                                                <button class="btn btn-secondary" data-toggle="modal" id="add_diag_modal" style="color: #fff"><span class="fa fa-plus"></span> Añadir diagnóstico</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block" id="div_semana_embarazo">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase">Semana de embarazo</h6>
                                        <label style="font-size:15px" class="m-b-20">(Campo opcional) Utilice solo si el caso lo amerita</label>
                                        <br>
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <input class="form-control" id="semana_embarazo" type="number" min="0">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block bg-light">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Planes de tratamiento</h6>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p class="f-w-400" style="font-size: 18px; color: red;"><strong>Antecedentes de Alergias</strong></p>
                                                <label style="font-size:15px" class="m-b-20">(Campo opcional) Registre solo si el caso lo amerita.</label>
                                                    <div class="row">
                                                        <div class="col-12 table-responsive">
                                                            <table class=" table table-striped" id="alergias_table">
                                                                <thead>
                                                                    <tr>
                                                                        <th scope="col">Médico</th>
                                                                        <th scope="col">Fecha</th>
                                                                        <th scope="col">Alergia</th>
                                                                        <th scope="col">Opciones</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="aler_body"></tbody> 
                                                            </table>
                                                            <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalAlergia"><span class="fa fa-plus"></span> Añadir antecedente de alergia</a>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="row mt-4">
                                            <div class="col-12 table-responsive">
                                            <h6 class="p-b-5 f-w-400 tit text-uppercase text-center">Receta Médica</h6>
                                                <div class="row">
                                                    <div class="col-sm-6 my-2 jutify-content-center" style="margin-top: 0!important; margin-bottom: 0!important">
                                                        <label style="font-size:15px; margin-bottom: 0!important" class="m-b-20">(Campo opcional) Utilice en caso de ser necesario.</label>
                                                    </div> 
                                                    <div class="col-sm-6 my-2 jutify-content-center" style="margin-top: 0!important; margin-bottom: 0!important">
                                                        <button class="btn btn-secondary rounded float-right my-4 mx-1" id="btn_hreceta" style="margin-top: 0!important; margin-bottom: 0.5em!important"><span class="fa fa-file-text-o"></span> Historial</button>
                                                    </div> 
                                                </div>
                                                <table class=" table table-striped" id="medicamento_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Datos del medicamento</th>
                                                            <th scope="col">Vía de administración</th>
                                                            <th scope="col">Cantidad</th></th>
                                                            <th scope="col">Indicaciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="medicamento_body"></tbody>
                                                </table>
                                                <button class="btn btn-secondary" data-toggle="modal" id="add_medicamento" style="color: #fff"><span class="fa fa-plus"></span> Añadir medicamento a receta</button>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <br>
                                                <h4 class="p-b-5 f-w-400 tit text-uppercase text-center">Signos de Alarma</h4>
                                                <p class="f-w-400 mb-3 mt-4" style="font-size: 16px;"> (campo opcional) Ingrese solo en caso de ser necesario</p>
                                                <label class="text-muted f-w-400">Ingrese máximo 700 caracteres</label>
                                                <textarea class="form-control" id="signos_alarma" size="700" maxlength="700" rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-6">
                                            <br>
                                                <h5 class="p-b-5 f-w-400 tit text-uppercase text-center">Recomendaciones NO Farmacológicas</h5>
                                                <p class="f-w-400 mb-3 mt-4" style="font-size: 16px;">(campo opcional) Ingrese solo en caso de ser necesario</p>
                                                <label class="text-muted f-w-400">Ingrese máximo 700 caracteres</label>
                                                <textarea class="form-control" id="rec_no_far" size="700" maxlength="700" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase">días de reposo</h6>
                                        <label style="font-size:15px" class="m-b-20">(Campo opcional) Dato necesario solo si se emite dias de reposo, utilizado en el certificado médico.</label>
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <input class="form-control" id="dias_reposo" type="number">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block bg-light">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">valores</h6>
                                        <div class="row">
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Tarifa de Consulta:</p>
                                                <label class="text-muted f-w-400" id="tarifa"></label>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <p class="m-b-10 f-w-600">Descuento:</p>
                                                <input placeholder="Dólares ($)" step="any" type="number" class="text-muted f-w-400 form-control" id="descuento" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <h6 class="p-b-5 b-b-default tit">Adicionales</h6>
                                                <label style="font-size:15px">(Campo opcional) Registre tratamientos o procedimientos para cobro de un valor adicional.</label>
                                            </div>

                                           
                                            <div class="col-12 table-responsive">
                                                <table class=" table table-striped" id="adicionales_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Tipo de servicio</th>
                                                            <th scope="col">Descripción</th>
                                                            <th scope="col">Costo ($)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="adicionales_body"></tbody>
                                                </table>
                                                <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalAdicionales"><span class="fa fa-plus"></span> Añadir adicional</a>
                                            </div>
                                                
                                        </div>
                                    </div>
                                    
                                    <div class="card-block bg-light">
                                        <h6 class="p-b-5 b-b-default f-w-600 tit text-uppercase">Detalle para certificado médico</h6>
                                        <label style="font-size:15px" class="m-b-20">(Campo opcional) Ingrese solo si es necesario añadir datos especificos al certificado médico</label>
                                        <br>
                                        <label class="text-muted f-w-400">Ingrese máximo 2000 caracteres</label>
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <textarea class="form-control" id="detalle_certificado" size="2000" maxlength="2000" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 my-2 jutify-content-center">
                                        <button class="btn btn-primary rounded float-right my-4 mx-1" id="btn_guardar"><span class="fa fa-floppy-o"></span> Guardar</button>
                                        <button class="btn btn-secondary rounded float-right my-4 mx-1" id="btn_borrador"><span class="fa fa-file-text-o"></span> Enviar a exámenes</button>
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


                <!--Modal: Antecedentes-->
                <div class="modal fade" id="modalAntecedente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir antecedente personal</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">
                                
                                <div class="input-group my-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Enfermedad:</p>
                                    <select class="custom-select" id="select_enfermedad_p" required></select>
                                </div>

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Descripción:</p>
                                    <textarea class="form-control" class="form-control validate" id="descripcion_ante" rows="7" size="255" maxlength="255"></textarea>                                  
                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_ante" data-dismiss="modal">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: Antecedentes Familiares-->
                <div class="modal fade" id="modalAntecedenteF" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir antecedente familiar</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="input-group my-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Enfermedad:</p>
                                    <select class="custom-select" id="select_enfermedad" required></select>
                                </div>

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Parentesco:</p>
                                    <input type="text" class="text-muted f-w-400 form-control" id="parentesco_antef" size="50" maxlength="50" required>
                                </div>

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12">Descripción:</p>
                                    <textarea id="descripcion_antef" class="form-control validate" size="255" maxlength="255" rows="5" required></textarea>
                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_antef" data-dismiss="modal">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                 <!--Modal: Adicionales-->
                 <div class="modal fade" id="modalAdicionales" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Adicionales</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="input-group my-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Tipo de Servicio:</p>
                                    <select class="custom-select" id="select_servicio" required></select>
                                </div>

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Descripción:</p>
                                    <textarea id="descripcion" class="form-control validate" size="255" maxlength="255" rows="4" required></textarea>
                                </div>

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Costo:</p>
                                    <input placeholder="Dólares ($)" step="any" type="number" class="text-muted f-w-400 form-control" id="costo" required>
                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_adicional" data-dismiss="modal">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: Signos vitales y antropometria-->
                <div class="modal fade bd-example-modal-lg" id="modalSignosVA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 98%!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir signos vitales y antropometría</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">
                                <div class="row  my-2">
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Temperatura °C:</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="temperatura" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Presión arterial:</p>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <input type="text" class="text-muted f-w-400 form-control" id="presion_as" placeholder="P. Sistólica" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="text" class="text-muted f-w-400 form-control" id="presion_ad" placeholder="P. Diastólica" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                                </div>
                                            </div>
                                             
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Pulso (min):</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="pulso" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Frecuencia respiratoria:</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="frecuencia_r" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  my-2">                                   
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Frecuencia cardiaca:</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="frecuencia_c" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Saturación de oxígeno:</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="sat_o" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Peso (kg):</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="peso" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Talla (cm):</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="talla" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  my-2">
                                    
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Perímetro Abdominal (cm):</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="p_abdominal" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Hemoglobina capilar (g/dl)</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="hemo_cap" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Glucosa capilar (mg/dl)</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="gluc_cap" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Pulsioximetria (%)</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="pulsio" required>
                                        </div>
                                    </div>
                                </div>
                                
                                    <div class="col-sm-12">
                                        <h5 class="modal-title w-100">Datos Pediatricos</h5>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Perímetro Cefálico (cm):</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="perimetro" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                </div>                             
                            
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_signosva" data-dismiss="modal">Añadir</button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
 
                <!--Modal: Diagnostico-->
                <div class="modal fade" id="modalDiagnostico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1300px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir diagnóstico</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">
                                <div class="row">
                                    <div class="col col-sm-4">
                                        <div class="input-group mb-12 col-sm-12">
                                            <h5>Opciones de busqueda</h5>
                                        </div>
                                        <div class="input-group mb-12 col-sm-12">
                                            <p class="f-w-600 col-sm-12 mb-12">Filtrar nombre enfermedad:</p>
                                            <input class="text-muted f-w-400 form-control" id="busc_cie" placeholder="Por diagnostico..." maxlength="255"></input>
                                        </div>
                                        <hr>
                                        <div class="input-group mb-4 col-sm-5">
                                            <p class="f-w-600 col-sm-12 mb-2">Filtrar CIE:</p>
                                            <input class="text-muted f-w-400 form-control" id="busc_cie_cod" placeholder="Por código..." maxlength="255"></input>
                                        </div>
                                    </div>
                                    <div class="vr"></div>
                                    <div class="col col-sm-8">
                                        <div class="input-group mb-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Diagnostico:</p>
                                            <p class="f-w-600 col-sm-12">  (La búsqueda entrega hasta 50 coincidencias. Si no encuentra el diagnóstico, por favor, sea más específico en valor entregado para filtrar.)</p>
                                            <select class="custom-select" id="select_diagnos" required></select>
                                        </div>
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>CIE:</p>
                                            <input class="text-muted f-w-400 form-control" id="cie" maxlength="255" disabled></input>
                                        </div>
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12">Diagnóstico Específico:</p>
                                            <input class="text-muted f-w-400 form-control" id="diagnostico_esp" maxlength="2000" disabled="disabled"></input>
                                        </div>
                                        <div class="input-group mb-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Tipo de diagnostico:</p>
                                            <select class="custom-select" id="select_t_diagnostico" required>
                                                <option selected="selected" value="0">Presuntivo</option>
                                                <option value="1">Definitivo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_diag" data-dismiss="modal">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!--Modal: Alergias-->
                <div class="modal fade" id="modalAlergia" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir alergia</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Alergia:</p>
                                    <textarea class="form-control validate" id="descripcion_aler" rows="7" size="500" maxlength="500"></textarea>                                  
                                </div>

                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_aler" data-dismiss="modal">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: Planes de tratamiento-->
                <div class="modal fade" id="modalTratamiento" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <form >
                                <div class="modal-header text-center">
                                    <h4 class="modal-title w-100 font-weight-bold">Añadir plan de tratamiento</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body mx-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="recetaCheck"><p class="f-w-600">El paciente asiste con medicación</p>
                                    </div> 
                                    <hr>
                                    <div class="input-group my-3">
                                        <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Datos del Medicamento:</p>
                                        <p class="f-w-600 col-sm-12">(dci, concentración y forma farmacéutica)</p>
                                        <input type="text" class="text-muted f-w-400 form-control" id="d_medicamento" maxlength="255" autocomplete></input>
                                    </div>
                                    <div class="input-group mb-3">
                                        <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Vía de administración:</p>
                                        <select class="custom-select" id="select_via_a" required>
                                            <option selected="selected" value="0">Vía Oral</option>
                                            <option value="1">Inyectable - Subcutánea</option>
                                            <option value="2">Inyectable - Intramuscular</option>
                                            <option value="3">Inyectable - Intravenosa</option>
                                            <option value="4">Inyectable - Intratecal</option>
                                            <option value="5">Vía Sublingual</option>
                                            <option value="6">Vía Rectal</option>
                                            <option value="7">Vía Vaginal</option>
                                            <option value="8">Vía Ocular</option>
                                            <option value="9">Vía Ótica</option>
                                            <option value="10">Vía Nasal</option>
                                            <option value="11">Vía Inhalatoria</option>
                                            <option value="12">Nebulizaciones</option>
                                            <option value="13">Vía Cutánea</option>
                                            <option value="14">Vía Transdérmica</option>
                                        </select>
                                    </div>
                                    <div class="input-group my-3">
                                        <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Cantidad:</p>
                                        <input type="number" step="any" class="text-muted f-w-400 form-control" id="c_medicamento"></input>
                                    </div>
                                    <div class="input-group my-3">
                                        <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Indicaciones:</p>
                                        <textarea id="indicaciones" class="form-control validate" size="1000" maxlength="1000" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center">
                                    <button class="btn btn-primary" id="add_pt" data-dismiss="modal">Añadir</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!--Modal: Historial Motivo Consulta-->
                <div class="modal fade" id="modalhpa" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1300px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Historial - Problema Actual</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                            <div class="col-12 table-responsive">
                                    <table class=" table table-striped" id="hpa_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Descripci&oacute;n</th>
                                            </tr>
                                        </thead>
                                        <tbody id="hpa_body"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            <!--Modal: Historial Motivo Consulta-->
            <div class="modal fade" id="modalhevo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1300px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Historial - Evoluci&oacute;n</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                            <div class="col-12 table-responsive">
                                    <table class=" table table-striped" id="hevo_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Descripci&oacute;n</th>
                                            </tr>
                                        </thead>
                                        <tbody id="hevo_body"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: Historial Motivo Consulta-->
                 <div class="modal fade" id="modalhmc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1300px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Historial - Motivo Consulta</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                            <div class="col-12 table-responsive">
                                    <table class=" table table-striped" id="hmc_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Descripci&oacute;n</th>
                                            </tr>
                                        </thead>
                                        <tbody id="hmc_body"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: Historial SVA-->
                <div class="modal fade" id="modalSva" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1300px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Historial - Signos Vitales y Antropometría</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                            <div class="col-12 table-responsive">
                                    <table class=" table table-striped" id="hsva_table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Fecha de medición</th>
                                                <th scope="col">Temp. (°C)</th>
                                                <th scope="col">Presión arterial</th>
                                                <th scope="col">Pulso (min)</th>
                                                <th scope="col">Frec. Respiratoria</th> 
                                                <th scope="col">Frec. Cardiaca</th>
                                                <th scope="col">Sat. O2</th>
                                                <th scope="col">Peso (kg)</th>
                                                <th scope="col">Talla (cm)</th>
                                                <th scope="col">IMC</th>
                                                <th scope="col">P. Abdomi.</th>
                                                <th scope="col">Hemo. Cap</th>
                                                <th scope="col">Gulc. Cap</th>
                                                <th scope="col">Pulsio ximetria</th>
                                            </tr>
                                        </thead>
                                        <tbody id="hsva_body"></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: Historial Recetas-->
                <div class="modal fade" id="modalHRecetas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1200px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Historial - Recetas</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="table-responsive">
                                    <table class="table" id="tabla_h_rece">
                                        <thead>
                                            <tr>
                                                <th scope="col" hidden>ID</th>
                                                <th scope="col" style="width: 13%!important">Fecha</th>
                                                <th scope="col">Datos del medicamento</th>
                                                <th scope="col">Vía de administración</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Indicaciones</th>
                                                <th scope="col">Añadir</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_h_rece"> </tbody>
                                    </table>
                                    <div class="col-md-12 text-center">
                                        <ul class="pagination pager" id="myPager"></ul>
                                    </div>
                                </div>
                                <div class="jutify-content-center">
                                    <button class="btn btn-primary btn-sm float-right" id="btn_sig_hreceta">Siguiente >></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--Modal: Historial Recetas PAG. 2-->
                <div class="modal fade" id="modalHRecetas-items" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 1200px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Recetas</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="table-responsive">
                                    <table class="table" id="tabla_h_rece-items">
                                        <thead>
                                            <tr>
                                                <th scope="col" hidden>ID</th>
                                                <th scope="col">Datos del medicamento</th>
                                                <th scope="col">Vía de administración</th>
                                                <th scope="col">Cantidad</th>
                                                <th scope="col">Indicaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_h_rece-items"> </tbody>
                                    </table>
                                    <div class="col-md-12 text-center">
                                        <ul class="pagination pager" id="myPager"></ul>
                                    </div>
                                </div>
                                <div class="jutify-content-center">
                                    <button class="btn btn-primary btn-sm float-right" id="btn_add_hreceta">Añadir</button>
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
    <script src="js/medi.js"></script>

    <script src="js/atencion_paci_sin.js"></script>
    <script src="../lib/gen-pass.js"></script>

</body>

</html>