<?php
session_start();
$page = "carta";
error_reporting(0);
Header( "HTTP/1.1 301 Moved Permanently" );
header('Location: platos.php?tipo=24');
require 'class/TipoProductoClass.php';
$objTipoProducto = new TipoProductoClass();
$lista = $objTipoProducto->getTipoProductos();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Carta</title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">
</head>
<body>
<?php include 'templates/navbar.php'; ?>

<div class="container text-center" style="margin-top:95px">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent font-weight-bold text-lowercase">
                    <li class="breadcrumb-item "><a href="index.php" class="text-dark">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Carta</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-xs-12">
            <h5>COMIENZA TU ORDEN AQUÍ</h5>
            <h3><img src="icon/sushi2.png" class="mx-2" alt="senshi sushi" style="width:40px">NUESTRA CARTA</h3>
            <h6>Buscamos darte ese deleite a través de nuestras diferentes especialidades.</h6>
        </div>
    </div>
</div>

<div class="container py-3 text-center mb-3" style="background:#000000">

    <div class="row p-0 m-0">

        <?php foreach ($lista as $campo) { ?>
            <div class=" col-xm-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 p-0 m-0">
                <div class="item p-2">
                    <div class="card">
                        <img
                                loading="lazy"
                                src="img/carta/categorias/<?php echo $campo['imageUrl'] ?>"
                                title="<?php echo $campo['nombre'] ?>" alt="<?php echo $campo['nombre'] ?>"
                                class="bg1 card-img-top">
                        <div class="card-body">
                            <?php
                            //si es sushi lo manda a otra pagina
                            if ($campo['idTipoProducto'] == 31) { ?>
                                <a href="senshi-sushi.php?tipo=<?php echo $campo['idTipoProducto'] ?>"
                                   class="btn btn5 btn-block font-weight-bold" style="font-size:1.8rem;"
                                ><?php echo $campo['nombre'] ?><i class="fas fa-sign-in-alt mx-4"></i>
                                </a>
                            <?php } elseif ($campo['idTipoProducto'] == 27){
                                ?>
                                <a href="senshi-paquetes.php?tipo=<?php echo $campo['idTipoProducto'] ?>"
                                   class="btn btn5 btn-block font-weight-bold" style="font-size:1.8rem;"
                                ><?php echo $campo['nombre'] ?><i class="fas fa-sign-in-alt mx-4"></i>
                                </a>
                                <?php
                            }elseif ($campo['idTipoProducto'] == 29){
                                ?>
                                <a href="senshi-gift-cards.php"
                                   class="btn btn5 btn-block font-weight-bold" style="font-size:1.8rem;"
                                ><?php echo $campo['nombre'] ?><i class="fas fa-sign-in-alt mx-4"></i>
                                </a>
                                <?php
                            }elseif ($campo['idTipoProducto'] == 25){
                                ?>
                                <a href="senshi-makis.php"
                                   class="btn btn5 btn-block font-weight-bold" style="font-size:1.8rem;"
                                ><?php echo $campo['nombre'] ?><i class="fas fa-sign-in-alt mx-4"></i>
                                </a>
                                <?php
                            }else { ?>
                                <a href="platos.php?tipo=<?php echo $campo['idTipoProducto'] ?>"
                                   class="btn btn5 btn-block font-weight-bold" style="font-size:1.8rem;"
                                ><?php echo $campo['nombre'] ?><i class="fas fa-sign-in-alt mx-4"></i>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

    </div>
</div>


<?php include 'templates/footer.php'; ?>

</body>
</html>
