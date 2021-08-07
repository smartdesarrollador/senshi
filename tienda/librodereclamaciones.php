<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senshi-Politicas de privacidad</title>
     <?php include 'templates/metalink.php';?>
     <link rel="stylesheet" href="css/carta.css">
</head>
<body> 
    <?php include 'templates/navbar.php';?>

     <div class="container-fluid text-center" style="background:#000000;color:#ffffff;margin-top:130px">
	     <div class="row">
		      <div class="col-sm-12 col-xs-12"> 
               <a href="index.php" class="text-decoration-none" style="color:#000000;margin-top:130px">
                  <h6 class="text-left mt-1 text-white"><i class="fas fa-arrow-left mr-2"></i>Volver</h6>
               </a>
               <h1 class="piqueos mt-1 ">LIBRO DE RECLAMACIONES</h1>
				</div>
		  </div>
  	  </div>
          
<div class="container-fluid">

   
   <div class="container" style="max-width:600px;width:100%;margin:0 auto;position:relative"> 
      <p class="text-justify mt-4">Conforme a lo establecido en código de la Protección y Defensa del consumidor contamos con un Libro
         de Reclamaciones a tu disposición para que puedas registrar tu queja o reclamo acerca de algún pedido o 
           transacción realizada</p> 
       <form id="contact" action="" method="post">
           <h3 class="text-center">HOJA DE RECLAMACION V-07865</h3>
           <h4 class="text-center">Fecha de Registro:02-05-2020</h4>
         
           <fieldset>
           <h5 class="">1.Identificacion del Usuario</h5>
               <input placeholder="Nombre y Apellidos" type="text" tabindex="1" required autofocus>
           </fieldset>
           <fieldset>
               <input placeholder="Domicilio" type="text" tabindex="2" required>
           </fieldset>
           <fieldset>
               <input placeholder="DNI / CE" type="tel" tabindex="3" required>
           </fieldset>
           <fieldset>
               <input placeholder="Número de Teléfono" type="tel" tabindex="3" required>
           </fieldset>
           <fieldset>
               <input placeholder="Correo Electrónico" type="email" tabindex="2" required>
           </fieldset>
           <h5>2.Detalle de Reclamación</h5>
          
                    <div class="form-check ml-3 mt-2">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1"
                               value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                            Reclamo:Disconformidad relacionada a los productos o servicios
                        </label>
                    </div>
                    <div class="form-check ml-3">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios2"
                               value="option2">
                        <label class="form-check-label" for="exampleRadios2">
                           Queja: Disconformidad no relacionada a los productos, descontento a la atención al público.
                        </label>
                    </div>
                   
           <fieldset>
               <textarea placeholder="Detalla tu reclamo o queja...." tabindex="5" required></textarea>
           </fieldset>
           <h5>3.Detalle del Producto o Servicio adquirido</h5>
           <label for="start">Fecha de Pedido:</label>
           
             <input type="date" id="start" name="trip-start"
                value="2020-05-02"
                min="2018-01-01" max="2021-12-31">
            <fieldset>
               <textarea placeholder="Detalle del pedido...." tabindex="5" required></textarea>
           </fieldset>
           <fieldset>
               <textarea placeholder="Pedido del Reclamante...." tabindex="5" required></textarea>
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