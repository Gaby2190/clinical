<?php
require_once '../FPDF/fpdf.php';
include_once '../../dbconnection.php';
include_once '../../variables.php';
$id_medico = $_GET['id_medico'];
$id_pago = $_GET['id_pago'];

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

    $query_sec = "SELECT MAX(secuencial) AS max_secuencial
               FROM receta WHERE id_medico = '{$id_medico}' AND id_cita = '{$id_cita}'";
    global $conn;
    $result_sec = mysqli_query($conn, $query_sec);
    if(!$result_sec) {
        die('Consulta fallida'. mysqli_error($conn));
    }
    while($row = mysqli_fetch_array($result_sec)) {
        $sec = floatval($row['max_secuencial']);
    }
    $len_id_sec = 6;
    $med_sec = substr(str_repeat(0, $len_id_sec).$sec, - $len_id_sec);
    //LOGO
    $this->Image('../../assets/images/logo_rce.jpeg',15,6,20);
    //TÍTULO
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(34, 68, 93); 
    $this->SetY(5);
    $this->Cell(85);
    $this->Cell(20,5,utf8_decode('CENTRO DE ESPECIALIDADES MÉDICAS'),0,0,'C');
    $this->Ln(4);
    $this->Cell(85);
    $this->Cell(20,5,utf8_decode('CLÍNICO QUIRÚRGICO CESMED HOSPITAL DEL DÍA'),0,0,'C');
    $this->Ln(4);
    // SLOGAN
    $this->SetFont('Arial','B',7);
    $this->SetTextColor(67, 184, 184);
    $this->Cell(85);
    $this->Cell(20,5,utf8_decode('"Al cuidado de su Salud y la de su Familia"'),0,0,'C');

    $this->Ln(4);
    //DIRECCIÓN
    $this->SetFont('Arial','BI', 8);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(85);
    $this->Cell(20,5,utf8_decode('Dirección: Av. San Francisco y Uruguay (esquina) - Tulcán - Ecuador'),0,0,'C');
    $this->Ln(4);
    $this->Cell(85);
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

    // Salto de línea
    $this->Ln(5);
   // $this->Image('../../assets/images/no_valido.png',60,140,100);
}
 
}

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(34, 68, 93); 
$pdf->Cell(57);
$len_id_sec = 6;
$pago_sec = substr(str_repeat(0, $len_id_sec).$id_pago, - $len_id_sec);

$pdf->Cell(75,5,utf8_decode('COMPROBANTE DE PAGO'),0,0,'C');

$pdf->SetFont('Arial','B', 12);
$pdf->SetTextColor(245,27,27);
$pdf->Cell(55,5,utf8_decode("N° ".$pago_sec),0,1,'R');
$pdf->Ln(2);
$pdf->SetFont('Arial','B',12);
$pdf->SetTextColor(34, 68, 93); 
//Query médico
$query = "SELECT ci.*, ca.id_medico, ca.id_paciente, me.sufijo, me.nombres_medi, me.tarifa, me.tarifa_control, me.comision_c, me.comision_a, me.apellidos_medi, me.celular_medi, pa.nombres_paci1, pa.apellidos_paci1 , pa.nombres_paci2, pa.apellidos_paci2, pa.fechan_paci, pa.cedula_paci, na.nombre as nacionalidad, ge.nombre as genero
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
          WHERE ca.id_medico='$id_medico' ORDER BY ci.id_cita DESC";

