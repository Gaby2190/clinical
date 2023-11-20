<?php
require('../FPDF/fpdf.php');
include('../../dbconnection.php');
require_once('../lib/numeroaletras.php');
date_default_timezone_set('America/Guayaquil'); 
$id_cita = $_GET['id_cita'];

$modelonumero = new modelonumero();
$numeroaletras = new numeroaletras();


class PDF extends FPDF
{
  function Header()
  {
    $this->Image('../../assets/images/marca_agua.jpeg',10,33,70);
   // $this->Image('../../assets/images/no_valido.png',60,140,100);
  }
}


$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();


#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(true,9); 

$query_1 = "SELECT ci.id_caso, ci.t_contingencia, ci.fecha,ci.dias_reposo, ci.detalle_certificado, ca.fecha_registro, ca.fecha_alta, ca.c_alta, ca.t_tratamiento, ca.proc_cq, ca.semana_embarazo, esp.nombre as especialidad, me.nautorizacion_medi,me.sufijo,me.apellidos_medi,me.nombres_medi, me.correo_medi, me.telefono_medi,me.celular_medi, pa.*, ge.nombre as genero, na.nombre as nacionalidad
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
            WHERE ci.id_cita='$id_cita'";

$result_1 = mysqli_query($conn, $query_1);
if(!$result_1) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result_1)) {
    $id_caso = $row['id_caso'];
    $fecha_registro = $row['fecha_registro'];
    $fecha = $row['fecha'];
    $fecha_alta = $row['fecha_alta'];
    $dias_reposo = $row['dias_reposo'];
    $c_alta = $row['c_alta'];
    $t_tratamiento = $row['t_tratamiento'];
    $t_contingencia = $row['t_contingencia'];
    $proc_cq = $row['proc_cq'];
    $s_embarazo = $row['semana_embarazo'];
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
    //$correo_paci = $row['correo_paci'];
    $direccion_paci = $row['direccion_paci'];
    //$barrio_paci = $row['barrio_paci'];
    $parroquia_paci = $row['parroquia_paci'];
    //$canton_paci = $row['canton_paci'];
    $provincia_paci = $row['provincia_paci'];
    //$zona_paci = $row['zona_paci'];
    //$lnacimiento_paci = $row['lnacimiento_paci'];
    //$gcultural_paci = $row['gcultural_paci'];
    //$ecivil_paci = $row['ecivil_paci'];
    //$instruccion_paci = $row['instruccion_paci'];
    $ocupacion_paci = $row['ocupacion_paci'];
    $empresat_paci = $row['empresat_paci'];
    //$ssalud_paci = $row['ssalud_paci'];
    //$referido_paci = $row['referido_paci'];
    $contacto_dir = $row['contacto_dir'];
    $contacto_nom = $row['contacto_nom'];   
    $contacto_ape = $row['contacto_ape']; 
    $contacto_par = $row['contacto_par'];
    $contacto_num = $row['contacto_num'];
    $genero = $row['genero'];
    $nacionalidad = $row['nacionalidad'];
    //$sangre = $row['sangre'];
    $sufijo = $row['sufijo'];
    $apellidos_medi = $row['apellidos_medi'];
    $nombres_medi = $row['nombres_medi'];
    $correo_medi = $row['correo_medi'];
    $telefono_medi = $row['telefono_medi'];
    $celular_medi = $row['celular_medi'];
    $detalle_certificado = $row['detalle_certificado'];
}

//Funcion calcular edad 
function calcular_edad($fecha){
    $fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); 
    $fecha_hoy =  new DateTime(date('Y/m/d',time())); 
    $edad = date_diff($fecha_hoy,$fecha_nac); 
    return $edad;
};

$edad_paci = calcular_edad($fechan_paci);

//==================Primera página==================
$pdf->AddPage();
$pdf->SetDrawColor(34, 68, 93);
$pdf->Cell(190,277,"",1,0);

//LOGO
$pdf->Image('../../assets/images/logo_reporte.png',13,10,55,20);
$pdf->SetY(35);

