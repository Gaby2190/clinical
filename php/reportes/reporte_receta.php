<?php
require_once '../FPDF/fpdf.php';
include_once '../../dbconnection.php';
$id_cita = $_GET['id_cita']; 
require_once "../lib/numeroaletras.php";
//llamamos a la(s) clases
$modelonumero = new modelonumero();
$numeroaletras = new numeroaletras();

//Constantes de X
$x_1 = 15;
$x_2 = 75;
$x_3 = 110;

 $query = "SELECT ci.*, ca.id_medico, ca.id_paciente, ca.id_especialidad, me.sufijo, me.nombres_medi, me.apellidos_medi, me.celular_medi, pa.nombres_paci1, pa.apellidos_paci1 , pa.nombres_paci2, pa.apellidos_paci2, pa.fechan_paci, pa.cedula_paci, na.nombre as nacionalidad, ge.nombre as genero
          FROM cita as ci
          INNER JOIN caso as ca
            ON ci.id_caso = ca.id_caso
          INNER JOIN medico as me
            ON ca.id_medico = me.id_medico
          INNER JOIN paciente as pa
            ON ca.id_paciente = pa.id_paciente
          INNER JOIN nacionalidad as na
            ON pa.nac_id = na.id
          INNER JOIN genero as ge
            ON pa.gen_id = ge.id
          WHERE ci.id_cita='$id_cita'";

$result = mysqli_query($conn, $query);
if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result)) {
    $fecha = $row['fecha'];
    $signos_a = $row['signos_a'];
    $recomendaciones_nf = $row['recomendaciones_nf'];
    $id_caso = $row['id_caso'];
    $id_especialidad = $row['id_especialidad'];
    $id_medico = $row['id_medico'];
    $id_paciente = $row['id_paciente'];
    $sufijo = $row['sufijo'];
    $nombres_medi = $row['nombres_medi'];
    $apellidos_medi = $row['apellidos_medi'];
    $celular_medi = $row['celular_medi'];
    $nombres_paci1 = $row['nombres_paci1'];
    $apellidos_paci1 = $row['apellidos_paci1'];
    $nombres_paci2 = $row['nombres_paci2'];
    $apellidos_paci2 = $row['apellidos_paci2'];
    $fechan_paci = $row['fechan_paci'];
    $cedula_paci = $row['cedula_paci'];
    $nacionalidad = $row['nacionalidad'];
    $genero = $row['genero'];
}

$query_es = "SELECT nombre FROM especialidad WHERE id = '$id_especialidad'";
$result_es = mysqli_query($conn, $query_es);

if(!$result_es) {
    die('Consulta fallida'. mysqli_error($conn));
}
$es = array();
while($row = mysqli_fetch_array($result_es)) {
    $es[] = array(
    'nombre' => $row['nombre']
    );
}

$especialidad = '';
for ($i=0; $i < sizeof($es); $i++) { 
  $nom = ucfirst(mb_strtolower($es[$i]['nombre']));
  $especialidad = $especialidad.$nom;
}

function calcular_edad($fecha){
    try {
        $fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); 
    } catch (Throwable $e) {
    $fecha_nac = new DateTime(date('Y/m/d',time())); 
        
    } 

$fecha_hoy =  new DateTime(date('Y/m/d',time())); 
$edad = date_diff($fecha_hoy,$fecha_nac); 
return $edad;
} 


$fecha_act = new DateTime($fecha);
$dia=$fecha_act->format('d');
$m=$fecha_act->format('n');
switch ($m) {
  case 1:
    $mes='enero';
    break;
  case 2:
    $mes='febrero';
    break;
  case 3:
    $mes='marzo';
    break;
  case 4:
    $mes='abril';
    break;
  case 5:
    $mes='mayo';
    break;
  case 6:
    $mes='junio';
    break;
  case 7:
    $mes='julio';
    break;
  case 8:
    $mes='agosto';
    break;
  case 9:
    $mes='septiembre';
    break;
  case 10:
    $mes='octubre';
    break;
  case 11:
    $mes='noviembre';
    break;
  case 12:
    $mes='diciembre';
    break;
}
$año=$fecha_act->format('Y');


