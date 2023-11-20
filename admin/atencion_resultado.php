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

    <title>Atención Resultados</title>


    <!-- Template CSS -->
    <link rel="stylesheet" href="../assets/css/style-starter.css">
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/atencion_resultado.css">


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
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit">Antecedentes personales</h6>
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class=" table table-striped" id="antecedentes_table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Médico</th>
                                                            <th scope="col">Fecha</th>
                                                            <th scope="col">Descripción</th>
                                                            <th scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ante_body"></tbody>
                                                </table>
                                                <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalAntecedente"><span class="fa fa-plus"></span> Añadir</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit">Antecedentes familiares</h6>
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
                                                <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalAntecedenteF"><span class="fa fa-plus"></span> Añadir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>motivo de consulta</h6>
                                        <label class="text-muted f-w-400">Ingrese máximo 2000 caracteres</label>
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <textarea class="form-control" id="motivo_consulta" size="2000" maxlength="2000" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>enfermedad o problema actual</h6>
                                        <label class="text-muted f-w-400">Ingrese máximo 2000 caracteres</label>
                                        <div class="row">
                                            <div class="col-sm-12 my-2"> 
                                                <textarea class="form-control" id="problema_actual" size="2000" maxlength="2000" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">revisión actual de órganos y sistemas</h6>
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
                                                <button id='cp_organos' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_organos' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
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
                                                <button id='cp_respiratorio' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_respiratorio' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
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
                                                <button id='cp_cardiov' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_cardiov' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
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
                                                <button id='cp_digestivo' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_digestivo' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input type="text" class="form-control" id="digestivo_i" size="255" maxlength="255" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 my-2">
                                            <p class="f-w-400" style="font-size: 20px;">Genital</p>
                                            </div>
                                            <div class="col-sm-2 my-2">
                                                <button id='cp_genital' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_genital' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input type="text" class="form-control" id="genital_i" size="255" maxlength="255" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 my-2">
                                            <p class="f-w-400" style="font-size: 20px;">Urinario</p>
                                            </div>
                                            <div class="col-sm-2 my-2">
                                                <button id='cp_urinario' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_urinario' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
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
                                                <button id='cp_musculoe' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_musculoe' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
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
                                                <button id='cp_endocrino' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_endocrino' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
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
                                                <button id='cp_hemol' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_hemol' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
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
                                                <button id='cp_nervioso' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_nervioso' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input type="text" class="form-control" id="nervioso_i" size="255" maxlength="255" disabled>
                                            </div>
                                        </div>     
                                    </div>

                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase mb-4"><span style="color: red;">*</span>signos vitales y antropometría</h6>
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
                                                            <th scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="signosva_body"></tbody>
                                                </table>
                                                <a class="btn btn-secondary" id="btn_sva" data-toggle="modal" style="color: #fff" data-target="#modalSignosVA"><span class="fa fa-plus"></span> Añadir</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Examen físico regional</h6>
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
                                            <p class="f-w-400" style="font-size: 20px;">Cabeza</p>
                                            </div>
                                            <div class="col-sm-2 my-2">
                                                <button id='cp_cabeza' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_cabeza' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input type="text" class="form-control" id="cabeza_i" size="255" maxlength="255" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 my-2">
                                            <p class="f-w-400" style="font-size: 20px;">Cuello</p>
                                            </div>
                                            <div class="col-sm-2 my-2">
                                                <button id='cp_cuello' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_cuello' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input type="text" class="form-control" id="cuello_i" size="255" maxlength="255" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 my-2">
                                            <p class="f-w-400" style="font-size: 20px;">Tórax</p>
                                            </div>
                                            <div class="col-sm-2 my-2">
                                                <button id='cp_torax' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_torax' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
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
                                                <button id='cp_abdomen' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_abdomen' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input type="text" class="form-control" id="abdomen_i" size="255" maxlength="255" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 my-2">
                                            <p class="f-w-400" style="font-size: 20px;">Pelvis</p>
                                            </div>
                                            <div class="col-sm-2 my-2">
                                                <button id='cp_pelvis' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_pelvis' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input type="text" class="form-control" id="pelvis_i" size="255" maxlength="255" disabled>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 my-2">
                                            <p class="f-w-400" style="font-size: 20px;">Extremidades</p>
                                            </div>
                                            <div class="col-sm-2 my-2">
                                                <button id='cp_extremidades' style="color: #fff" class="btn btn-primary btn-sm">CP</button><button id='sp_extremidades' style="color: #fff" class="btn btn-secondary btn-sm">SP</button>
                                            </div>
                                            <div class="col-sm-6 my-2">
                                                <input type="text" class="form-control" id="extremidades_i" size="255" maxlength="255" disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block" id="div_evolucion">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Evolución</h6>
                                        <label class="text-muted f-w-400">Ingrese máximo 10000 caracteres</label>
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <textarea class="form-control" id="evolucion" size="10000" maxlength="10000" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Tipo de Contingencia</h6>
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
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase"><span style="color: red;">*</span>diagnóstico</h6>
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
                                                <button class="btn btn-secondary" data-toggle="modal" id="add_diag_modal" style="color: #fff"><span class="fa fa-plus"></span> Añadir</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block" id="div_semana_embarazo">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Semana de embarazo</h6>
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <input class="form-control" id="semana_embarazo" type="number">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">Planes de tratamiento</h6>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <p class="f-w-400 mb-3" style="font-size: 18px;">Antecedentes de Alergias</p>
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
                                                            <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalAlergia"><span class="fa fa-plus"></span> Añadir</a>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-12 table-responsive">
                                            <p class="f-w-400 mb-3" style="font-size: 18px;">Receta Médica</p>
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
                                                <button class="btn btn-secondary" data-toggle="modal" id="add_medicamento" style="color: #fff"><span class="fa fa-plus"></span> Añadir</button>
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <p class="f-w-400 mb-3 mt-4" style="font-size: 18px;">Signos de Alarma</p>
                                                <label class="text-muted f-w-400">Ingrese máximo 1000 caracteres</label>
                                                <textarea class="form-control" id="signos_alarma" size="1000" maxlength="1000" rows="3"></textarea>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="f-w-400 mb-3 mt-4" style="font-size: 18px;">Recomendaciones NO Farmacológicas</p>
                                                <label class="text-muted f-w-400">Ingrese máximo 1000 caracteres</label>
                                                <textarea class="form-control" id="rec_no_far" size="1000" maxlength="1000" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
                                        <h6 class="m-b-20 p-b-5 b-b-default f-w-600 tit text-uppercase">días de reposo</h6>
                                        <div class="row">
                                            <div class="col-sm-12 my-2">
                                                <input class="form-control" id="dias_reposo" type="number">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-block">
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
                                            <div class="col-sm-12 my-2">
                                                <h6 class="m-b-20 p-b-5 b-b-default tit">Adicionales</h6>
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
                                                <a class="btn btn-secondary" data-toggle="modal" style="color: #fff" data-target="#modalAdicionales"><span class="fa fa-plus"></span> Añadir</a>
                                            </div>
                                                
                                        </div>
                                    </div>
                                    <div class="col-sm-12 my-2 justify-content-right">
                                        <button class="btn btn-primary rounded float-right my-4" id="btn_guardar"><span class="fa fa-floppy-o"></span> Guardar</button>
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
                <div class="modal fade" id="modalSignosVA" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 700px!important;" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir signos vitales y antropometría</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">
                                <div class="row  my-2">
                                    <div class="col-sm-6">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Temperatura °C:</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="temperatura" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
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
                                </div>
                                <div class="row  my-2">
                                    <div class="col-sm-6">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Pulso (min):</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="pulso" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Frecuencia respiratoria:</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="frecuencia_r" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  my-2">
                                    <div class="col-sm-6">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Frecuencia cardiaca:</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="frecuencia_c" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Saturación de oxígeno:</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="sat_o" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row  my-2">
                                    <div class="col-sm-6">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Peso (kg):</p>
                                            <input step="any" type="number" class="text-muted f-w-400 form-control" id="peso" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group my-3">
                                            <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Talla (cm):</p>
                                            <input type="text" class="text-muted f-w-400 form-control" id="talla" onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="3" required>
                                        </div>
                                    </div>
                                </div>                             
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_signosva" data-dismiss="modal">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>
 
                <!--Modal: Diagnostico-->
                <div class="modal fade" id="modalDiagnostico" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir diagnóstico</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="input-group mb-4">
                                    <input class="text-muted f-w-400 form-control" id="busc_cie" placeholder="Buscar CIE por diagnostico..." maxlength="255"></input>
                                </div>
                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Diagnostico:</p>
                                    <select class="custom-select" id="select_diagnos" required></select>
                                </div>
                                <div class="input-group my-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>CIE:</p>
                                    <input class="text-muted f-w-400 form-control" id="cie" maxlength="255" disabled></input>
                                </div>
                                <div class="input-group mb-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Tipo de diagnostico:</p>
                                    <select class="custom-select" id="select_t_diagnostico" required>
                                        <option selected="selected" value="0">Presuntivo</option>
                                        <option value="1">Definitivo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center">
                                <button class="btn btn-primary" id="add_diag" data-dismiss="modal">Añadir</button>
                            </div>
                        </div>
                    </div>
                </div>


                <!--Modal: Antecedentes-->
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
                            <div class="modal-header text-center">
                                <h4 class="modal-title w-100 font-weight-bold">Añadir plan de tratamiento</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body mx-3">

                                <div class="input-group my-3">
                                    <p class="f-w-600 text-uppercase col-sm-12"><span style="color: red;">*</span>Datos del Medicamento:</p>
                                    <p class="f-w-600 col-sm-12">(dci, concentración y forma farmacéutica)</p>
                                    <input type="text" class="text-muted f-w-400 form-control" id="d_medicamento" maxlength="255" ></input>
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
                                            </tr>
                                        </thead>
                                        <tbody id="hsva_body"></tbody>
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

    <script src="js/atencion_resultado.js"></script>

</body>

</html>