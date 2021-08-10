<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
error_reporting(0);
$page = "carta";

if (isset($_GET['tipo']) && $_GET['tipo'] !== '' && is_numeric($_GET['tipo'])) {
} else {
    header("Status: 301 Moved Permanently");
    header('location: index.php');
    exit();
}

require 'class/ProductoClass.php';
require 'class/TiendaClass.php';
$objTienda = new TiendaClass();
$objProducto = new ProductoClass();
$idProducto = trim($_GET['tipo']);
$lista = $objProducto->getTipoProductos($idProducto);
$categoria = $objProducto->getTipoProductoById($idProducto);

$nombreCategoria = $categoria['nombre'];

$estadoTienda = trim($objTienda->getEstadoTienda()['estado']);


//GENERANDO LOS META TAGS
$nombres = '';
foreach ($lista as $item) {
    $nombres = $nombres . ', ' . $item['nombreProducto'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Senshi Sushi/Bar - <?php echo $nombreCategoria ?></title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">

</head>

<body>
    <?php include 'templates/navbar.php'; ?>

    <div class="container text-center" style="margin-top:95px">
        <div class="row ">
            <div class="col">
                <h5 class="my-4">COMIENZA TU ORDEN AQUÍ</h5>
                <h6 class="text-danger font-weight-bolder mb-5">CATEGORIAS</h6>
            </div>
        </div>


    </div>

    <?php include 'templates/categoryBar.php' ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <h5 class="piqueos mt-5 mb-3 text-uppercase"><?php echo $nombreCategoria ?></h5>
                <div class="mb-3" style="border-bottom: 2px solid black"></div>

            </div>
        </div>
        <div class="row">
            <?php
            foreach ($lista as $campo) {

            ?>
                <form data-maxChecked='<?php echo $campo['productoObservaciones'] ?>' action="script/cartAction.php" method="get" class="col-12 col-md-6 col-lg-6 col-xl-6">

                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                            <input type="hidden" name="action" value="addToCart">
                            <input class="idProducto" type="hidden" name="id" value="<?php echo $campo['idProducto'] ?>">
                            <h5 class="text-danger"><?php echo $campo['nombreProducto'] ?></h5>
                            <p><?php echo $campo['descripcionProducto'] ?></p>
                            <p class="text-danger font-weight-bold">
                                <strike>S/. <?php echo $campo['precioProducto'] ?>.00</strike><br>
                                S/. <?php echo round(($campo['precioProducto'] * 85) / 100) ?>.00
                            </p>
                        </div>

                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center">
                            <img data-zoomable="true" src="img/carta/platos/<?php echo $campo['imagenProducto'] ?>" class="img-fluid" alt="">

                        </div>
                        <div class="col-12 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center justify-content-center">
                            <div class="text-center my-3">

                                <?php if ($campo['productoObservaciones'] == 'MULTI_PAQUETE1') { ?>
                                    <a href="senshi-paquete1.php" class="btn btn-danger btn-sm mt-2" style="font-weight:bold">
                                        Comprar
                                    </a>
                                <?php } elseif ($campo['productoObservaciones'] == 'MULTI_PAQUETE2') { ?>
                                    <a href="senshi-paquete2.php" class="btn btn-danger btn-sm mt-2" style="font-weight:bold">
                                        Comprar
                                    </a>
                                <?php } elseif ($campo['productoObservaciones'] == 'MULTI_PAQUETE3') { ?>
                                    <a href="senshi-paquete3.php" class="btn btn-danger btn-sm mt-2" style="font-weight:bold">
                                        Comprar
                                    </a>
                                <?php } elseif ($campo['productoObservaciones'] == 'MULTI_PAQUETE4') { ?>
                                    <a href="senshi-paquete4.php" class="btn btn-danger btn-sm mt-2" style="font-weight:bold">
                                        Comprar
                                    </a>
                                <?php } elseif ($campo['productoObservaciones'] == 'MULTI_PAQUETE5') { ?>
                                    <a href="senshi-paquete5.php" class="btn btn-danger btn-sm mt-2" style="font-weight:bold">
                                        Comprar
                                    </a>
                                <?php } elseif ($campo['productoObservaciones'] == 'MULTI_PAQUETE2-10082020') { ?>
                                    <a href="paquete-2-1082020.php" class="btn btn-danger btn-sm mt-2" style="font-weight:bold">
                                        Comprar
                                    </a>
                                <?php } ?>
                                <?php if ($campo['acumulaNPuntos'] > 0) { ?>
                                    <small class="d-block text-danger">Acumula <?php echo round(($campo['acumulaNPuntos'] * 85) / 100) ?> puntos</small>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                    <div class="my-3">

                        <hr>
                    </div>
                </form>

            <?php } ?>
        </div>


    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger" id="exampleModalLabel"><i class="far fa-check-circle"></i> Producto
                        agregado al carrito</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-footer">
                    <a href="#" data-dismiss="modal">Seguir comprando</a>
                    <a href="carrito.php" class="btn btn-danger">Ir al carrito de compras</a>
                </div>
            </div>
        </div>
    </div>
    <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>
    <script>
        let categoria = <?php echo $_GET['tipo'] ?>
    </script>

    <?php include 'templates/footer.php'; ?>
    <script src="js/platos.js"></script>
</body>

</html>