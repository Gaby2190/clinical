<?php
require('../FPDF/fpdf.php');
include('../../dbconnection.php');
date_default_timezone_set('America/Guayaquil'); 
$id_caso = $_GET['id_caso'];

class PDF extends FPDF
{
  function Header()
  {
    //$this->Image('../../assets/images/no_valido.png',60,140,100);
  }
}

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$query_1 = "SELECT ci.id_caso, ca.fecha_registro, ca.fecha_alta, ca.c_alta, ca.t_tratamiento, ca.proc_cq, esp.nombre as especialidad, me.nautorizacion_medi, pa.*, ge.nombre as genero, na.nombre as nacionalidad, sa.nombre as sangre
            FROM cita as ci
            INNER JOIN caso as ca
                ON ci.id_caso = ca.id_caso
            INNER JOIN especialidad as esp
                ON ca.id_especialidad = esp.id
            INNER JOIN paciente as pa
                ON ca.id_paciente = pa.id_paciente
            INNER JOIN medico as me
                ON ca.id_medico = me.id_medico
            INNER JOIN genero as ge
                ON pa.gen_id = ge.id
            INNER JOIN nacionalidad as na
                ON pa.nac_id = na.id
            INNER JOIN sangre as sa
                ON pa.san_id = sa.id
            WHERE ca.id_caso='$id_caso'";

$result_1 = mysqli_query($conn, $query_1);
if(!$result_1) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result_1)) {
    $id_caso = $row['id_caso'];
    $fecha_registro = $row['fecha_registro'];
    $fecha_alta = $row['fecha_alta'];
    $c_alta = $row['c_alta'];
    $t_tratamiento = $row['t_tratamiento'];
    $proc_cq = $row['proc_cq'];
    $especialidad = $row['especialidad'];
    $nautorizacion_medi = $row['nautorizacion_medi'];
    $id_paciente = $row['id_paciente'];
    $cedula_paci = $row['cedula_paci'];
    $nombres_paci1 = $row['nombres_paci1'];
    $apellidos_paci1 = $row['apellidos_paci1'];
    $nombres_paci2 = $row['nombres_paci2'];
    $apellidos_paci2 = $row['apellidos_paci2'];
    $fechan_paci = $row['fechan_paci'];
    $telefono_paci = $row['telefono_paci'];
    $celular_paci = $row['celular_paci'];
    $correo_paci = $row['correo_paci'];
    $direccion_paci = $row['direccion_paci'];
    $barrio_paci = $row['barrio_paci'];
    $parroquia_paci = $row['parroquia_paci'];
    $canton_paci = $row['canton_paci'];
    $provincia_paci = $row['provincia_paci'];
    $zona_paci = $row['zona_paci'];
    $lnacimiento_paci = $row['lnacimiento_paci'];
    $gcultural_paci = $row['gcultural_paci'];
    $ecivil_paci = $row['ecivil_paci'];
    $instruccion_paci = $row['instruccion_paci'];
    $ocupacion_paci = $row['ocupacion_paci'];
    $empresat_paci = $row['empresat_paci'];
    $ssalud_paci = $row['ssalud_paci'];
    $referido_paci = $row['referido_paci'];
    $contacto_dir = $row['contacto_dir'];
    $contacto_nom = $row['contacto_nom'];   
    $contacto_ape = $row['contacto_ape']; 
    $contacto_par = $row['contacto_par'];
    $contacto_num = $row['contacto_num'];
    $genero = $row['genero'];
    $nacionalidad = $row['nacionalidad'];
    $sangre = $row['sangre'];

}

//Funcion calcular edad 
function calcular_edad($fecha){
    $fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); 
    $fecha_hoy =  new DateTime(date('Y/m/d',time())); 
    $edad = date_diff($fecha_hoy,$fecha_nac); 
    return $edad;
}

//==================Primera página vertical==================
$pdf->AddPage();
$pdf->SetFont('Arial','B', 8);

$pdf->Image('../../assets/images/logo_rce.jpeg',17,12,13,12);

$pdf->Cell(20,5,"",'LT',0,'C');
$pdf->SetTextColor(34, 68, 93); 
$pdf->Cell(75,5,utf8_decode('CENTRO DE ESPECIALIDADES MÉDICAS'),'TR',0,'C');
$pdf->SetTextColor(0, 0, 0); 
$pdf->Cell(14,5,utf8_decode('COD. UO'),1,0,'C');
$pdf->Cell(42,5,utf8_decode('COD. LOCALIZACIÓN'),1,0,'C');
$pdf->Cell(39,5,utf8_decode('NÚMERO DE'),'LTR',1,'C');
$pdf->Cell(20,5,"",'L',0,'C');
$pdf->SetTextColor(34, 68, 93); 
$pdf->Cell(75,5,utf8_decode('CLÍNICO QUIRÚRGICO AMBULATORIO'),'R',0,'C');
$pdf->SetTextColor(0,0,0); 
$pdf->Cell(14,11,utf8_decode('25800'),1,0,'C');
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(14,5,utf8_decode('PARROQUIA'),1,0,'C');
$pdf->Cell(14,5,utf8_decode('CANTÓN'),1,0,'C');
$pdf->Cell(14,5,utf8_decode('PROVINCIA'),1,0,'C');
$pdf->SetFont('Arial','B', 8);
$pdf->Cell(39,5,utf8_decode('HISTORIA CLÍNICA'),'LBR',1,'C');
$pdf->Cell(20,4,"",'L',0,'C');
$pdf->SetTextColor(34, 68, 93); 
$pdf->Cell(75,5,utf8_decode('CESMED HOSPITAL DEL DÍA'),'R',0,'C');
$pdf->SetTextColor(0,0,0); 
$pdf->Cell(14);
$pdf->Cell(14,6,utf8_decode('02'),1,0,'C');
$pdf->Cell(14,6,utf8_decode('01'),1,0,'C');
$pdf->Cell(14,6,utf8_decode('04'),1,0,'C');

