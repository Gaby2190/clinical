<?php
require_once '../FPDF/fpdf.php';
include_once '../../dbconnection.php';
include_once '../../variables.php';

date_default_timezone_set('America/Guayaquil'); 
$id_caso = $_GET['id_caso'];



class PDF extends FPDF {
// Cabecera de página
function Header()
{
    //Configuración de la base de datos 
    $servername = "localhost";
    $database = "cesmedec_clinical";
    $username = "root";
    $password = "";

    // Crear conexi��n con la extención mysqli
    $conn = new mysqli($servername, $username, $password, $database);
    $conn->set_charset("utf8");
    // Verificar Conexi��n 
    if (!$conn) {
        die("Conex��n fallida: " . mysqli_connect_error());
    }
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
   
    //$this->Image('../../assets/images/no_valido.png',60,140,100);
    $pagina=$this->PageNo();
    if($pagina>1)
    {
        // ---------------------------- SEGUNDA PAGINA ----------------------------
        //---------------------------------- BLOQUE A - DATOS USUARIO PACIENTE ---------------------------------
        
        $id_caso = $_GET['id_caso'];
        $query = "SELECT ca.id_caso, ca.motivo_con, ca.problema_act, me.id_medico, pa.id_paciente,me.sufijo, me.nombres_medi, me.apellidos_medi, me.nautorizacion_medi, pa.nombres_paci1, pa.apellidos_paci1 , pa.nombres_paci2, pa.apellidos_paci2,pa.cedula_paci, pa.fechan_paci, ge.nombre as genero, ca.fecha_registro
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
            $fecha_registro = $row['fecha_registro'];
        }

        
        $fecha_nac = new DateTime(date('Y/m/d',strtotime($fechan_paci))); 
        $fecha_hoy =  new DateTime(date('Y/m/d',strtotime($fecha_registro))); 
        $edad = date_diff($fecha_hoy,$fecha_nac); 
       
        
        
        
        $this->SetFont('Arial','B', 10);
        $this->SetFillColor(153,153,153);
        $this->SetTextColor(34,68,93);
        $this->Cell(190,5,'A. DATOS DEL USUARIO / PACIENTE',1,0,'L',true);
        $this->Ln(5);

        $this->SetFillColor(188,188,188);
        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','B', 6);
        $this->Cell(50,5,utf8_decode('PRIMER APELLIDO'),1,0,'C',true);
        $this->Cell(50,5,utf8_decode('PRIMER NOMBRE'),1,0,'C',true);
        $this->Cell(20,5,utf8_decode('EDAD'),1,0,'C',true);
        $this->Cell(42,5,utf8_decode('NÚMERO DE HISTORIA CLÍNICA ÚNICA'),1,0,'C',true);
        $this->Cell(28,5,utf8_decode('NÚMERO DE ARCHIVO'),1,1,'C',true);


        $this->SetFont('Arial','', 6);
        $this->Cell(50,5,utf8_decode($apellidos_paci1),1,0,'C');
        $this->Cell(50,5,utf8_decode($nombres_paci1),1,0,'C');
        $this->Cell(20,5,$edad->format('%Y').utf8_decode(' años, ').$edad->format('%m').' meses',1,0,'C');
        $this->Cell(42,5,$cedula_paci,1,0,'C');
        $this->Cell(28,5,$cedula_paci,1,1,'C');
        $this->Ln(2);

        $query_evol = "SELECT ci.*
                        FROM cita as ci
                        INNER JOIN caso as ca
                            ON ci.id_caso = ca.id_caso
                        WHERE ca.id_caso = '{$id_caso}' and ci.tipo_cita = 0";
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

        $this->SetFont('Arial','B', 10);
        $this->SetFillColor(153,153,153);
        $this->SetTextColor(34,68,93);
        $this->Cell(70,6,utf8_decode('B. EVOLUCIÓN Y PRESCRIPCIONES'),'LBT',0,'L',true);
        $this->SetFont('Arial','', 5);
        $this->Cell(75,6,utf8_decode('FIRMA AL PIE DE CADA EVOLUCIÓN Y PRESCRIPCIÓN'),'BT',0,'L',true);
        $this->Cell(45,3,utf8_decode('REGISTRAR CON ROJO LA ADMINISTRACIÓN DE FARMACOS'),'TR',0,'R',true);
        $this->Ln(3);
        $this->Cell(145,3,utf8_decode(''),0,0,'R');
        $this->Cell(45,3,utf8_decode('Y COLOCACIÓN DE DISPOSITIVOS MÉDICOS'),'BR',1,'R',true);



        $this->SetFont('Arial','B', 7);
        $this->Cell(94,5,utf8_decode('1. EVOLUCIÓN'),1,0,'L');
        $this->Cell(2);

        $this->Cell(94,5,'2. PRESCRIPCIONES',1,1,'L');


        $this->Cell(12,3,utf8_decode('FECHA'),'LRT',0,'C');
        $this->Cell(8,3,utf8_decode('HORA'),'LRT',0,'C');
        $this->Cell(74,6,utf8_decode('NOTAS DE EVOLUCIÓN'),1,0,'C');
        $this->Cell(2);
        $this->Cell(74,3,utf8_decode('FARMACOTERAPIA E INDICACIONES'),'TLR',0,'C');
        $this->SetFont('Arial','', 6);
        $this->Cell(20,2,utf8_decode('ADMINISTR.'),'TRD',0,'C');
        $this->Ln(2);
        $this->SetFont('Arial','', 5);
        $this->Cell(12,4,utf8_decode('(aaa-mm-dd)'),'LRB',0,'C');
        $this->Cell(8,4,utf8_decode('(hh:mm)'),'LRB',0,'C');
        $this->SetFont('Arial','', 6);
        $this->Cell(76);
        $this->Cell(74,3,utf8_decode('(Para enfermería y otro profesional de salud)'),'LR',0,'C');
        $this->Cell(20,2,utf8_decode('FÁRMACOS.'),'RL',0,'C');
        $this->Ln(2);
        $this->Cell(96);
        $this->Cell(74,2,utf8_decode(' '),'LRB',0,'C');
        $this->Cell(20,2,utf8_decode('DISPOSITIVO.'),'RLB',1,'C');
        $this->Ln(2);
    }

}

