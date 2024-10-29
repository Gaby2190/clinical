<?php
require_once '../FPDF/fpdf.php';
include_once '../../dbconnection.php';
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
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Image('../../assets/images/logo_rce.jpeg',10,9,11,10);
$pdf->Image('../../assets/images/msp_logo.png',190,10,14,8);
//TÍTULO
$pdf->SetFont('Arial','B',9);
$pdf->SetTextColor(34, 68, 93); 
$pdf->Cell(195,4,utf8_decode('CENTRO DE ESPECIALIDADES MÉDICAS CLÍNICO QUIRÚRGICO CESMED HOSPITAL DEL DÍA'),0,1,'C');
//DIRECCIÓN
$pdf->SetFont('Arial','BI', 9);
$pdf->Cell(195,4,utf8_decode('Dirección: Av. San Francisco y Uruguay (esquina) - Tulcán - Ecuador - Teléfono: 2986771'),0,0,'C');
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);

//CONCEPTO
$pdf->SetFont('Arial','B', 12);
$pdf->Cell(195,4,utf8_decode('CUADRE DE CAJA DEL '.$fecha),0,0,'C');
$pdf->Ln(10);


    
//<<<<<<<<<<<<<<<<<<<<<<<< INGRESOS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>
//TITULO INGRESOS
$pdf->SetFont('Arial','B', 7);
$pdf->SetFillColor(153,153,153);
$pdf->SetTextColor(34,68,93);
$pdf->Cell(195,5,utf8_decode("INGRESOS"),1,1,'C',true);
$pdf->SetFillColor(188,188,188);
$pdf->SetTextColor(0,0,0);

//SUBTITULOS INGRESOS
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(12,6,utf8_decode("CITA"),1,0,'C',true);
$pdf->Cell(8,6,utf8_decode("HORA"),1,0,'C',true);
$pdf->Cell(55,6,utf8_decode("PACIENTE"),1,0,'C',true);
$pdf->Cell(11,6,utf8_decode("CONSULTA"),1,0,'C',true);
$pdf->Cell(20,6,utf8_decode("TOTAL COBRADO"),1,0,'C',true);
$pdf->Cell(15,6,utf8_decode("DESCUENTO"),1,0,'C',true);
$pdf->Cell(15,6,utf8_decode("ADICIONALES"),1,0,'C',true);
$pdf->Cell(15,6,utf8_decode("OTROS"),1,0,'C',true);
$pdf->Cell(44,6,utf8_decode("FORMA DE PAGO"),1,1,'C',true);


//CONSULTAS CITAS
$query_i = "SELECT ci_pa.*, ci.*, ca.id_medico, ca.id_paciente, me.pago_ingreso, me.sufijo, me.nombres_medi, me.apellidos_medi, pa.nombres_paci1, pa.apellidos_paci1, pa.nombres_paci2, pa.apellidos_paci2, me.tarifa, me.tarifa_control, usu.id_usuario, fp.nombre
                    FROM cita_pago AS ci_pa 
                    INNER JOIN cita AS ci ON ci_pa.id_cita = ci.id_cita 
                    INNER JOIN caso AS ca ON ci.id_caso = ca.id_caso 
                    INNER JOIN medico AS me ON me.id_medico = ca.id_medico 
                    INNER JOIN paciente AS pa ON pa.id_paciente = ca.id_paciente 
                    INNER JOIN usuario as usu ON pa.id_usuario = usu.id_usuario
                    INNER JOIN f_pago AS fp ON fp.id = ci_pa.id_f_pago
                WHERE ci_pa.fecha_p = '{$fecha}' and ci_pa.id_usuario = '{$id_usuario}'   ORDER BY ci_pa.id_cita ASC";
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
          'hora_p' => $row['hora_p'],
          'costo' => $row['costo'],
          'nombre' => $row['nombre']
    );
    
}
for ($i=0; $i < sizeof($citas_i); $i++) {
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(12,5,utf8_decode($citas_i[$i]['id_cita']),1,0,'C');
  $pdf->Cell(8,5,utf8_decode(substr($citas_i[$i]['hora'], 0, -3).'h'),1,0,'C');
  $pdf->Cell(55,5,utf8_decode(ucwords(mb_strtolower($citas_i[$i]['nombres_paci1'].' '.$citas_i[$i]['nombres_paci2'].' '.$citas_i[$i]['apellidos_paci1'].' '.$citas_i[$i]['apellidos_paci2']))),1,0,'C');
  if(intval($citas_i[$i]['tipo_cita'])==1){
      $pdf->Cell(11,5,utf8_decode("Normal"),1,0,'C');
      
  }
  if(intval($citas_i[$i]['tipo_cita'])==0){
      $pdf->Cell(11,5,utf8_decode("Control"),1,0,'C');
      
  }
  $descuento_i = number_format($citas_i[$i]['descuento'],2);
  
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
  
  
  //TOTAL
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20,5,utf8_decode("$".number_format($citas_i[$i]['costo'],2)),1,0,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(15,5,utf8_decode("$".$descuento_i),1,0,'C');
  $pdf->Cell(15,5,utf8_decode("$".number_format($t_adicionales,2)),1,0,'C');
  $pdf->Cell(15,5,utf8_decode("$".number_format($t_otros,2)),1,0,'C');
  
  //===============MÉTODOS DE PAGO===========================
  $pdf->Cell(44,5,utf8_decode($citas_i[$i]['nombre']),1,1,'C');
  //<<<<<==================query==========================>>>>>
    
}
$pdf->Ln(5);
//<<<<<<<<<<<<<<<<<<<<<<<< EFRESOS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$h_egresos = $pdf->GetY() + 5;