//Número de Historia Clínica
$pdf->SetFont('Arial','', 8);
$pdf->Cell(39,6,utf8_decode($cedula_paci),1,1,'C');
$pdf->SetY(22);
$pdf->Cell(20,4,"",'LB',0,'C');
$pdf->Cell(75,4,utf8_decode(''),'BR',0,'C');

//Salto de línea
$pdf->Ln(7);

//1 REGISTRO DE PRIMERA ADMISIÓN
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(190,5,utf8_decode('1 REGISTRO DE PRIMERA ADMISIÓN'),1,1,'');
$pdf->SetFont('Arial','', 5);

$pdf->Cell(38,5,utf8_decode('APELLIDO PATERNO'),'LTB',0,'C');
$pdf->Cell(38,5,utf8_decode('APELLIDO MATERNO'),'TB',0,'C');
$pdf->Cell(38,5,utf8_decode('PRIMER NOMBRE'),'TB',0,'C');
$pdf->Cell(38,5,utf8_decode('SEGUNDO NOMBRE'),'TB',0,'C');
$pdf->Cell(38,5,utf8_decode('N° CÉDULA DE CIUDADANÍA'),'TRB',1,'C');

$pdf->Cell(38,5,utf8_decode($apellidos_paci1),1,0,'C');
$pdf->Cell(38,5,utf8_decode($apellidos_paci2),1,0,'C');
$pdf->Cell(38,5,utf8_decode($nombres_paci1),1,0,'C');
$pdf->Cell(38,5,utf8_decode($nombres_paci2),1,0,'C');
$pdf->Cell(38,5,utf8_decode($cedula_paci),1,1,'C');
//--------------------------------------------------------------------------
$pdf->Cell(70,5,utf8_decode('DIRECCIÓN DE RESIDENCIA HABITUAL (CALLE Y N° - MANZANA Y CASA)'),'LTB',0,'C');
$pdf->Cell(20,5,utf8_decode('BARRIO'),'TB',0,'C');
$pdf->Cell(20,5,utf8_decode('PARROQUIA'),'TB',0,'C');
$pdf->Cell(18,5,utf8_decode('CANTÓN'),'TB',0,'C');
$pdf->Cell(18,5,utf8_decode('PROVINCIA'),'TB',0,'C');
$pdf->Cell(6,5,utf8_decode('ZONA (U/R)'),'TB',0,'C');
$pdf->Cell(38,5,utf8_decode('N° TELÉFONO'),'TRB',1,'C');

$pdf->Cell(70,5,utf8_decode($direccion_paci),1,0,'C');
$pdf->Cell(20,5,utf8_decode($barrio_paci),1,0,'C');
$pdf->Cell(20,5,utf8_decode($parroquia_paci),1,0,'C');
$pdf->Cell(18,5,utf8_decode($canton_paci),1,0,'C');
$pdf->Cell(18,5,utf8_decode($provincia_paci),1,0,'C');
if (intval($zona_paci) == 1) {
    $pdf->Cell(6,5,utf8_decode("U"),1,0,'C');
}else{
    $pdf->Cell(6,5,utf8_decode("R"),1,0,'C');
}
if ($telefono_paci != "") {
    $pdf->Cell(38,5,utf8_decode($telefono_paci." - ".$celular_paci),1,1,'C');
}else{
    $pdf->Cell(38,5,utf8_decode($celular_paci),1,1,'C');
} 
//--------------------------------------------------------------------------
$pdf->Cell(20,3,utf8_decode(''),'LT',0,'C');
$pdf->Cell(35,3,utf8_decode(''),'T',0,'C');
$pdf->Cell(32,3,utf8_decode(''),'T',0,'C');
$pdf->Cell(23,3,utf8_decode(''),'T',0,'C');
$pdf->Cell(15,3,utf8_decode("EDAD"),'TR',0,'C');
$pdf->Cell(15,5,utf8_decode('SEXO'),'LTR',0,'C');
$pdf->Cell(25,5,utf8_decode('ESTADO CIVIL'),'LTR',0,'C');
$pdf->Cell(25,3,utf8_decode('INSTRUCCIÓN'),'LTR',1,'C');
$pdf->Cell(20,3,utf8_decode('FECHA NACIMIENTO'),'L',0,'C');
$pdf->Cell(35,3,utf8_decode('LUGAR NACIMIENTO'),0,0,'C');
$pdf->Cell(32,3,utf8_decode('NACIONALIDAD (PAÍS)'),0,0,'C');
$pdf->Cell(23,3,utf8_decode('GRUPO CULTURAL'),0,0,'C');
$pdf->Cell(15,3,utf8_decode('AÑOS'),'R',0,'C');
$pdf->Cell(8,5,utf8_decode(''),'L',0,'C');
$pdf->Cell(7,5,utf8_decode(''),'R',0,'C');
$pdf->Cell(25,5,utf8_decode(''),'LR',0,'C');
$pdf->Cell(25,3,utf8_decode('ÚLTIMO AÑO'),'LR',1,'C');
$pdf->Cell(20,3,utf8_decode(''),'L',0,'C');
$pdf->Cell(35,3,utf8_decode(''),0,0,'C');
$pdf->Cell(32,3,utf8_decode(''),0,0,'C');
$pdf->Cell(23,3,utf8_decode(''),0,0,'C');
$pdf->Cell(15,3,utf8_decode('CUMPLIDOS'),'R',0,'C');
$pdf->Cell(8,3,utf8_decode('M'),'LB',0,'C');
$pdf->Cell(7,3,utf8_decode('F'),'RB',0,'C');
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(5,3,utf8_decode('SOL'),'B',0,'C');
$pdf->Cell(5,3,utf8_decode('CAS'),'B',0,'C');
$pdf->Cell(5,3,utf8_decode('DIV'),'B',0,'C');
$pdf->Cell(5,3,utf8_decode('VIU'),'B',0,'C');
$pdf->Cell(5,3,utf8_decode('U-L'),'BR',0,'C');
$pdf->SetFont('Arial','', 5);
$pdf->Cell(25,3,utf8_decode('APROBADO'),'LBR',1,'C');