// Pie de página
function Footer()
{
   
    // Posición: a 1,5 cm del final
    $this->SetY(-20);
    // Arial italic 10
    $this->SetFont('Arial','B',7);
    $this->SetTextColor(34, 68, 93);
    $this->Cell(20,5,utf8_decode('SNS-MSP / HCU-form.005 / 2021'),0,0,'L');
    $this->SetFont('Arial','B',9);
    $this->Cell(150);

    $pagina= $this->PageNo();
   
        $this->Cell(20,5,utf8_decode('EVOLUCIÓN Y PRESCRIPCIONES ('.$pagina.')'),0,0,'R');
   
}



}

// Creación del objeto de la clase heredada
$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//BLOQUE - DATOS DEL PACIENTE
$query = "SELECT ca.id_caso, ca.motivo_con, ca.problema_act, me.id_medico, pa.id_paciente,me.sufijo, me.nombres_medi, me.apellidos_medi, me.nautorizacion_medi, pa.nombres_paci1, pa.apellidos_paci1 , pa.nombres_paci2, pa.apellidos_paci2,pa.cedula_paci, pa.fechan_paci, ge.nombre as genero, ca.fecha_registro
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
    $fecha_registro = $row['fecha_registro'];
}

function calcular_edad($fecha,$fecha_registro) {
$fecha_nac = new DateTime(date('Y/m/d',strtotime($fecha))); 

$fecha_hoy =  new DateTime(date('Y/m/d',strtotime($fecha_registro))); 
$edad = date_diff($fecha_hoy,$fecha_nac); 
return $edad;
}



