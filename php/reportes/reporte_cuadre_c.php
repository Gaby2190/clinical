<?php
require('../FPDF/fpdf.php');
include('../../dbconnection.php');
date_default_timezone_set('America/Guayaquil'); 
$fecha = $_GET['fecha'];
$id_usuario = $_GET['id_usuario'];


class PDF extends FPDF
{
  function Header()
  {
    //$this->Image('../../assets/images/no_valido.png',100,90,100);
  }
}

// Creación del objeto de la clase heredada
$pdf = new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
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

//VARIABLES GLOBALES
$t_efectivo_i = 0;
$t_transferencia_b_i = 0;
$t_tarjeta_c_i = 0;
$t_tarjeta_d_i = 0;
$t_cheque_i = 0;
$t_letra_c_i = 0;

$t_efectivo_e = 0;
$t_transferencia_b_e = 0;
$t_tarjeta_c_e = 0;
$t_tarjeta_d_e = 0;
$t_cheque_e = 0;
$t_letra_c_e = 0;
    
//<<<<<<<<<<<<<<<<<<<<<<<< INGRESOS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>
//TITULO INGRESOS
$pdf->SetFont('Arial','B', 7);
$pdf->Cell(201,5,utf8_decode("INGRESOS"),1,0,'C');
$pdf->Cell(76,5,utf8_decode("MÉTODOS DE PAGO"),1,1,'C');
//SUBTITULOS INGRESOS
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(12,6,utf8_decode("FECHA"),1,0,'C');
$pdf->Cell(8,6,utf8_decode("HORA"),1,0,'C');
$pdf->Cell(55,6,utf8_decode("PACIENTE"),1,0,'C');
$pdf->Cell(55,6,utf8_decode("MÉDICO"),1,0,'C');
$pdf->Cell(11,6,utf8_decode("CONSULTA"),1,0,'C');
$pdf->Cell(8,6,utf8_decode("TARIFA"),1,0,'C');
$pdf->Cell(12,6,utf8_decode("DESCUENTO"),1,0,'C');
$pdf->Cell(13,6,utf8_decode("ADICIONALES"),1,0,'C');
$pdf->Cell(12,6,utf8_decode("OTROS"),1,0,'C');
$pdf->Cell(15,6,utf8_decode(""),1,0,'C');

$pdf->Cell(12,6,utf8_decode("EFECTIVO"),1,0,'C');
$pdf->Cell(16,6,utf8_decode(""),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,0,'C');
$pdf->Cell(12,6,utf8_decode("CHEQUE"),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,1,'C');
//CONSULTAS CITAS
$query_i = "SELECT ci_pa.fecha_p, ci_pa.hora_p, ci.*, ca.id_medico, ca.id_paciente, me.pago_ingreso, me.sufijo, me.nombres_medi, me.apellidos_medi, pa.nombres_paci1, pa.apellidos_paci1, pa.nombres_paci2, pa.apellidos_paci2, me.tarifa, me.tarifa_control, usu.id_usuario
                FROM cita_pago AS ci_pa
                INNER JOIN cita AS ci
                    ON ci_pa.id_cita = ci.id_cita
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON me.id_medico = ca.id_medico
                INNER JOIN paciente AS pa
                    ON pa.id_paciente = ca.id_paciente
                INNER JOIN usuario as usu
                    ON pa.id_usuario = usu.id_usuario
                WHERE ci_pa.fecha_p = '{$fecha}' and ci_pa.id_usuario = '{$id_usuario}'  GROUP BY ci_pa.id_cita ORDER BY ci_pa.id_cita ASC";
$result_i = mysqli_query($conn, $query_i);

if(!$result_i) {
    die('Error en consulta '.mysqli_error($conn));
} 

