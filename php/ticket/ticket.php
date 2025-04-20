<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TICKET</title>
    <link rel="stylesheet" href="ticket.css">
    <script src="ticket.js"></script>
</head>
<body>
        <?php
        $id_cita=$_GET['id_cita'];
        ?>
        <input type="text" id="id_cita" value="<?php echo($id_cita);?>" required hidden disabled>
    <div class="ticket">
        <p class="centrado">Centro de Especialidades Médicas
            <br><strong>"CESMED" S.C.</strong>
            <br>Al cuidado de su salud y la de su familia</p>
        <div class="centrado"><img
            src="../../assets/images/logo_rce.jpeg"
            alt="Logotipo" width="70" height="70"></div>
        <div class="centrado">
        <table>
            <tbody>
                <tr>
                    <td><label id="medico"></label></td>
                </tr>              
                <tr>
                    <td><strong><label id="fecha"></label></strong></td>
                </tr>
                <tr>
                    <td><strong><label id="hora"></label></strong></td>
                </tr>
                <tr>
                    <td></br></td>
                </tr>
                <tr>
                    <td><label id="paciente"></label></td>
                </tr>
                <tr>
                    <td><label id="t_cita"></label></td>
                </tr>
                <tr>
                    <td><label id="turno"></label></td>
                </tr>
                <tr>
                    <td></br> <strong>COBROS REALIZADOS</strong></td>
                </tr>
                <tr>
                    <td id="f_pago"></td>                    
                </tr> 
            </tbody>
        </table>
        </div>
        <p class="centrado"><strong>AGENDA TU PRÓXIMA CITA
            <br>0992552373 - 062985931</strong>
            <br>www.cesmed.ec
            <br><br>¡Gracias por preferirnos!</p>
    </div>

    <script src="../../assets/js/jquery-3.6.0.min.js"></script>
    <script src="../../assets/js/jquery-1.10.2.min.js"></script>


    <script src="../../assets/js/jquery.nicescroll.js"></script>
    <script src="../../assets/js/scripts.js"></script>
    <script src="ticket.js"></script> 
</body>
</html>