if($fechan_paci=='0000-00-00')
{
    $edad = '0000/00/00';
}
else
{
    $edad = calcular_edad($fechan_paci,$fecha_registro);
}
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
$pdf->Cell(51,5,utf8_decode('CLÍNICA CESMEC S.C.'),1,0,'C');
$pdf->Cell(45,5,$cedula_paci,1,0,'C');
$pdf->Cell(30,5,$cedula_paci,1,0,'C');
$pdf->Cell(10,5,"1",1,1,'C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(35,6,utf8_decode('PRIMER APELLIDO'),1,0,'C',true);
$pdf->Cell(35,6,utf8_decode('SEGUNDO APELLIDO'),1,0,'C',true);
$pdf->Cell(35,6,utf8_decode('PRIMER NOMBRE'),1,0,'C',true);
$pdf->Cell(35,6,utf8_decode('SEGUNDO NOMBRE'),1,0,'C',true);
$pdf->Cell(10,6,utf8_decode('SEXO'),1,0,'C',true);
$pdf->Cell(20,6,utf8_decode('EDAD'),1,0,'C',true);
$pdf->SetFont('Arial','B', 4);
$pdf->Cell(20,2,utf8_decode('CONDICIÓN'),'RLT',1,'C',true);
$pdf->Cell(170);
$pdf->Cell(10,2,utf8_decode('EDAD'),'LB',0,'R',true);
$pdf->SetFont('Arial','', 4);
$pdf->Cell(10,2,utf8_decode('(MARCAR)'),'RB',1,'L',true);
$pdf->Cell(170);
$pdf->Cell(5,2,utf8_decode('H'),1,0,'C',true);
$pdf->Cell(5,2,utf8_decode('D'),1,0,'C',true);
$pdf->Cell(5,2,utf8_decode('M'),1,0,'C',true);
$pdf->Cell(5,2,utf8_decode('A'),1,1,'C',true);

$pdf->SetFont('Arial','', 6);
$pdf->Cell(35,5,utf8_decode($apellidos_paci1),1,0,'C');
$pdf->Cell(35,5,utf8_decode($apellidos_paci2),1,0,'C');
$pdf->Cell(35,5,utf8_decode($nombres_paci1),1,0,'C');
$pdf->Cell(35,5,utf8_decode($nombres_paci2),1,0,'C');
$pdf->Cell(10,5,$genero[0],1,0,'C');

if ($edad != '0000/00/00')
{
    $pdf->Cell(20,5,$edad->format('%Y').utf8_decode(' años, ').$edad->format('%m').' meses',1,0,'C');
}
else
{
    $pdf->Cell(20,5,"",1,0,'C');
}
$pdf->SetFont('Arial','', 8);
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(5,5,utf8_decode(''),1,0,'C');
$pdf->Cell(5,5,utf8_decode('x'),1,1,'C');

$pdf->Ln(2);

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

$pdf->SetFont('Arial','B', 10);
$pdf->SetFillColor(153,153,153);
$pdf->SetTextColor(34,68,93);
$pdf->Cell(70,6,utf8_decode('B. EVOLUCIÓN Y PRESCRIPCIONES'),'LBT',0,'L',true);
$pdf->SetFont('Arial','', 5);
$pdf->Cell(75,6,utf8_decode('FIRMA AL PIE DE CADA EVOLUCIÓN Y PRESCRIPCIÓN'),'BT',0,'L',true);
$pdf->Cell(45,3,utf8_decode('REGISTRAR CON ROJO LA ADMINISTRACIÓN DE FARMACOS'),'TR',0,'R',true);
$pdf->Ln(3);
$pdf->Cell(145,3,utf8_decode(''),0,0,'R');
$pdf->Cell(45,3,utf8_decode('Y COLOCACIÓN DE DISPOSITIVOS MÉDICOS'),'BR',1,'R',true);


$pdf->SetFillColor(188,188,188);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B', 8);
$pdf->Cell(94,5,utf8_decode('1. EVOLUCIÓN'),1,0,'C',true);
$pdf->Cell(2);

$pdf->Cell(94,5,'2. PRESCRIPCIONES',1,1,'C',true);


$pdf->SetFillColor(238,238,238); 
$pdf->SetFont('Arial','B', 6);

$pdf->Cell(12,3,utf8_decode('FECHA'),'LRT',0,'C',true);
$pdf->Cell(8,3,utf8_decode('HORA'),'LRT',0,'C',true);
$pdf->Cell(74,6,utf8_decode('NOTAS DE EVOLUCIÓN'),1,0,'C',true);
$pdf->Cell(2);
$pdf->Cell(74,3,utf8_decode('FARMACOTERAPIA E INDICACIONES'),'TLR',0,'C',true);
$pdf->SetFont('Arial','', 6);
$pdf->Cell(20,2,utf8_decode('ADMINISTR.'),'TRD',0,'C',true);
$pdf->Ln(2);
$pdf->SetFont('Arial','', 5);
$pdf->Cell(12,4,utf8_decode('(aaa-mm-dd)'),'LRB',0,'C',true);
$pdf->Cell(8,4,utf8_decode('(hh:mm)'),'LRB',0,'C',true);
$pdf->SetFont('Arial','', 6);
$pdf->Cell(76);
$pdf->Cell(74,3,utf8_decode('(Para enfermería y otro profesional de salud)'),'LR',0,'C',true);
$pdf->Cell(20,2,utf8_decode('FÁRMACOS.'),'RL',0,'C',true);
$pdf->Ln(2);
$pdf->Cell(96);
$pdf->Cell(74,2,utf8_decode(' '),'LRB',0,'C');
$pdf->Cell(20,2,utf8_decode('DISPOSITIVO.'),'RLB',1,'C',true);
$pdf->Ln(2);



$h_gen = 70;


for ($i=0; $i < sizeof($evoluciones); $i++) {
    
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
        $cont_prescrip="";
        for ($j=0; $j < sizeof($recetas); $j++) { 
            $pdf->SetTextColor(0, 0, 0); 
            $cantidad = substr($recetas[$j]['cantidad'],0,-3);
            $receta = mb_strtoupper($recetas[$j]['datos_m']);
            $via_a = mb_strtolower($recetas[$j]['indicaciones']);
            $cont_prescrip = $cont_prescrip."SUMINISTRACIÓN DE ".$cantidad." ".$receta." - ".$via_a." ";
        }
     
        $pdf->Cell(12,5,utf8_decode($evoluciones[$i]['fecha_cita']),1,0,'C');
        $pdf->Cell(8,5,utf8_decode(substr($evoluciones[$i]['hora_cita'],0,-3)."h"),1,0,'C');
        
        
        $evolucion=$evoluciones[$i]['evolucion'];
        $array_evolucion = str_split($evolucion, 52);
        $cantidad_filas=count($array_evolucion);
        $pdf->Cell(74,5,utf8_decode($array_evolucion[0]),1,0,'L');
        $pdf->Cell(2);
        $array_prescripcion=str_split(mb_strtoupper($cont_prescrip), 52);

        $pdf->SetTextColor(245,27,27);
        $cantidad_filas_pres=count($array_prescripcion);
        if ($cantidad_filas_pres>0)
        {
            $pdf->Cell(74,5,utf8_decode($array_prescripcion[0]),1,0,'L');
            $pdf->Cell(20,5,utf8_decode($recetas[0]['via_a']),1,1,'C');
        }
        else
        {
            $pdf->Cell(74,5,"",1,0,'L',true);
            $pdf->Cell(20,5,"",1,1,'C',true);
        }
        $p=1;
        $pdf->SetFillColor(238,238,238); 
        if($cantidad_filas>$cantidad_filas_pres)
        {
            for($h=1; $h < $cantidad_filas; $h++)
            {
                 
                $pdf->SetTextColor(0, 0, 0);           
                $pdf->Cell(12,5,"",1,0,'C',true);
                $pdf->Cell(8,5,"",1,0,'C', true);
                $pdf->Cell(74,5,utf8_decode($array_evolucion[$h]),1,0,'L');
                
                $pdf->Cell(2);
                $pdf->SetTextColor(245,27,27);
                if($p<$cantidad_filas_pres)
                {
                    $pdf->Cell(74,5,utf8_decode($array_prescripcion[$p]),1,0,'L');
                    $pdf->Cell(20,5,"",1,1,'C',true);
                    $p++;
                }
                else
                {
                    $pdf->Cell(74,5,"",1,0,'L',true);
                    $pdf->Cell(20,5,"",1,1,'C',true);
                    $p++;
                } 

            }
        }
        else
        {
            for($h=1; $h < $cantidad_filas_pres; $h++)
            {
                $pdf->SetTextColor(0, 0, 0);           
                if($p<$cantidad_filas)
                {
                    $pdf->Cell(12,5,"",1,0,'C',true);
                    $pdf->Cell(8,5,"",1,0,'C',true);
                    $pdf->Cell(74,5,utf8_decode($array_evolucion[$p]),1,0,'L');
                }
                else
                {
                    $pdf->Cell(12,5,"",1,0,'C',true);
                    $pdf->Cell(8,5,"",1,0,'C',true);
                    $pdf->Cell(74,5,"",1,0,'L',true);
                } 
                $pdf->Cell(2);
                $pdf->SetTextColor(245,27,27);
               
                    $pdf->Cell(74,5,utf8_decode($array_prescripcion[$h]),1,0,'L');
                    $pdf->Cell(20,5,"",1,1,'C',true);
                    $p++;
            }
        }
    $ejey=$pdf->GetY();
    $pdf->SetTextColor(0,0,0);
}
$ejey=$pdf->GetY();
    $pdf->SetXY(10,$ejey);
    $celdas_evo = (270 - $ejey)/5;
    for ($d=0; $d < ($celdas_evo); $d++) { 
        $pdf->SetFillColor(238,238,238);
        $pdf->Cell(12,5,"",1,0,'C', true);
        $pdf->Cell(8,5,"",1,0,'C', true);
        
        $pdf->Cell(74,5,"",1,0,'L', true); 
        $pdf->Cell(2);
        $pdf->Cell(74,5,"",1,0,'C',true);
        $pdf->Cell(20,5,"",1,1,'C', true);
    }        


$pdf->Output("reporte_hcu_005.pdf","I",true);
?>