<?php
require('../FPDF/fpdf.php');
include('../../dbconnection.php');
include('../../variables.php');

date_default_timezone_set('America/Guayaquil'); 
$id_caso = $_GET['id_caso'];


class PDF extends FPDF {
// Cabecera de página
function Header()
{
    $this->SetY(10);
    //LOGO
    $this->Image('../../assets/images/logo_rce.jpeg',12,9,10,10);
    $this->Image('../../assets/images/msp_logo.png',182,10,14,8);
    //TÍTULO
    $this->SetFont('Arial','B',9);
    $this->SetTextColor(34, 68, 93); 
    $this->Cell(80);
    $this->Cell(20,4,utf8_decode('CENTRO DE ESPECIALIDADES MÉDICAS CLÍNICO QUIRÚRGICO CESMED HOSPITAL DEL DÍA'),0,1,'C');
    //DIRECCIÓN
    $this->SetFont('Arial','BI', 9);
    $this->Cell(80);
    $this->Cell(20,4,utf8_decode('Dirección: Av. San Francisco y Uruguay (esquina) - Tulcán - Ecuador - Teléfono: 2986771'),0,0,'C');
    $this->Ln(6);
    
    //$this->Image('../../assets/images/no_valido.png',60,140,100);
}

// Pie de página
function Footer()
{
   
    // Posición: a 1,5 cm del final
    $this->SetY(-12);
    // Arial italic 10
    $this->SetFont('Arial','B',7);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(20,5,utf8_decode('SNS-MSP / HCU-form.002 / 2008'),0,0,'L');
    $this->SetFont('Arial','B',9);
    $this->Cell(150);
    $this->Cell(20,5,utf8_decode('CONSULTA EXTERNA - ANAMNESIS Y EXAMEN FÍSICO'),0,0,'R');
    

}
}

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//BLOQUE - DATOS DEL PACIENTE
$query = "SELECT ca.id_caso, ca.motivo_con, ca.problema_act, me.id_medico, pa.id_paciente,me.sufijo, me.nombres_medi, me.apellidos_medi, me.nautorizacion_medi, pa.nombres_paci1, pa.apellidos_paci1 , pa.nombres_paci2, pa.apellidos_paci2,pa.cedula_paci, pa.fechan_paci, ge.nombre as genero
          FROM caso as ca
          INNER JOIN medico as me
            ON ca.id_medico = me.id_medico
          INNER JOIN paciente as pa
            ON ca.id_paciente = pa.id_paciente
          INNER JOIN genero as ge
            ON pa.gen_id = ge.id
          WHERE ca.id_caso='$id_caso'";

$result = mysqli_query($conn, $query);
if(!$result) {
    die('Consulta fallida'. mysqli_error($conn));
}

while($row = mysqli_fetch_array($result)) {
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
}

function calcular_edad($fecha) {
$fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); 
$fecha_hoy =  new DateTime(date('Y/m/d',time())); 
$edad = date_diff($fecha_hoy,$fecha_nac); 
return $edad;
}

$edad = calcular_edad($fechan_paci);


$pdf->SetFont('Arial','', 6);
$pdf->Cell(36,3,'ESTABLECIMIENTO',1,0,'C');
$pdf->Cell(44,3,'NOMBRE',1,0,'C');
$pdf->Cell(44,3,'APELLIDO',1,0,'C');
$pdf->Cell(15,3,'SEXO (M-F)',1,0,'C');
$pdf->Cell(21,3,'EDAD',1,0,'C');
$pdf->Cell(28,3,utf8_decode('N° HISTORIA CLÍNICA'),1,1,'C');
$pdf->Cell(36,4,'CESMED S.C.',1,0,'C');
$pdf->Cell(44,4,utf8_decode($nombres_paci1.' '.$nombres_paci2),1,0,'C');
$pdf->Cell(44,4,utf8_decode($apellidos_paci1.' '.$apellidos_paci2),1,0,'C');
$pdf->Cell(15,4,$genero[0],1,0,'C');
$pdf->Cell(21,4,$edad->format('%Y').utf8_decode(' años, ').$edad->format('%m').' meses',1,0,'C');
$pdf->Cell(28,4,$cedula_paci,1,1,'C');
$pdf->Ln(2);

//BLOQUE 1
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(188,5,'1 MOTIVO DE LA CONSULTA',1,1,'L');
$pdf->SetFont('Arial','', 6);
$pdf->MultiCell(188,3,'*'.$motivo_con.'*',1,'L');
$pdf->Ln(2);

//BLOQUE 2
$query2 = "SELECT ap.*, enf.nombre
            FROM antecedente_p as ap
            INNER JOIN enfermedad as enf
                ON ap.id_enfermedad = enf.id
            WHERE ap.id_paciente = '$id_paciente'";
$result2 = mysqli_query($conn, $query2);
if(!$result2) {
    die('Consulta fallida'. mysqli_error($conn));
}
$antecedentes_p = array();
while($row = mysqli_fetch_array($result2)) {
    $antecedentes_p[] = array(
    'descripcion' => $row['descripcion'],
    'nombre' => $row['nombre']
    );
}