$pdf->SetY($h_egresos-5);
//TITULO EGRESOS
$pdf->SetFont('Arial','B', 7);
$pdf->SetFillColor(153,153,153);
$pdf->SetTextColor(34,68,93);
$pdf->Cell(195,5,utf8_decode("EGRESOS"),1,1,'C',true);
$pdf->SetFillColor(188,188,188);
$pdf->SetTextColor(0,0,0);
//SUBTITULOS EGRESOS
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(20,6,utf8_decode("COMPROBANTE"),1,0,'C',true);
$pdf->Cell(8,6,utf8_decode("HORA"),1,0,'C',true);
$pdf->Cell(75,6,utf8_decode("MÉDICO"),1,0,'C',true);
$pdf->Cell(20,6,utf8_decode("TOTAL PAGADO"),1,0,'C',true);
$pdf->Cell(72,6,utf8_decode("FORMA DE PAGO"),1,1,'C',true);
//CONSULTA MEDICOS PAGO
$query_e = "SELECT me_p.*, me.sufijo, me.nom_ape_medi ,fp.nombre
             FROM medico_pago as me_p
             INNER JOIN pago as pa
                ON me_p.id_pago = pa.id_pago
             INNER JOIN f_pago as fp
             	ON fp.id=me_p.id_f_pago
             INNER JOIN medico as me
             	ON me.id_medico = pa.id_medico
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
        'id_pago' => $row['id_pago'],
        'nombre' => $row['nombre'],
        'sufijo' => $row['sufijo'],
        'nom_ape_medi' => $row['nom_ape_medi'],
        'costo' => $row['costo']
    );
}
for ($i=0; $i < sizeof($pagos_e); $i++) {
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(20,5,utf8_decode($pagos_e[$i]['id_pago']),1,0,'C');
  $pdf->Cell(8,5,utf8_decode(substr($pagos_e[$i]['hora_p'], 0, -3).'h'),1,0,'C');
  
  $pdf->Cell(75,5,utf8_decode(ucwords(mb_strtolower($pagos_e[$i]['sufijo'].' '.$pagos_e[$i]['nom_ape_medi']))),1,0,'C');
  $pdf->SetFont('Arial','B',6);
  $pdf->Cell(20,5,utf8_decode("$".number_format($pagos_e[$i]['costo'],2)),1,0,'C');
  $pdf->SetFont('Arial','',6);
  $pdf->Cell(72,5,utf8_decode($pagos_e[$i]['nombre']),1,1,'C');
 
}
$pdf->Ln(5);

//<<<<<<<<<<<<<<<<<<<<<<<< INGRESOS - EGRESOS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>
$pdf->SetFont('Arial','B', 6);
$pdf->SetFillColor(153,153,153);
$pdf->SetTextColor(34,68,93);
$pdf->Cell(50,6,utf8_decode("CUENTAS"),1,0,'C',true);
$pdf->Cell(30,6,utf8_decode("INGRESOS"),1,0,'C',true);
$pdf->Cell(30,6,utf8_decode("EGRESOS"),1,0,'C',true);
$pdf->Cell(30,6,utf8_decode("TOTAL"),1,1,'C',true);
$pdf->SetFillColor(188,188,188);
$pdf->SetTextColor(0,0,0);