class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    global $nombres_medi;
    global $apellidos_medi;
    global $id_cita;
    $iniciales = preg_replace('/\b(\w)[^\s]*\s*/m', '$1', $nombres_medi.' '.$apellidos_medi);
    global $id_medico;
    $len_id_rec = 3;
    $id_med_rec = substr(str_repeat(0, $len_id_rec).$id_medico, - $len_id_rec);
    global $especialidad;
    global $dia;
    global $mes;
    global $año;
    global $nombres_paci1;
    global $nombres_paci2;
    global $apellidos_paci1;
    global $apellidos_paci2;
    
   // $this->Image('../../assets/images/no_valido.png',100,50,100);

    $query_sec = "SELECT MAX(secuencial) AS max_secuencial
               FROM receta WHERE id_medico = '{$id_medico}' AND id_cita = '{$id_cita}'";
    global $conn;
    $result_sec = mysqli_query($conn, $query_sec);
    if(!$result_sec) {
        die('Consulta fallida'. mysqli_error($conn));
    }
    while($row = mysqli_fetch_array($result_sec)) {
        $sec = intval($row['max_secuencial']);
    }
    $len_id_sec = 6;
    $med_sec = substr(str_repeat(0, $len_id_sec).$sec, - $len_id_sec);
    //LOGO
    $this->Image('../../assets/images/logo_rce.jpeg',12,8,15);
    $this->Image('../../assets/images/logo_rce.jpeg',160,8,15);
    //TÍTULO
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(34, 68, 93); 
    $this->SetY(5);
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode('CENTRO DE ESPECIALIDADES MÉDICAS'),0,0,'C');


    $this->Cell(127);
    $this->Cell(20,5,utf8_decode('CENTRO DE ESPECIALIDADES MÉDICAS'),0,0,'C');

    $this->Ln(4);
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode('CLÍNICO QUIRÚRGICO CESMED HOSPITAL DEL DÍA'),0,0,'C');

    $this->Cell(127);
    $this->Cell(20,5,utf8_decode('CLÍNICO QUIRÚRGICO CESMED HOSPITAL DEL DÍA'),0,0,'C');
    $this->Ln(4);
    // SLOGAN
    $this->SetFont('Arial','B',7);
    $this->SetTextColor(67, 184, 184);
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode('"Al cuidado de su Salud y la de su Familia"'),0,0,'C');

    $this->Cell(127);
    $this->Cell(20,5,utf8_decode('"Al cuidado de su Salud y la de su Familia"'),0,0,'C');
    $this->Ln(4);
    //DIRECCIÓN
    $this->SetFont('Arial','BI', 8);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode('Dirección: Av. San Francisco y Uruguay (esquina) - Tulcán - Ecuador'),0,0,'C');

    $this->Cell(127);
    $this->Cell(20,5,utf8_decode('Dirección: Av. San Francisco y Uruguay (esquina) - Tulcán - Ecuador'),0,0,'C');
    $this->Ln(4);
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode('Teléfono: 2986771 - cesmedtulcan@hotmail.com'),0,0,'C');

    $this->Cell(127);
    $this->Cell(20,5,utf8_decode('Teléfono: 2986771 - cesmedtulcan@hotmail.com'),0,0,'C');
    $this->Ln(6);
    //DIVISION
    $this->Cell(5);
    $this->SetFillColor(67, 184, 184);
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');


    $this->Cell(28);
    $this->SetFillColor(67, 184, 184);
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,0,'C');
    $this->Cell(7,1,"",0,0,'C',true);
    $this->Cell(1,1,"",0,1,'C');

    $this->SetFont('Arial','B', 10);
    $this->SetFillColor(255,255,255);
    $this->Cell(5);
    $this->Cell(35,8,'',0,0,'C',true);
    $this->Cell(49,8,utf8_decode(""),0,0,'C',true);
    $this->SetFont('Arial','B', 12);
    $this->SetTextColor(245,27,27);
    $this->Cell(35,8,$iniciales.'-'.$id_med_rec.'-'.$med_sec,0,0,'R',true);

    $this->Cell(29);
    $this->SetFont('Arial','B', 10);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(35,8,'',0,0,'C',true);
    $this->Cell(49,8,utf8_decode(""),0,0,'C',true);
    $this->SetFont('Arial','B', 12);
    $this->SetTextColor(245,27,27);
    $this->Cell(35,8,$iniciales.'-'.$id_med_rec.'-'.$med_sec,0,0,'R',true);

    // Salto de línea
    $this->Ln(5);

    $this->SetFont('Arial','BI',9);
    $this->SetY(37);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(5);
    $this->Cell(20,5,utf8_decode('SERVICIO/ESPECIALIDAD: '),0,0,'L');
    $this->SetFont('Arial','',9);
    $this->SetTextColor(35, 35, 35);
    $this->Cell(30);
    $this->Cell(20,5,utf8_decode(substr(' *'.$especialidad.'*',1)),0,0,'L');

    //Lado derecho
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(77);
    $this->Cell(20,5,utf8_decode('Tulcán, '.$dia.' de '.$mes.' del '.$año),0,0,'L');
    $this->Ln(6);

    //Lado izquierdo
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(5);
    $this->Cell(20,5,utf8_decode('Tulcán, '.$dia.' de '.$mes.' del '.$año),0,0,'L');
    $this->Ln(6);

    $this->SetFont('Arial','',10);
    $this->SetTextColor(34, 35, 35);
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode($apellidos_paci1.' '.$apellidos_paci2.' '.$nombres_paci1.' '.$nombres_paci2),0,0,'C');

    //Lado derecho
    $this->SetFont('Arial','',10);
    $this->SetTextColor(34, 35, 35);
    $this->Cell(127);
    $this->Cell(20,5,utf8_decode($apellidos_paci1.' '.$apellidos_paci2.' '.$nombres_paci1.' '.$nombres_paci2),0,0,'C');
    $this->Ln(6);

    //Lado izquiero
    $this->Cell(5);
    $this->SetDrawColor(34, 68, 93);
    $this->Cell(120,1,"",'T',0,'C');

    $this->Cell(27);
    $this->SetDrawColor(34, 68, 93);
    $this->Cell(120,1,"",'T',0,'C');
    $this->Ln(1);

    //Lado izquierdo
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode('Apellidos y Nombres del Paciente'),0,0,'C');

    //Lado derecho
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(127);
    $this->Cell(20,5,utf8_decode('Apellidos y Nombres del Paciente'),0,0,'C');
    $this->Ln(7);
      
    
}

