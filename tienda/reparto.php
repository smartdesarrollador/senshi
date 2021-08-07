<?php
session_start();
$page='reparto';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senshi Sushi/Bar-Reparto</title>
     <?php include 'templates/metalink.php';?>
     <link rel="stylesheet" href="css/carta.css">
</head>
<body> 
    <?php include 'templates/navbar.php';?>

    <div class="container text-center" style="margin-top:140px">
	     <div class="row">
		      <div class="col-sm-12 col-xs-12"> 

			           <h1 class="piqueos mb-4">Zona de Reparto</h1>
				   <h3 class="text-danger font-weight-bolder">Si estás fuera de la zona de reparto contáctanos al 949115822</h3>
			  </div>
		 </div>
        <div class="row mb-5">
            <div class="col">
                
                
                
                <iframe src="https://www.google.com/maps/d/embed?mid=1L3g8tc58sSF6bMCZFDeyAbDeQli07i6N" width="100%" height="600"></iframe>
            </div>
        </div>
	</div>
    
   
	
		


 


<?php include 'templates/footer.php';?>

    
</body>
</html>
