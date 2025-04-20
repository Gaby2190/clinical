<?php  
require 'librerias/phpword/vendor/autoload.php';
include_once '../../../dbconnection.php';
require_once '../../lib/numeroaletras.php';
date_default_timezone_set('America/Guayaquil'); 
$id_cita = $_GET['id_cita'];
$modelonumero = new modelonumero();
$numeroaletras = new numeroaletras();



//======================= Consulta Query 1 ========================



$query_1 = "SELECT ci.id_caso, ci.problema_act, ci.t_contingencia, ci.fecha,ci.dias_reposo, ci.detalle_certificado, ca.fecha_registro, ca.fecha_alta, ca.c_alta, ca.t_tratamiento, ca.proc_cq, ca.semana_embarazo, esp.nombre as especialidad, me.nautorizacion_medi,me.sufijo,me.apellidos_medi,me.nombres_medi, me.correo_medi, me.telefono_medi,me.celular_medi,me.cedula_medi, pa.*, ge.nombre as genero, na.nombre as nacionalidad
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
    $direccion_paci = $row['direccion_paci'];
    $parroquia_paci = $row['parroquia_paci'];
    $provincia_paci = $row['provincia_paci'];
    $ocupacion_paci = $row['ocupacion_paci'];
    $empresat_paci = $row['empresat_paci'];
    $contacto_dir = $row['contacto_dir'];
    $contacto_nom = $row['contacto_nom'];   
    $contacto_ape = $row['contacto_ape']; 
    $contacto_par = $row['contacto_par'];
    $contacto_num = $row['contacto_num'];
    $genero = $row['genero'];
    $nacionalidad = $row['nacionalidad'];
    $sufijo = $row['sufijo'];
    $apellidos_medi = $row['apellidos_medi'];
    $nombres_medi = $row['nombres_medi'];
    $correo_medi = $row['correo_medi'];
    $telefono_medi = $row['telefono_medi'];
    $celular_medi = $row['celular_medi'];
    $detalle_certificado = $row['detalle_certificado'];
    $problema_act = $row['problema_act'];
    $cedula_medico=$row['cedula_medi'];
    
    
}

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

     $fecha_nac = new DateTime(date('Y/m/d',strtotime($fechan_paci))); 
     $fecha_hoy =  new DateTime(date('Y/m/d',strtotime($fecha))); 
     $edad = date_diff($fecha_hoy,$fecha_nac); 
   



$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('plantillas/CERTIFICADO.docx');
$templateProcessor->setValue('especialidad',$especialidad);

if($genero=="MASCULINO"){
    $templateProcessor->setValue('genero',"el");
    $templateProcessor->setValue('embarazo',""); 

}
if($genero=="FEMENINO"){
    $templateProcessor->setValue('genero',"la");

    if (intval($s_embarazo)>0) {
      if (intval($s_embarazo)==1) {
        $templateProcessor->setValue('genero',"la");
        $templateProcessor->setValue('embarazo',"Con ".$s_embarazo." semana de embarazo.");
      }else{
        $templateProcessor->setValue('genero',"la");
        $templateProcessor->setValue('embarazo',"Con ".$s_embarazo." semanas de embarazo.");
      }
        
    }else{
      $templateProcessor->setValue('genero',"la");
      $templateProcessor->setValue('embarazo',"");                                                                                                                                                       
    }

}




$templateProcessor->setValue('paciente',$nombres_paci1.' '.$nombres_paci2.' '.$apellidos_paci1.' '.$apellidos_paci2);
$templateProcessor->setValue('edad',$edad->format('%Y')." años ");
$templateProcessor->setValue('cedula_paci',$cedula_paci);
$templateProcessor->setValue('provincia',$provincia_paci);
$templateProcessor->setValue('parroquia',$parroquia_paci);
$templateProcessor->setValue('direccion',$direccion_paci);
$templateProcessor->setValue('telefono',$celular_paci);
$templateProcessor->setValue('contingencia',$t_contingencia);
$templateProcessor->setValue('actividad_laboral',$ocupacion_paci);
$templateProcessor->setValue('trabajo',$empresat_paci);


//==================== consulta query 2 =================0
$query2 = "SELECT dia.*, cie.clave, ci.fecha 
            FROM diagnostico as dia 
            INNER JOIN diagnosticoscie10 as cie 
              ON dia.id_cie = cie.id 
            INNER JOIN cita as ci 
              ON dia.id_cita = ci.id_cita 
            INNER JOIN caso as ca 
              ON ci.id_caso = ca.id_caso 
            WHERE ca.id_caso = '$id_caso' ORDER BY ci.fecha DESC";
$result2 = mysqli_query($conn, $query2);
if(!$result2) {
    die('Consulta fallida'. mysqli_error($conn));
}
$diagnosticos = array();
while($row = mysqli_fetch_array($result2)) {
    $diagnosticos[] = array(
    'descripcion' => $row['descripcion'],
    'pre_def' => $row['pre_def'],
    'clave' => $row['clave'],
    'diagnostico_esp' => $row['diagnostico_esp']
    
    );
}


$templateProcessor->setValue('diagnostico',$diagnosticos[0]['descripcion']);
$templateProcessor->setValue('cie',$diagnosticos[0]['clave']);
$templateProcessor->setValue('situacion',$problema_act);

$fecha_ing = new DateTime($fecha);
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


$templateProcessor->setValue('dia',$numeroaletras->convertir(floatval($dia_ing)));
$templateProcessor->setValue('fecha',$dia_ing." de ".$mes_ing." de ".$año_ing);

if($dias_reposo>0){

  $templateProcessor->setValue('campo_reposo','N.º de días de reposo absoluto:');
  $templateProcessor->setValue('reposo',"(".$numeroaletras->convertir(floatval($dias_reposo)).") ".$dias_reposo." días");
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
  $templateProcessor->setValue('periodo_reposo',"Desde el ".$dia."/".$m."/".$año." (".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($dia))))." de ".$mes." del ".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($año)))).") hasta el ".$dia_des."/".$m_des."/".$año_des." (".mb_strtolower(rtrim ($numeroaletras->convertir(floatval(($dia_des)))))." de ".$mes_des." del ".mb_strtolower(rtrim ($numeroaletras->convertir(floatval($año_des)))).")");
}
else
{
  $templateProcessor->setValue('campo_reposo','');
  $templateProcessor->setValue('reposo',"");
  $templateProcessor->setValue('periodo_reposo',"");
}



$templateProcessor->setValue('sufijo',$sufijo);
$templateProcessor->setValue('medico',$nombres_medi.' '.$apellidos_medi);
$templateProcessor->setValue('cedula_medi',$cedula_medico);
$templateProcessor->setValue('correo_medi',$correo_medi);
$templateProcessor->setValue('cel_medi',$celular_medi);


if(strlen($detalle_certificado)>0)
{
  $templateProcessor->setValue('campo_nota','Nota: ');
  $templateProcessor->setValue('nota',$detalle_certificado);
}
else
{
  $templateProcessor->setValue('campo_nota','');
  $templateProcessor->setValue('nota','');
}


header('Content-Disposition: attachment; filename="'.$nombres_paci1.' '.$nombres_paci2.' '.$apellidos_paci1.' '.$apellidos_paci2.'.docx"');
$templateProcessor->saveAs("php://output");

?>