$str_ant_p = '';
for ($i=0; $i < sizeof($antecedentes_p); $i++) { 
    $str_ant_p = $str_ant_p.mb_strtoupper($antecedentes_p[$i]['nombre'])." - ".$antecedentes_p[$i]['descripcion'].'. ';
}

$pdf->SetFont('Arial','B', 9);
$pdf->Cell(144,5,'2 ANTECEDENTES PERSONALES','LBT',0,'L');
$pdf->SetFont('Arial','', 5);
$pdf->Cell(44,5,utf8_decode('DATOS CLÍNICO - QUIRÚRGICOS RELEVANTES Y GINECO OBSTÉTRICOS'),'RBT',1,'R');
$pdf->SetFont('Arial','', 6);
$pdf->MultiCell(188,3,utf8_decode('*'.$str_ant_p.'*'),1,'L');
$pdf->Ln(2);

//BLOQUE 3
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

$pdf->SetFont('Arial','B', 9);
$pdf->Cell(188,5,'3 ANTECEDENTES FAMILIARES',1,1,'L');
$pdf->SetFont('Arial','', 5);
$pdf->Cell(16,6,utf8_decode('1. CARDIOPATÍA'),1,0,'C');
if ($car == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(14,6,utf8_decode('2. DIABETES'),1,0,'C');
if ($dia == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(14,3,utf8_decode('3. ENF. C.'),'LRT',0,'C');
if ($ecv == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(14,3,utf8_decode('4. HIPER'),'LRT',0,'C');
if ($hip == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(14,6,utf8_decode('5. CÁNCER'),1,0,'C');
if ($can == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(18,6,utf8_decode('6. TUBERCULOSIS'),1,0,'C');
if ($tub == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(14,3,utf8_decode('7. ENF.'),'LRT',0,'C');
if ($e_me == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(15,3,utf8_decode('8. ENF.'),'LRT',0,'C');
if ($e_in == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(15,3,utf8_decode('9. MAL'),'LRT',0,'C');
if ($mf == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

$pdf->Cell(14,6,utf8_decode('10. OTRO'),1,0,'C');
if ($otr == 1) {
    $pdf->Cell(4,6,'X',1,0,'C');
}else{
    $pdf->Cell(4,6,'',1,0,'C');
}

//Abajo
$pdf->Ln(3);
$pdf->Cell(38);
$pdf->Cell(14,3,utf8_decode('VASCULAR'),'LRB',0,'C');
$pdf->Cell(4);
$pdf->Cell(14,3,utf8_decode('TENSIÓN'),'LRB',0,'C');
$pdf->Cell(44);
$pdf->Cell(14,3,utf8_decode('MENTAL'),'LRB',0,'C');
$pdf->Cell(4);
$pdf->Cell(15,3,utf8_decode('INFECCIOSA'),'LRB',0,'C');
$pdf->Cell(4);
$pdf->Cell(15,3,utf8_decode('FORMACIÓN'),'LRB',1,'C');


$desc_af = '';
for ($i=0; $i < sizeof($antecedentes_f); $i++) {
    if (($antecedentes_f[$i]['descripcion'] != null) || ($antecedentes_f[$i]['descripcion'] != '')) {
    $desc_af = $desc_af.$antecedentes_f[$i]['nombre'].' en '.$antecedentes_f[$i]['parentesco'].' - '.$antecedentes_f[$i]['descripcion'].'. ';
    }
}

$pdf->SetFont('Arial','', 7);
$pdf->MultiCell(188,4,utf8_decode('*'.$desc_af.'*'),1,'L');
$pdf->Ln(2);

//BLOQUE 4
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(188,5,'4 ENFERMEDAD O PROBLEMA ACTUAL',1,1,'L');
$pdf->SetFont('Arial','', 6);
$pdf->MultiCell(188,3,'*'.$problema_act.'*',1,'L');
$pdf->Ln(2);

//BLOQUE 5
$query4 = "SELECT ros.* 
            FROM revision_o_s  as ros
            INNER JOIN cita as ci
                ON ros.id_cita = ci.id_cita
            INNER JOIN caso as ca
                ON ci.id_caso = ca.id_caso
            WHERE ca.id_caso = '$id_caso' and ci.tipo_cita = '{$c_normal}'";
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
        case 'Genital':
            $cp_gen = intval($revisiones_os[$i]['cp']);
            break;
        case 'Urinario':
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

$pdf->SetFont('Arial','B', 9);
$pdf->Cell(94,5,utf8_decode('5 REVISIÓN ACTUAL DE ÓRGANOS Y SISTEMAS'),'LTB',0,'L');
$pdf->SetFont('Arial','', 5);
$pdf->Cell(50,3,utf8_decode('CP = CON EVIDENCIA DE PATOLOGÍA: MARCAR "X" Y'),'T',0,'C');
$pdf->Cell(44,3,utf8_decode('SP = SIN EVIDENCIA DE PATOLOGÍA:'),'TR',1,'C');
$pdf->Cell(94);
$pdf->Cell(50,2,utf8_decode('DESCRIBIR ABAJO ANOTANDO EL NÚMERO Y LA LETRA'),'B',0,'C');
$pdf->Cell(44,2,utf8_decode('MARCAR "X" Y NO DESCRIBIR'),'BR',1,'C');

$pdf->Cell(26,3,'','LTB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(26,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(24,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(26,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(26,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TBR',1,'C');

$pdf->Cell(6,6,'1',1,0,'R');
$pdf->Cell(20,3,utf8_decode('ÓRGANOS DE LOS'),'LTR',0,'R');

if ($cp_os == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'3',1,0,'R');
$pdf->Cell(20,6,utf8_decode('CARDIO VASCULAR'),1,0,'R');

if ($cp_cv == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'5',1,0,'R');
$pdf->Cell(18,6,utf8_decode('GENITAL'),1,0,'R');

if ($cp_gen == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'7',1,0,'R');
$pdf->Cell(20,3,utf8_decode('MÚSCULO'),'LTR',0,'R');

if ($cp_me == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'9',1,0,'R');
$pdf->Cell(20,6,utf8_decode('HEMO LINFÁTICO'),1,0,'R');

if ($cp_hl == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

//Parte Inferior
$pdf->Ln(3);
$pdf->Cell(6);
$pdf->Cell(20,3,utf8_decode('SENTIDOS'),'LBR',0,'R');
$pdf->Cell(92);
$pdf->Cell(20,3,utf8_decode('ESQUELÉTICO'),'LBR',1,'R');


$pdf->Cell(6,6,'2',1,0,'R');
$pdf->Cell(20,6,utf8_decode('RESPIRATORIO'),1,0,'R');

if ($cp_res == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'4',1,0,'R');
$pdf->Cell(20,6,utf8_decode('DIGESTIVO'),1,0,'R');

if ($cp_dig == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'6',1,0,'R');
$pdf->Cell(18,6,utf8_decode('URINARIO'),1,0,'R');

if ($cp_uri == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'8',1,0,'R');
$pdf->Cell(20,6,utf8_decode('ENDOCRINO'),1,0,'R');

if ($cp_end == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'10',1,0,'R');
$pdf->Cell(20,6,utf8_decode('NERVIOSO'),1,0,'R');

if ($cp_ner == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,1,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,1,'C');  
}

$desc_ros = '';
for ($i=0; $i < sizeof($revisiones_os); $i++) { 
    if (($revisiones_os[$i]['descripcion'] != '') || ($revisiones_os[$i]['descripcion'] != null)) {
        $desc_ros = $desc_ros.$revisiones_os[$i]['orga_sist'].' - '.$revisiones_os[$i]['descripcion'].'. ';
    }
}

$pdf->SetFont('Arial','', 7);
$pdf->MultiCell(188,4,utf8_decode('*'.$desc_ros.'*'),1,'L');
$pdf->Ln(2);

//BLOQUE 6
$query5 = "SELECT sva.* 
            FROM signov_ant  as sva
            INNER JOIN cita as ci
                ON sva.id_cita = ci.id_cita
            INNER JOIN caso as ca
                ON ci.id_caso = ca.id_caso
            WHERE ca.id_caso = '$id_caso'";

$result5 = mysqli_query($conn, $query5);
if(!$result5) {
    die('Consulta fallida'. mysqli_error($conn));
}
$signosv_ant = array();
while($row = mysqli_fetch_array($result5)) {
    $signosv_ant[] = array(
    'fecha' => $row['fecha'],
    'temperatura' => $row['temperatura'],
    'presion_as' => $row['presion_as'],
    'presion_ad' => $row['presion_ad'],
    'pulso' => $row['pulso'],
    'frecuencia_r' => $row['frecuencia_r'],
    'frecuencia_c' => $row['frecuencia_c'],
    'sat_o' => $row['sat_o'],
    'peso' => $row['peso'],
    'talla' => $row['talla']

    );
}

$reg_sva = sizeof($signosv_ant);
$rest_sva = 4 - $reg_sva;


$pdf->SetFont('Arial','B', 9);
$pdf->Cell(188,5,utf8_decode('6 SIGNOS VITALES Y ANTROPOMETRÍA'),1,1,'L');
$pdf->SetFont('Arial','B', 5);

$pdf->Cell(44,4,utf8_decode('FECHA DE MEDICIÓN'),1,0,'L');
$pdf->SetFont('Arial','', 5);
for ($i=0; $i < $reg_sva; $i++) { 
    if (($i == ($reg_sva-1)) && ($rest_sva == 0)) {
        $pdf->Cell(36,4,utf8_decode('*'.$signosv_ant[$i]['fecha'].'*'),1,1,'C');
    }else{
        $pdf->Cell(36,4,utf8_decode('*'.$signosv_ant[$i]['fecha'].'*'),1,0,'C');
    }  
}
for ($i=0; $i < $rest_sva; $i++) { 
    if ($i==($rest_sva-1)) {
        $pdf->Cell(36,4,utf8_decode(''),1,1,'C');
    }else{
        $pdf->Cell(36,4,utf8_decode(''),1,0,'C');
    }
}

$pdf->SetFont('Arial','B', 5);
$pdf->Cell(44,4,utf8_decode('TEMPERATURA °C'),1,0,'L');
$pdf->SetFont('Arial','', 5);
for ($i=0; $i < $reg_sva; $i++) { 
    if (($i == ($reg_sva-1)) && ($rest_sva == 0)) {
        $pdf->Cell(36,4,utf8_decode('*'.$signosv_ant[$i]['temperatura'].'*'),1,1,'C');
    }else{
        $pdf->Cell(36,4,utf8_decode('*'.$signosv_ant[$i]['temperatura'].'*'),1,0,'C');
    }  
}
for ($i=0; $i < $rest_sva; $i++) { 
    if ($i==($rest_sva-1)) {
        $pdf->Cell(36,4,utf8_decode(''),1,1,'C');
    }else{
        $pdf->Cell(36,4,utf8_decode(''),1,0,'C');
    }
}
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(44,4,utf8_decode('FRECUENCIA CARDIACA'),1,0,'L');
$pdf->SetFont('Arial','', 5);
for ($i=0; $i < $reg_sva; $i++) { 
    if (($i == ($reg_sva-1)) && ($rest_sva == 0)) {
        $pdf->Cell(36,4,utf8_decode('*'.$signosv_ant[$i]['frecuencia_c'].'*'),1,1,'C');
    }else{
        $pdf->Cell(36,4,utf8_decode('*'.$signosv_ant[$i]['frecuencia_c'].'*'),1,0,'C');
    }  
}
for ($i=0; $i < $rest_sva; $i++) { 
    if ($i==($rest_sva-1)) {
        $pdf->Cell(36,4,utf8_decode(''),1,1,'C');
    }else{
        $pdf->Cell(36,4,utf8_decode(''),1,0,'C');
    }
}
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(44,4,utf8_decode('SATURACIÓN DE OXÍGENO'),1,0,'L');
$pdf->SetFont('Arial','', 5);
for ($i=0; $i < $reg_sva; $i++) { 
    if (($i == ($reg_sva-1)) && ($rest_sva == 0)) {
        $pdf->Cell(36,4,utf8_decode('*'.$signosv_ant[$i]['sat_o'].'*'),1,1,'C');
    }else{
        $pdf->Cell(36,4,utf8_decode('*'.$signosv_ant[$i]['sat_o'].'*'),1,0,'C');
    }  
}
for ($i=0; $i < $rest_sva; $i++) { 
    if ($i==($rest_sva-1)) {
        $pdf->Cell(36,4,utf8_decode(''),1,1,'C');
    }else{
        $pdf->Cell(36,4,utf8_decode(''),1,0,'C');
    }
}
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(44,4,utf8_decode('PRESIÓN ARTERIAL'),1,0,'L');
$pdf->SetFont('Arial','', 5);
for ($i=0; $i < $reg_sva; $i++) { 
    if (($i == ($reg_sva-1)) && ($rest_sva == 0)) {
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['presion_as'].'*'),1,0,'C');
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['presion_ad'].'*'),1,1,'C');
    }else{
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['presion_as'].'*'),1,0,'C');
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['presion_ad'].'*'),1,0,'C');
    }  
}
for ($i=0; $i < $rest_sva; $i++) { 
    if ($i==($rest_sva-1)) {
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
        $pdf->Cell(18,4,utf8_decode(''),1,1,'C');
    }else{
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
    }
}
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(14,4,utf8_decode('PULSO / min'),1,0,'L');
$pdf->Cell(30,4,utf8_decode('FRECUENCIA RESPIRATORIA'),1,0,'L');
$pdf->SetFont('Arial','', 5);
for ($i=0; $i < $reg_sva; $i++) { 
    if (($i == ($reg_sva-1)) && ($rest_sva == 0)) {
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['pulso'].'*'),1,0,'C');
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['frecuencia_r'].'*'),1,1,'C');
    }else{
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['pulso'].'*'),1,0,'C');
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['frecuencia_r'].'*'),1,0,'C');
    }  
}
for ($i=0; $i < $rest_sva; $i++) { 
    if ($i==($rest_sva-1)) {
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
        $pdf->Cell(18,4,utf8_decode(''),1,1,'C');
    }else{
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
    }
}
$pdf->SetFont('Arial','B', 5);
$pdf->Cell(22,4,utf8_decode('PESO / Kg'),1,0,'L');
$pdf->Cell(22,4,utf8_decode('TALLA / cm'),1,0,'L');
$pdf->SetFont('Arial','', 5);
for ($i=0; $i < $reg_sva; $i++) { 
    if (($i == ($reg_sva-1)) && ($rest_sva == 0)) {
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['peso'].'*'),1,0,'C');
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['talla'].'*'),1,1,'C');
    }else{
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['peso'].'*'),1,0,'C');
        $pdf->Cell(18,4,utf8_decode('*'.$signosv_ant[$i]['talla'].'*'),1,0,'C');
    }  
}
for ($i=0; $i < $rest_sva; $i++) { 
    if ($i==($rest_sva-1)) {
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
        $pdf->Cell(18,4,utf8_decode(''),1,1,'C');
    }else{
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
        $pdf->Cell(18,4,utf8_decode(''),1,0,'C');
    }
}
$pdf->Ln(2);