$citas_i = array();
while($row = mysqli_fetch_array($result_i)) {
    $citas_i[] = array(
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
      'pago_ingreso' => $row['pago_ingreso'],
      'nombres_medi' => $row['nombres_medi'],
      'apellidos_medi' => $row['apellidos_medi'],
      'tarifa' => $row['tarifa'],
      'tarifa_control' => $row['tarifa_control'],
      'nombres_paci1' => $row['nombres_paci1'],
      'apellidos_paci1' => $row['apellidos_paci1'],
      'nombres_paci2' => $row['nombres_paci2'],
      'apellidos_paci2' => $row['apellidos_paci2'],
      'actualizacion' => $row['actualizacion'],
      'id_usuario' => $row['id_usuario'],
      'fecha_p' => $row['fecha_p'],
      'hora_p' => $row['hora_p']
    );
    
}
for ($i=0; $i < sizeof($citas_i); $i++) {
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,utf8_decode($fecha),1,0,'C');
  $pdf->Cell(8,5,utf8_decode(substr($citas_i[$i]['hora_p'], 0, -3).'h'),1,0,'C');
  $pdf->Cell(55,5,utf8_decode(ucwords(mb_strtolower($citas_i[$i]['nombres_paci1'].' '.$citas_i[$i]['nombres_paci2'].' '.$citas_i[$i]['apellidos_paci1'].' '.$citas_i[$i]['apellidos_paci2']))),1,0,'C');
  $pdf->Cell(55,5,utf8_decode(ucwords(mb_strtolower($citas_i[$i]['sufijo'].' '.$citas_i[$i]['nombres_medi'].' '.$citas_i[$i]['apellidos_medi']))),1,0,'C');
  $tarifa_i = 0;
  if(intval($citas_i[$i]['tipo_cita'])==1){
      $pdf->Cell(11,5,utf8_decode("Normal"),1,0,'C');
      $pdf->Cell(8,5,utf8_decode("$".number_format($citas_i[$i]['tarifa'],2)),1,0,'C');
      $tarifa_i = number_format($citas_i[$i]['tarifa'],2);
  }
  if(intval($citas_i[$i]['tipo_cita'])==0){
      $pdf->Cell(11,5,utf8_decode("Control"),1,0,'C');
      $pdf->Cell(8,5,utf8_decode("$".number_format($citas_i[$i]['tarifa_control'],2)),1,0,'C');
      $tarifa_i = number_format($citas_i[$i]['tarifa_control'],2);
  }
  $descuento_i = number_format($citas_i[$i]['descuento'],2);
  $pdf->Cell(12,5,utf8_decode("$".$descuento_i),1,0,'C');
  //Adicionales
  //<<<<<==================query==========================>>>>>
  $query_ia = "SELECT * from adicional where id_cita = '{$citas_i[$i]['id_cita']}'";
  $result_ia = mysqli_query($conn, $query_ia);
  if(!$result_ia) {
    die('Error en consulta '.mysqli_error($conn));
  }
  $adicional_i = array();
  while($row = mysqli_fetch_array($result_ia)) {
      $adicional_i[] = array(
      'costo' => $row['costo']
      );
  }
  //<<<<<==================query==========================>>>>>
  $t_adicionales = 0;
  for ($j=0; $j < sizeof($adicional_i); $j++) {
      $t_adicionales += $adicional_i[$j]['costo'];
  }
  
  $pdf->Cell(13,5,utf8_decode("$".number_format($t_adicionales,2)),1,0,'C');
  //Otros
  //<<<<<==================query==========================>>>>>
  $query_io = "SELECT * FROM otro_c WHERE id_cita = '{$citas_i[$i]['id_cita']}'";
  $result_io = mysqli_query($conn, $query_io);
  if(!$result_io) {
      die('Consulta fallida'. mysqli_error($conn));
  }
  $otro_i = array();
  while($row = mysqli_fetch_array($result_io)) {
      $otro_i[] = array(
      'costo' => $row['costo']
      );
  }
  //<<<<<==================query==========================>>>>>
  $t_otros = 0;
  for ($j=0; $j < sizeof($otro_i); $j++) {
      $t_otros += $otro_i[$j]['costo'];
  }
  
  $pdf->Cell(12,5,utf8_decode("$".number_format($t_otros,2)),1,0,'C');
  //TOTAL
  $total_i = $tarifa_i - $descuento_i + $t_adicionales + $t_otros;
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(15,5,utf8_decode("$".number_format($total_i,2)),1,0,'C');
  $pdf->SetFont('Arial','',6);
  //===============MÉTODOS DE PAGO===========================
  //<<<<<==================query==========================>>>>>
    $query_ip = "SELECT cp.*, fp.nombre 
                FROM cita_pago as cp
                INNER JOIN f_pago as fp
                    ON cp.id_f_pago = fp.id
                WHERE cp.id_cita = '{$citas_i[$i]['id_cita']}' and cp.fecha_p = '{$fecha}'";
    
    $result_ip = mysqli_query($conn, $query_ip);
    if(!$result_ip) {
        die('Consulta fallida'. mysqli_error($conn));
    }

    $formasp_i = array();
    while($row = mysqli_fetch_array($result_ip)) {
        $formasp_i[] = array(
        'costo' => $row['costo'],
        'id_f_pago' => $row['id_f_pago']
        );
    }
    //<<<<<==================query==========================>>>>>
    $efectivo_i = 0;
    $transferencia_b_i = 0;
    $tarjeta_c_i = 0;
    $tarjeta_d_i = 0;
    $cheque_i = 0;
    $letra_c_i = 0;
    for ($j=0; $j < sizeof($formasp_i); $j++) {
      switch (floatval($formasp_i[$j]['id_f_pago'])) {
          case 1:
            $efectivo_i = $formasp_i[$j]['costo'];
            break;
        case 2:
            $transferencia_b_i = $formasp_i[$j]['costo'];
            break;
        case 4:
            $tarjeta_c_i = $formasp_i[$j]['costo'];
            break;
        case 5:
            $tarjeta_d_i = $formasp_i[$j]['costo'];
            break;
        case 6:
            $cheque_i = $formasp_i[$j]['costo'];
            break;
        case 7:
            $letra_c_i = $formasp_i[$j]['costo'];
            break;
      }
    }
    $pdf->Cell(12,5,utf8_decode("$".number_format($efectivo_i,2)),1,0,'C');
    $pdf->Cell(16,5,utf8_decode("$".number_format($transferencia_b_i,2)),1,0,'C');
    $pdf->Cell(12,5,utf8_decode("$".number_format($tarjeta_c_i,2)),1,0,'C');
    $pdf->Cell(12,5,utf8_decode("$".number_format($tarjeta_d_i,2)),1,0,'C');
    $pdf->Cell(12,5,utf8_decode("$".number_format($cheque_i,2)),1,0,'C');
    $pdf->Cell(12,5,utf8_decode("$".number_format($letra_c_i,2)),1,1,'C');
    
    $t_efectivo_i += $efectivo_i;
    $t_transferencia_b_i += $transferencia_b_i;
    $t_tarjeta_c_i += $tarjeta_c_i;
    $t_tarjeta_d_i += $tarjeta_d_i;
    $t_cheque_i += $cheque_i;
    $t_letra_c_i += $letra_c_i;
}
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(201);
$pdf->Cell(12,5,utf8_decode("$".number_format($t_efectivo_i,2)),1,0,'C');
$pdf->Cell(16,5,utf8_decode("$".number_format($t_transferencia_b_i,2)),1,0,'C');
$pdf->Cell(12,5,utf8_decode("$".number_format($t_tarjeta_c_i,2)),1,0,'C');
$pdf->Cell(12,5,utf8_decode("$".number_format($t_tarjeta_d_i,2)),1,0,'C');
$pdf->Cell(12,5,utf8_decode("$".number_format($t_cheque_i,2)),1,0,'C');
$pdf->Cell(12,5,utf8_decode("$".number_format($t_letra_c_i,2)),1,1,'C');
$pdf->Ln(5);
//<<<<<<<<<<<<<<<<<<<<<<<< EFRESOS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$h_egresos = $pdf->GetY() + 5;