$pdf->SetFont('Times','B', 15);
$pdf->Cell(190,10,utf8_decode('CERTIFICADO MÉDICO'),0,1,'C');

$fecha_act = new DateTime($fecha);
$dia=$fecha_act->format('d');
$m=$fecha_act->format('m');
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


$pdf->SetFont('Times','', 13);
$pdf->Cell(20);
$pdf->Cell(150,10,utf8_decode("Tulcán, ".$dia." de ".$mes." de ".$año),0,1,'R');

$pdf->Ln(5);
$pdf->SetFont('Times','', 11);
$pdf->Cell(20);
$pdf->Multicell(150,6,utf8_decode("El que suscribe, médico del servicio: ".$especialidad."."),0,'L');

if ($genero == "MASCULINO") {
    $pdf->Cell(20);
    $pdf->Multicell(150,6,utf8_decode("Certifico haber atendido al paciente ".$nombres_paci1." ".$nombres_paci2." ".$apellidos_paci1." ".$apellidos_paci2." de ".$edad_paci->format('%Y')." años ".$edad_paci->format('%m')." meses de edad con C.I. ".$cedula_paci."."),0,'J');  
}
if ($genero == "FEMENINO") {
    if (intval($s_embarazo)>0) {
      if (intval($s_embarazo)==1) {
        $pdf->Cell(20);
        $pdf->Multicell(150,6,utf8_decode("Certifico haber atendido a la paciente ".$nombres_paci1." ".$nombres_paci2." ".$apellidos_paci1." ".$apellidos_paci2." de ".$edad_paci->format('%Y')." años ".$edad_paci->format('%m')." meses de edad con C.I. ".$cedula_paci.". Con ".$s_embarazo." semana de embarazo."),0,'J');
      }else{
        $pdf->Cell(20);
        $pdf->Multicell(150,6,utf8_decode("Certifico haber atendido a la paciente ".$nombres_paci1." ".$nombres_paci2." ".$apellidos_paci1." ".$apellidos_paci2." de ".$edad_paci->format('%Y')." años ".$edad_paci->format('%m')." meses de edad con C.I. ".$cedula_paci.". Con ".$s_embarazo." semanas de embarazo."),0,'J');
      }
        
    }else{
        $pdf->Cell(20);
        $pdf->Multicell(150,6,utf8_decode("Certifico haber atendido a la paciente ".$nombres_paci1." ".$nombres_paci2." ".$apellidos_paci1." ".$apellidos_paci2." de ".$edad_paci->format('%Y')." años ".$edad_paci->format('%m')." meses de edad con C.I. ".$cedula_paci."."),0,'J');
                                                                                                                                                       
    }
}

$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(20,6,utf8_decode("Domicilio:"),0,0,'L');
$pdf->SetFont('Times','', 11);
$pdf->Multicell(130,6,utf8_decode(ucwords(mb_strtolower($provincia_paci.", ".$parroquia_paci.", ".$direccion_paci))),0,'L');

$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(18,6,utf8_decode("Teléfono:"),0,0,'L');
$pdf->SetFont('Times','', 11);
if ($telefono_paci == "") {
  $pdf->Multicell(132,6,utf8_decode($celular_paci),0,'L');
}else{
  $pdf->Multicell(132,6,utf8_decode($celular_paci." / ".$telefono_paci),0,'L');
}

$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(30,6,utf8_decode("Historia Clínica:"),0,0,'L');
$pdf->SetFont('Times','', 11);
$pdf->Multicell(120,6,utf8_decode($cedula_paci),0,'L');

$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(40,6,utf8_decode("Tipo de Contingencia:"),0,0,'L');
$pdf->SetFont('Times','', 11);
$pdf->Multicell(110,6,utf8_decode($t_contingencia),0,'L');

$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(33,6,utf8_decode("Actividad Laboral:"),0,0,'L');
$pdf->SetFont('Times','', 11);
$pdf->Multicell(117,6,utf8_decode(ucwords(mb_strtolower($ocupacion_paci))),0,'L');

