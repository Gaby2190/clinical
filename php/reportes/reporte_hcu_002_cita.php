<?php
require_once '../FPDF/fpdf.php';
include_once '../../dbconnection.php';
include_once '../../variables.php';

date_default_timezone_set('America/Guayaquil'); 
$id_cita_consulta = $_GET['id_cita'];
$id_caso = 0;

$query = "SELECT id_caso from cita
WHERE id_cita ='$id_cita_consulta'";

$result = mysqli_query($conn, $query);
if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result)) {
    $id_caso = $row['id_caso'];
}





function calcular_edad($fecha,$fecha_registro) {
    $fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); 
    $fecha_hoy =  new DateTime(date('Y/m/d',strtotime($fecha_registro))); 
    $edad = date_diff($fecha_hoy,$fecha_nac); 
    return $edad;
}

$hoja=0;

class PDF extends FPDF {
// Cabecera de página
function Header()
{
    $this->SetY(10);
    //LOGO
    $this->Image('../../assets/images/logo_rce.jpeg',12,9,15,15);
    $this->Image('../../assets/images/msp_logo.png',178,10,20,13);
    //TÍTULO
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(34, 68, 93); 
    $this->Cell(190,4,utf8_decode('CENTRO DE ESPECIALIDADES MÉDICAS CLÍNICO QUIRÚRGICO'),0,1,'C');
    $this->Cell(190,4,utf8_decode('AMBULATORIO CESMED HOSPITAL DEL DÍA'),0,1,'C');
    //DIRECCIÓN
    $this->SetFont('Arial','BI', 7);

    $this->Cell(190,4,utf8_decode('Dirección: Av. San Francisco y Uruguay (esquina) Teléfono: 2986771  -  2985931'),0,1,'C');
    $this->Cell(190,4,utf8_decode('Tulcán - Ecuador'),0,1,'C');
   
   // $this->Image('../../assets/images/no_valido.png',60,140,100);
}

// Pie de página
function Footer()
{
   
    // Posición: a 1,5 cm del final
    $this->SetY(-20);
    // Arial italic 10
    $this->SetFont('Arial','B',7);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(20,5,utf8_decode('SNS-MSP / HCU-form.002 / 2021'),0,0,'L');
    $this->SetFont('Arial','B',9);
    $this->Cell(150);

    $pagina= $this->PageNo();
    if (($pagina % 2) == 0) {
        $this->Cell(20,5,utf8_decode('CONSULTA EXTERNA - EXAMEN FÍSICO Y PRESCRIPCIONES (2)'),0,0,'R');
    } else {
        $this->Cell(20,5,utf8_decode('CONSULTA EXTERNA - ANAMNESIS (1)'),0,0,'R');
    }
}



}

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//BLOQUE - DATOS DEL PACIENTE
$query = "SELECT ci.tipo_cita, ci.id_cita, ci.fecha, ci.hora, ci.motivo_con, ci.problema_act, ca.id_caso, me.id_medico, pa.id_paciente,me.sufijo, me.nombres_medi, me.apellidos_medi, me.nautorizacion_medi, pa.nombres_paci1, pa.apellidos_paci1 , pa.nombres_paci2, pa.apellidos_paci2,pa.cedula_paci, pa.fechan_paci, ge.nombre as genero, ca.fecha_registro 
FROM caso as ca 
INNER JOIN cita as ci ON ci.id_caso = ca.id_caso 
INNER JOIN medico as me ON ca.id_medico = me.id_medico 
INNER JOIN paciente as pa ON ca.id_paciente = pa.id_paciente 
INNER JOIN genero as ge ON pa.gen_id = ge.id 
WHERE ca.id_caso='$id_caso'";