$pdf->Cell(20,5,utf8_decode($fechan_paci),1,0,'C');
$pdf->Cell(35,5,utf8_decode($lnacimiento_paci),1,0,'C');
$pdf->Cell(32,5,utf8_decode($nacionalidad),1,0,'C');
$pdf->Cell(23,5,utf8_decode($gcultural_paci),1,0,'C');
$edad = calcular_edad($fechan_paci);
$pdf->Cell(15,5,$edad->format('%Y').utf8_decode(' años, ').$edad->format('%m').' m.',1,0,'C');
if ($genero == "MASCULINO") {
    $pdf->Cell(8,5,utf8_decode('X'),1,0,'C');
    $pdf->Cell(7,5,utf8_decode(''),1,0,'C');
}
if ($genero == "FEMENINO") {
    $pdf->Cell(8,5,utf8_decode('X'),'LTB',0,'C');
    $pdf->Cell(7,5,utf8_decode(''),'RTB',0,'C');
}

switch ($ecivil_paci) {
    case "Soltero/a":
        $pdf->Cell(5,5,utf8_decode('X'),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        break;
    case "Casado/a":
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode('X'),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        break;
    case "Divorciado/a":
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode('X'),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        break;
    case "Viudo/a":
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode('X'),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        break;
    case "Unión Libre":
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode(''),1,0,'C');
        $pdf->Cell(5,5,utf8_decode('X'),1,0,'C');
        break;
}
$pdf->Cell(25,5,utf8_decode($instruccion_paci),1,1,'C');
//-----------------------------------------------------------------------------------------------------------------------
$pdf->Cell(20,5,utf8_decode('FECHA DE ADMISIÓN'),"L",0,'C');
$pdf->Cell(35,5,utf8_decode('OCUPACIÓN'),0,0,'C');
$pdf->Cell(50,5,utf8_decode('EMPRESA DONDE TRABAJA'),0,0,'C');
$pdf->Cell(40,5,utf8_decode('TIPO DE SEGURO DE SALUD'),0,0,'C');
$pdf->Cell(45,5,utf8_decode('REFERIDO DE:'),"R",1,'C');

$pdf->Cell(20,5,utf8_decode($fecha_registro),1,0,'C');
$pdf->Cell(35,5,utf8_decode($ocupacion_paci),1,0,'C');
$pdf->Cell(50,5,utf8_decode($empresat_paci),1,0,'C');
$pdf->Cell(40,5,utf8_decode($ssalud_paci),1,0,'C');
$pdf->Cell(45,5,utf8_decode($referido_paci),1,1,'C');

$pdf->Cell(60,5,utf8_decode('EN CASO NECESARIO LLAMAR A:'),"L",0,'C');
$pdf->Cell(25,5,utf8_decode('PARENTESCO-AFINIDAD'),0,0,'C');
$pdf->Cell(70,5,utf8_decode('DIRECCIÓN'),0,0,'C');
$pdf->Cell(35,5,utf8_decode('N° TELÉFONO'),"R",1,'C');

$pdf->Cell(60,5,utf8_decode($contacto_nom." ".$contacto_ape),1,0,'C');
$pdf->Cell(25,5,utf8_decode($contacto_par),1,0,'C');
$pdf->Cell(70,5,utf8_decode($contacto_dir),1,0,'C');
$pdf->Cell(35,5,utf8_decode($contacto_num),1,1,'C');

$pdf->Cell(175,2,"",0,0,'C');
$pdf->Cell(15,2,utf8_decode("CÓDIGO"),0,1,'C');

$pdf->Cell(160,5,utf8_decode('COD= CÓDIGO    U= URBANA    R= RURAL    M= MASCULINO    F= FEMENINO    SOL= SOLTERO    CAS= CASADO    DIV= DIVORCIADO    VIU= VIUDO    U-L= UNIÓN LIBRE'),0,0,'L');
$pdf->Cell(15,5,"ADMISIONISTA",1,0,'C');
$pdf->Cell(15,5,$nautorizacion_medi,1,1,'C');

$pdf->Ln(4);

//2 REGISTRO DE NUEVAS ADMISIONES PARA ATENCIONES POR PRIMERA VEZ Y SUBSECUENTES
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(190,5,utf8_decode('2 REGISTRO DE NUEVAS ADMISIONES PARA ATENCIONES POR PRIMERA VEZ Y SUBSECUENTES'),1,1,'');
$pdf->SetFont('Arial','', 6);
$h = $pdf -> GetY();

