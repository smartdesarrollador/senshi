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
            <hr>

        </div>
    </div>

    <?php
    foreach ($lista as $campo) {

        ?>
        <form
                data-maxChecked='<?php echo $campo['productoObservaciones'] ?>'
                action="script/cartAction.php" method="get" class="formCard">
                                        <input type="hidden" name="action" value="addToCart">
            <div class="row pt-2 pb-3 py-md-4">
                <div class="col-12 col-md-6 col-lg-6 col-xl-6">
                    <input type="hidden" name="action" value="addToCart">
                    <input class="idProducto" type="hidden" name="id"
                           value="<?php echo $campo['idProducto'] ?>">
                    <h5 class="text-danger"><?php echo $campo['nombreProducto'] ?></h5>
                    <?php if($campo['idProducto'] == 389){ ?>
                        <!-- checkouts -->
                        <div class="row">
                        <div class="col-md-12">
                        <h5>Escoge 2 de 3 sabores:</h5>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Shake Sesame" id="shake" name="shake" >
                        <label class="form-check-label" for="shake">
                        <strong>Shake Sesame:</strong> Tartar de salmón, salsa cítrica aromatizada con aceite de sésamo, palta y arroz de sushi en alga nori crocante.
                        </label>
                        </div>

                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="katsuo Spicy" id="katsuo" name="katsuo" >
                        <label class="form-check-label" for="katsuo">
                       <strong>Katsuo Spicy: </strong> Tartar de bonito, mayo nikkei semi picante, culantro, palta y arroz de sushi en alga nori crocante.
                        </label>
                        </div>
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="Tnt Scallops Taco" id="tnt" name="tnt"  >
                        <label class="form-check-label" for="tnt">
                       <strong>Tnt Scallops Taco: </strong>Mix de conchitas (tnt), palta y arroz de sushi en alga nori crocante.
                        </label>
                        </div>

                        </div>
                        </div>
                         <!-- /checkouts -->
                                        
                     <?php } ?>




                    <p><?php echo $campo['descripcionProducto'] ?></p>
                </div>
                <div class="col-12 col-md-6 col-lg-1 col-xl-1 d-flex align-items-center">
                <span class="my-2">
                    S/. <?php echo $campo['precioProducto'] ?>.00
                </span>

                </div>
                <div class="col-12 col-md-6 col-lg-2 col-xl-2 d-flex align-items-center">
                    <img data-zoomable="true" src="img/carta/platos/<?php echo $campo['imagenProducto'] ?>" class="img-fluid" alt="">

                </div>
                <div class="col-12 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center">
                    <div class="text-center my-3" style="width: 100%;">
                        <div class="input-group mb-3 justify-content-center">
                            <div class="input-group-prepend input-group-append">
                                <button onclick="changeQty(this,'minus')"
                                        class="btn btn-sm" type="button">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input
                                        style="width: 80px"
                                        required onkeypress="return solonumeros(event);"
                                       type="number"
                                       minlength="1" class="form-control text-center cantidad"
                                       min="1" name="cantidad" value="1" placeholder="Cantidad"
                                       aria-label="Cantidad"
                                       aria-describedby="button-addon2">
                                <button onclick="changeQty(this,'add')"
                                        type="button" class="btn btn-sm">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <button
                            <?php echo ($campo['stock'] == 'NOT') ? 'disabled' : '' ?>
                                class="btn btn-sm btn-danger btn-comprar" style="font-weight:bold"
                                type="submit">
                            <i class="fas fa-shopping-cart mr-1"></i>Comprar
                        </button>
                        <?php echo ($campo['stock'] == 'NOT') ? '<small class="text-danger d-block">Agotado</small>' : '' ?>
                        <?php if ($campo['acumulaNPuntos'] > 0) { ?>
                            <strong class="d-block text-danger">Acumula <?php echo $campo['acumulaNPuntos'] ?> puntos</strong>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </form>
        <div>
            <hr>
        </div>
    <?php } ?>

</div>


<?php 
$url = $_SERVER['REQUEST_URI']; 
?>
<?php if ($_SESSION['local'] == "san_borja") { ?>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
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

                        <?php } else if ($_SESSION['local'] == "lince") { ?>
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
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
                        <?php }else {  ?>
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                            <div class="modal-body">
                           
                            <h3 class=" text-center">Selecciona un Local</h3>
                            

                            </div>
                            <div class="modal-footer">
                            <div class="row">
                            
                            <div class="col-md-12 ">
                            <a href="sesion_zona_reparto_url.php?zona=san_borja&url=<?php echo $url; ?>" class="btn btn-danger btn-lg btn-block">Tienda 1 (San Borja)</a><br>
                            
                            </div>
                            <div class="col-md-12 ">
                            <a href="sesion_zona_reparto_url.php?zona=lince&url=<?php echo $url; ?>" class="btn btn-danger btn-lg btn-block">Tienda 2 (lince)</a><br>
                            </div>
                            
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                        <?php } ?>



<button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fas fa-arrow-up"></i></button>
<script>
    let categoria = <?php echo $_GET['tipo'] ?>
</script>

<?php include 'templates/footer.php'; ?>
<script src="js/platos.js"></script>
<script>
/* var limit = 3;
$('input.form-check-input').on('change', function(evt) {
   if($(this).siblings(':checked').length <= limit) {
       this.checked = false;
   }
}); */

$('input[type=checkbox]').on('change', function (e) {
    if ($('input[type=checkbox]:checked').length > 2) {
        $(this).prop('checked', false);
        alert("Escoge solo 2 sabores porfavor!");
    }
});

/* $('button[type=submit]').on('click', function (e) {
    if ($('input[type=checkbox]:checked').length <= 1) {
       
        alert("Escoge 2 sabores porfavor!");

    }   
});
 */

</script>
</body>

</html>