//Titulos dobles ingresos
$pdf->SetFont('Arial','B', 5);
$pdf->SetXY(196,29);
$pdf->MultiCell(15,3,utf8_decode("TOTAL COBRADO"),0,'C');
$pdf->SetXY(222,29);
$pdf->MultiCell(18,3,utf8_decode("TRANSFERENCIA BANCARA"),0,'C');
$pdf->SetXY(238,29);
$pdf->MultiCell(14,3,utf8_decode("TARJETA DE CRÉDITO"),0,'C');
$pdf->SetXY(250,29);
$pdf->MultiCell(14,3,utf8_decode("TARJETA DE DÉBITO"),0,'C');
$pdf->SetXY(274,29);
$pdf->MultiCell(14,3,utf8_decode("LETRA DE CAMBIO"),0,'C');

//Titulos dobles egresos
$pdf->SetXY(29,$h_egresos);
$pdf->MultiCell(18,3,utf8_decode("COMPROBANTE DE PAGO"),0,'C');
$pdf->SetXY(147,$h_egresos);
$pdf->MultiCell(12,3,utf8_decode("COMISIÓN BANCO"),0,'C');
$pdf->SetXY(158,$h_egresos);
$pdf->MultiCell(14,3,utf8_decode("RETENCIÓN CLÍNICA"),0,'C');
$pdf->SetXY(170,$h_egresos);
$pdf->MultiCell(14,3,utf8_decode("COMISIÓN CONSULTA"),0,'C');
$pdf->SetXY(182,$h_egresos);
$pdf->MultiCell(15,3,utf8_decode("COMISIÓN ADICIONALES"),0,'C');
$pdf->SetXY(196,$h_egresos);
$pdf->MultiCell(15,3,utf8_decode("TOTAL PAGADO"),0,'C');
$pdf->SetXY(222,$h_egresos);
$pdf->MultiCell(18,3,utf8_decode("TRANSFERENCIA BANCARA"),0,'C');
$pdf->SetXY(238,$h_egresos);
$pdf->MultiCell(14,3,utf8_decode("TARJETA DE CRÉDITO"),0,'C');
$pdf->SetXY(250,$h_egresos);
$pdf->MultiCell(14,3,utf8_decode("TARJETA DE DÉBITO"),0,'C');
$pdf->SetXY(274,$h_egresos);
$pdf->MultiCell(14,3,utf8_decode("LETRA DE CAMBIO"),0,'C');