//BLOQUE 7
$query6 = "SELECT efr.* 
            FROM examen_fr  as efr
            INNER JOIN cita as ci
                ON efr.id_cita = ci.id_cita
            INNER JOIN caso as ca
                ON ci.id_caso = ca.id_caso
            WHERE ca.id_caso = '$id_caso' and ci.tipo_cita = '{$c_normal}'";
            

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
        case 'Cuello':
            $cp_cue = intval($examenes_fr[$i]['cp']);
            break;
        case 'Cabeza':
            $cp_cab = intval($examenes_fr[$i]['cp']);
            break;
        case 'Tórax':
            $cp_tor = intval($examenes_fr[$i]['cp']);
            break;
        case 'Abdomen':
            $cp_abd = intval($examenes_fr[$i]['cp']);
            break;
        case 'Extremidades':
            $cp_ext = intval($examenes_fr[$i]['cp']);
            break;
        case 'Pelvis':
            $cp_pel = intval($examenes_fr[$i]['cp']);
            break;
    }
}

$pdf->SetFont('Arial','B', 9);
$pdf->Cell(94,5,utf8_decode('7 EXAMEN FÍSICO REGIONAL'),'LTB',0,'L');
$pdf->SetFont('Arial','', 5);
$pdf->Cell(50,3,utf8_decode('CP = CON EVIDENCIA DE PATOLOGÍA: MARCAR "X" Y'),'T',0,'C');
$pdf->Cell(44,3,utf8_decode('SP = SIN EVIDENCIA DE PATOLOGÍA:'),'TR',1,'C');
$pdf->Cell(94);
$pdf->Cell(50,2,utf8_decode('DESCRIBIR ABAJO ANOTANDO EL NÚMERO Y LA LETRA'),'B',0,'C');
$pdf->Cell(44,2,utf8_decode('MARCAR "X" Y NO DESCRIBIR'),'BR',1,'C');