$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(32,6,utf8_decode("Lugar de Trabajo:"),0,0,'L');
$pdf->SetFont('Times','', 11);
$pdf->Multicell(118,6,utf8_decode(ucwords(mb_strtolower($empresat_paci))),0,'L');

$pdf->Ln(5);

$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(35,6,utf8_decode("DIAGNÓSTICO:"),0,1,'L');


$query7 = "SELECT dia.*, cie.clave, ci.fecha 
            FROM diagnostico as dia 
            INNER JOIN diagnosticoscie10 as cie 
              ON dia.id_cie = cie.id 
            INNER JOIN cita as ci 
              ON dia.id_cita = ci.id_cita 
            INNER JOIN caso as ca 
              ON ci.id_caso = ca.id_caso 
            WHERE ca.id_caso = '$id_caso' ORDER BY ci.fecha DESC";
$result7 = mysqli_query($conn, $query7);
if(!$result7) {
    die('Consulta fallida'. mysqli_error($conn));
}
$diagnosticos = array();
while($row = mysqli_fetch_array($result7)) {
    $diagnosticos[] = array(
    'descripcion' => $row['descripcion'],
    'pre_def' => $row['pre_def'],
    'clave' => $row['clave'],
    'diagnostico_esp' => $row['diagnostico_esp']
    
    );
}

$pdf->Cell(20);
$pdf->Multicell(150,6,utf8_decode("- ".mb_strtoupper($diagnosticos[0]['descripcion'])." (CIE10: ".$diagnosticos[0]['clave'].")."),0,'L');
if (strlen($diagnosticos[0]['descripcion'])>0)
{
    $pdf->SetFont('Times','', 11);
    $pdf->Cell(20);
    $pdf->Multicell(150,6,utf8_decode("DIAGNÓSTICO ESPECÍFICO: ".mb_strtoupper($diagnosticos[0]['diagnostico_esp'])."."),0,'L');
}
$pdf->Ln(5);

$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(32,6,utf8_decode("Fecha de Ingreso:"),0,0,'L');
$pdf->SetFont('Times','', 11);

$fecha_ing = new DateTime($fecha_registro);
$dia_ing=$fecha_ing->format('d');
$m_ing=$fecha_ing->format('m');
switch ($m_ing) {
  case 1:
    $mes_ing='enero';
    break;
  case 2:
    $mes_ing='febrero';
    break;
  case 3:
    $mes_ing='marzo';
    break;
  case 4:
    $mes_ing='abril';
    break;
  case 5:
    $mes_ing='mayo';
    break;
  case 6:
    $mes_ing='junio';
    break;
  case 7:
    $mes_ing='julio';
    break;
  case 8:
    $mes_ing='agosto';
    break;
  case 9:
    $mes_ing='septiembre';
    break;
  case 10:
    $mes_ing='octubre';
    break;
  case 11:
    $mes_ing='noviembre';
    break;
  case 12:
    $mes_ing='diciembre';
    break;
}
$año_ing=$fecha_ing->format('Y');

$pdf->Multicell(118,6,utf8_decode("(".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($dia_ing)))).") ".$dia_ing." de ".$mes_ing." de ".$año_ing),0,'L');


$pdf->SetFont('Times','B', 11);
$pdf->Cell(20);
$pdf->Cell(32,6,utf8_decode("Fecha de Egreso:"),0,0,'L');
$pdf->SetFont('Times','', 11);

$pdf->Multicell(118,6,utf8_decode("(".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($dia)))).") ".$dia." de ".$mes." de ".$año),0,'L');



