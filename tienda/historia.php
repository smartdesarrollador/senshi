<?php
session_start();
$page='historia';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senshi Sushi/Historia</title>
     <?php include 'templates/metalink.php';?>
     <link rel="stylesheet" href="css/carta.css">
</head>
<body> 
    <?php include 'templates/navbar.php';?>

     <div class="container-fluid text-center" style="background:#000000;color:#ffffff;margin-top:100px">
        <div class="container">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" >
                        <ol class="breadcrumb bg-transparent font-weight-bold text-lowercase">
                            <li class="breadcrumb-item "><a href="index.php" class="text-white">Inicio</a></li>
                            <li class="breadcrumb-item active text-muted" aria-current="page">Historia</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
	     <div class="row">
		      <div class="col-sm-12 col-sm-12">
               <h1 class="piqueos mt-4">HISTORIA</h1>
				</div>
		  </div>
  	  </div>

  
<!--reseña historica e imagen con espacio arriba y abajo-->

<div class="container-fluid" style="background:#000000;color:#ffffff">
   <div class="container">
       <div class="row" > 
          <div class=" col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-5" >
              <h1 style="text-align: center; color:#ffffff;font-size: 30px"> SENSHI SUSHI/BAR</h1>
               <p class="text-justify">Con perseverancia, dedicación y 13 años de experiencia en la cocina Nikkei; 
                  SENSHI fue fundado por los hermanos Pierre y Paolo en el año 2016. Al igual que el significado de
                  SENSHI, ellos se identifican como GUERREROS, que con humildad y disciplina pudieron concretar su 
                  sueño. SENSHI se enfoca en ofrecer a sus clientes productos de primera calidad, excelente atención 
                  a un precio accesible.
               </p>   
                  <br>
              <h3 class="text-center">¡ Vive la experiencia de la gastronomía Nikkei !</h3>
           </div>

           <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6 mt-5 p-0 m-0">
              <img class="img-fluid" src="img/senshiFoto.png" class="img-fluid" alt="senshi foto">
           </div>
       </div>
   </div>
</div>

<div class="container-fluid mb-1" style="background:#000000">
     <div class="container">
        <div class="row">
           <div class="col-xs-12 col-sm-12 col-md-12  text-center mt-5">
                <img src="img/senshifoto1.jpg" class="img-fluid" alt="Responsive image" style="width:900px">
           </div>
        </div>
     </div>
</div>
	
		


 


<?php include 'templates/footer.php';?>
   <script src="js/popper.min.js"></script>
   <script src="js/jquery-3.4.1.slim.min.js"></script>
   <script src="js/bootstrap.min.js"></script>
    
</body>
</html>