$pdf->Cell(18,3,'','LTB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(18,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(19,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(19,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(19,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TB',0,'C');
$pdf->Cell(23,3,'','TB',0,'C');
$pdf->Cell(6,3,utf8_decode('CP'),'TB',0,'C');
$pdf->Cell(6,3,utf8_decode('SP'),'TBR',1,'C');

$pdf->Cell(6,6,'1',1,0,'R');
$pdf->Cell(12,6,utf8_decode('CABEZA'),1,0,'R');
if ($cp_cab == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'2',1,0,'R');
$pdf->Cell(12,6,utf8_decode('CUELLO'),1,0,'R');
if ($cp_cue == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'3',1,0,'R');
$pdf->Cell(13,6,utf8_decode('TÓRAX'),1,0,'R');
if ($cp_tor == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'4',1,0,'R');
$pdf->Cell(13,6,utf8_decode('ABDOMEN'),1,0,'R');
if ($cp_abd == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'5',1,0,'R');
$pdf->Cell(13,6,utf8_decode('PELVIS'),1,0,'R');
if ($cp_pel == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,0,'C');  
}

$pdf->Cell(6,6,'6',1,0,'R');
$pdf->Cell(17,6,utf8_decode('EXTREMIDADES'),1,0,'R');
if ($cp_ext == 1) {
    $pdf->Cell(6,6,'X',1,0,'C');
    $pdf->Cell(6,6,'',1,1,'C');  
}else{
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'X',1,1,'C');  
}