$pdf->Cell(5,15,utf8_decode("N°"),"LTB",0,'C');
$pdf->Cell(13,15,utf8_decode("FECHA"),"TB",0,'C');
$pdf->Cell(12,15,utf8_decode("EDAD"),"TB",0,'C');
$pdf->Cell(40,15,utf8_decode("REFERIDO DE:"),"RTB",0,'C');

$pdf->Cell(5,15,"",1,0,'C');
$pdf->SetFont('Arial','B', 5);
$pdf->TextWithDirection(83,$h+11,'PRIMERA','U');
$pdf->SetFont('Arial','', 5);

$pdf->Cell(5,15,"",1,0,'C');
$pdf->SetFont('Arial','B', 4);
$pdf->TextWithDirection(87,$h+9,'SUB','U');
$pdf->TextWithDirection(89,$h+11,'SECUENTE','U');
$pdf->SetFont('Arial','B', 5);

$pdf->Cell(15,15,"",1,0,'C');
$pdf->TextWithDirection(94,$h+7,utf8_decode("CÓDIGO"),'R');
$pdf->TextWithDirection(91,$h+10,utf8_decode("ADMISIONISTA"),'R');


$pdf->SetFont('Arial','', 6);
$pdf->Cell(5,15,utf8_decode("N°"),"LTB",0,'C');
$pdf->Cell(13,15,utf8_decode("FECHA"),"TB",0,'C');
$pdf->Cell(12,15,utf8_decode("EDAD"),"TB",0,'C');
$pdf->Cell(40,15,utf8_decode("REFERIDO DE:"),"RTB",0,'C');

$pdf->Cell(5,15,"",1,0,'C');
$pdf->SetFont('Arial','B', 5);
$pdf->TextWithDirection(178,$h+11,'PRIMERA','U');
$pdf->SetFont('Arial','', 5);

$pdf->Cell(5,15,"",1,0,'C');
$pdf->SetFont('Arial','B', 4);
$pdf->TextWithDirection(182,$h+9,'SUB','U');
$pdf->TextWithDirection(184,$h+11,'SECUENTE','U');
$pdf->SetFont('Arial','B', 5);

$pdf->Cell(15,15,"",1,0,'C');
$pdf->TextWithDirection(189,$h+7,utf8_decode("CÓDIGO"),'R');
$pdf->TextWithDirection(186,$h+10,utf8_decode("ADMISIONISTA"),'R');

$pdf -> Ln(15);
$h2 = $pdf -> GetY();
for ($i=0; $i < 10; $i++) { 
    $pdf->Cell(5,5,$i+1,1,0,'C');
    $pdf->Cell(13,5,"",1,0,'C');
    $pdf->Cell(12,5,"",1,0,'C');
    $pdf->Cell(40,5,"",1,0,'C');
    $pdf->Cell(5,5,"",1,0,'C');
    $pdf->Cell(5,5,"",1,0,'C');
    $pdf->Cell(15,5,"",1,1,'C');
}

for ($j=0; $j < 10; $j++) {
    $pdf->SetXY(105,$h2+($j*5)); 
    $pdf->Cell(5,5,$j+11,1,0,'C');
    $pdf->Cell(13,5,"",1,0,'C');
    $pdf->Cell(12,5,"",1,0,'C');
    $pdf->Cell(40,5,"",1,0,'C');
    $pdf->Cell(5,5,"",1,0,'C');
    $pdf->Cell(5,5,"",1,0,'C');
    $pdf->Cell(15,5,"",1,0,'C');
}
$pdf->Ln(9);

//3 REGISTRO DE CAMBIOS
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(190,5,utf8_decode('3 REGISTRO DE CAMBIOS'),1,1,'');

for ($i=0; $i < 4; $i++) { 
    $pdf->SetFont('Arial','Bi', 9);
    $pdf->Cell(5,16,$i+1,1,0,'C');
    $pdf->SetFont('Arial','', 5);
    $pdf->Cell(17,3,utf8_decode("FECHA"),0,0,'C');
    $pdf->Cell(25,3,utf8_decode("ESTADO CIVIL"),0,0,'C');
    $pdf->Cell(22,3,utf8_decode("INSTRUCCIÓN"),0,0,'C');
    $pdf->Cell(43,3,utf8_decode("OCUPACIÓN"),0,0,'C');
    $pdf->Cell(43,3,utf8_decode("EMPRESA"),0,0,'C');
    $pdf->Cell(35,3,utf8_decode("TIPO DE SEGURO DE SALUD"),"R",1,'C');
    $pdf->Cell(5);
    $pdf->Cell(17,5,"",1,0,'C');
    $pdf->Cell(25,5,"",1,0,'C');
    $pdf->Cell(22,5,"",1,0,'C');
    $pdf->Cell(43,5,"",1,0,'C');
    $pdf->Cell(43,5,"",1,0,'C');
    $pdf->Cell(35,5,"",1,1,'C');

    $pdf->Cell(5);
    $pdf->Cell(68,3,utf8_decode('DIRECCIÓN DE RESIDENCIA HABITUAL (CALLE Y NÚMERO O MANZANA Y CA'),0,0,'C');
    $pdf->Cell(20,3,utf8_decode('BARRIO'),0,0,'C');
    $pdf->Cell(6,3,utf8_decode('ZONA'),0,0,'C');
    $pdf->Cell(20,3,utf8_decode('PARROQUIA'),0,0,'C');
    $pdf->Cell(18,3,utf8_decode('CANTÓN'),0,0,'C');
    $pdf->Cell(18,3,utf8_decode('PROVINCIA'),0,0,'C');
    $pdf->Cell(35,3,utf8_decode('N° TELÉFONO'),'R',1,'C');

    $pdf->Cell(5);
    $pdf->Cell(68,5,"",1,0,'C');
    $pdf->Cell(20,5,"",1,0,'C');
    $pdf->Cell(6,5,"",1,0,'C');
    $pdf->Cell(20,5,"",1,0,'C');
    $pdf->Cell(18,5,"",1,0,'C');
    $pdf->Cell(18,5,"",1,0,'C');
    $pdf->Cell(35,5,"",1,1,'C');
}

