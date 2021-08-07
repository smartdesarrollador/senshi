<?php
session_start();
$page='reparto';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senshi Sushi/Bar-Error</title>
     <?php include 'templates/metalink.php';?>
     <link rel="stylesheet" href="css/carta.css">
</head>
<body> 
    <?php include 'templates/navbar.php';?>

    <div class="container" style="min-height: 800px;margin-top: 150px">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img style="width: 200px" class="m-3" src="icon/error.png" alt="">
                        <h4 class="p-2" style="color: red">No hemos podido procesar tu pago debido a un problema con tu tarjeta de crédito</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">

                        <p>Le recomendamos que se ponga en contracto con el emisor de su tarjeta de crédito.
                        </p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12 col-xl12 col-sm-12 col-lg-12 col-12 text-center">


                        <a href="carta.php"  class="btn btn-info btn-block">Volver a la carta</a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    
   
	
		


 


<?php include 'templates/footer.php';?>

    
</body>
</html>