// Pie de página
function Footer()
{
    global $apellidos_medi;
    global $sufijo;
    global $nombres_medi;
    global $celular_medi;
    // Posición: a 1,5 cm del final
    
    
    $this->SetY(-20);
    // Arial italic 10
    $this->SetFont('Arial','',10);
    $this->SetTextColor(35, 35, 35); 
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode($sufijo.' '.$apellidos_medi.' '.$nombres_medi),0,0,'C');
    $this->Ln(6);
    $this->SetFont('Arial','',10);
    $this->SetTextColor(34, 68, 93); 
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode('DATOS DEL PRESCRIPTOR'),0,0,'C');
    $this->Ln(4);
    $this->SetFont('Arial','',10);
    $this->SetTextColor(34, 68, 93); 
    $this->Cell(55);
    $this->Cell(20,5,utf8_decode('Apellidos y Nombres'),0,0,'C');

    // Posición: a 1,5 cm del final
    $this->SetY(-26);
    $this->SetFont('Arial','',10);
    $this->SetTextColor(35, 35, 35); 
    $this->Cell(202);
    $this->Cell(20,5,utf8_decode($sufijo.' '.$apellidos_medi.' '.$nombres_medi),0,0,'C');
    $this->Ln(6);
    $this->SetFont('Arial','',10);
    $this->SetTextColor(34, 68, 93); 
    $this->Cell(202);
    $this->Cell(20,5,utf8_decode('DATOS DEL PRESCRIPTOR'),0,0,'C');
    $this->Ln(4);
    $this->Cell(202);
    $this->Cell(20,5,utf8_decode('Apellidos y Nombres'),0,0,'C');
    $this->Ln(6);
    $this->Cell(190);
    $this->Cell(20,5,utf8_decode('NÚMERO DE CONTACTO: '),0,0,'C');
    $this->SetFont('Arial','',10);
    $this->SetTextColor(35, 35, 35); 
    $this->Cell(13);
    $this->Cell(20,5,$celular_medi,0,0,'C');

}
}

// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//CONSULTA DIAGNOSTICO
$query2 = "SELECT ci.id_cita, dc.clave
          FROM cita as ci
          INNER JOIN diagnostico as di
            ON ci.id_cita = di.id_cita
          INNER JOIN diagnosticoscie10 as dc
            ON di.id_cie = dc.id
          WHERE ci.id_cita='$id_cita'";

$result2 = mysqli_query($conn, $query2);
if(!$result2) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result2)) {
    $cie = $row['clave'];
}
//CIERRE DIAGNOSTICO

//CONSULTA ALERGIAS
$query3 = "SELECT * FROM alergia WHERE id_paciente='$id_paciente'";

$result3 = mysqli_query($conn, $query3);
if(!$result3) {
    die('Consulta fallida'. mysqli_error($conn));
}

$alergias = array();
while($row = mysqli_fetch_array($result3)) {
    $alergias[] = array(
    'descripcion' => $row['descripcion']
    );
}
$alergia = "";
for ($i=0; $i < sizeof($alergias); $i++) { 
  $alergia = $alergia.' '.$alergias[$i]['descripcion'].' ';
}

//Consulta Planes de Tratamiento
$query4 = "SELECT * FROM plan_t where id_cita = '{$id_cita}'";
    
$result4 = mysqli_query($conn, $query4);
if(!$result4) {
    die('Consulta fallida'. mysqli_error($conn));
}

$recetas = array();
while($row = mysqli_fetch_array($result4)) {
    $recetas[] = array(
    'datos_m' => $row['datos_m'],
    'via_a' => $row['via_a'],
    'cantidad' => $row['cantidad'],
    'indicaciones' => $row['indicaciones'],
    );
}

//CIERRE ALERGIAS


//------------------------------------------- CARA IZQUIERDA -----------------------------
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(34, 68, 93);
$pdf->Cell(5);
$pdf->Cell(30,5,'H. Clinica:','LTR',0,'L');
$pdf->Cell(20,5,'CIE:','LTR',0,'L');
$pdf->Cell(70,5,'Antecedentes de Alergias:','LTR',0,'L');
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(35, 35, 35);
$pdf->SetY(68);
$pdf->Cell(5);
$pdf->Cell(30,5,$cedula_paci,'LBR',0,'L');
if (!empty($cie)) {
  $pdf->Cell(20,5,$cie,'LBR',0,'L');
}else{
  $pdf->Cell(20,5,'','LBR',0,'L');
}
if (empty($alergia)) {
  $pdf->Cell(70,5,'NO','LBR',1,'L');
}else{
  $pdf->Cell(70,5,utf8_decode('SÍ - '.mb_strtolower(substr($alergia,1))),'LBR',1,'L');
}
$pdf->Cell(5);
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(34, 68, 93);
$pdf->Cell(30,5,'Sexo:','LTR',0,'L');
$pdf->Cell(40,5,'Nacionalidad:','LTR',0,'L');
$pdf->Cell(50,5,'Edad:','LTR',0,'L');
$pdf->SetY(78);
$pdf->Cell(5);
$pdf->SetFont('Arial','',8);
$pdf->Cell(30,5,$genero,'LBR',0,'L');
$pdf->Cell(40,5,$nacionalidad,'LBR',0,'L');
// codigo insertado 10/01/2023 DCH
$edad = calcular_edad($fechan_paci);
if(($edad->format('%Y')==0) &&($edad->format('%m')==0))
{
    $pdf->Cell(50,5,"",'LBR',1,'L');
}
else
{
$pdf->Cell(50,5,$edad->format('%Y').utf8_decode(' años, ').$edad->format('%m').' meses','LBR',1,'L');
}
// fin modificacion del codigo