$desc_efr = '';
for ($i=0; $i < sizeof($examenes_fr); $i++) { 
    if (($examenes_fr[$i]['descripcion'] != '') || ($examenes_fr[$i]['descripcion'] != null)) {
        $desc_efr = $desc_efr.$examenes_fr[$i]['examen_fr'].' - '.$examenes_fr[$i]['descripcion'].'. ';
    }
}

$pdf->SetFont('Arial','', 8);
$pdf->MultiCell(188,4,utf8_decode('*'.$desc_efr.'*'),1,'L');
$pdf->Ln(2);

//BLOQUE 8
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

$pdf->SetFont('Arial','B', 9);
$pdf->Cell(30,5,utf8_decode('8 DIAGNÓSTICO'),'LTB',0,'L');
$pdf->SetFont('Arial','', 5);
$pdf->Cell(30,3,utf8_decode('PRE = PRESUNTIVO'),'T',0,'C');
$pdf->Cell(7,5,'','TB',0,'L');
$pdf->Cell(15,5,utf8_decode('CIE'),'TB',0,'C');
$pdf->Cell(6,5,utf8_decode('PRE'),'TB',0,'C');
$pdf->Cell(6,5,utf8_decode('DEF'),'TB',0,'C');
$pdf->Cell(67,5,'','TB',0,'C');
$pdf->Cell(15,5,utf8_decode('CIE'),'TB',0,'C');
$pdf->Cell(6,5,utf8_decode('PRE'),'TB',0,'C');
$pdf->Cell(6,5,utf8_decode('DEF'),'TBR',0,'C');