$pdf->SetY($h_egresos-5);
//TITULO EGRESOS
$pdf->SetFont('Arial','B', 7);
$pdf->Cell(201,5,utf8_decode("EGRESOS"),1,0,'C');
$pdf->Cell(76,5,utf8_decode("MÉTODOS DE PAGO"),1,1,'C');
//SUBTITULOS EGRESOS
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(12,6,utf8_decode("FECHA"),1,0,'C');
$pdf->Cell(8,6,utf8_decode("HORA"),1,0,'C');
$pdf->Cell(16,6,utf8_decode(""),1,0,'C');
$pdf->Cell(68,6,utf8_decode("MÉDICO"),1,0,'C');
$pdf->Cell(8,6,utf8_decode("TARIFA"),1,0,'C');
$pdf->Cell(12,6,utf8_decode("DESCUENTO"),1,0,'C');
$pdf->Cell(13,6,utf8_decode("ADICIONALES"),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,0,'C');
$pdf->Cell(13,6,utf8_decode(""),1,0,'C');
$pdf->Cell(15,6,utf8_decode(""),1,0,'C');

$pdf->Cell(12,6,utf8_decode("EFECTIVO"),1,0,'C');
$pdf->Cell(16,6,utf8_decode(""),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,0,'C');
$pdf->Cell(12,6,utf8_decode("CHEQUE"),1,0,'C');
$pdf->Cell(12,6,utf8_decode(""),1,1,'C');
//CONSULTA MEDICOS PAGO
$query_e = "SELECT me_p.* 
             FROM medico_pago as me_p
             INNER JOIN pago as pa
                ON me_p.id_pago = pa.id_pago
             WHERE me_p.fecha_p = '{$fecha}' and pa.id_usuario = '{$id_usuario}' GROUP BY me_p.id_pago ORDER BY me_p.hora_p ASC";