$result = mysqli_query($conn, $query);
if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result)) {
    $hoja++;
    if ($row['id_cita']==$id_cita_consulta) 
{
    $tipo_cita = $row['tipo_cita'];
    $id_caso = $row['id_caso'];
    $motivo_con = $row['motivo_con'];
    $problema_act = $row['problema_act'];
    $id_medico = $row['id_medico'];
    $id_paciente = $row['id_paciente'];
    $sufijo = $row['sufijo'];
    $nombres_medi = $row['nombres_medi'];
    $apellidos_medi = $row['apellidos_medi'];
    $nautorizacion_medi = $row['nautorizacion_medi'];
    $nombres_paci1 = $row['nombres_paci1'];
    $apellidos_paci1 = $row['apellidos_paci1'];
    $nombres_paci2 = $row['nombres_paci2'];
    $apellidos_paci2 = $row['apellidos_paci2'];
    $fechan_paci = $row['fechan_paci'];
    $cedula_paci = $row['cedula_paci'];
    $genero = $row['genero'];
    $fecha_registro = $row['fecha'];  
    $id_cita = $row['id_cita'];
    $fecha_norm = $row['fecha'];
    $hora_norm = $row['hora'];

    


        if($fechan_paci=='0000-00-00')
        {
            $edad = 'no calculada';
        }
        else
        {
            $edad = calcular_edad($fechan_paci,$fecha_registro);
        }
//echo $edad;
        //---------------------------------- BLOQUE A - DATOS ESTABLECIMIENTO ---------------------------------
        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(190,5,'A. DATOS DEL ESTABLECIMIENTO Y USUARIO / PACIENTE',1,0,'L',true);
        $pdf->Ln(5);

        $pdf->SetFillColor(188,188,188);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','B', 6);
        $pdf->Cell(34,5,utf8_decode('INSTITUCIÓN DEL SISTEMA'),1,0,'C',true);
        $pdf->Cell(20,5,utf8_decode('UNICÓDIGO'),1,0,'C',true);
        $pdf->Cell(51,5,utf8_decode('ESTABLECIMIENTO DE SALUD'),1,0,'C',true);
        $pdf->Cell(45,5,utf8_decode('NÚMERO DE HISTORIA CLÍNICA ÚNICA'),1,0,'C',true);
        $pdf->Cell(30,5,utf8_decode('NÚMERO DE ARCHIVO'),1,0,'C',true);
        $pdf->Cell(10,5,utf8_decode('N° HOJA'),1,1,'C',true);

        $pdf->SetFont('Arial','', 6);
        $pdf->Cell(34,5,'PRIVADO',1,0,'C');
        $pdf->Cell(20,5,'25800',1,0,'C');
        $pdf->Cell(51,5,utf8_decode('CESMED S.C.'),1,0,'C');
        $pdf->Cell(45,5,$cedula_paci,1,0,'C');
        $pdf->Cell(30,5,"CE-".$id_caso."-".$id_cita,1,0,'C');
        $pdf->Cell(10,5,$hoja,1,1,'C');

       

        $pdf->SetFont('Arial','B', 6);
        $pdf->Cell(40,5,utf8_decode('PRIMER APELLIDO'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode('SEGUNDO APELLIDO'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode('PRIMER NOMBRE'),1,0,'C',true);
        $pdf->Cell(40,5,utf8_decode('SEGUNDO NOMBRE'),1,0,'C',true);
        $pdf->Cell(10,5,utf8_decode('SEXO'),1,0,'C',true);
        $pdf->Cell(20,5,utf8_decode('EDAD'),1,1,'C',true);

        $pdf->SetFont('Arial','', 6);
        $pdf->Cell(40,5,utf8_decode($apellidos_paci1),1,0,'C');
        $pdf->Cell(40,5,utf8_decode($apellidos_paci2),1,0,'C');
        $pdf->Cell(40,5,utf8_decode($nombres_paci1),1,0,'C');
        $pdf->Cell(40,5,utf8_decode($nombres_paci2),1,0,'C');
        $pdf->Cell(10,5,$genero[0],1,0,'C');
        if ($edad != '0000/00/00')
        {
            $pdf->Cell(20,5,$edad->format('%Y').utf8_decode(' años, ').$edad->format('%m').' meses',1,0,'C');
        }
        else
        {
            $pdf->Cell(20,5,"",1,0,'C');
        }

        $pdf->Ln(7);

        //---------------------------------- BLOQUE B - MOTIVO CONSULTA ---------------------------------

        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(110,5,'B. MOTIVO DE CONSULTA',1,0,'L',true);
        $pdf->SetFont('Arial','B', 7);
        if ($tipo_cita==1){
            $pdf->Cell(25,5,utf8_decode('PRIMERA'),'RBT',0,'C', true);
            $pdf->Cell(10,5,utf8_decode('X'),'RBT',0,'C');
            $pdf->Cell(35,5,utf8_decode('SUBSECUENTE'),'RBT',0,'C', true);
            $pdf->Cell(10,5,utf8_decode(''),'RBT',1,'R');
        }
        else
        {
            $pdf->Cell(25,5,utf8_decode('PRIMERA'),'RBT',0,'C', true);
            $pdf->Cell(10,5,utf8_decode(''),'RBT',0,'R');
            $pdf->Cell(35,5,utf8_decode('SUBSECUENTE'),'RBT',0,'C', true);
            $pdf->Cell(10,5,utf8_decode('X'),'RBT',1,'C');
        }

      

        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','', 7);
        $pdf->MultiCell(190,5,'*'.$motivo_con.'*',1,'L');
        $pdf->Ln(2);

        //---------------------------------- BLOQUE C. ANTECEDENTES PERSONALES ---------------------------------
        $query2 = "SELECT ap.*, enf.nombre
                    FROM antecedente_p as ap
                    INNER JOIN enfermedad as enf
                        ON ap.id_enfermedad = enf.id
                    WHERE ap.id_paciente = '$id_paciente' AND ap.fecha <= '$fecha_norm'";
        $result2 = mysqli_query($conn, $query2);
        if(!$result2) {
            die('Consulta fallida'. mysqli_error($conn));
        }
        $antecedentes_p = array();
        while($row = mysqli_fetch_array($result2)) {
            $antecedentes_p[] = array(
            'descripcion' => $row['descripcion'],
            'id_enfermedad' => $row['id_enfermedad'],
            'nombre' => $row['nombre'],
            'fecha' => $row['fecha']
            );
        }

        $car = 0;
        $dia = 0;
        $ecv = 0;
        $hip = 0;
        $can = 0;
        $tub = 0;
        $e_me = 0;
        $e_in = 0;
        $mf = 0;
        $otr = 0;
        for ($i=0; $i < sizeof($antecedentes_p); $i++) {
            switch ($antecedentes_p[$i]['id_enfermedad']) {
                case 1:
                    $car = 1;
                    break;
                case 2:
                    $dia = 1;
                    break;
                case 3:
                    $ecv = 1;
                    break;
                case 4:
                    $hip = 1;
                    break;
                case 5:
                    $can = 1;
                    break;
                case 6:
                    $tub = 1;
                    break;
                case 7:
                    $e_me = 1;
                    break;
                case 8:
                    $e_in = 1;
                    break;
                case 9:
                    $mf = 1;
                    break;
                case 10:
                    $otr = 1;
                    break;
            }
        }

        $str_ant_p = '';
        for ($i=0; $i < sizeof($antecedentes_p); $i++) { 
            $str_ant_p = $str_ant_p.mb_strtoupper($antecedentes_p[$i]['fecha']." - ".$antecedentes_p[$i]['nombre'])." - ".$antecedentes_p[$i]['descripcion'].'. ';
        }


        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(120,5,utf8_decode('C. ANTECEDENTES PATOLOGICOS PERSONALES'),1,0,'L',true);
        $pdf->SetFont('Arial','B', 5);
        $pdf->Cell(70,5,utf8_decode('DATOS CLÍNICO - QUIRÚRGICOS, OBSTÉTRICOS, ALÉRGICOS RELEVANTES'),'RBT',1,'R', true);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(188,188,188);
        $pdf->Cell(15,3,utf8_decode('1. '),'LRT',0,'L',true);
        if ($car == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(17,3,utf8_decode('2.'),'LRT',0,'L',true);
        if ($dia == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,3,utf8_decode('3. ENF. C.'),'LRT',0,'C',true);
        if ($ecv == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,3,utf8_decode('4. ENDÓCRINO'),'LRT',0,'C',true);
        if ($hip == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,6,utf8_decode('5. CÁNCER'),1,0,'C',true);
        if ($can == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(18,6,utf8_decode('6. TUBERCULOSIS'),1,0,'C',true);
        if ($tub == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,3,utf8_decode('7. ENF.'),'LRT',0,'C',true);
        if ($e_me == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(15,3,utf8_decode('8. ENF.'),'LRT',0,'C',true);
        if ($e_in == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(15,3,utf8_decode('9. MAL'),'LRT',0,'C',true);
        if ($mf == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,6,utf8_decode('10. OTRO'),1,0,'C',true);
        if ($otr == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        //Abajo
        $pdf->Ln(3);
        $pdf->Cell(15,3,utf8_decode('CARDIOPATÍA'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(17,3,utf8_decode('HIPERTENSIÓN'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(14,3,utf8_decode('VASCULAR'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(14,3,utf8_decode('METABÓLICO'),'LRB',0,'C',true);
        $pdf->Cell(44);
        $pdf->Cell(14,3,utf8_decode('MENTAL'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(15,3,utf8_decode('INFECCIOSA'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(15,3,utf8_decode('FORMACIÓN'),'LRB',1,'C',true);
        $pdf->SetFont('Arial','', 7);


        $pdf->MultiCell(190,5,utf8_decode('*'.$str_ant_p.'*'),1,'L');


        $celdas = (95 - $pdf->GetY())/5;
        for ($i=0; $i < $celdas; $i++) { 
            $pdf->SetFillColor(238,238,238);
            $pdf->Cell(190,5,'',1,1,'C',true);
        }

        $pdf->Ln(2);

        //---------------------------------- BLOQUE D. ANTECEDENTES FAMILIARES ---------------------------------
        $query3 = "SELECT anf.*, enf.nombre
                FROM antecedente_f as anf
                INNER JOIN enfermedad as enf
                    ON anf.id_enfermedad = enf.id
                WHERE anf.id_paciente = '$id_paciente'";
        $result3 = mysqli_query($conn, $query3);
        if(!$result3) {
            die('Consulta fallida'. mysqli_error($conn));
        }
        $antecedentes_f = array();
        while($row = mysqli_fetch_array($result3)) {
            $antecedentes_f[] = array(
            'parentesco' => $row['parentesco'],
            'descripcion' => $row['descripcion'],
            'id_enfermedad' => $row['id_enfermedad'],
            'nombre' => $row['nombre']
            );
        }
        $car = 0;
        $dia = 0;
        $ecv = 0;
        $hip = 0;
        $can = 0;
        $tub = 0;
        $e_me = 0;
        $e_in = 0;
        $mf = 0;
        $otr = 0;
        for ($i=0; $i < sizeof($antecedentes_f); $i++) {
            switch ($antecedentes_f[$i]['id_enfermedad']) {
                case 1:
                    $car = 1;
                    break;
                case 2:
                    $dia = 1;
                    break;
                case 3:
                    $ecv = 1;
                    break;
                case 4:
                    $hip = 1;
                    break;
                case 5:
                    $can = 1;
                    break;
                case 6:
                    $tub = 1;
                    break;
                case 7:
                    $e_me = 1;
                    break;
                case 8:
                    $e_in = 1;
                    break;
                case 9:
                    $mf = 1;
                    break;
                case 10:
                    $otr = 1;
                    break;
            }
        }

        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(190,5,utf8_decode('D. ANTECEDENTES PATOLOGICOS FAMILIARES'),1,0,'L',true);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','', 5);
        $pdf->SetFillColor(188,188,188);
        $pdf->Ln(5);
        $pdf->Cell(15,3,utf8_decode('1. '),'LRT',0,'L',true);
        if ($car == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(17,3,utf8_decode('2.'),'LRT',0,'L',true);
        if ($dia == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,3,utf8_decode('3. ENF. C.'),'LRT',0,'C',true);
        if ($ecv == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,3,utf8_decode('4. ENDÓDRINO'),'LRT',0,'C',true);
        if ($hip == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,6,utf8_decode('5. CÁNCER'),1,0,'C',true);
        if ($can == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(18,6,utf8_decode('6. TUBERCULOSIS'),1,0,'C',true);
        if ($tub == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,3,utf8_decode('7. ENF.'),'LRT',0,'C',true);
        if ($e_me == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(15,3,utf8_decode('8. ENF.'),'LRT',0,'C',true);
        if ($e_in == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(15,3,utf8_decode('9. MAL'),'LRT',0,'C',true);
        if ($mf == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        $pdf->Cell(14,6,utf8_decode('10. OTRO'),1,0,'C',true);
        if ($otr == 1) {
            $pdf->Cell(4,6,'X',1,0,'C');
        }else{
            $pdf->Cell(4,6,'',1,0,'C');
        }

        //Abajo
        $pdf->Ln(3);
        $pdf->Cell(15,3,utf8_decode('CARDIOPATÍA'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(17,3,utf8_decode('HIPERTENSIÓN'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(14,3,utf8_decode('VASCULAR'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(14,3,utf8_decode('METABÓLICO'),'LRB',0,'C',true);
        $pdf->Cell(44);
        $pdf->Cell(14,3,utf8_decode('MENTAL'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(15,3,utf8_decode('INFECCIOSA'),'LRB',0,'C',true);
        $pdf->Cell(4);
        $pdf->Cell(15,3,utf8_decode('FORMACIÓN'),'LRB',1,'C',true);


        $desc_af = '';
        for ($i=0; $i < sizeof($antecedentes_f); $i++) {
            if (($antecedentes_f[$i]['descripcion'] != null) || ($antecedentes_f[$i]['descripcion'] != '')) {
            $desc_af = $desc_af.$antecedentes_f[$i]['nombre'].' en '.$antecedentes_f[$i]['parentesco'].' - '.$antecedentes_f[$i]['descripcion'].'. ';
            }
        }


        $pdf->MultiCell(190,5,utf8_decode('*'.$desc_af.'*'),1,'L');
        $celdas = (125 - $pdf->GetY())/5;
        for ($i=0; $i < $celdas; $i++) { 
            $pdf->SetFillColor(238,238,238);
            $pdf->Cell(190,5,'',1,1,'C',true);
        }

        $pdf->Ln(2);

        //---------------------------------- BLOQUE E. ENFERMEDAD O PROBLEMA ACTUAL ---------------------------------

        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(110,6,utf8_decode('E. ENFERMEDAD O PROBLEMA ACTUAL'),1,0,'L',true);

        $pdf->SetFont('Arial','', 6);
        $pdf->Cell(80,3,utf8_decode('CRONOLOGÍA - LOCALIZACIÓN - CARACTERÍSTICAS - INTENSIDAD -'),'TR',0,'R',true);
        $pdf->Ln(3);
        $pdf->Cell(110);
        $pdf->Cell(80,3,utf8_decode('FRECUENCIA - FACTORES AGRAVANTES'),'BR',0,'R',true);

        $pdf->SetTextColor(0,0,0);
        $pdf->Ln(5);
        $pdf->SetFont('Arial','', 8);


        $pdf->MultiCell(190,5,utf8_decode('*'.$problema_act.'*'),1,'L');
        $celdas = (170 - $pdf->GetY())/5;
        for ($i=0; $i < $celdas; $i++) { 
            $pdf->SetFillColor(238,238,238);
            $pdf->Cell(190,5,'',1,1,'C',true);
        }



        $pdf->Ln(2);

        //---------------------------------- BLOQUE F. CONSTANTES VITALES Y ANTROPOMETRIA ---------------------------------

        $query5 = "SELECT sva.* 
                    FROM signov_ant  as sva
                    INNER JOIN cita as ci
                        ON sva.id_cita = ci.id_cita
                    INNER JOIN caso as ca
                        ON ci.id_caso = ca.id_caso
                    WHERE ca.id_caso = '$id_caso' AND ci.id_cita ='$id_cita'"; 
 
        $result5 = mysqli_query($conn, $query5);
        if(!$result5) {
            die('Consulta fallida'. mysqli_error($conn));
        }
        $signosv_ant = array();
        while($row = mysqli_fetch_array($result5)) {
            $signosv_ant[] = array(
            'fecha' => $row['fecha'],
            'hora' => $row['hora'],
            'temperatura' => $row['temperatura'],
            'presion_as' => $row['presion_as'],
            'presion_ad' => $row['presion_ad'],
            'pulso' => $row['pulso'],
            'frecuencia_r' => $row['frecuencia_r'],
            'frecuencia_c' => $row['frecuencia_c'],
            'sat_o' => $row['sat_o'],
            'peso' => $row['peso'],
            'talla' => $row['talla'],
            'p_abdominal' => $row['p_abdominal'],
            'h_capilar' => $row['h_capilar'],
            'g_capilar' => $row['g_capilar'],
            'pulsio' => $row['pulsio']
            );
        }

        $reg_sva = sizeof($signosv_ant);
        $rest_sva = 4 - $reg_sva;

        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(190,5,utf8_decode('F. CONSTANTES VITALES Y ANTROPOMETRÍA'),1,0,'L',true);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','B', 5);
        $pdf->Ln(5);
        $pdf->SetFillColor(188,188,188);
 
        $y_total = $pdf->getY();
        $x_total = 10;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(15,6,utf8_decode('FECHA'),1,'C',true);
        $x_total += 15;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(10,6,utf8_decode('HORA'),1,'C',true);
        $x_total += 10;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(15,3,utf8_decode('Temperatura (°C)'),1,'C',true);
        $x_total += 15;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(21,3,utf8_decode('Presión Arterial (mmHg)'),1,'C',true);
        $x_total += 21;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(12,6,utf8_decode('Pulso / Min'),1,'C',true);
        $x_total += 12;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(10,3,utf8_decode('Peso (Kg)'),1,'C',true);
        $x_total += 10;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(10,3,utf8_decode('Talla (cm)'),1,'C',true);
        $x_total += 10;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(10,3,utf8_decode('IMC (Kg/m²)'),1,'C',true);
        $x_total += 10;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(22,3,utf8_decode('Perímetro Abdominal (cm)'),1,'C',true);
        $x_total += 22;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(15,3,utf8_decode('Hemoglobina Capilar (g/dl)'),1,'C',true);
        $x_total += 15;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(20,3,utf8_decode('Frecuencia Respiratoria / Min'),1,'C',true);
        $x_total += 20;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(15,3,utf8_decode('Glucosa Capilar (mg/dl)'),1,'C',true);
        $x_total += 15;
        $pdf->SetXY($x_total, $y_total);
        $pdf->Multicell(15,3,utf8_decode('Pulsioximetría (%)'),1,'C',true);




        $pdf->SetFont('Arial','', 5);
        for ($i=0; $i < $reg_sva; $i++) { 
            
                $pdf->Cell(15,4,utf8_decode('*'.$signosv_ant[$i]['fecha'].'*'),1,0,'C');
                $pdf->Cell(10,4,utf8_decode('*'.substr($signosv_ant[$i]['hora'],0,5).'*'),1,0,'C');
                $pdf->Cell(15,4,utf8_decode('*'.$signosv_ant[$i]['temperatura'].'*'),1,0,'C');
                $pdf->Cell(10.5,4,utf8_decode('*'.$signosv_ant[$i]['presion_as'].'*'),1,0,'C');
                $pdf->Cell(10.5,4,utf8_decode('*'.$signosv_ant[$i]['presion_ad'].'*'),1,0,'C');
                $pdf->Cell(12,4,utf8_decode('*'.$signosv_ant[$i]['pulso'].'*'),1,0,'C');
                $pdf->Cell(10,4,utf8_decode('*'.$signosv_ant[$i]['peso'].'*'),1,0,'C');
                $pdf->Cell(10,4,utf8_decode('*'.$signosv_ant[$i]['talla'].'*'),1,0,'C');
                $tallam=($signosv_ant[$i]['talla'])/100;
                $peso=$signosv_ant[$i]['peso'];
                if (($peso==0)||($tallam==0))
                {
                    $imc=0;
                }
                else
                {
                    $imc=number_format($peso/(($tallam)*($tallam)),0);
                }
                $pdf->Cell(10,4,utf8_decode('*'.$imc.'*'),1,0,'C');
                $pdf->Cell(22,4,utf8_decode('*'.$signosv_ant[$i]['frecuencia_r'].'*'),1,0,'C');
                $pdf->Cell(15,4,utf8_decode('*'.$signosv_ant[$i]['p_abdominal'].'*'),1,0,'C');
                $pdf->Cell(20,4,utf8_decode('*'.$signosv_ant[$i]['h_capilar'].'*'),1,0,'C');
                $pdf->Cell(15,4,utf8_decode('*'.$signosv_ant[$i]['g_capilar'].'*'),1,0,'C');
                $pdf->Cell(15,4,utf8_decode('*'.$signosv_ant[$i]['pulsio'].'*'),1,1,'C');
        }


        $pdf->Ln(2);
        //---------------------------------- BLOQUE G. REVISION DE ORGANOS Y SISTEMAS ---------------------------------
        $query4 = "SELECT ros.* 
                    FROM revision_o_s  as ros
                    INNER JOIN cita as ci
                        ON ros.id_cita = ci.id_cita
                    INNER JOIN caso as ca
                        ON ci.id_caso = ca.id_caso
                    WHERE ca.id_caso = '$id_caso'and ci.fecha='$fecha_norm' and ci.hora='$hora_norm';";
        $result4 = mysqli_query($conn, $query4);
        if(!$result4) {
            die('Consulta fallida'. mysqli_error($conn));
        }
        $revisiones_os = array();
        while($row = mysqli_fetch_array($result4)) {
            $revisiones_os[] = array(
            'orga_sist' => $row['orga_sist'],
            'cp' => $row['cp'],
            'descripcion' => $row['descripcion']
            );
        }
        $cp_os = 0;
        $cp_cv = 0;
        $cp_gen = 0;
        $cp_uri = 0;
        $cp_end = 0;
        $cp_me = 0;
        $cp_dig = 0;
        $cp_res = 0;
        $cp_ner = 0;
        $cp_hl = 0;

        for ($i=0; $i < sizeof($revisiones_os); $i++) { 
            switch ($revisiones_os[$i]['orga_sist']) {
                case 'Órganos de los sentidos':
                    $cp_os = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Cardio vascular':
                    $cp_cv = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Genito - Urinario':
                    $cp_gen = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Piel - Anexos':
                    $cp_uri = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Endocrino':
                    $cp_end = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Músculo esquelético':
                    $cp_me = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Digestivo':
                    $cp_dig = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Respiratorio':
                    $cp_res = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Nervioso':
                    $cp_ner = intval($revisiones_os[$i]['cp']);
                    break;
                case 'Hemo linfático':
                    $cp_hl = intval($revisiones_os[$i]['cp']);
                    break;
            }
        }


        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(130,5,utf8_decode('G. REVISIÓN ACTUAL DE ÓRGANOS Y SISTEMAS'),1,0,'L',true);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Arial','', 5);
        $pdf->Cell(60,5,utf8_decode('MARCAR "X" CUANDO PRESENTE PATOLOGÍA Y DESCRIBA'),1,1,'C',true);

        $pdf->SetFillColor(188,188,188);
        $pdf->SetFont('Arial','', 6);
        $pdf->Cell(6,6,'1',1,0,'R',true);
        $pdf->Cell(33,6,utf8_decode('PIEL - ANEXOS'),'LTR',0,'L',true);

        if ($cp_uri == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
            
        }

        $pdf->Cell(6,6,'3',1,0,'R',true);
        $pdf->Cell(22,6,utf8_decode('RESPIRATORIO'),1,0,'L',true);

        if ($cp_res == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
            
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
            
        }

        $pdf->Cell(6,6,'5',1,0,'R',true);
        $pdf->Cell(22,6,utf8_decode('DIGESTIVO'),1,0,'L',true);

        if ($cp_dig == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
            
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
            
        }

        $pdf->Cell(6,6,'7',1,0,'R',true);
        $pdf->Cell(31,6,utf8_decode('MÚSCULO - ESQUELÉTICO'),'LTR',0,'L',true);

        if ($cp_me == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
            
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
            
        }

        $pdf->Cell(6,6,'9',1,0,'R',true);
        $pdf->Cell(22,6,utf8_decode('HEMO LINFÁTICO'),1,0,'L',true);

        if ($cp_hl == 1) {
            $pdf->Cell(6,6,'X',1,1,'C');
            
        }else{
            $pdf->Cell(6,6,'',1,1,'C');
            
        }



        //Parte Inferior

        $pdf->Cell(6,6,'2',1,0,'R',true);
        $pdf->Cell(33,6,utf8_decode('ÓRGANOS DE LOS SENTIDOS'),1,0,'L',true);
        if ($cp_os == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
            
        }


        $pdf->Cell(6,6,'4',1,0,'R',true);
        $pdf->Cell(22,6,utf8_decode('CARDIO VASCULAR'),1,0,'L',true);

        if ($cp_cv == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'6',1,0,'R',true);
        $pdf->Cell(22,6,utf8_decode('GENITO - URINARIO'),1,0,'L',true);

        if ($cp_gen == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');  
        }




        $pdf->Cell(6,6,'8',1,0,'R',true);
        $pdf->Cell(31,6,utf8_decode('ENDOCRINO'),1,0,'L',true);

        if ($cp_end == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'10',1,0,'R',true);
        $pdf->Cell(22,6,utf8_decode('NERVIOSO'),1,0,'L',true);

        if ($cp_ner == 1) {
            $pdf->Cell(6,6,'X',1,1,'C');
        }else{
            $pdf->Cell(6,6,'',1,1,'C'); 
        }

        $desc_ros = '';
        for ($i=0; $i < sizeof($revisiones_os); $i++) { 
            if (($revisiones_os[$i]['descripcion'] != '') || ($revisiones_os[$i]['descripcion'] != null)) {
                $desc_ros = $desc_ros.$revisiones_os[$i]['orga_sist'].' - '.$revisiones_os[$i]['descripcion'].'. ';
            }
        }

        $pdf->SetFont('Arial','', 7);
        $pdf->MultiCell(190,4,utf8_decode('*'.$desc_ros.'*'),1,'L');


        $celdas = (270 - $pdf->GetY())/5;
        for ($i=0; $i < $celdas; $i++) { 
            $pdf->SetFillColor(238,238,238);
            $pdf->Cell(190,5,'',1,1,'C',true);
        }

        //_-------------------------------------- Segunda Pagina ----------------------------------

        $pdf->Ln(1);

        //BLOQUE 7
        $query6 = "SELECT efr.* 
                    FROM examen_fr  as efr
                    INNER JOIN cita as ci
                        ON efr.id_cita = ci.id_cita
                    INNER JOIN caso as ca
                        ON ci.id_caso = ca.id_caso
                    WHERE ca.id_caso = '$id_caso' and ci.fecha='$fecha_norm' and ci.hora='$hora_norm';";
                    

        $result6 = mysqli_query($conn, $query6);
        if(!$result6) {
            die('Consulta fallida'. mysqli_error($conn));
        }
        $examenes_fr = array();
        while($row = mysqli_fetch_array($result6)) {
            $examenes_fr[] = array(
            'examen_fr' => $row['examen_fr'],
            'cp' => $row['cp'],
            'descripcion' => $row['descripcion']
            );
        }
        $cp_cue = 0;
        $cp_cab = 0;
        $cp_tor = 0;
        $cp_abd = 0;
        $cp_ext = 0;
        $cp_pel = 0;

        for ($i=0; $i < sizeof($examenes_fr); $i++) { 
            switch ($examenes_fr[$i]['examen_fr']) {
                case 'Piel - Faneras':
                    $cp_piel = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Cabeza':
                    $cp_cabeza = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Ojos':
                    $cp_ojos = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Oidos':
                    $cp_oidos = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Nariz':
                    $cp_nariz = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Orofaringe':
                    $cp_orofaringe = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Boca':
                    $cp_boca = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Cuello':
                    $cp_cuello = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Axilas - Mamas':
                    $cp_axilas = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Torax':
                    $cp_torax = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Columna':
                    $cp_columna = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Abdomen':
                    $cp_abdomen = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Ingle':
                    $cp_ingle = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Miembros Superiores':
                    $cp_msup = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Miembros Inferiores':
                    $cp_minf = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Organos de los Sentidos':
                    $cp_sorganos = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Cardio - Vascular':
                    $cp_scardio = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Respiratorio':
                    $cp_srespiratorio = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Digestivo':
                    $cp_sdigestivo = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Genital':
                    $cp_sgenital = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Urinario':
                    $cp_surinario = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Endocrino':
                    $cp_sendocrino = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Musculo Esqueletico':
                    $cp_smusculo = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Hemo - Linfatico':
                    $cp_shemo = intval($examenes_fr[$i]['cp']);
                    break;
                case 'Neurologico':
                    $cp_sneurologico = intval($examenes_fr[$i]['cp']);
                    break;
        }
        }


        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(130,5,utf8_decode('H. EXAMEN FÍSICO'),1,0,'L',true);
        $pdf->SetTextColor(0,0,0);


        $pdf->SetFont('Arial','', 5);
        $pdf->Cell(60,5,utf8_decode('MARCAR "X" CUANDO PRESENTE LA PATOLOGÍA Y DESCRIBA'),1,0,'C',true);
        $pdf->SetFont('Arial','', 6);
        $pdf->Ln(5);
        $pdf->SetFillColor(188,188,188);
        $pdf->Cell(104,5,utf8_decode('REGIONAL'),1,0,'C',true);
        $pdf->Cell(86,5,utf8_decode('SISTEMICO'),1,1,'C',true);
        $pdf->SetFillColor(238,238,238);
        // ----------------- fila 1 -------------------------
        $pdf->Cell(6,6,'1R',1,0,'R',true);
        $pdf->Cell(19,6,utf8_decode('PIEL - FANERAS'),1,0,'L',true);
        if ($cp_piel == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'6R',1,0,'R',true);
        $pdf->Cell(20,6,utf8_decode('BOCA'),1,0,'L',true);
        if ($cp_boca == 1) {
            $pdf->Cell(6,6,'X',1,0,'C'); 
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'11R',1,0,'R',true);
        $pdf->Cell(29,6,utf8_decode('ABDOMEN'),1,0,'L',true);
        if ($cp_abdomen == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'1S',1,0,'R',true);
        $pdf->Cell(32,6,utf8_decode('ORGANOS DE LOS SENTIDOS'),1,0,'L',true);
        if ($cp_sorganos == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C'); 
        }

        $pdf->Cell(6,6,'6S',1,0,'R',true);
        $pdf->Cell(30,6,utf8_decode('URINARIO'),1,0,'L',true);
        if ($cp_surinario == 1) {
            $pdf->Cell(6,6,'X',1,1,'C');  
        }else{
            $pdf->Cell(6,6,'',1,1,'C');
        }

        // ----------------- fila 2 -------------------------
        $pdf->Cell(6,6,'2R',1,0,'R',true);
        $pdf->Cell(19,6,utf8_decode('CABEZA'),1,0,'L',true);
        if ($cp_cabeza == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'7R',1,0,'R',true);
        $pdf->Cell(20,6,utf8_decode('OROFARINGE'),1,0,'L',true);
        if ($cp_orofaringe == 1) {
            $pdf->Cell(6,6,'X',1,0,'C'); 
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'12R',1,0,'R',true);
        $pdf->Cell(29,6,utf8_decode('COLUMNA VERTEBRAL'),1,0,'L',true);
        if ($cp_columna == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'2S',1,0,'R',true);
        $pdf->Cell(32,6,utf8_decode('RESPIRATORIO'),1,0,'L',true);
        if ($cp_srespiratorio == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C'); 
        }

        $pdf->Cell(6,6,'7S',1,0,'R',true);
        $pdf->Cell(30,6,utf8_decode('MÚSCULO ESQUELÉTICO'),1,0,'L',true);
        if ($cp_smusculo == 1) {
            $pdf->Cell(6,6,'X',1,1,'C');  
        }else{
            $pdf->Cell(6,6,'',1,1,'C');
        }
        // ----------------- fila 3 -------------------------
        $pdf->Cell(6,6,'3R',1,0,'R',true);
        $pdf->Cell(19,6,utf8_decode('OJOS'),1,0,'L',true);
        if ($cp_ojos == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'8R',1,0,'R',true);
        $pdf->Cell(20,6,utf8_decode('CUELLO'),1,0,'L',true);
        if ($cp_cuello == 1) {
            $pdf->Cell(6,6,'X',1,0,'C'); 
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'13R',1,0,'R',true);
        $pdf->Cell(29,6,utf8_decode('INGLE - PERINÉ'),1,0,'L',true);
        if ($cp_ingle == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'3S',1,0,'R',true);
        $pdf->Cell(32,6,utf8_decode('CARDIO - VASCULAR'),1,0,'L',true);
        if ($cp_scardio == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C'); 
        }

        $pdf->Cell(6,6,'8S',1,0,'R',true);
        $pdf->Cell(30,6,utf8_decode('ENDÓCRINO'),1,0,'L',true);
        if ($cp_sendocrino == 1) {
            $pdf->Cell(6,6,'X',1,1,'C');  
        }else{
            $pdf->Cell(6,6,'',1,1,'C');
        }
        // ----------------- fila 4 -------------------------
        $pdf->Cell(6,6,'4R',1,0,'R',true);
        $pdf->Cell(19,6,utf8_decode('OÍDOS'),1,0,'L',true);
        if ($cp_oidos == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'9R',1,0,'R',true);
        $pdf->Cell(20,6,utf8_decode('AXILAS - MAMAS'),1,0,'L',true);
        if ($cp_axilas == 1) {
            $pdf->Cell(6,6,'X',1,0,'C'); 
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'14R',1,0,'R',true);
        $pdf->Cell(29,6,utf8_decode('MIEMBROS SUPERIORES'),1,0,'L',true);
        if ($cp_msup == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'4S',1,0,'R',true);
        $pdf->Cell(32,6,utf8_decode('DIGESTIVO'),1,0,'L',true);
        if ($cp_sdigestivo == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C'); 
        }

        $pdf->Cell(6,6,'9S',1,0,'R',true);
        $pdf->Cell(30,6,utf8_decode('HEMO - LINFÁTICO'),1,0,'L',true);
        if ($cp_shemo == 1) {
            $pdf->Cell(6,6,'X',1,1,'C');  
        }else{
            $pdf->Cell(6,6,'',1,1,'C');
        }
        // ----------------- fila 5 -------------------------
        $pdf->Cell(6,6,'5R',1,0,'R',true);
        $pdf->Cell(19,6,utf8_decode('NARIZ'),1,0,'L',true);
        if ($cp_nariz == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'10R',1,0,'R',true);
        $pdf->Cell(20,6,utf8_decode('TÓRAX'),1,0,'L',true);
        if ($cp_torax == 1) {
            $pdf->Cell(6,6,'X',1,0,'C'); 
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'15R',1,0,'R',true);
        $pdf->Cell(29,6,utf8_decode('MIEMBROS INFERIORES'),1,0,'L',true);
        if ($cp_minf == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C');
        }

        $pdf->Cell(6,6,'5S',1,0,'R',true);
        $pdf->Cell(32,6,utf8_decode('GENITAL'),1,0,'L',true);
        if ($cp_sgenital == 1) {
            $pdf->Cell(6,6,'X',1,0,'C');
        }else{
            $pdf->Cell(6,6,'',1,0,'C'); 
        }

        $pdf->Cell(6,6,'10S',1,0,'R',true);
        $pdf->Cell(30,6,utf8_decode('NEUROLÓGICO'),1,0,'L',true);
        if ($cp_sneurologico == 1) {
            $pdf->Cell(6,6,'X',1,1,'C');  
        }else{
            $pdf->Cell(6,6,'',1,1,'C');
        }

        //----------------- descripcion adicional ---------------------

        $desc_efr = '';
        for ($i=0; $i < sizeof($examenes_fr); $i++) { 
            if (($examenes_fr[$i]['descripcion'] != '') || ($examenes_fr[$i]['descripcion'] != null)) {
                $desc_efr = $desc_efr.$examenes_fr[$i]['examen_fr'].' - '.$examenes_fr[$i]['descripcion'].'. ';
            }
        }

        $pdf->SetFont('Arial','', 8);
        $pdf->MultiCell(190,4,utf8_decode('*'.$desc_efr.'*'),1,'L');
        $celdas = (120 - $pdf->GetY())/5;
        for ($i=0; $i < $celdas; $i++) { 
            $pdf->SetFillColor(238,238,238);
            $pdf->Cell(190,5,'',1,1,'C',true);
        }
        $pdf->Ln(2);

        //---------------------------------------   I. DIAGNOSTICO ---------------------------------------
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
            'clave' => $row['clave'],
            'diagnostico_esp' => $row['diagnostico_esp']
            );
        }

        $reg_diag = sizeof($diagnosticos);

        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);

        $pdf->SetFont('Arial','B', 10);
        $pdf->Cell(32,5,utf8_decode('I. DIAGNÓSTICO'),'T',0,'L',true);
        $pdf->SetFont('Arial','', 5);
        $pdf->Cell(37,3,utf8_decode('PRE = PRESUNTIVO'),'T',0,'R',true);

        $pdf->Cell(15,5,utf8_decode('CIE'),1,0,'C',true);
        $pdf->Cell(6,5,utf8_decode('PRE'),1,0,'C',true);
        $pdf->Cell(6,5,utf8_decode('DEF'),1,0,'C',true);
        $pdf->Cell(67,5,'','TB',0,'C',true);
        $pdf->Cell(15,5,utf8_decode('CIE'),1,0,'C',true);
        $pdf->Cell(6,5,utf8_decode('PRE'),1,0,'C',true);
        $pdf->Cell(6,5,utf8_decode('DEF'),1,0,'C',true);

        //PARTE INFERIOR
        $pdf->Ln(3);
        $pdf->Cell(32);
        $pdf->Cell(37,2,utf8_decode('DEF = DEFINITIVO'),'B',1,'R',true);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(238,238,238);
        $diag_esp = ["","","",""];

        if (isset($diagnosticos[0])) {
            if ($diagnosticos[0]['diagnostico_esp']!="") {
                $diag_esp[0]="1. ".$diagnosticos[0]['diagnostico_esp'].". ";
            }
            $pdf->Cell(6,6,'1.',1,0,'R',true);
            $pdf->SetFont('Arial','', 6);
            $pdf->Cell(63,6,utf8_decode('*'.$diagnosticos[0]['descripcion'].'*'),1,0,'R');
            if (intval($diagnosticos[0]['pre_def']) == 1) {
                $pdf->Cell(15,6,utf8_decode($diagnosticos[0]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'',1,0,'C');
                $pdf->Cell(6,6,'X',1,0,'C');  
            }else{
                $pdf->Cell(15,6,utf8_decode($diagnosticos[0]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'X',1,0,'C');
                $pdf->Cell(6,6,'',1,0,'C');  
            } 
        }else{
            $pdf->Cell(6,6,'1.',1,0,'R',true);
            $pdf->Cell(63,6,'',1,0,'R');
            $pdf->Cell(15,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
        }

        if (isset($diagnosticos[3])) {
            if ($diagnosticos[3]['diagnostico_esp']!="") {
                $diag_esp[3]="4. ".$diagnosticos[3]['diagnostico_esp'].". ";
            }
            $pdf->Cell(6,6,'4.',1,0,'R',true);
            $pdf->SetFont('Arial','', 6);
            $pdf->Cell(61,6,utf8_decode('*'.$diagnosticos[3]['descripcion'].'*'),1,0,'R');
            if (intval($diagnosticos[3]['pre_def']) == 1) {
                $pdf->Cell(15,6,utf8_decode($diagnosticos[3]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'',1,0,'C');
                $pdf->Cell(6,6,'X',1,1,'C');  
            }else{
                $pdf->Cell(15,6,utf8_decode($diagnosticos[3]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'X',1,0,'C');
                $pdf->Cell(6,6,'',1,1,'C');  
            } 
        }else{
            $pdf->Cell(6,6,'4.',1,0,'R',true);
            $pdf->Cell(61,6,'',1,0,'R');
            $pdf->Cell(15,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,1,'C');
        }

        if (isset($diagnosticos[1])) {
            if ($diagnosticos[1]['diagnostico_esp']!="") {
                $diag_esp[1]="2. ".$diagnosticos[1]['diagnostico_esp'].". ";
            }
            $pdf->Cell(6,6,'2.',1,0,'R',true);
            $pdf->SetFont('Arial','', 6);
            $pdf->Cell(63,6,utf8_decode('*'.$diagnosticos[1]['descripcion'].'*'),1,0,'R');
            if (intval($diagnosticos[1]['pre_def']) == 1) {
                $pdf->Cell(15,6,utf8_decode($diagnosticos[1]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'',1,0,'C');
                $pdf->Cell(6,6,'X',1,0,'C');  
            }else{
                $pdf->Cell(15,6,utf8_decode($diagnosticos[1]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'X',1,0,'C');
                $pdf->Cell(6,6,'',1,0,'C');  
            } 
        }else{
            $pdf->Cell(6,6,'2.',1,0,'R',true);
            $pdf->Cell(63,6,'',1,0,'R');
            $pdf->Cell(15,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
        }

        if (isset($diagnosticos[4])) {
            if ($diagnosticos[4]['diagnostico_esp']!="") {
                $diag_esp[4]="5. ".$diagnosticos[4]['diagnostico_esp'].". ";
            }
            $pdf->Cell(6,6,'5.',1,0,'R',true);
            $pdf->SetFont('Arial','', 6);
            $pdf->Cell(61,6,utf8_decode('*'.$diagnosticos[4]['descripcion'].'*'),1,0,'R');
            if (intval($diagnosticos[4]['pre_def']) == 1) {
                $pdf->Cell(15,6,utf8_decode($diagnosticos[4]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'',1,0,'C');
                $pdf->Cell(6,6,'X',1,1,'C');  
            }else{
                $pdf->Cell(15,6,utf8_decode($diagnosticos[4]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'X',1,0,'C');
                $pdf->Cell(6,6,'',1,1,'C');  
            } 
        }else{
            $pdf->Cell(6,6,'5.',1,0,'R',true);
            $pdf->Cell(61,6,'',1,0,'R');
            $pdf->Cell(15,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,1,'C');
        }

        if (isset($diagnosticos[2])) {
            if ($diagnosticos[2]['diagnostico_esp']!="") {
                $diag_esp[2]="3. ".$diagnosticos[2]['diagnostico_esp'].". ";
            }
            $pdf->Cell(6,6,'3.',1,0,'R',true);
            $pdf->SetFont('Arial','', 6);
            $pdf->Cell(63,6,utf8_decode('*'.$diagnosticos[2]['descripcion'].'*'),1,0,'R');
            if (intval($diagnosticos[2]['pre_def']) == 1) {
                $pdf->Cell(15,6,utf8_decode($diagnosticos[2]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'',1,0,'C');
                $pdf->Cell(6,6,'X',1,0,'C');  
            }else{
                $pdf->Cell(15,6,utf8_decode($diagnosticos[2]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'X',1,0,'C');
                $pdf->Cell(6,6,'',1,0,'C');  
            } 
        }else{
            $pdf->Cell(6,6,'3.',1,0,'R',true);
            $pdf->Cell(63,6,'',1,0,'R');
            $pdf->Cell(15,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
        }

        if (isset($diagnosticos[5])) {
            if ($diagnosticos[5]['diagnostico_esp']!="") {
                $diag_esp[5]="6. ".$diagnosticos[3]['diagnostico_esp'].". ";
            }
            $pdf->Cell(6,6,'6.',1,0,'R',true);
            $pdf->SetFont('Arial','', 6);
            $pdf->Cell(61,6,utf8_decode('*'.$diagnosticos[5]['descripcion'].'*'),1,0,'R');
            if (intval($diagnosticos[5]['pre_def']) == 1) {
                $pdf->Cell(15,6,utf8_decode($diagnosticos[5]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'',1,0,'C');
                $pdf->Cell(6,6,'X',1,1,'C');  
            }else{
                $pdf->Cell(15,6,utf8_decode($diagnosticos[5]['clave']),1,0,'C');
                $pdf->SetFont('Arial','', 5);
                $pdf->Cell(6,6,'X',1,0,'C');
                $pdf->Cell(6,6,'',1,1,'C');  
            } 
        }else{
            $pdf->Cell(6,6,'6.',1,0,'R',true);
            $pdf->Cell(61,6,'',1,0,'R');
            $pdf->Cell(15,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,0,'C');
            $pdf->Cell(6,6,'',1,1,'C');
        }





        $txt_diag_esp = "";
        for ($i=0; $i < sizeof($diag_esp); $i++) { 
            $txt_diag_esp = $txt_diag_esp . $diag_esp[$i];
        }
        $pdf->SetFont('Arial','', 7);
        $pdf->MultiCell(190,4,utf8_decode("*".$txt_diag_esp."*"),1,'L');

        $pdf->Ln(2);

        //----------------------------------   J. PLAN DE TRATAMIENTO ------------------------------
        $query8 = "SELECT pt.*,  ci.signos_a, ci.recomendaciones_nf
                    FROM plan_t as pt
                    INNER JOIN cita as ci
                        ON pt.id_cita = ci.id_cita
                    Inner JOIN caso as ca
                        ON ci.id_caso = ca.id_caso
                    WHERE ca.id_caso = '$id_caso' and ci.fecha='$fecha_norm' and ci.hora='$hora_norm';";
        $result8 = mysqli_query($conn, $query8);
        if(!$result8) {
            die('Consulta fallida'. mysqli_error($conn));
        }
        $planes_t = array();
        $signos_a="";
        $recomendaciones_nf="";
        while($row = mysqli_fetch_array($result8)) {
            $planes_t[] = array(
            'datos_m' => $row['datos_m'],
            'via_a' => $row['via_a'],
            'cantidad' => $row['cantidad'],
            'indicaciones' => $row['indicaciones']
            );
            $signos_a = $row['signos_a'];
            $recomendaciones_nf = $row['recomendaciones_nf'];
        }

        $desc_pt = '';
        for ($i=0; $i < sizeof($planes_t); $i++) { 
            $desc_pt = $desc_pt.
            "Suministrar ".
            $planes_t[$i]['via_a'].' - '.
            $planes_t[$i]['datos_m'].' - '.
            $planes_t[$i]['indicaciones'].' - Cantidad total '.
            $planes_t[$i]['cantidad'].'.   ';
        }

        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(130,5,utf8_decode('J. PLAN DE TRATAMIENTO'),'LBT',0,'L',true);
        $pdf->SetTextColor(0,0,0);

        $pdf->SetFont('Arial','', 7);
        $pdf->Cell(60,5,utf8_decode('DIAGNÓSTICO, TERAPÉUTICO Y EDUCACIONAL'),'RBT',1,'R',true);

        if(strlen($signos_a)>0)
        {
            $desc_pt = $desc_pt.' - Signos de Alarma '.$signos_a;
        }

        if(strlen($recomendaciones_nf)>0)
        {
            $desc_pt = $desc_pt.' - Recomendaciones no farmacológicas '.$recomendaciones_nf;
        }
        $desc_pt = preg_replace("/[\r\n|\n|\r]+/", " ", $desc_pt);
        $pdf->MultiCell(190,5,utf8_decode('*'.$desc_pt.'*'),1,'L');



        $celdas = (235 - $pdf->GetY())/5;
        for ($i=0; $i < $celdas; $i++) { 
            $pdf->SetFillColor(238,238,238);
            $pdf->Cell(190,5,'',1,1,'C',true);
        }
        $pdf->Ln(1);

        //--------------------------- K. DATOS DEL PROFESIONAL RESPONSABLE -----------------------
        $pdf->SetFont('Arial','B', 10);
        $pdf->SetFillColor(153,153,153);
        $pdf->SetTextColor(34,68,93);
        $pdf->Cell(190,5,utf8_decode('K. DATOS DEL PROFESIONAL RESPONSABLE'),1,1,'L',true);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFillColor(238,238,238);


        $pdf->SetFont('Arial','', 6);
        $pdf->Cell(20,3,utf8_decode('FECHA'),'LRT',0,'C',true);
        $pdf->Cell(20,3,utf8_decode('HORA'),'LRT',0,'C',true);
        $pdf->Cell(50,6,utf8_decode('PRIMER NOMBRE'),'LRT',0,'C',true);
        $pdf->Cell(50,6,utf8_decode('PRIMER APELLIDO'),'LRT',0,'C',true);
        $pdf->Cell(50,6,utf8_decode('SEGUNDO APELLIDO'),'LRT',0,'C',true);
        $pdf->Ln(3);
        $pdf->Cell(20,3,utf8_decode('(aaaa-mm-dd)'),'LRB',0,'C',true);
        $pdf->Cell(20,3,utf8_decode('(hh:mm)'),'LRB',1,'C',true);


        $pdf->Cell(20,6,utf8_decode($fecha_norm),1,0,'C');
        $pdf->Cell(20,6,utf8_decode(substr($hora_norm,0,-3)."h"),1,0,'C');
        $pdf->Cell(50,6,utf8_decode($nombres_medi),1,0,'C');
        $apellidos_medico = explode(" ", $apellidos_medi);
        $pdf->Cell(50,6,utf8_decode($apellidos_medico[0]),1,0,'C');
        $pdf->Cell(50,6,utf8_decode($apellidos_medico[1]),1,1,'C');


        $pdf->Cell(40,3,utf8_decode('NÚMERO DE DOCUMENTO'),'LRT',0,'C',true);
        $pdf->Cell(75,6,utf8_decode('FIRMA'),'LRTB',0,'C',true);
        $pdf->Cell(75,6,utf8_decode('SELLO'),'LRTB',0,'C',true);
        $pdf->Ln(3);
        $pdf->Cell(40,3,utf8_decode('DE IDENTIFICACIÓN'),'LRB',1,'C',true);


        $pdf->Cell(40,15,utf8_decode($nautorizacion_medi),'LRTB',0,'C');
        $pdf->Cell(75,15,utf8_decode(''),'LRTB',0,'C');
        $pdf->Cell(75,15,utf8_decode(''),'LRTB',1,'C');
}     
}
$pdf->Output("reporte_hcu_002.pdf","I",true);
?>