$result = mysqli_query($conn, $query);
if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result)) {
    $fecha = $row['fecha'];
    $signos_a = $row['signos_a'];
    $recomendaciones_nf = $row['recomendaciones_nf'];
    $id_caso = $row['id_caso'];
    $id_medico = $row['id_medico'];
    $id_paciente = $row['id_paciente'];
    $sufijo = $row['sufijo'];
    $nombres_medi = $row['nombres_medi'];
    $apellidos_medi = $row['apellidos_medi'];
    $celular_medi = $row['celular_medi'];
    $tarifa = $row['tarifa'];
    $tarifa_control = $row['tarifa_control'];
    $comision_c = $row['comision_c'];
    $tipo_cita = $row['tipo_cita'];
    $comision_a = $row['comision_a'];
    $nombres_paci1 = $row['nombres_paci1'];
    $apellidos_paci1 = $row['apellidos_paci1'];
    $nombres_paci2 = $row['nombres_paci2'];
    $apellidos_paci2 = $row['apellidos_paci2'];
    $fechan_paci = $row['fechan_paci'];
    $cedula_paci = $row['cedula_paci'];
    $nacionalidad = $row['nacionalidad'];
    $genero = $row['genero'];
}

 
//Query citas cobradas
 $query_cb = "SELECT ci.*, ca.id_medico, ca.id_paciente,me.sufijo, me.nombres_medi, me.apellidos_medi, pa.nombres_paci1, pa.apellidos_paci1, pa.nombres_paci2, pa.apellidos_paci2, me.tarifa, me.tarifa_control, pag.fecha_gen, am.valor, am.id_seguro, fp.nombre, cp.costo
                FROM cita AS ci
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON me.id_medico = ca.id_medico
                INNER JOIN paciente AS pa
                    ON pa.id_paciente = ca.id_paciente
                INNER JOIN detalle_pago as d_pa
                    ON ci.id_cita = d_pa.id_cita
                INNER JOIN pago as pag
                    ON d_pa.id_pago = pag.id_pago
                INNER JOIN cita_pago as cp
                	ON cp.id_cita = ci.id_cita
                INNER JOIN f_pago as fp
                	ON fp.id = cp.id_f_pago
                INNER JOIN asegu_med as am
                	ON am.id_seguro = fp.aseguradora and am.id_medico = ca.id_medico
                WHERE ci.id = '{$cita_finalizada}' AND ca.id_medico = '{$id_medico}' AND d_pa.id_pago = '{$id_pago}' GROUP BY ci.id_cita ORDER BY ci.id_cita ASC";
  //echo $query_cb;
    $result_cb = mysqli_query($conn, $query_cb);

  if(!$result_cb) {
    die('Error en consulta '.mysqli_error($conn));
  }

  $cita_c = array();
  while($row = mysqli_fetch_array($result_cb)) {
      $cita_c[] = array(
        'id_cita' => $row['id_cita'],
        'descripcion' => $row['descripcion'],
        'fecha' => $row['fecha'],
        'hora' => $row['hora'],
        'tipo_cita' => $row['tipo_cita'],
        'id' => $row['id'],
        'descuento' => $row['descuento'],
        'id_caso' => $row['id_caso'],
        'id_medico' => $row['id_medico'],
        'id_paciente' => $row['id_paciente'],
        'sufijo' => $row['sufijo'],
        'nombres_medi' => $row['nombres_medi'],
        'apellidos_medi' => $row['apellidos_medi'],
        'tarifa' => $row['tarifa'],
        'tarifa_control' => $row['tarifa_control'],
        'nombres_paci1' => $row['nombres_paci1'],
        'apellidos_paci1' => $row['apellidos_paci1'],
        'nombres_paci2' => $row['nombres_paci2'],
        'apellidos_paci2' => $row['apellidos_paci2'],
        'fecha_gen' => $row['fecha_gen'],
        'valor' => $row['valor'],
        'id_seguro' => $row['id_seguro'],
        'nombre' => $row['nombre'],
        'costo' => $row['costo']
      );
      
  }

$c_c=0;

$fecha_cor = new DateTime($cita_c[0]['fecha_gen']);
$dia=$fecha_cor->format('d');
$m=$fecha_cor->format('n');
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
$año=$fecha_cor->format('Y');

$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(34, 68, 93);
$pdf->Cell(5);
$pdf->Cell(90,5,utf8_decode('Médico: '.$sufijo.' '.$apellidos_medi.' '.$nombres_medi),0,0,'L');
$pdf->Cell(3);
$pdf->Cell(90,5,utf8_decode('Fecha Corte: '.$dia.' de '.$mes.' del '.$año),0,1,'R');
$pdf->Cell(5);

if (floatval($comision_c) > 5) {
  $pdf->Cell(90,5,utf8_decode('Comisión : '.$comision_c. ' % cada consulta'),0,0,'L');
}else{
  $pdf->Cell(90,5,utf8_decode('Comisión : '.$comision_c. ' dólares cada consulta'),0,0,'L');
}

$pdf->Cell(3);

$pdf->Cell(90,5,utf8_decode('Comisión Adicionales: '.$comision_a. ' % cada adicional'),0,1,'R'); 


$pdf->Ln(5);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(5); 
$pdf->Cell(9,5,utf8_decode('Cita N°'),1,0,'C');
$pdf->Cell(14,5,utf8_decode('Fecha'),1,0,'C');
$pdf->Cell(9,5,utf8_decode('Turno'),1,0,'C');
$pdf->Cell(59,5,utf8_decode('Paciente'),1,0,'C');
$pdf->Cell(12,5,utf8_decode('Consulta'),1,0,'C');
$pdf->Cell(14,5,utf8_decode('Descuento'),1,0,'C');
$pdf->Cell(15,5,utf8_decode('Adicionales'),1,0,'C');
$pdf->Cell(13,5,utf8_decode(''),1,0,'C');
$pdf->Cell(13,5,utf8_decode(''),1,0,'C');
$pdf->Cell(13,5,utf8_decode(''),1,0,'C');
$pdf->Cell(11,5,utf8_decode('TOTAL'),1,1,'C');