if (intval($dias_reposo)>0) {
  $pdf->SetFont('Times','B', 11);
  $pdf->Cell(20);
  $pdf->Cell(55,6,utf8_decode("Nro. De días de reposo absoluto:"),0,0,'L');
  $pdf->SetFont('Times','', 11);
  if (intval($dias_reposo)==1) {
    $pdf->Multicell(95,6,utf8_decode(" (".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($dias_reposo)))).") ".$dias_reposo." día"),0,'L');
  }else{
    $pdf->Multicell(95,6,utf8_decode(" (".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($dias_reposo)))).") ".$dias_reposo." días"),0,'L');
  }

  $str_rep = '+'.(intval($dias_reposo)-1).' day';
 
 
  $nuevaFecha = date("Y-m-d",strtotime ( $fecha." ".$str_rep ) );
  $fecha_des = new DateTime($nuevaFecha);

  $dia_des=$fecha_des->format('d');
  $m_des=$fecha_des->format('m');
  switch ($m_des) {
    case 1:
      $mes_des='enero';
      break;
    case 2:
      $mes_des='febrero';
      break;
    case 3:
      $mes_des='marzo';
      break;
    case 4:
      $mes_des='abril';
      break;
    case 5:
      $mes_des='mayo';
      break;
    case 6:
      $mes_des='junio';
      break;
    case 7:
      $mes_des='julio';
      break;
    case 8:
      $mes_des='agosto';
      break;
    case 9:
      $mes_des='septiembre';
      break;
    case 10:
      $mes_des='octubre';
      break;
    case 11:
      $mes_des='noviembre';
      break;
    case 12:
      $mes_des='diciembre';
      break;
  }
  $año_des=$fecha_des->format('Y');
  
  $pdf->SetFont('Times','B', 11);
  $pdf->Ln(5);
  $pdf->Cell(20);
  $pdf->Multicell(150,6,utf8_decode("Desde el ".$dia."/".$m."/".$año." (".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($dia))))." de ".$mes." del ".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($año)))).") hasta ".($dia_des)."/".$m_des."/".$año_des." (".mb_strtolower(rtrim ($numeroaletras->convertir(floatval(($dia_des)))))." de ".$mes_des." del ".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($año_des)))).")"),0,'L');
}

$pdf->Ln(5);
$pdf->Cell(20);
$pdf->SetFont('Times','', 11);
if (trim($detalle_certificado)) {
  $detalle_certificado = "NOTA: " . ucfirst(mb_strtolower($detalle_certificado)) . ".";
}
if ($genero == "MASCULINO") {
  $pdf->Multicell(150,6,utf8_decode($detalle_certificado. "\n" . "En consecuencia el paciente ".$nombres_paci1." ".$nombres_paci2." ".$apellidos_paci1." ".$apellidos_paci2." puede hacer uso del presente certificado como considere necesario."),0,'L');
}
if ($genero == "FEMENINO") {
  $pdf->Multicell(150,6,utf8_decode($detalle_certificado. "\n" . "En consecuencia la paciente ".$nombres_paci1." ".$nombres_paci2." ".$apellidos_paci1." ".$apellidos_paci2." puede hacer uso del presente certificado como considere necesario."),0,'L');
}


$pdf->Ln(5);
$pdf->Cell(20);
$pdf->Cell(40,6,utf8_decode("Atentamente,"),0,0,'L');

$pdf->Ln(35);
$pdf->SetFont('Times','BI', 11);
$pdf->Cell(20);
$pdf->Cell(150,6,utf8_decode($sufijo." ".$nombres_medi." ".$apellidos_medi),0,1,'C');
$pdf->Cell(20);
$pdf->Cell(150,6,utf8_decode($especialidad),0,1,'C');
$pdf->Cell(20);
$pdf->Cell(150,6,utf8_decode("MSP. ".$nautorizacion_medi),0,1,'C');
$pdf->Cell(20);
$pdf->Cell(150,6,utf8_decode($correo_medi),0,1,'C');
$pdf->Cell(20);
if ($telefono_medi == "") {
  $pdf->Cell(150,6,utf8_decode("Telf. ".$celular_medi),0,1,'C');
}else{
  $pdf->Cell(150,6,utf8_decode("Telf. ".$celular_medi." / ".$telefono_medi),0,1,'C');
}

$pdf->Image('../../assets/images/fotter_cm.jpeg',80,278,120,9);

$pdf->Output("certificado_medico.pdf","I",true);
?>