$pdf->Ln(4);

//4 INFORMACIÓN ADICIONAL
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(190,5,utf8_decode('4 INFORMACIÓN ADICIONAL'),1,1,'L');

$pdf->SetFont('Arial','', 5);
$pdf->TextWithDirection(125,248,utf8_decode("ESPACIO RESERVADO PARA REGISTRAR OTROS DATOS ESPECÍFICOS DEL USUARIO"),'R');
$pdf->TextWithDirection(133,250,utf8_decode("REQUERIDOS POR LA INSTITUCIÓN QUE CONSTA EN EL ENCABEZAMIENTO"),'R');

for ($i=0; $i < 4; $i++) { 
    $pdf->Cell(190,5,"",1,1,'L');
}





// Pie de página
$pdf->SetFont('Arial','B',7);
$pdf->Cell(20,5,utf8_decode('SNS-MSP / HCU-form.001 / 2008'),0,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(150);
$pdf->Cell(20,5,utf8_decode('ADMISIÓN'),0,0,'R');


//===============Segunda página horizontal================
$pdf->AddPage('L');


$pdf->Image('../../assets/images/logo_rce.jpeg',55,9,11,10);
$pdf->Image('../../assets/images/msp_logo.png',232,10,14,8);
//TÍTULO
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(34, 68, 93); 
$pdf->Cell(277,4,utf8_decode('CENTRO DE ESPECIALIDADES MÉDICAS CLÍNICO QUIRÚRGICO CESMED HOSPITAL DEL DÍA'),0,1,'C');
//DIRECCIÓN
$pdf->SetFont('Arial','BI', 9);
$pdf->Cell(277,4,utf8_decode('Dirección: Av. San Francisco y Uruguay (esquina) - Tulcán - Ecuador - Teléfono: 2986771'),0,0,'C');
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0); 