//RECETAS DEL MEDICAMENTO

$pdf->SetY(85);
$pdf->Cell(5);
$pdf->SetFont('Arial','B',7);
$pdf->SetTextColor(34, 68, 93);
$pdf->Cell(60,4,'DATOS DEL MEDICAMENTO','LRT',0,'C');
$pdf->SetY(89);
$pdf->Cell(5);
$pdf->SetFont('Arial','B',6);
$pdf->Cell(60,3,utf8_decode('(dci, concentración y forma farmacéutica)'),'LRB',0,'C');
$pdf->SetY(85);
$pdf->Cell(65);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(35,7,utf8_decode('VÍA DE ADMINISTRACIÓN'),1,0,'C');
$pdf->Cell(25,7,'CANTIDAD',1,1,'C');

$rece_start = 92;
$aux_y = 0;
$y_total_cel = 0; // Posición final de Y al rellenar las celdas

//Celdas para rellenar Vía de Administración Y cantidad
/*
for ($i=0; $i < 23; $i++) { 
  $pdf->Cell(5);
  $pdf->SetFillColor(255, 255, 255);
  $pdf->SetXY($x_2, ($rece_start+($i*4)));
  $pdf->Cell(35,4,'',1,0,'C', true);
  $pdf->SetXY($x_3, ($rece_start+($i*4)));
  $pdf->Cell(25,4,'',1,1,'C', true);
}
*/

$y_total_cel = $pdf->getY();

if (sizeof($recetas) > 0) {
  for ($i=0; $i < sizeof($recetas); $i++) {
      if(($recetas[$i]['cantidad'])>0)
      {
        $pdf->Cell(5);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(35, 35, 35);
       
        $pdf->SetXY($x_1, $rece_start);
        $pdf->Multicell(60,4,utf8_decode('*'.ucfirst(mb_strtolower($recetas[$i]['datos_m']))." - ".ucfirst(mb_strtolower(trim($recetas[$i]['indicaciones']))).'*'),1,'L');
        $largo_cadena=strlen(utf8_decode('*'.ucfirst(mb_strtolower($recetas[$i]['datos_m']))." - ".ucfirst(mb_strtolower(trim($recetas[$i]['indicaciones']))).'*'));
        $lineas=($largo_cadena/53);
       
        $entero = intval($lineas);
        $decimal = $lineas - $entero;
        if($decimal>0)
        {
            $decimal=1;
        }
        $lineas=$entero+$decimal;
        
        $aux_y = $pdf->getY();
        $pdf->SetXY($x_2, $rece_start);
        $pdf->Cell(35,(4*$lineas),utf8_decode('*'.ucfirst(mb_strtolower($recetas[$i]['via_a'])).'*'),1,1,'C');
        $pdf->SetXY($x_3, $rece_start);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(25,(4*$lineas),utf8_decode('*'.$recetas[$i]['cantidad'].' ('.mb_strtolower(rtrim ($numeroaletras->convertir(floatval($recetas[$i]['cantidad'])))).')*'),'LTR',1,'C');
        $pdf->Cell(100);
        
        $rece_start = $aux_y;
      }
        
  }

  $tot_rellenar = ((184 - $rece_start)/4);
  $pdf->SetY($rece_start);
  for ($i=0; $i < $tot_rellenar; $i++) { 
        $pdf->Cell(5);
        $pdf->SetFillColor(235, 235, 235);
        $pdf->Cell(60,4,'',1,0,'C',true);
        $pdf->SetXY($x_2, ($rece_start+($i*4)));
        $pdf->Cell(35,4,'',1,0,'C', true);
        $pdf->SetXY($x_3, ($rece_start+($i*4)));
        $pdf->Cell(25,4,'',1,1,'C', true);
  }

}else{
    
  $pdf->SetY(92);
  for ($i=0; $i < 23; $i++) { 
    $pdf->Cell(5);
    $pdf->SetFillColor(235, 235, 235);
    $pdf->Cell(60,4,'',1,0,'C', true);
    $pdf->Cell(35,4,utf8_decode(''),1,0,'C', true);
    $pdf->Cell(25,4,'',1,1,'C', true);
    
  }
  
}


