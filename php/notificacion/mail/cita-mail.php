<?php
$medico = htmlspecialchars(ucwords(mb_strtolower($_POST['medico'])),ENT_QUOTES,'UTF-8');
$tipo_cita = $_POST['tipo_cita'];
$t_cita = "";
if(intval($tipo_cita) == 1){
    $t_cita = "Normal";
}
if(intval($tipo_cita) == 0){
    $t_cita = "Control";
}
$usuario = htmlspecialchars(ucwords(mb_strtolower($_POST['nom_ape'])),ENT_QUOTES,'UTF-8');
$email = htmlspecialchars($_POST['correo'],ENT_QUOTES,'UTF-8');
$fecha = htmlspecialchars($_POST['fecha'],ENT_QUOTES,'UTF-8');
$hora = htmlspecialchars($_POST['hora'],ENT_QUOTES,'UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/Exception.php';
require '../../PHPMailer/PHPMailer.php';
require '../../PHPMailer/SMTP.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    /*$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
	);*/
    //Server settings
    //$mail->SMTPDebug = 0;                      // Enable verbose debug output
    //$mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'rapid.hostingec.host';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = 'true';                                   // Enable SMTP authentication
    $mail->Username   = 'info@cesmed.ec';                     // SMTP username
    $mail->Password   = 'Cesmed2022*';                               // SMTP password
    $mail->SMTPSecure = 'SSL';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
    $mail->CharSet = 'UTF-8';
    $mail->From = 'info@cesmed.ec';
    $mail->FromName = 'CESMED - Centro de Especialidades Médicas';


    //Recipients
    //$mail->setFrom('info@cesmed.ec', 'CESMED - Centro de Especialidades Médicas');
    $mail->AddAddress($email, $usuario);     // Add a recipient             

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Generación de nueva cita para '.$usuario;
    $mail->Body    = '<!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <td>
                        <img href="www.cesmed.ec" src="https://www.cesmed.ec/clinical/assets/images/banner-mail.jpg" alt="CESMED" width="100%">
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;font-size: 15px;font-family: Verdana;color: #1e1f1e;">
                        Estimado '.$usuario.', el Centro de Especialidades Médicas - CESMED le ha generado una nueva cita.
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px;font-size: 12px;font-family: Verdana;color: #1e1f1e;">
                        <b>MÉDICO:</b> '.$medico.'<br><br>
                        <b>TIPO CITA:</b> '.$t_cita.'<br><br>
                        <b>FECHA:</b> '.$fecha.'<br><br>
                        <b>HORA:</b> '.$hora.' horas<br><br>
                    </td>
                </tr>
            </thead>
        </table>
    </body>
    </html>';

    $mail->send();
    echo 1;
} catch (Exception $e) {
    echo 0;
}