//5 ALTA AMBULATORIA
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(277,5,utf8_decode('5 ALTA AMBULATORIA'),1,1,'L');
$pdf->Ln(2);
$pdf->Cell(90,5,utf8_decode('CARACTERÍSTICAS'),1,0,'C');
$pdf->Cell(128,5,utf8_decode('DIAGNÓSTICO'),1,0,'C');
$pdf->Cell(59,5,utf8_decode('TRATAMIENTO'),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(5,27,"",1,0,'C');
$pdf->TextWithDirection(13,$pdf-> GetY()+24,utf8_decode("NÚMERO DE ORDEN"),'U');
$pdf->Cell(15,27,"",1,0,'C');
$pdf->TextWithDirection(16,$pdf-> GetY()+10,utf8_decode(" FECHAS DE"),'R');
$pdf->TextWithDirection(17,$pdf-> GetY()+12,utf8_decode(" ADMISIÓN"),'R');
$pdf->TextWithDirection(18,$pdf-> GetY()+14,utf8_decode(" Y ALTA"),'R');
$pdf->SetFont('Arial','', 6);
$pdf->TextWithDirection(15,$pdf-> GetY()+20,utf8_decode(" AÑO/MES/DÍA"),'R');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(6,27,"",1,0,'C');
$pdf->TextWithDirection(33,$pdf-> GetY()+22,utf8_decode("CONSULTAS DE"),'U');
$pdf->TextWithDirection(35,$pdf-> GetY()+21,utf8_decode("EMERGENCIA"),'U');
$pdf->Cell(6,27,"",1,0,'C');
$pdf->TextWithDirection(39,$pdf-> GetY()+20,utf8_decode("NÚMERO DE"),'U');
$pdf->TextWithDirection(41,$pdf-> GetY()+26,utf8_decode("CONSULTAS EXTERNAS"),'U');
$pdf->Cell(42,27,"",1,0,'C');
$pdf->TextWithDirection(49,$pdf-> GetY()+12,utf8_decode("    ESPECIALIDAD DEL"),'R');
$pdf->TextWithDirection(54,$pdf-> GetY()+16,utf8_decode("    SERVICIO"),'R');
$pdf->Cell(12,8,"",1,0,'C');
$pdf->SetFont('Arial','B', 5);
$pdf->TextWithDirection(85,$pdf-> GetY()+3,utf8_decode("CONDICIÓN"),'R');
$pdf->TextWithDirection(86,$pdf-> GetY()+6,utf8_decode(" AL ALTA"),'R');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(99,$pdf-> GetY()+18,utf8_decode("MUERTO"),'U');
$pdf->Cell(47,27,utf8_decode("DIAGNÓSTICOS O SÍNDROMES"),1,0,'C');
$pdf->Cell(9,27,utf8_decode("CIE"),1,0,'C');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(159,$pdf-> GetY()+21,utf8_decode("PRESUNTIVO"),'U');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(163,$pdf-> GetY()+20,utf8_decode("DEFINITIVO"),'U');
$pdf->Cell(47,27,utf8_decode("DIAGNÓSTICOS O SÍNDROMES"),1,0,'C');
$pdf->Cell(9,27,utf8_decode("CIE"),1,0,'C');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(223,$pdf-> GetY()+21,utf8_decode("PRESUNTIVO"),'U');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(227,$pdf-> GetY()+20,utf8_decode("DEFINITIVO"),'U');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(231,$pdf-> GetY()+18,utf8_decode("CLÍNICO"),'U');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(235,$pdf-> GetY()+20,utf8_decode("QUIRÚRGICO"),'U');
$pdf->Cell(41,27,"",1,0,'C');
$pdf->TextWithDirection(240,$pdf-> GetY()+10,utf8_decode("PROCEDIMIENTOS CLÍNICOS O"),'R');
$pdf->TextWithDirection(249,$pdf-> GetY()+14,utf8_decode("QUIRÚRGICOS"),'R');
$pdf->TextWithDirection(249,$pdf-> GetY()+18,utf8_decode("PRINCIPALES"),'R');
$pdf->Cell(10,27,"",1,0,'C');
$pdf->TextWithDirection(281,$pdf-> GetY()+20,utf8_decode("CÓDIGO DEL"),'U');
$pdf->TextWithDirection(284,$pdf-> GetY()+22,utf8_decode("RESPONSABLE"),'U');
$pdf->Ln(8);
$pdf->Cell(74);
$pdf->Cell(4,19,"",1,0,'C');
$pdf->TextWithDirection(87,$pdf-> GetY()+14,utf8_decode("CURADO"),'U');
$pdf->Cell(4,19,"",1,0,'C');
$pdf->TextWithDirection(91,$pdf-> GetY()+12,utf8_decode("IGUAL"),'U');
$pdf->Cell(4,19,"",1,0,'C');
$pdf->TextWithDirection(95,$pdf-> GetY()+12,utf8_decode("PEOR"),'U');
$pdf->Ln(19);

$query_ncit = "SELECT ci.id_cita
                FROM cita as ci
                INNER JOIN caso as ca
                    ON ci.id_caso = ca.id_caso
                WHERE ca.id_caso = '{$id_caso}'";
$result_ncit = mysqli_query($conn, $query_ncit);
if(!$result_ncit) {
    die('Consulta fallida'. mysqli_error($conn));
}
$citas = array();
while($row = mysqli_fetch_array($result_ncit)) {
    $citas[] = array(
    'id_cita' => $row['id_cita']
    );
}

$h3= $pdf-> GetY();
$pdf->Cell(5,10,"1",1,0,'C');
$pdf->SetFont('Arial','', 5);
$pdf->Cell(15,5,utf8_decode($fecha_registro),1,0,'C');
$pdf->Cell(6,10,"0",1,0,'C');
$pdf->Cell(6,10,sizeof($citas),1,0,'C');

$pdf->Cell(42,10,utf8_decode("*".$especialidad."*"),1,0,'C');

switch ($c_alta) {
    case 'Curado':
        $pdf->Cell(4,10,"X",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        break;
    case 'Igual':
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"X",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        break;
    case 'Peor':
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"X",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        break;
    case 'Muerto':
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"",1,0,'C');
        $pdf->Cell(4,10,"X",1,0,'C');
        break;
}

$query7 = "SELECT dia.*, cie.clave
           FROM diagnostico as dia
           INNER JOIN diagnosticoscie10 as cie
            ON dia.id_cie = cie.id 
           INNER JOIN cita as ci
            ON dia.id_cita = ci.id_cita
           INNER JOIN caso as ca
            ON ci.id_caso = ca.id_caso
           WHERE ca.id_caso = '$id_caso'";
$result7 = mysqli_query($conn, $query7);
if(!$result7) {
    die('Consulta fallida'. mysqli_error($conn));
}
$diagnosticos = array();
while($row = mysqli_fetch_array($result7)) {
    $diagnosticos[] = array(
    'descripcion' => $row['descripcion'],
    'pre_def' => $row['pre_def'],
    'clave' => $row['clave']
    );
}


//Diagnóstico 1
if (isset($diagnosticos[0])) {
    $pdf->Cell(47,5,utf8_decode("*".$diagnosticos[0]['descripcion']."*"),1,0,'C');
    $pdf->Cell(9,5,utf8_decode("*".$diagnosticos[0]['clave']."*"),1,0,'C');
    if (intval($diagnosticos[0]['pre_def']) == 1) {
        $pdf->Cell(4,5,"",1,0,'C');
        $pdf->Cell(4,5,"X",1,0,'C');
    }else{
        $pdf->Cell(4,5,"X",1,0,'C');
        $pdf->Cell(4,5,"",1,0,'C');
    }
}else{
    $pdf->Cell(47,5,'',1,0,'C');
    $pdf->Cell(9,5,'',1,0,'C');
    $pdf->Cell(4,5,'',1,0,'C');
    $pdf->Cell(4,5,'',1,0,'C');
}
//----------------------------

//Diagnóstico 2
if (isset($diagnosticos[1])) {
    $pdf->Cell(47,5,utf8_decode("*".$diagnosticos[1]['descripcion']."*"),1,0,'C');
    $pdf->Cell(9,5,utf8_decode("*".$diagnosticos[1]['clave']."*"),1,0,'C');
    if (intval($diagnosticos[1]['pre_def']) == 1) {
        $pdf->Cell(4,5,"",1,0,'C');
        $pdf->Cell(4,5,"X",1,0,'C');
    }else{
        $pdf->Cell(4,5,"X",1,0,'C');
        $pdf->Cell(4,5,"",1,0,'C');
    }
}else{
    $pdf->Cell(47,5,'',1,0,'C');
    $pdf->Cell(9,5,'',1,0,'C');
    $pdf->Cell(4,5,'',1,0,'C');
    $pdf->Cell(4,5,'',1,0,'C');
}

//----------------------------
if ($t_tratamiento == "Clínico") {
    $pdf->Cell(4,10,"X",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C'); 
}
if ($t_tratamiento == "Quirúrgico") {
    $pdf->Cell(4,10,"X",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C'); 
}
$pdf->Multicell(41,5,utf8_decode("*".$proc_cq."*"),0,'C');
$pdf->SetY(68);
$pdf->Cell(5);
$pdf->Cell(15,5,utf8_decode($fecha_alta),1,0,'C');
$pdf->Cell(70);
//Diagnóstico 3
if (isset($diagnosticos[2])) {
    $pdf->Cell(47,5,utf8_decode("*".$diagnosticos[2]['descripcion']."*"),1,0,'C');
    $pdf->Cell(9,5,utf8_decode("*".$diagnosticos[2]['clave']."*"),1,0,'C');
    if (intval($diagnosticos[2]['pre_def']) == 1) {
        $pdf->Cell(4,5,"",1,0,'C');
        $pdf->Cell(4,5,"X",1,0,'C');
    }else{
        $pdf->Cell(4,5,"X",1,0,'C');
        $pdf->Cell(4,5,"",1,0,'C');
    }
}else{
    $pdf->Cell(47,5,'',1,0,'C');
    $pdf->Cell(9,5,'',1,0,'C');
    $pdf->Cell(4,5,'',1,0,'C');
    $pdf->Cell(4,5,'',1,0,'C');
}
//----------------------------

//Diagnóstico 4
if (isset($diagnosticos[3])) {
    $pdf->Cell(47,5,utf8_decode("*".$diagnosticos[3]['descripcion']."*"),1,0,'C');
    $pdf->Cell(9,5,utf8_decode("*".$diagnosticos[3]['clave']."*"),1,0,'C');
    if (intval($diagnosticos[3]['pre_def']) == 1) {
        $pdf->Cell(4,5,"",1,0,'C');
        $pdf->Cell(4,5,"X",1,0,'C');
    }else{
        $pdf->Cell(4,5,"X",1,0,'C');
        $pdf->Cell(4,5,"",1,0,'C');
    }
}else{
    $pdf->Cell(47,5,'',1,0,'C');
    $pdf->Cell(9,5,'',1,0,'C');
    $pdf->Cell(4,5,'',1,0,'C');
    $pdf->Cell(4,5,'',1,0,'C');
}
//----------------------------
$pdf->Cell(4,5,"",0,0,'C');
$pdf->Cell(4,5,"",0,0,'C');
$pdf->Cell(41,5,"",0,0,'C');
$pdf->SetXY(277,63);
$pdf->SetFont('Arial','', 4);
$pdf->Cell(10,10,$nautorizacion_medi,1,1,'C');

for ($i=0; $i < 3; $i++) { 
    $pdf->SetFont('Arial','B', 6);
    $pdf->Cell(5,10,$i+2,1,0,'C');
    $pdf->SetFont('Arial','', 5);
    $pdf->Cell(15,5,"",1,0,'C');
    $pdf->Cell(6,10,"",1,0,'C');
    $pdf->Cell(6,10,"",1,0,'C');
    $pdf->Cell(42,10,"",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C');
    $pdf->Cell(47,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(47,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C'); 
    $pdf->Cell(41,10,"",1,0,'C');

    $pdf->SetY(68+(10*($i+1)));
    $pdf->Cell(5);
    $pdf->Cell(15,5,"",1,0,'C');
    $pdf->Cell(70);
    $pdf->Cell(47,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(47,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",0,0,'C');
    $pdf->Cell(4,5,"",0,0,'C');
    $pdf->Cell(41,5,"",0,0,'C');
    $pdf->SetXY(277,63+(10*($i+1)));
    $pdf->Cell(10,10,"",1,1,'C');
}

$pdf->Ln(3);

//6 EGRESO HOSPITALARIO
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(277,5,utf8_decode('6 EGRESO HOSPITALARIO'),1,1,'L');
$pdf->Ln(2);
$pdf->Cell(90,5,utf8_decode('CARACTERÍSTICAS'),1,0,'C');
$pdf->Cell(128,5,utf8_decode('DIAGNÓSTICO'),1,0,'C');
$pdf->Cell(59,5,utf8_decode('TRATAMIENTO'),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(5,27,"",1,0,'C');
$pdf->TextWithDirection(13,$pdf-> GetY()+24,utf8_decode("NÚMERO DE ORDEN"),'U');
$pdf->Cell(15,27,"",1,0,'C');
$pdf->TextWithDirection(16,$pdf-> GetY()+10,utf8_decode(" FECHAS DE"),'R');
$pdf->TextWithDirection(17,$pdf-> GetY()+12,utf8_decode(" ADMISIÓN"),'R');
$pdf->TextWithDirection(16,$pdf-> GetY()+14,utf8_decode(" Y EGRESO"),'R');
$pdf->SetFont('Arial','', 6);
$pdf->TextWithDirection(15,$pdf-> GetY()+20,utf8_decode(" AÑO/MES/DÍA"),'R');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(6,27,"",1,0,'C');
$pdf->TextWithDirection(33,$pdf-> GetY()+25,utf8_decode("NÚMERO DE DÍAS DE"),'U');
$pdf->TextWithDirection(35,$pdf-> GetY()+18,utf8_decode("ESTADA"),'U');
$pdf->Cell(51,27,"",1,0,'C');
$pdf->TextWithDirection(55,$pdf-> GetY()+14,utf8_decode("SERVICIO"),'R');
$pdf->Cell(13,8,"",1,0,'C');
$pdf->SetFont('Arial','B', 5);
$pdf->TextWithDirection(88,$pdf-> GetY()+3,utf8_decode(" CONDICIÓN"),'R');
$pdf->TextWithDirection(88,$pdf-> GetY()+6,utf8_decode(" AL EGRESO"),'R');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(47,27,utf8_decode("DIAGNÓSTICOS O SÍNDROMES"),1,0,'C');
$pdf->Cell(9,27,utf8_decode("CIE"),1,0,'C');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(159,$pdf-> GetY()+21,utf8_decode("PRESUNTIVO"),'U');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(163,$pdf-> GetY()+20,utf8_decode("DEFINITIVO"),'U');
$pdf->Cell(47,27,utf8_decode("DIAGNÓSTICOS O SÍNDROMES"),1,0,'C');
$pdf->Cell(9,27,utf8_decode("CIE"),1,0,'C');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(223,$pdf-> GetY()+21,utf8_decode("PRESUNTIVO"),'U');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(227,$pdf-> GetY()+20,utf8_decode("DEFINITIVO"),'U');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(231,$pdf-> GetY()+18,utf8_decode("CLÍNICO"),'U');
$pdf->Cell(4,27,"",1,0,'C');
$pdf->TextWithDirection(235,$pdf-> GetY()+20,utf8_decode("QUIRÚRGICO"),'U');
$pdf->Cell(41,27,"",1,0,'C');
$pdf->TextWithDirection(240,$pdf-> GetY()+10,utf8_decode("PROCEDIMIENTOS CLÍNICOS O"),'R');
$pdf->TextWithDirection(249,$pdf-> GetY()+14,utf8_decode("QUIRÚRGICOS"),'R');
$pdf->TextWithDirection(249,$pdf-> GetY()+18,utf8_decode("PRINCIPALES"),'R');
$pdf->Cell(10,27,"",1,0,'C');
$pdf->TextWithDirection(281,$pdf-> GetY()+20,utf8_decode("CÓDIGO DEL"),'U');
$pdf->TextWithDirection(284,$pdf-> GetY()+22,utf8_decode("RESPONSABLE"),'U');
$pdf->Ln(8);
$pdf->Cell(77);
$pdf->Cell(3,19,"",1,0,'C');
$pdf->TextWithDirection(89,$pdf-> GetY()+14,utf8_decode("   ALTA"),'U');
$pdf->Cell(5,19,"",1,0,'C');
$pdf->TextWithDirection(92,$pdf-> GetY()+18,utf8_decode("MUERTE MENOS"),'U');
$pdf->TextWithDirection(94,$pdf-> GetY()+17,utf8_decode("DE 48 HORAS"),'U');
$pdf->Cell(5,19,"",1,0,'C');
$pdf->TextWithDirection(97,$pdf-> GetY()+19,utf8_decode(" MUERTE MÁS DE"),'U');
$pdf->TextWithDirection(99,$pdf-> GetY()+15,utf8_decode(" 48 HORAS"),'U');

$pdf->Ln(19);
for ($i=0; $i < 4; $i++) { 
    $pdf->SetFont('Arial','B', 6);
    $pdf->Cell(5,10,$i+1,1,0,'C');
    $pdf->SetFont('Arial','', 5);
    $pdf->Cell(15,5,"",1,0,'C');
    $pdf->Cell(6,10,"",1,0,'C');
    $pdf->Cell(51,10,"",1,0,'C');
    $pdf->Cell(3,10,"",1,0,'C');
    $pdf->Cell(5,10,"",1,0,'C');
    $pdf->Cell(5,10,"",1,0,'C');
    $pdf->Cell(47,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(47,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C');
    $pdf->Cell(4,10,"",1,0,'C'); 
    $pdf->Cell(41,10,"",1,0,'C');

    $pdf->SetY(140+(10*($i+1)));
    $pdf->Cell(5);
    $pdf->Cell(15,5,"",1,0,'C');
    $pdf->Cell(70);
    $pdf->Cell(47,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(47,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",1,0,'C');
    $pdf->Cell(4,5,"",0,0,'C');
    $pdf->Cell(4,5,"",0,0,'C');
    $pdf->Cell(41,5,"",0,0,'C');
    $pdf->SetXY(277,135+(10*($i+1)));
    $pdf->Cell(10,10,"",1,1,'C');
}

$pdf->SetY(184);
// Pie de página
$pdf->SetFont('Arial','B',7);
$pdf->Cell(20,5,utf8_decode('SNS-MSP / HCU-form.001 / 2008'),0,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(238);
$pdf->Cell(20,5,utf8_decode('ALTA - EGRESO'),0,0,'R');

$pdf->Output("reporte_hcu_001.pdf","I",true);
?>