$result_e = mysqli_query($conn, $query_e);
if(!$result_e) {
    die('Error en consulta '.mysqli_error($conn));
} 
$pagos_e = array();
while($row = mysqli_fetch_array($result_e)) {
    $pagos_e[] = array(
        'fecha_p' => $row['fecha_p'],
        'hora_p' => $row['hora_p'],
        'id_pago' => $row['id_pago']
    );
}
for ($i=0; $i < sizeof($pagos_e); $i++) {
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,utf8_decode($fecha),1,0,'C');
  $pdf->Cell(8,5,utf8_decode(substr($pagos_e[$i]['hora_p'], 0, -3).'h'),1,0,'C');
  $pdf->Cell(16,5,utf8_decode($pagos_e[$i]['id_pago']),1,0,'C');
  //===============CITAS EGRESOS===========================
  $query_ce = "SELECT de_pa.*, ci.*, me.comision_c, me.comision_a, me.sufijo, me.nombres_medi, me.apellidos_medi, me.tarifa, me.tarifa_control
                FROM detalle_pago AS de_pa
                INNER JOIN cita AS ci
                    ON de_pa.id_cita = ci.id_cita
                INNER JOIN caso AS ca
                    ON ci.id_caso = ca.id_caso
                INNER JOIN medico AS me
                    ON me.id_medico = ca.id_medico
                WHERE de_pa.id_pago = '{$pagos_e[$i]['id_pago']}' ORDER BY ci.id_cita ASC";
  $result_ce = mysqli_query($conn, $query_ce);
  if(!$result_ce) {
    die('Error en consulta '.mysqli_error($conn));
  }
  $citas_ce = array();
  while($row = mysqli_fetch_array($result_ce)) {
        $citas_ce[] = array(
          'id_cita' => $row['id_cita'],
          'descripcion' => $row['descripcion'],
          'fecha' => $row['fecha'],
          'hora' => $row['hora'],
          'tipo_cita' => $row['tipo_cita'],
          'id' => $row['id'],
          'descuento' => $row['descuento'],
          'sufijo' => $row['sufijo'],
          'nombres_medi' => $row['nombres_medi'],
          'apellidos_medi' => $row['apellidos_medi'],
          'tarifa' => $row['tarifa'],
          'tarifa_control' => $row['tarifa_control'],
          'comision_c' => $row['comision_c'],
          'comision_a' => $row['comision_a']
        );
    }
  $medico = $citas_ce[0]["sufijo"]." ".$citas_ce[0]["nombres_medi"]." ".$citas_ce[0]["apellidos_medi"];
  $t_tarifas = 0;
  $t_descuentos = 0;
  $t_adicionales = 0;
  $t_comisiones_ban = 0;
  $t_retenciones_cli = 0;
  $t_comisiones_c = 0;
  $t_comisiones_a = 0;
  $t_pagado = 0;
  
  for ($j=0; $j < sizeof($citas_ce); $j++) {
      $com_c = floatval($citas_ce[$j]["comision_c"]);
      $com_a = floatval($citas_ce[$j]["comision_a"]);
      $tarifa_e = 0;
      if(intval($citas_ce[$j]['tipo_cita'])==1){
          $tarifa_e = number_format($citas_ce[$j]['tarifa'],2);
      }
      if(intval($citas_ce[$j]['tipo_cita'])==0){
          $tarifa_e = number_format($citas_ce[$j]['tarifa_control'],2);
      }
      $t_tarifas += $tarifa_e;
      $t_descuentos += number_format($citas_ce[$j]['descuento'],2);
      //Adicionales
      //<<<<<==================query==========================>>>>>
      $query_ea = "SELECT * from adicional where id_cita = '{$citas_ce[$j]['id_cita']}'";
      $result_ea = mysqli_query($conn, $query_ea);
      if(!$result_ea) {
        die('Error en consulta '.mysqli_error($conn));
      }
      $adicional_e = array();
      while($row = mysqli_fetch_array($result_ea)) {
          $adicional_e[] = array(
          'costo' => $row['costo']
          );
      }
      //<<<<<==================query==========================>>>>>
      $adicionales = 0;
      for ($k=0; $k < sizeof($adicional_e); $k++) {
          $adicionales += $adicional_e[$k]['costo'];
      }
      $t_adicionales += number_format($adicionales,2);
      //Comisión Banco y Retención clínica
      //<<<<<==================query==========================>>>>>
      $query_cbrc = "SELECT * FROM p_tarjeta WHERE id_cita = '{$citas_ce[$j]['id_cita']}'";
      $result_cbrc = mysqli_query($conn, $query_cbrc);
      if(!$result_cbrc) {
          die('Consulta fallida'. mysqli_error($conn));
      }
      $cbrc = array();
      while($row = mysqli_fetch_array($result_cbrc)) {
          $cbrc[] = array(
          'comision_ban' => $row['comision_ban'],
          'retencion_cli' => $row['retencion_cli']
          );
      }
      //<<<<<==================query==========================>>>>>
      $val_comision_ban = 0;
      $val_retencion_cli = 0;
      for ($k=0; $k < sizeof($cbrc); $k++) {
          $val_comision_ban += $cbrc[$k]['comision_ban'];
          $val_retencion_cli += $cbrc[$k]['retencion_cli'];
      }
      $t_comisiones_ban += number_format($val_comision_ban,2);
      $t_retenciones_cli += number_format($val_retencion_cli,2);
      //Comisión consulta y comisión adicionales
      $comision_c = 0;
      $comision_a = 0;
      if (floatval($com_c)>5) {
          $comision_c = (((floatval($tarifa_e)-floatval(number_format($citas_ce[$j]['descuento'],2)))*floatval($com_c))/100);  
      }else{
          $comision_c =  floatval($com_c);  
      }
      $comision_a = (((floatval($adicionales))*floatval($com_a))/100);
      $t_comisiones_c += floatval($comision_c);
      $t_comisiones_a += floatval($comision_a);
  }
  $t_pagado = $t_tarifas - $t_descuentos + $t_adicionales - $t_comisiones_ban - $t_retenciones_cli - $t_comisiones_c - $t_comisiones_a;
  
  //<<<<<==================query==========================>>>>>
  $query_mp = "SELECT mp.*, fp.nombre 
            FROM medico_pago as mp
            INNER JOIN f_pago as fp
              ON mp.id_f_pago = fp.id
            WHERE mp.id_pago = '{$pagos_e[$i]['id_pago']}'";
  $result_mp = mysqli_query($conn, $query_mp);
  if(!$result_mp) {
        die('Consulta fallida'. mysqli_error($conn));
    }
  $formasp_e = array();
  while($row = mysqli_fetch_array($result_mp)) {
      $formasp_e[] = array(
      'costo' => $row['costo'],
      'id_f_pago' => $row['id_f_pago'],
      );
  }
  //<<<<<==================query==========================>>>>>
  $efectivo_e = 0;
  $transferencia_b_e = 0;
  $tarjeta_c_e = 0;
  $tarjeta_d_e = 0;
  $cheque_e = 0;
  $letra_c_e = 0;
  for ($j=0; $j < sizeof($formasp_e); $j++) {
    switch (floatval($formasp_e[$j]['id_f_pago'])) {
        case 1:
          $efectivo_e = $formasp_e[$j]['costo'];
          break;
      case 2:
          $transferencia_b_e = $formasp_e[$j]['costo'];
          break;
      case 4:
          $tarjeta_c_e = $formasp_e[$j]['costo'];
          break;
      case 5:
          $tarjeta_d_e = $formasp_e[$j]['costo'];
          break;
      case 6:
          $cheque_e = $formasp_e[$j]['costo'];
          break;
      case 7:
          $letra_c_e = $formasp_e[$j]['costo'];
          break;
    }
  }
  
  $t_efectivo_e += $efectivo_e;
  $t_transferencia_b_e += $transferencia_b_e;
  $t_tarjeta_c_e += $tarjeta_c_e;
  $t_tarjeta_d_e += $tarjeta_d_e;
  $t_cheque_e += $cheque_e;
  $t_letra_c_e += $letra_c_e;
    
  $pdf->Cell(68,5,utf8_decode(ucwords(mb_strtolower($medico))),1,0,'C');
  $pdf->Cell(8,5,utf8_decode("$".number_format($t_tarifas,2)),1,0,'C');
  $pdf->Cell(12,5,utf8_decode("$".number_format($t_descuentos,2)),1,0,'C');
  $pdf->Cell(13,5,utf8_decode("$".number_format($t_adicionales,2)),1,0,'C');
  $pdf->Cell(12,5,utf8_decode("$".number_format($t_comisiones_ban,2)),1,0,'C');
  $pdf->Cell(12,5,utf8_decode("$".number_format($t_retenciones_cli,2)),1,0,'C');
  $pdf->Cell(12,5,utf8_decode("$".number_format($t_comisiones_c,2)),1,0,'C');
  $pdf->Cell(13,5,utf8_decode("$".number_format($t_comisiones_a,2)),1,0,'C');
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(15,5,utf8_decode("$".number_format($t_pagado,2)),1,0,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,utf8_decode("$".number_format($efectivo_e,2)),1,0,'C');
  $pdf->Cell(16,5,utf8_decode("$".number_format($transferencia_b_e,2)),1,0,'C');
  $pdf->Cell(12,5,utf8_decode("$".number_format($tarjeta_c_e,2)),1,0,'C');
  $pdf->Cell(12,5,utf8_decode("$".number_format($tarjeta_d_e,2)),1,0,'C');
  $pdf->Cell(12,5,utf8_decode("$".number_format($cheque_e,2)),1,0,'C');
  $pdf->Cell(12,5,utf8_decode("$".number_format($letra_c_e,2)),1,1,'C');
}
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(201);
$pdf->Cell(12,5,utf8_decode("$".number_format($t_efectivo_e,2)),1,0,'C');
$pdf->Cell(16,5,utf8_decode("$".number_format($t_transferencia_b_e,2)),1,0,'C');
$pdf->Cell(12,5,utf8_decode("$".number_format($t_tarjeta_c_e,2)),1,0,'C');
$pdf->Cell(12,5,utf8_decode("$".number_format($t_tarjeta_d_e,2)),1,0,'C');
$pdf->Cell(12,5,utf8_decode("$".number_format($t_cheque_e,2)),1,0,'C');
$pdf->Cell(12,5,utf8_decode("$".number_format($t_letra_c_e,2)),1,1,'C');
$pdf->Ln(5);
//<<<<<<<<<<<<<<<<<<<<<<<< INGRESOS - EGRESOS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("CUENTAS"),1,0,'C');
$pdf->Cell(30,6,utf8_decode("INGRESOS"),1,0,'C');
$pdf->Cell(30,6,utf8_decode("EGRESOS"),1,0,'C');
$pdf->Cell(30,6,utf8_decode("TOTAL"),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("EFECTIVO"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format($t_efectivo_i,2)),1,0,'C');
$pdf->Cell(30,6,utf8_decode("$".number_format($t_efectivo_e,2)),1,0,'C');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_efectivo_i-$t_efectivo_e),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("TRANSFERENCIA BANCARIA"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format($t_transferencia_b_i,2)),1,0,'C');
$pdf->Cell(30,6,utf8_decode("$".number_format($t_transferencia_b_e,2)),1,0,'C');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_transferencia_b_i-$t_transferencia_b_e),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("TARJETA DE CRÉDITO"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format($t_tarjeta_c_i,2)),1,0,'C');
$pdf->Cell(30,6,utf8_decode("$".number_format($t_tarjeta_c_e,2)),1,0,'C');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_tarjeta_c_i-$t_tarjeta_c_e),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("TARJETA DE DÉBITO"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format($t_tarjeta_d_i,2)),1,0,'C');
$pdf->Cell(30,6,utf8_decode("$".number_format($t_tarjeta_d_e,2)),1,0,'C');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_tarjeta_d_i-$t_tarjeta_d_e),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("CHEQUE"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format($t_cheque_i,2)),1,0,'C');
$pdf->Cell(30,6,utf8_decode("$".number_format($t_cheque_e,2)),1,0,'C');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_cheque_i-$t_cheque_e),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("LETRA DE CAMBIO"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format($t_letra_c_i,2)),1,0,'C');
$pdf->Cell(30,6,utf8_decode("$".number_format($t_letra_c_e,2)),1,0,'C');
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_letra_c_i-$t_letra_c_e),2)),1,1,'C');
$pdf->Ln(5);

//<<<<<<<<<<<<<<<<<<<<<<<< TOTALES >>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("TOTAL CAJA"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_efectivo_i-$t_efectivo_e),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("TOTAL CUENTAS"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format((($t_transferencia_b_i-$t_transferencia_b_e)+($t_tarjeta_c_i-$t_tarjeta_c_e)+($t_tarjeta_d_i-$t_tarjeta_d_e)),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("CHEQUES"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_cheque_i-$t_cheque_e),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("LETRAS DE CAMBIO"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format(($t_letra_c_i-$t_letra_c_e),2)),1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(50,6,utf8_decode("TOTAL"),1,0,'C');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(30,6,utf8_decode("$".number_format((($t_efectivo_i-$t_efectivo_e)+($t_transferencia_b_i-$t_transferencia_b_e)+($t_tarjeta_c_i-$t_tarjeta_c_e)+($t_tarjeta_d_i-$t_tarjeta_d_e)+($t_cheque_i-$t_cheque_e)+($t_letra_c_i-$t_letra_c_e)),2)),1,1,'C');


$pdf->Output("reporte_cuadre_c.pdf","I",true);
?>