$consultas_t = 0;
$transferencia_b_t = 0;
$descuentos_t = 0;
$adicionales_t = 0;
$comision_ban_t = 0;
$retencion_cli_t = 0;
$otros_t = 0;
for ($i=0; $i < sizeof($cita_c); $i++) {
  $total = 0;
  $pdf->SetFont('Arial','',7);
  $pdf->Cell(5);
  $pdf->Cell(9,5,utf8_decode($cita_c[$i]['id_cita']),1,0,'C');
  $pdf->Cell(14,5,utf8_decode($cita_c[$i]['fecha']),1,0,'C');
  $pdf->Cell(9,5,utf8_decode(substr($cita_c[$i]['hora'], 0, -3).'h'),1,0,'C');
  $pdf->Cell(59,5,utf8_decode(ucwords(mb_strtolower($cita_c[$i]['nombres_paci1'].' '.$cita_c[$i]['nombres_paci2'].' '.$cita_c[$i]['apellidos_paci1'].' '.$cita_c[$i]['apellidos_paci2']))),1,0,'C');

  
  if ($cita_c[$i]['id_seguro']==1)
  {
    if (floatval($cita_c[$i]['tipo_cita'] == 1)) {
      $pdf->Cell(12,5,utf8_decode('$ '.number_format($cita_c[$i]['costo'],2)),1,0,'C');  
      $total = $total + floatval($cita_c[$i]['costo']);
      $consultas_t += floatval($cita_c[$i]['costo']);
    }
    if (floatval($cita_c[$i]['tipo_cita'] == 0)) {
      $pdf->Cell(12,5,utf8_decode('$ '.number_format($cita_c[$i]['costo'],2)),1,0,'C');
      $total = $total + floatval($cita_c[$i]['costo']);
      $consultas_t += floatval($cita_c[$i]['costo']);

    }
    if (floatval($comision_c) > 5) {
      $porcentaje=floatval($comision_c)/100;
      $c_c = floatval($consultas_t-$descuentos_t)*$porcentaje;
   
    }else{
      $c_c += floatval($comision_c);
      
    }

    
  }
  else
  {
      $pdf->Cell(12,5,utf8_decode('$ '.number_format($cita_c[$i]['valor'],2)),1,0,'C');  
      $total = $total + floatval($cita_c[$i]['valor']);
      $consultas_t += floatval($cita_c[$i]['valor']);
      
  }




  $pdf->Cell(14,5,utf8_decode('$ '.number_format($cita_c[$i]['descuento'],2)),1,0,'C');
  $total = $total - floatval($cita_c[$i]['descuento']);
  $descuentos_t += floatval($cita_c[$i]['descuento']);
  //Adicionales
  $query_ad = "SELECT * FROM adicional WHERE id_cita = '{$cita_c[$i]['id_cita']}'";
  $result_ad = mysqli_query($conn, $query_ad);
  if(!$result_ad) {
    die('Error en consulta '.mysqli_error($conn));
  }
  $adicionales = array();
  while($row = mysqli_fetch_array($result_ad)) {
      $adicionales[] = array(
        'costo' => $row['costo']
      );
      
  }
  $costo_ad = 0;
  for ($j=0; $j < sizeof($adicionales); $j++) { 
    $costo_ad += floatval($adicionales[$j]['costo']);
  }
  $pdf->Cell(15,5,utf8_decode('$ '.number_format($costo_ad,2)),1,0,'C');

  //Consulta transferencias Bancarias
  $query_tb = "SELECT costo FROM cita_pago WHERE id_cita = '{$cita_c[$i]['id_cita']}' AND id_f_pago = '$transferencia_b'";
    
  $result_tb = mysqli_query($conn, $query_tb);

  if(!$result_tb) {
      die('Consulta fallida'. mysqli_error($conn));
  }

  $transfer_b = array();
  while($row = mysqli_fetch_array($result_tb)) {
      $transfer_b[] = array(
        'costo' => $row['costo']
      );
      
  }
  $costo_tb = 0;
  for ($j=0; $j < sizeof($transfer_b); $j++) { 
    $costo_tb += floatval($transfer_b[$j]['costo']);
  }
  $pdf->Cell(13,5,utf8_decode('$ '.number_format($costo_tb,2)),1,0,'C');
  
  //Consultar Comisión y Retención
  $query_cbrc = "SELECT * FROM p_tarjeta WHERE id_cita = '{$cita_c[$i]['id_cita']}'";
  $result_cbrc = mysqli_query($conn, $query_cbrc);
  if(!$result_cbrc) {
    die('Error en consulta '.mysqli_error($conn));
  }
  $comision_ban = 0;
  $retencion_cli = 0;
  while($row = mysqli_fetch_array($result_cbrc)) {
        $comision_ban = $row['comision_ban'];
        $retencion_cli = $row['retencion_cli'];
  }
  $pdf->Cell(13,5,utf8_decode('$ '.number_format($comision_ban,2)),1,0,'C');
  $pdf->Cell(13,5,utf8_decode('$ '.number_format($retencion_cli,2)),1,0,'C');
  $total = $total + floatval($costo_ad);
  $adicionales_t += floatval($costo_ad);
  $transferencia_b_t += floatval($costo_tb);
  $comision_ban_t += floatval($comision_ban);
  $retencion_cli_t += floatval($retencion_cli);

  

  $pdf->Cell(11,5,utf8_decode('$ '.number_format($total,2)),1,1,'C');
}

