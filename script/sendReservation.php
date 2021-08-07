<?php
/**
 * Created by PhpStorm.
 * Developer: Johen Guevara Santos.
 * Email: mguevara@enfocussoluciones.com
 * Date: 6/09/2019
 * Time: 09:44
 */
error_reporting(0);
if (isset($_POST['submit'])) {


    function limpiar($s)
    {
        $s = str_replace('á', 'a', $s);
        $s = str_replace('Á', 'A', $s);
        $s = str_replace('é', 'e', $s);
        $s = str_replace('É', 'E', $s);
        $s = str_replace('í', 'i', $s);
        $s = str_replace('Í', 'I', $s);
        $s = str_replace('ó', 'o', $s);
        $s = str_replace('Ó', 'O', $s);
        $s = str_replace('Ú', 'U', $s);
        $s = str_replace('ú', 'u', $s);
        $s = str_replace('ñ', 'n', $s);
        $s = str_replace('"', ' ', $s);

        return $s;
    }
        $nombreCompleto = limpiar($_POST['nombreCompleto']);
        $empresa = limpiar($_POST['empresa']);
        $email = trim($_POST['email']);
        $telefono = limpiar($_POST["telefono"]);
        $hora = limpiar($_POST["hora"]);
        $fecha = limpiar($_POST["fecha"]);
        $motivo = limpiar($_POST["motivo"]);
        $numPersonas = limpiar($_POST["numPersonas"]);
        $dni = limpiar($_POST["dni"]);


        $mensaje = "
<table cellspacing=\"0\" cellpadding=\"0\" border=\"0\" style=\"color:#333;background:#fff;padding:0;margin:0;width:100%;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica\"> <tbody><tr width=\"100%\"> <td valign=\"top\" align=\"left\" style=\"background:#eef0f1;font:15px/1.25em 'Helvetica Neue',Arial,Helvetica\"> <table style=\"border:none;padding:0 18px;margin:50px auto;width:500px\">
 <tbody> <tr width=\"100%\" height=\"60\"> 
 <td valign=\"top\" align=\"left\" style=\"border-top-left-radius:4px;border-top-right-radius:4px;background:#000000 ;padding:10px 18px;text-align:center\"> 
 
 <img  width=\"50\" src=\"https://senshi.pe/img/logo2.png\" title=\"Logo Senshi\" style=\"font-weight:bold;font-size:18px;color:#fff;vertical-align:top\" class=\"CToWUd\"> 
 </td> 
 </tr> 
 <tr width=\"100%\"> <td valign=\"top\" align=\"left\" style=\"background:#fff;padding:18px\">

 <h1 style=\"font-size:20px;margin:16px 0;color:#333;text-align:center\"> 
      Nueva Reservación: 
</h1> 

<h3 style=\"font-size:15px;margin:16px 0;color:#333;\"> 
      Nombre Completo: 
</h3>
 <p style=\"font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align:center\">
 " . $nombreCompleto . " <strong>DNI:" . $dni . "
 </strong></p>

<h3 style=\"font-size:15px;margin:16px 0;color:#333;\"> 
      Empresa: 
</h3>
 <p style=\"font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align:center\">" . $empresa . "</p>

<h3 style=\"font-size:15px;margin:16px 0;color:#333;\"> 
      Correo: 
</h3>
 <p style=\"font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align:center\">" . $email . "</p>

<h3 style=\"font-size:15px;margin:16px 0;color:#333;\"> 
      Fecha y Hora: 
</h3>
<p style=\"font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align:center\"><strong>
" . $fecha . ", " . $hora . "
</strong></p>

<h3 style=\"font-size:15px;margin:16px 0;color:#333;\"> 
      Motivo de la reserva: 
</h3>
<p style=\"font:15px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align:center\">" . $motivo . "</p>
  
<h3 style=\"font-size:15px;margin:16px 0;color:#333;\"> 
      Numero de Personas: 
</h3>
 <p style=\"font:20px 'Helvetica Neue',Arial,Helvetica;color:#333;text-align:center;\">
 <span style='border: 2px solid black; padding: 5px; border-radius: 5px'>" . $numPersonas . "</span>
 </p>
 
 
<p style=\"font:20px/1.25em 'Helvetica Neue',Arial,Helvetica;color:#333;text-align:center\">
<a target='_blank' href=\"https://senshi.pe\" style='text-decoration: none'>senshi.pe</a>

</p>
 </td>

 </tr>

 </tbody> </table> </td> </tr></tbody> </table>";

        $to = "reservaciones@senshi.pe,maurojohen@gmail.com";
        $subject = "Nueva Reservación - Senshi";
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= 'From: Senshi - AVISOS<noreply@senshi.pe>' . "\r\n";

        if (mail($to, $subject, $mensaje, $headers)) {
            ?>
            <script>
                window.location = '../reservas.php?code=success';
            </script>
            <?php
        } else {
            echo "Error al enviar el mensaje, contacte con el administrador";
        }




} else {
    echo "No tiene autorización para ver esta página";
}
