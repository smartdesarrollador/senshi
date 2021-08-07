<?php
session_start();
$page='contacto';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senshi Sushi/Bar-Contacto</title>
     <?php include 'templates/metalink.php';?>
     <link rel="stylesheet" href="css/carta.css">
</head>
<body> 
    <?php include 'templates/navbar.php';?>


    
  
<div class="container-fluid" style="margin-top: 140px">
    <?php
    error_reporting(0);
    if ($_GET["code"] == "success") {
        ?>

        <div class="alert alert-success" role="alert">
            Se ha enviado el mensaje correctamente, nos pondremos en contacto contigo.
        </div>
        <?php
    }
    ?>
    <div class="container" style="max-width:600px;width:100%;margin:0 auto;position:relative">  
        <form id="contact" action="script/sendMail.php" method="post">
            <h3 class="text-center">CONTÁCTANOS</h3>
            <h4 class="text-center">¡Contáctenos hoy y reciba respuesta inmediatamente!</h4>
            <h4 class="text-center"><i class="fas fa-envelope mr-2" style="font-size:20px"></i>reservas@senshi.pe</h4>
            <h4 class="text-center"><i class="fas fa-phone mr-2" style="font-size:20px"></i>(01) 3088698</h4>
            <h4 class="text-center"><i class="fas fa-map-marker-alt mr-2" style="font-size:20px"></i>Av. Aviación 3455, San Borja</h4>
            <fieldset>
                <input name="nombres" placeholder="Nombre y Apellidos" type="text" tabindex="1" required autofocus>
            </fieldset>
            <fieldset>
                <input name="correo" placeholder="Correo Electrónico" type="email" tabindex="2" required>
            </fieldset>
            <fieldset>
                <input name="celular" placeholder="Número de Teléfono" type="tel" tabindex="3" required>
            </fieldset>
            <fieldset>
                <textarea name="mensaje" placeholder="Escribe tu mensaje...." tabindex="5" required></textarea>
            </fieldset>
            <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending">Enviar</button>
            </fieldset>
        </form>
   </div>
   </div>		


 


<?php include 'templates/footer.php';?>
   <script src="js/popper.min.js"></script>
   <script src="js/jquery-3.4.1.slim.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
    
</body>
</html>