$pdf->SetFont('Arial','BU',10);
$pdf->Ln(6);
$pdf->Cell(5); 
$pdf->Cell(15,5,utf8_decode('TOTALES'),0,1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(5); 
$pdf->Cell(37,5,utf8_decode('(C) Consultas:'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format($consultas_t,2)),0,0,'L');
$pdf->Cell(20); 
$pdf->Cell(60,5,utf8_decode('(NC) Número de Citas:'),0,0,'L');
$pdf->Cell(20,5,utf8_decode(sizeof($cita_c)),0,1,'L');
$pdf->Cell(5); 
$pdf->Cell(37,5,utf8_decode('(D) Descuentos:'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format($descuentos_t,2)),0,0,'L');
$pdf->Cell(20);
$pdf->Cell(60,5,utf8_decode('(TC) Total Consultas (C-D):'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format(($consultas_t-$descuentos_t),2)),0,1,'L');
$pdf->Cell(5); 
$pdf->Cell(37,5,utf8_decode('(A) Adicionales:'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format($adicionales_t,2)),0,0,'L');
$pdf->Cell(20);


$pdf->Cell(60,5,utf8_decode('(CC) Comisión Consulta:'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format($c_c,2)),0,1,'L');

$pdf->Cell(5); 
$pdf->Cell(37,5,utf8_decode('(CB) Comisión Banco:'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format($comision_ban_t,2)),0,0,'L');
$pdf->Cell(20); 
$pdf->Cell(60,5,utf8_decode('(CA) Comisión Adicionales (A x '.$comision_a.'%):'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format(($adicionales_t*$comision_a/100),2)),0,1,'L');
$pdf->Cell(5); 
$pdf->Cell(37,5,utf8_decode('(RC) Retención Clínica:'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format($retencion_cli_t,2)),0,0,'L');
$pdf->Cell(20);
$pdf->SetFont('Arial','B',9);

$pdf->Cell(60,5,utf8_decode('TOTAL (TC-CC-CA+A-CB-RC-TB):'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format((($consultas_t-$descuentos_t) - $c_c - ($adicionales_t*$comision_a/100) + $adicionales_t - number_format($transferencia_b_t,2) - $comision_ban_t - $retencion_cli_t),2)),0,1,'L');
$pdf->Cell(5); 
$pdf->Cell(37,5,utf8_decode('(TB) Transfer. Bancarias:'),0,0,'L');
$pdf->Cell(20,5,utf8_decode('$ '.number_format($transferencia_b_t,2)),0,0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Ln(10); 
$pdf->Cell(5); 
$pdf->Cell(60,5,utf8_decode('FORMAS DE PAGO'),0,1,'L');
//Consultar Comisión y Retención
$query_mp = "SELECT mp.costo, mp.descripcion, mp.fecha_p, mp.hora_p, fp.nombre  
FROM `medico_pago` as mp
INNER JOIN f_pago as fp
ON fp.id = mp.id_f_pago
 WHERE id_pago = '{$id_pago}' ";
$result_mp = mysqli_query($conn, $query_mp);
if(!$result_mp) {
  die('Error en consulta '.mysqli_error($conn));
}
$pdf->SetFont('Arial','B',7);
$pdf->Cell(5); 
$pdf->Cell(20,5,utf8_decode('Fecha'),1,0,'C');
$pdf->Cell(15,5,utf8_decode('Hora'),1,0,'C');
$pdf->Cell(15,5,utf8_decode('costo'),1,0,'C');
$pdf->Cell(60,5,utf8_decode('Forma de Pago'),1,0,'C');
$pdf->Cell(70,5,utf8_decode('Observación'),1,1,'C');
$pdf->SetFont('Arial','',7);
while($row = mysqli_fetch_array($result_mp)) {
      $costo = $row['costo'];
      $descripcion = $row['descripcion'];
      $fecha_p = $row['fecha_p'];
      $hora_p = $row['hora_p'];
      $nombre = $row['nombre'];
      $pdf->Cell(5); 
      $pdf->Cell(20,5,utf8_decode($fecha_p),1,0,'C');
      $pdf->Cell(15,5,utf8_decode($hora_p),1,0,'C');
      $pdf->Cell(15,5,utf8_decode($costo),1,0,'C');
      $pdf->Cell(60,5,utf8_decode($nombre),1,0,'C');
      $pdf->Cell(70,5,utf8_decode($descripcion),1,1,'C');
      
}



$pdf->Ln(35);

$pdf->Cell(5); 
$pdf->Cell(80,5,utf8_decode('Comprobante de pago generado por:'),'T',0,'C');
$pdf->Cell(20); 
$pdf->Cell(80,5,utf8_decode('Comprobante de pago recibido por:'),'T',1,'C');
$pdf->Cell(5);
 
//Query usuario
$id_usuario = $_GET['id_usuario'];
$query_us = "SELECT * FROM usuario WHERE id_usuario = '{$id_usuario}'";

$result_us = mysqli_query($conn, $query_us);
if(!$result_us) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result_us)) {
    $id_rol = $row['id_rol'];
}
$nombres = '';
$apellidos = '';
switch (floatval($id_rol)) {
  case $admin:
    $query_admin = "SELECT * FROM administrador WHERE id_usuario = '{$id_usuario}'";
    $result_admin = mysqli_query($conn, $query_admin);
    while($row = mysqli_fetch_array($result_admin)) {
        $nombres = $row['nombres_admin'];
        $apellidos = $row['apellidos_admin'];
    }
    break;
  case $rece:
    $query_rece = "SELECT * FROM recepcionista WHERE id_usuario = '{$id_usuario}'";
    $result_rece = mysqli_query($conn, $query_rece);
    while($row = mysqli_fetch_array($result_rece)) {
        $nombres = $row['nombres_rece'];
        $apellidos = $row['apellidos_rece'];
    }
    break;
  case $medi:
    $query_medi = "SELECT * FROM medico WHERE id_usuario = '{$id_usuario}'";
    $result_medi = mysqli_query($conn, $query_medi);
    while($row = mysqli_fetch_array($result_medi)) {
        $nombres = $row['nombres_medi'];
        $apellidos = $row['apellidos_medi'];
    }
    break;
  case $caje:
    $query_caje = "SELECT * FROM cajero WHERE id_usuario = '{$id_usuario}'";
    $result_caje = mysqli_query($conn, $query_caje);
    while($row = mysqli_fetch_array($result_caje)) {
        $nombres = $row['nombres_caje'];
        $apellidos = $row['apellidos_caje'];
    }
    break;
}

$pdf->Cell(80,5,utf8_decode(ucwords(mb_strtolower(($nombres.' '.$apellidos)))),0,0,'C');
$pdf->Cell(20); 
$pdf->Cell(80,5,utf8_decode(ucwords(mb_strtolower(($sufijo.' '.$nombres_medi.' '.$apellidos_medi)))),0,1,'C');


//Títulos dos lineas
$pdf->SetFont('Arial','B', 6);

$pdf->SetXY(147,55);
$pdf->Cell(13,1,utf8_decode("Transfer."),0,1,'C');
$pdf->SetX(147);
$pdf->Cell(13,2,utf8_decode("Bancaria"),0,1,'C');

$pdf->SetXY(160,55);
$pdf->Cell(13,1,utf8_decode("Comisión"),0,1,'C');
$pdf->SetX(160);
$pdf->Cell(13,2,utf8_decode("Banco"),0,1,'C');

$pdf->SetXY(173,55);
$pdf->Cell(13,1,utf8_decode("Retención"),0,1,'C');
$pdf->SetX(173);
$pdf->Cell(13,2,utf8_decode("Clínica"),0,1,'C');

$pdf->Output("reporte_comp_p.pdf","I",true);
?>