//PARTE INFERIOR
$pdf->Ln(3);
$pdf->Cell(30);
$pdf->Cell(30,2,utf8_decode('DEF = DEFINITIVO'),'B',1,'C');

$diag_esp = ["","","",""];

if (isset($diagnosticos[0])) {
    if ($diagnosticos[0]['diagnostico_esp']!="") {
        $diag_esp[0]="1. ".$diagnosticos[0]['diagnostico_esp'].". ";
    }
    $pdf->Cell(6,6,'1',1,0,'R');
    $pdf->SetFont('Arial','', 6);
    $pdf->Cell(61,6,utf8_decode('*'.$diagnosticos[0]['descripcion'].'*'),1,0,'R');
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
    $pdf->Cell(6,6,'1',1,0,'R');
    $pdf->Cell(61,6,'',1,0,'R');
    $pdf->Cell(15,6,'',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');
}

if (isset($diagnosticos[2])) {
    if ($diagnosticos[2]['diagnostico_esp']!="") {
        $diag_esp[2]="3. ".$diagnosticos[2]['diagnostico_esp'].". ";
    }
    $pdf->Cell(6,6,'3',1,0,'R');
    $pdf->SetFont('Arial','', 6);
    $pdf->Cell(61,6,utf8_decode('*'.$diagnosticos[2]['descripcion'].'*'),1,0,'R');
    if (intval($diagnosticos[2]['pre_def']) == 1) {
        $pdf->Cell(15,6,utf8_decode($diagnosticos[2]['clave']),1,0,'C');
        $pdf->SetFont('Arial','', 5);
        $pdf->Cell(6,6,'',1,0,'C');
        $pdf->Cell(6,6,'X',1,1,'C');  
    }else{
        $pdf->Cell(15,6,utf8_decode($diagnosticos[2]['clave']),1,0,'C');
        $pdf->SetFont('Arial','', 5);
        $pdf->Cell(6,6,'X',1,0,'C');
        $pdf->Cell(6,6,'',1,1,'C');  
    } 
}else{
    $pdf->Cell(6,6,'3',1,0,'R');
    $pdf->Cell(61,6,'',1,0,'R');
    $pdf->Cell(15,6,'',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'',1,1,'C');
}

if (isset($diagnosticos[1])) {
    if ($diagnosticos[1]['diagnostico_esp']!="") {
        $diag_esp[1]="2. ".$diagnosticos[1]['diagnostico_esp'].". ";
    }
    $pdf->Cell(6,6,'2',1,0,'R');
    $pdf->SetFont('Arial','', 6);
    $pdf->Cell(61,6,utf8_decode('*'.$diagnosticos[1]['descripcion'].'*'),1,0,'R');
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
    $pdf->Cell(6,6,'2',1,0,'R');
    $pdf->Cell(61,6,'',1,0,'R');
    $pdf->Cell(15,6,'',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');
    $pdf->Cell(6,6,'',1,0,'C');
}

if (isset($diagnosticos[3])) {
    if ($diagnosticos[3]['diagnostico_esp']!="") {
        $diag_esp[3]="4. ".$diagnosticos[3]['diagnostico_esp'].". ";
    }
    $pdf->Cell(6,6,'4',1,0,'R');
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
    $pdf->Cell(6,6,'4',1,0,'R');
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
$pdf->MultiCell(188,4,utf8_decode("*".$txt_diag_esp."*"),1,'L');

$pdf->Ln(2);

//BLOQUE 9
$query8 = "SELECT pt.* 
            FROM plan_t as pt
            INNER JOIN cita as ci
                ON pt.id_cita = ci.id_cita
            Inner JOIN caso as ca
                ON ci.id_caso = ca.id_caso
            WHERE ca.id_caso = '$id_caso' and ci.tipo_cita = '{$c_normal}'";
$result8 = mysqli_query($conn, $query8);
if(!$result8) {
    die('Consulta fallida'. mysqli_error($conn));
}
$planes_t = array();
while($row = mysqli_fetch_array($result8)) {
    $planes_t[] = array(
    'datos_m' => $row['datos_m'],
    'via_a' => $row['via_a'],
    'cantidad' => $row['cantidad'],
    'indicaciones' => $row['indicaciones']
    );
}

$desc_pt = '';
for ($i=0; $i < sizeof($planes_t); $i++) { 
    $desc_pt = $desc_pt.$planes_t[$i]['datos_m'].' - '.$planes_t[$i]['indicaciones'].'. ';
}

$pdf->SetFont('Arial','B', 9);
$pdf->Cell(144,5,'9 PLANES DE TRATAMIENTO','LBT',0,'L');
$pdf->SetFont('Arial','', 5);
$pdf->Cell(44,5,utf8_decode('REGISTRAR LOS PLANES: DIAGNÓSTICO, TERAPÉUTICO Y EDUCACIONAL'),'RBT',1,'R');

$pdf->SetFont('Arial','', 7);
$pdf->Cell(125,5,utf8_decode('DATOS DEL MEDICAMENTO'),1,0,'C');
$pdf->Cell(40,5,utf8_decode('VÍA DE ADMINISTRACIÓN'),1,0,'C');
$pdf->Cell(23,5,utf8_decode('CANTIDAD'),1,1,'C');
for ($i=0; $i < sizeof($planes_t); $i++) { 
    $pdf->Cell(125,5,utf8_decode('*'.$planes_t[$i]['datos_m'].'*'),1,0,'L');
    $pdf->Cell(40,5,utf8_decode('*'.$planes_t[$i]['via_a'].'*'),1,0,'C');
    $pdf->Cell(23,5,utf8_decode('*'.$planes_t[$i]['cantidad'].'*'),1,1,'C');
}
$pdf->MultiCell(188,5,utf8_decode('*'.$desc_pt.'*'),1,'L');



$celdas = (262 - $pdf->GetY())/5;
for ($i=0; $i < $celdas; $i++) { 
    $pdf->SetFillColor(235, 235, 235);
    $pdf->Cell(188,5,'',1,1,'C',true);
}
$pdf->Ln(1);

//BLOQUE FINAL

$query_date = "SELECT ci.fecha, ci.hora
                FROM cita as ci
                INNER JOIN caso as ca
                    ON ci.id_caso = ca.id_caso
                WHERE ca.id_caso = '{$id_caso}' AND ci.tipo_cita = '$c_normal'";

$result_date = mysqli_query($conn, $query_date);
if(!$result_date) {
    die('Consulta fallida'. mysqli_error($conn));
}
 
while($row = mysqli_fetch_array($result_date)) {
    $fecha_norm = $row['fecha'];
    $hora_norm = $row['hora'];
}

$pdf->SetFont('Arial','', 6);
$pdf->Cell(110,2,'',0,0,'C');
$pdf->Cell(15,2,utf8_decode('CÓDIGO'),0,1,'C');
$pdf->Cell(10,5,utf8_decode('FECHA'),1,0,'C');
//$pdf->Cell(15,5,date('m-d-Y'),1,0,'C');
$pdf->Cell(13,5,utf8_decode($fecha_norm),1,0,'C');
$pdf->Cell(9,5,utf8_decode('HORA'),1,0,'C');
//$pdf->Cell(11,5,date('h:i a'),1,0,'C');
$pdf->Cell(8,5,utf8_decode(substr($hora_norm,0,-3)."h"),1,0,'C');
$pdf->Cell(20,3,utf8_decode('NOMBRE DEL'),'LRT',0,'C');
$pdf->Cell(50,5,utf8_decode($sufijo.' '.$apellidos_medi.' '.$nombres_medi),1,0,'C');
$pdf->Cell(15,5,utf8_decode($nautorizacion_medi),1,0,'C');
$pdf->Cell(10,5,utf8_decode('FIRMA'),1,0,'C');
$pdf->Cell(30,5,'',1,0,'C');
$pdf->Cell(15,3,utf8_decode('NÚMERO'),'LRT',0,'C');
$pdf->Cell(8,5,'1',1,0,'C');
$pdf->Ln(2);
$pdf->Cell(40);
$pdf->Cell(20,3,utf8_decode('PROFESIONAL'),'LRB',0,'C');
$pdf->Cell(105);
$pdf->Cell(15,3,utf8_decode('DE HOJA'),'LRB',1,'C');
$pdf->Ln(2);

$pdf->AddPage();
$query_evol = "SELECT ci.*
                FROM cita as ci
                INNER JOIN caso as ca
                    ON ci.id_caso = ca.id_caso
                WHERE ca.id_caso = '{$id_caso}' and ci.tipo_cita = '{$c_control}'";
$result_evol = mysqli_query($conn, $query_evol);
if(!$result_evol) {
    die('Consulta fallida'. mysqli_error($conn));
}
$evoluciones = array();
while($row = mysqli_fetch_array($result_evol)) {
    $evoluciones[] = array(
    'id_cita' => $row['id_cita'],
    'fecha_cita' => $row['fecha'],
    'hora_cita' => $row['hora'],
    'evolucion' => $row['evolucion']
    );
}



$pdf->SetFont('Arial','B', 9);
$pdf->Cell(60,5,utf8_decode('10 EVOLUCIÓN'),'LBT',0,'L');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(40,5,'FIRMAR AL PIE DE CADA NOTA','RBT',0,'R');
$pdf->Cell(3);
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(39,5,'11 PRESCRIPCIONES','LBT',0,'L');
$pdf->SetFont('Arial','', 6);
$pdf->Cell(46,5,utf8_decode('FIRMA AL PIE DE CADA PRESCRIPCIÓN'),'RBT',1,'R');
$pdf->Cell(188,5,utf8_decode('REGISTRAR EN ROJO LA ADMINISTRACIÓN DE FÁRMACOS Y OTROS PRODUCTOS (ENFERMERÍA)'),0,1,'R');
$pdf->Cell(17,2,utf8_decode(''),'LTR',0,'C');
$pdf->Cell(9,2,utf8_decode(''),'LTR',0,'C');
$pdf->Cell(74,7,utf8_decode('NOTAS DE EVOLUCIÓN'),1,0,'C');
$pdf->Cell(3);
$pdf->Cell(68,2,utf8_decode(''),'LTR',0,'C');
$pdf->Cell(17,2,utf8_decode('ADMINISTR.'),'LTR',0,'C');
$pdf->Ln(2);
$pdf->Cell(17,2,utf8_decode('FECHA'),'LR',0,'C');
$pdf->Cell(9,2,utf8_decode('HORA'),'LR',0,'C');
$pdf->Cell(77);
$pdf->Cell(68,2,utf8_decode('FARMACOTERAPIA E INDICACIONES'),'LR',0,'C');
$pdf->Cell(17,2,utf8_decode('FÁRMACOS'),'LR',0,'C');
$pdf->Ln(2);
$pdf->Cell(17,3,utf8_decode('(DÍA/MES/AÑO)'),'LBR',0,'C');
$pdf->Cell(9,3,'','LBR',0,'C');
$pdf->Cell(77);
$pdf->Cell(68,3,utf8_decode('(PARA ENFERMERÍA Y OTRO PERSONAL)'),'LBR',0,'C');
$pdf->Cell(17,2,utf8_decode('Y OTROS'),'LR',0,'C');
$pdf->Ln(2);
$pdf->Cell(171);
$pdf->Cell(17,1,utf8_decode(''),'LBR',1,'C');

$n_celdas = 47;

for ($i=0; $i < $n_celdas; $i++) { 
    $pdf->SetY(37 + ($i*5));
    $pdf->Cell(17,5,"",1,0,'C');
    $pdf->Cell(9,5,"",1,0,'C');
    $pdf->Cell(74,5,"",1,1,'C');
}

for ($i=0; $i < $n_celdas; $i++) { 
    $pdf->SetXY(113,37 + ($i*5));
    $pdf->Cell(68,5,"",1,0,'C');
    $pdf->Cell(17,5,"",1,1,'C');
}



$h_gen = 37;

for ($i=0; $i < sizeof($evoluciones); $i++) {
    $pdf->SetXY(10,$h_gen);
    $pdf->Cell(17,5,utf8_decode($evoluciones[$i]['fecha_cita']),1,0,'C');
    $pdf->Cell(9,5,utf8_decode(substr($evoluciones[$i]['hora_cita'],0,-3)."h"),1,0,'C');
    $pdf->Multicell(74,5,utf8_decode("*".$evoluciones[$i]['evolucion']."*"),1,'L', false);    
    $h_ev = $pdf -> GetY();
    

    $id_c = $evoluciones[$i]['id_cita'];
    $query_rece = "SELECT * FROM plan_t WHERE id_cita = '{$id_c}'";
    $result_rece = mysqli_query($conn, $query_rece);
    if(!$result_rece) {
        die('Consulta fallida'. mysqli_error($conn));
    }
    $recetas = array();
    while($row = mysqli_fetch_array($result_rece)) {
        $recetas[] = array(
        'datos_m' => $row['datos_m'],
        'via_a' => $row['via_a'],
        'cantidad' => $row['cantidad'],
        'indicaciones' => $row['indicaciones']
        );
    }

    $h_n = 0;
    $pdf->SetTextColor(245,27,27);
    for ($j=0; $j < sizeof($recetas); $j++) { 
        $cantidad = substr($recetas[$j]['cantidad'],0,-3);
        $receta = mb_strtoupper($recetas[$j]['datos_m']);
        $via_a = mb_strtolower($recetas[$j]['indicaciones']);
        if ($j == 0) {
            $pdf->SetXY(110,$h_gen);
            $pdf->Cell(3);
            $pdf->Multicell(68,5,utf8_decode("*".$cantidad." ".$receta." - ".$via_a."*"),1,'L');
            $h_re = $pdf -> GetY();
            $h_n = $h_re;
            $pdf->SetXY(181,$h_gen);
            $pdf->Cell(17,5,utf8_decode($recetas[$j]['via_a']),1,0,'C');
        }else{
            $pdf->SetXY(110,$h_n);
            $pdf->Cell(3);
            $pdf->Multicell(68,5,utf8_decode("*".$cantidad." ".$receta." - ".$via_a."*"),1,'L');
            $h_re = $pdf -> GetY();
            $pdf->SetXY(181,$h_n);
            $pdf->Cell(17,5,utf8_decode($recetas[$j]['via_a']),1,0,'C');
            $h_n = $h_re;
        }        
        
    }
    $pdf->SetTextColor(0,0,0);
    

    


    if ($h_ev > $h_re) {
        $h_gen = $h_ev + 5;
    }else{
        $h_gen = $h_re + 5;
    }

    
    
}











$pdf->Output("reporte_hcu_002.pdf","I",true);
?>