$query_fp = "SELECT * FROM f_pago ORDER BY aseguradora";

$result_fp = mysqli_query($conn, $query_fp);
if(!$result_fp) {
    die('Error en consulta '.mysqli_error($conn));
} 
$fp = array();
while($row = mysqli_fetch_array($result_fp)) {
    $fp[] = array(
        'id' => $row['id'],
        'nombre' => $row['nombre'],
        'aseguradora' => $row['aseguradora']
    );
}
for ($i=0; $i < sizeof($fp); $i++) {
    $ingreso=0;
    $pdf->SetFont('Arial','', 6);
    $pdf->Cell(50,6,utf8_decode($fp[$i]['nombre']),1,0,'C',true);
        //============================ INGRESOS TOTALES ===========================
        $query_ing = "SELECT SUM(ci_pa.costo) as total, fp.nombre
                    FROM cita_pago AS ci_pa 
                    INNER JOIN cita AS ci ON ci_pa.id_cita = ci.id_cita 
                    INNER JOIN caso AS ca ON ci.id_caso = ca.id_caso 
                    INNER JOIN medico AS me ON me.id_medico = ca.id_medico 
                    INNER JOIN paciente AS pa ON pa.id_paciente = ca.id_paciente 
                    INNER JOIN usuario as usu ON pa.id_usuario = usu.id_usuario
                    INNER JOIN f_pago AS fp ON fp.id = ci_pa.id_f_pago
                WHERE ci_pa.fecha_p = '{$fecha}' and ci_pa.id_usuario = '{$id_usuario}' and fp.id='{$fp[$i]['id']}' GROUP BY fp.nombre ASC";

        $result_ing = mysqli_query($conn, $query_ing);
        if(!$result_ing) {
            die('Error en consulta '.mysqli_error($conn));
        } 
        $ing = array();
        while($row = mysqli_fetch_array($result_ing)) {
            $ing[] = array(
                'total' => $row['total']
            );
        }

        for ($h=0; $h < sizeof($ing); $h++) {
            $pdf->SetFont('Arial','B', 6);
            $pdf->Cell(30,6,utf8_decode("$".number_format($ing[$h]['total'],2)),1,0,'C');
            $ingreso=$ing[$h]['total'];
            $pdf->SetFont('Arial','',6);
        }
        if (sizeof($ing)==0)
        {
            $pdf->Cell(30,6,utf8_decode("$".number_format($ingreso,2)),1,0,'C');
        }
        //============================ EGRESOS TOTALES ===========================
        $egreso=0;
        $query_egr = "SELECT SUM(me_p.costo) as total ,fp.nombre
             FROM medico_pago as me_p
             INNER JOIN pago as pa
                ON me_p.id_pago = pa.id_pago
             INNER JOIN f_pago as fp
             	ON fp.id=me_p.id_f_pago
             INNER JOIN medico as me
             	ON me.id_medico = pa.id_medico
                WHERE me_p.fecha_p = '{$fecha}' and pa.id_usuario = '{$id_usuario}' and fp.id='{$fp[$i]['id']}'  ORDER BY fp.nombre ASC";

        $result_egr = mysqli_query($conn, $query_egr);
        if(!$result_egr) {
            die('Error en consulta '.mysqli_error($conn));
        } 
        $egr = array();
        while($row = mysqli_fetch_array($result_egr)) {
            $egr[] = array(
                'total' => $row['total']
            );
        }
        for ($l=0; $l < sizeof($egr); $l++) {
            $egreso=$egr[$l]['total'];
            if($egreso==0)
            {
                $pdf->SetFont('Arial','', 6);
                $pdf->Cell(30,6,utf8_decode("$".number_format($egr[$l]['total'],2)),1,0,'C');
                
            }
            else
            {
                $pdf->SetFont('Arial','B', 6);
                $pdf->Cell(30,6,utf8_decode("$".number_format($egr[$l]['total'],2)),1,0,'C');
                $pdf->SetFont('Arial','',6);
            }
        }
   
        $pdf->SetFont('Arial','B', 6);
        $pdf->Cell(30,6,utf8_decode("$".number_format($ingreso-$egreso,2)),1,1,'C');
        $pdf->SetFont('Arial','', 6);
        
   
}




$pdf->Output("reporte_cuadre_c.pdf","I",true);
?>