//------------------------------------- FIN CARA IZQUIERDA------------------------------------
//------------------------------------- INICIO CARA DERECHA ----------------------------------
$x=161;
$y=60;
$pdf->SetXY($x,$y);
//Traer indicaciones del plan de tratamiento

$pdf->SetFont('Arial','',15);
$pdf->Cell(70,10,'Indicaciones:',0,1,'L');
$y+=10;
$pdf->SetXY($x,$y);

$indicaciones = '';
for ($i=0; $i < sizeof($recetas); $i++) { 
    if($recetas[$i]['datos_m']==""){
        $indicaciones = $indicaciones."\n *"."MEDICAMENTO DEL PACIENTE"."* \n      *".ucfirst(mb_strtolower(trim($recetas[$i]['indicaciones'])))."*.";
    }else{
        $indicaciones = $indicaciones."\n *".$recetas[$i]['datos_m']."* \n      *".ucfirst(mb_strtolower(trim($recetas[$i]['indicaciones'])))."*.";
    }
}




//Fin Plan de tratamiento


$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(35, 35, 35);
$pdf->MultiCell(120,5,utf8_decode(substr($indicaciones, 1)),0,'L');

$salto=round((strlen($indicaciones)/55),0,PHP_ROUND_HALF_UP);

$y=$y+($salto*5)+10;
$pdf->SetXY($x,$y);


//Signos de Alarma
$pdf->SetTextColor(34, 68, 93);
$pdf->SetFont('Arial','',10);
$pdf->Cell(25,7,'Signos de Alarma:',0,0,'L');
$pdf->Cell(10);
if (!empty($signos_a)) {
  $pdf->Cell(7,7,utf8_decode('SÍ'),0,0,'L');
  $pdf->Cell(8,7,'X',1,0,'C');
  $pdf->Cell(6);
  $pdf->Cell(8,7,'NO',0,0,'L');
  $pdf->Cell(8,7,'',1,1,'L');
  $y+=7;
  $pdf->SetXY($x,$y);
  $pdf->SetTextColor(35, 35, 35);
  $pdf->MultiCell(120,5,'*'.utf8_decode($signos_a).'*',0,'L');
  $y+=5;
}else{
  $pdf->Cell(7,7,utf8_decode('SÍ'),0,0,'L');
  $pdf->Cell(8,7,'',1,0,'L');
  $pdf->Cell(6);
  $pdf->Cell(8,7,'NO',0,0,'L');
  $pdf->Cell(8,7,'X',1,1,'C');
  $y+=7;
  $pdf->SetXY($x,$y);
  $pdf->SetTextColor(35, 35, 35);
  $pdf->MultiCell(120,5,'',0,'L');
}


//Recomendaciones no farmacológicas
$pdf->Cell(26);
$pdf->SetFont('Arial','',10);
$pdf->SetTextColor(34, 68, 93);
$pdf->SetXY(161,$y);
$pdf->Cell(25,7,utf8_decode('Recomendaciones NO Farmacológicas:'),0,1,'L');
$y+=5;

if (!empty($recomendaciones_nf)) {
  $pdf->SetXY(161,$y);
  $pdf->SetTextColor(35, 35, 35);
  $pdf->SetFont('Arial','',10);
  $pdf->MultiCell(120,5,'*'.utf8_decode($recomendaciones_nf).'*',0,'L');
  $y+=5;
}else{
  $pdf->SetXY(161,160);
  $pdf->MultiCell(120,5,'',0,'L');
}

//----------------------------------------  FIN CARA DERECHA ------------------------------------

$pdf->Output("reporte_receta.pdf","I",true);
?>