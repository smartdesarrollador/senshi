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

        $s = str_replace('"', '', $s);
        $s = str_replace(':', '', $s);
        $s = str_replace('.', '', $s);
        $s = str_replace(',', '', $s);
        $s = str_replace(';', '', $s);
        return $s;
    }

    $nombres = limpiar($_POST['nombres']);
    $correo = $_POST["correo"];
    $mensaje = limpiar($_POST["mensaje"]);
    $celular = limpiar($_POST["celular"]);



        $to = "reservaciones@senshi.pe";
        $subject = "Nuevo Mensaje";
        $message = "Hola tienes un nuevo mensaje desde la web senshi.pe:<br><br>";
        $message = $message . "<p style=' border: 2px solid #000000; border-radius: 3px;display: inline-block; padding: 10px 10px 10px 10px;;
position: relative; '>" . $mensaje . "</p><br><br>";

        $message = $message . "Nombre: " . $nombres . "<br>";
        $message = $message . "Correo: " . $correo . "<br>";
        $message = $message . "Numero de celular: " . $celular . "<br>";


/////
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= 'From: Senshi Contacto <noreply@senshi.pe>' . "\r\n";

        if (mail($to, $subject, $message, $headers)) {

            ?>
            <script>

                window.location = '../contacto.php?code=succes';
            </script>

            <?php
        } else {
            echo "Error al enviar el mensaje, contacte con el administrador";
        }



} else {
    echo "No tiene autorización para ver esta página";
}
