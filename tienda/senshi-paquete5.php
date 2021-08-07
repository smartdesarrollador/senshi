<?php
session_start();
$page = 'carta';
include 'class/ProductoClass.php';
include 'class/Producto_ingrediente.php';
$objProducto = new ProductoClass();
$objProductoIngrediente = new Producto_ingrediente();

$idProducto = 342;
/*SI SE REQUIERE CAMBIAR LA CANTIDAD DE LOS INGREDIENTES*/
$cantidadSashimis = 6;
$cantidadMakis = 1;
$cantidadSushis = 8;
$cantidadPlatosCalientes = 1;

//*maxima cantidad de ingredientes*/
$maxCantidadSashimis = 4;
$maxCantidadMakis = 1;
$maxCantidadSushis = 4;
$maxCantidadPlatosCalientes = 1;

$producto = $objProducto->getProductoById($idProducto);

$ingredientes = $objProductoIngrediente->getIngredientesByIdProductoAndTipo($idProducto, 'MAKI', 'nombre');


$ingredientesSashimi = $objProductoIngrediente->getIngredientesByIdProductoAndTipo($idProducto, 'SASHIMI', 'posicion');

$ingredientesSushis = $objProductoIngrediente->getIngredientesByIdProductoAndTipo($idProducto, 'SUSHI', 'posicion');
$ingredientesGunkans = $objProductoIngrediente->getIngredientesByIdProductoAndTipo($idProducto, 'GUNKAN', 'posicion');
$ingredientesPlatosCalientes = $objProductoIngrediente->getIngredientesByIdProductoAndTipo(342, 'PLATOCALIENTE', 'posicion');

//CUANTOS CUADROS HAY
$piecesSashimi = array_chunk($ingredientesSashimi, ceil(count($ingredientesSashimi) / 3));
$piecesMakis = array_chunk($ingredientes, ceil(count($ingredientes) / 6));

$piecesSushis = array_chunk($ingredientesSushis, ceil(count($ingredientesSushis) / 2));
$piecesGunkans = array_chunk($ingredientesGunkans, ceil(count($ingredientesGunkans) / 2));
$piecesPlatosCalientes = array_chunk($ingredientesPlatosCalientes, ceil(count($ingredientesPlatosCalientes) / 1));



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Senshi - <?php echo $producto['nombreProducto'] ?></title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">
    <link rel="stylesheet" href="css/paquetes.css">
    <style>
        .input-group-ingredientes {
            width: 100%;
        }
    </style>
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
    <div class="row mt-3">
        <div class="col mx-0 mx-md-5">
            <h5 class="mb-2 d-inline"><?php echo $producto['nombreProducto'] ?></h5>
            <br class="d-block d-lg-none">
            <span class="ml-0 ml-lg-4"><?php echo $producto['descripcionProducto'] ?></span>
            <div class="mb-3 mt-2" style="border-bottom: 2px solid black"></div>
        </div>
    </div>
    <div class="row jumbotron">
        <div class="col mx-3">
            <div class="row mb-2">
                <div class="col text-left px-0">
                    <h6>Escoge <?php echo $cantidadMakis ?> variedades de Maki</h6>
                </div>
            </div>


            <div class="row makisContainer">
                <?php foreach ($piecesMakis as $pieces) { ?>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                        <div class="card h-100 m-2 border-0 rounded">
                            <div class="card-body">
                                <?php for ($i = 0; $i <= count($pieces); $i++) {
                                    $ingrediente = $pieces[$i];
                                    if ($ingrediente['estado'] == 'ACTIVO') {
                                        ?>
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                <small>
                                                    <?php
                                                    echo $ingrediente['nombre'];
                                                    ?>

                                                </small>


                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <div class="input-group justify-content-center">
                                                    <div class="input-group-prepend input-group-append">
                                                        <button onclick="changeQtyMin0(this,'minus',0,<?php echo $maxCantidadMakis ?>)"
                                                                class="btn btn-light btn-sm"
                                                                type="button">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input
                                                                style="width: 60px;"
                                                                required
                                                                onkeypress="return solonumeros(event);"
                                                                type="number"
                                                                readonly
                                                                data-nombreIngrediente="<?php echo $ingrediente['nombre'] ?>"
                                                                minlength="1"
                                                                class="form-control text-center"
                                                                min="0" name="cantidad" value="0"
                                                                placeholder="Cantidad"
                                                                aria-label="Cantidad"
                                                                aria-describedby="button-addon2">
                                                        <button onclick="changeQtyMin0(this,'add',0,<?php echo $maxCantidadMakis ?>)"
                                                                type="button"
                                                                class="btn btn-sm btn-light">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                ?>
                            </div>
                        </div>


                    </div>
                <?php } ?>
            </div>


        </div>
    </div>
    <div class="row jumbotron">
        <div class="col mx-3">
            <div class="row mb-2">
                <div class="col text-left px-0">
                    <h6 class="mb-0">Escoge <?php echo $cantidadSashimis ?> cortes de sashimi o 1 sashimi moriawase</h6>
                    <small class="text-danger">(máximo 4 por variedad)</small>
                </div>
            </div>


            <div class="row sashimisContainer" id="sashimisContainer">
                <?php foreach ($piecesSashimi as $pieces) { ?>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                        <div class="card h-100 m-2 border-0 rounded">
                            <div class="card-body">
                                <?php for ($i = 0; $i <= count($pieces); $i++) {
                                    $ingrediente = $pieces[$i];
                                    if ($ingrediente['estado'] == 'ACTIVO') {
                                        ?>
                                        <div class="row mt-2">
                                            <div class="col-6">

                                                <small>
                                                    <?php
                                                    echo $ingrediente['nombre'];
                                                    ?>
                                                </small>

                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <div class="input-group justify-content-center">
                                                    <div class="input-group-prepend input-group-append">
                                                        <button onclick="changeQtyMin0(this,'minus',0,<?php echo $maxCantidadSashimis ?>)"
                                                                class="btn btn-light btn-sm"
                                                                type="button">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input
                                                                style="width: 60px;"
                                                                required
                                                                onkeypress="return solonumeros(event);"
                                                                type="number"
                                                                readonly
                                                                data-nombreIngrediente="<?php echo $ingrediente['nombre'] ?>"
                                                                minlength="1"
                                                                class="form-control text-center"
                                                                min="0" name="cantidad" value="0"
                                                                placeholder="Cantidad"
                                                                aria-label="Cantidad"
                                                                aria-describedby="button-addon2">
                                                        <button onclick="changeQtyMin0(this,'add',0,<?php echo $maxCantidadSashimis ?>)"
                                                                type="button"
                                                                class="btn btn-sm btn-light">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                ?>

                            </div>
                        </div>


                    </div>
                <?php } ?>
                <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                    <div class="card h-100 m-2 border-0 rounded">
                        <div class="card-body">

                            <div>
                                SASHIMI MORIAWASE<br><small class="text-info">(A elección del
                                    itamae)</small></div>
                            <div>
                                <div class="input-group justify-content-center input-group-ingredientes">
                                    <div class="text-center">
                                        <input class="mt-2" style="transform: scale(1.5);"
                                               id="moriawaseSashimis"
                                               type="checkbox"
                                               aria-describedby="button-addon2">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>
    </div>
    <div class="row jumbotron">
        <div class="col mx-3">
            <div class="row mb-2">
                <div class="col text-left px-0">
                    <h6 class="mb-0">Escoge <?php echo $cantidadSushis ?> cortes de sushi o 1 sushi moriawase</h6>
                    <small class="text-danger">(máximo 4 por variedad)</small>
                </div>
            </div>


            <div class="row sushisContainer" id="sushisContainer">
                <?php foreach ($piecesSushis as $pieces) { ?>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                        <div class="card h-100 m-2 border-0 rounded">
                            <div class="card-body">
                                <?php for ($i = 0; $i <= count($pieces); $i++) {
                                    $ingrediente = $pieces[$i];
                                    if ($ingrediente['estado'] == 'ACTIVO') {
                                        ?>
                                        <div class="row mt-2">
                                            <div class="col-6">

                                                <small>
                                                    <?php
                                                    echo $ingrediente['nombre'];
                                                    ?>
                                                </small>
                                                <select onchange="addFlambeado2(this)"
                                                        class="custom-select custom-select-sm bg-secondary text-white">
                                                    <option disabled selected>¿flambeado?</option>
                                                    <option value="salsa de ostión">salsa de ostión</option>
                                                    <option value="salsa parrillera">salsa parrillera</option>
                                                    <option value="parmesano con crema picante">parmesano con crema
                                                        picante
                                                    </option>
                                                </select>

                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <div class="input-group justify-content-center">
                                                    <div class="input-group-prepend input-group-append">
                                                        <button onclick="changeQtyMin0(this,'minus',0,<?php echo $maxCantidadSushis ?>)"
                                                                class="btn btn-light btn-sm"
                                                                type="button">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input
                                                                style="width: 60px;"
                                                                required
                                                                onkeypress="return solonumeros(event);"
                                                                type="number"
                                                                readonly
                                                                data-nombreIngrediente="<?php echo $ingrediente['nombre'] ?>"
                                                                data-flambeado=""
                                                                minlength="1"
                                                                class="form-control text-center cantidadSushis"
                                                                min="0" name="cantidad" value="0"
                                                                placeholder="Cantidad"
                                                                aria-label="Cantidad"
                                                                aria-describedby="button-addon2">
                                                        <button onclick="changeQtyMin0(this,'add',0,<?php echo $maxCantidadSushis ?>)"
                                                                type="button"
                                                                class="btn btn-sm btn-light">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                ?>

                            </div>
                        </div>


                    </div>
                <?php } ?>

                <?php foreach ($piecesGunkans as $pieces) { ?>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                        <div class="card h-100 m-2 border-0 rounded">
                            <div class="card-body">
                                <?php for ($i = 0; $i <= count($pieces); $i++) {
                                    $ingrediente = $pieces[$i];
                                    if ($ingrediente['estado'] == 'ACTIVO') {
                                        ?>
                                        <div class="row mt-2">
                                            <div class="col">

                                                <small>
                                                    <?php
                                                    echo $ingrediente['nombre'];
                                                    ?>
                                                </small>


                                            </div>
                                            <div class="col">
                                                <div class="input-group justify-content-center">
                                                    <div class="input-group-prepend input-group-append">
                                                        <button onclick="changeQtyMin0(this,'minus',0,<?php echo $maxCantidadSushis ?>)"
                                                                class="btn btn-light btn-sm"
                                                                type="button">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input
                                                                style="width: 60px;"
                                                                required
                                                                onkeypress="return solonumeros(event);"
                                                                type="number"
                                                                readonly
                                                                data-nombreIngrediente="<?php echo $ingrediente['nombre'] ?>"
                                                                minlength="1"
                                                                class="form-control text-center"
                                                                min="0" name="cantidad" value="0"
                                                                placeholder="Cantidad"
                                                                aria-label="Cantidad"
                                                                aria-describedby="button-addon2">
                                                        <button onclick="changeQtyMin0(this,'add',0,<?php echo $maxCantidadSushis ?>)"
                                                                type="button"
                                                                class="btn btn-sm btn-light">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                ?>

                            </div>
                        </div>


                    </div>
                <?php } ?>
                <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                    <div class="card h-100 m-2 border-0 rounded">
                        <div class="card-body">

                            <div>SUSHI MORIAWASE<br><small class="text-info">(A elección del
                                    itamae)</small></div>
                            <div>
                                <div class="input-group justify-content-center input-group-ingredientes"
                                     style="">
                                    <div class="text-center">
                                        <input class="mt-2" style="transform: scale(1.5);"
                                               id="sushiMoriawase"
                                               type="checkbox"
                                               aria-describedby="button-addon2">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>


        </div>
    </div>
    <div class="row jumbotron">
        <div class="col mx-3">
            <div class="row mb-2">
                <div class="col text-left px-0">
                    <h6 class="mb-0">Escoge <?php echo $cantidadPlatosCalientes ?> plato caliente</h6>

                </div>
            </div>


            <div class="row platosCalientesContainer" id="platosCalientesContainer">
                <?php foreach ($piecesPlatosCalientes as $pieces) { ?>
                    <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                        <div class="card h-100 m-2 border-0 rounded">
                            <div class="card-body">
                                <?php for ($i = 0; $i <= count($pieces); $i++) {
                                    $ingrediente = $pieces[$i];
                                    if ($ingrediente['estado'] == 'ACTIVO') {
                                        ?>
                                        <div class="row mt-2">
                                            <div class="col-6">

                                                <small>
                                                    <?php
                                                    echo $ingrediente['nombre'];
                                                    ?>
                                                </small>

                                            </div>
                                            <div class="col-6 d-flex align-items-center">
                                                <div class="input-group justify-content-center">
                                                    <div class="input-group-prepend input-group-append">
                                                        <button onclick="changeQtyMin0(this,'minus',0,<?php echo $maxCantidadPlatosCalientes ?>)"
                                                                class="btn btn-light btn-sm"
                                                                type="button">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <input
                                                                style="width: 60px;"
                                                                required
                                                                onkeypress="return solonumeros(event);"
                                                                type="number"
                                                                readonly
                                                                data-nombreIngrediente="<?php echo $ingrediente['nombre'] ?>"
                                                                minlength="1"
                                                                class="form-control text-center"
                                                                min="0" name="cantidad" value="0"
                                                                placeholder="Cantidad"
                                                                aria-label="Cantidad"
                                                                aria-describedby="button-addon2">
                                                        <button onclick="changeQtyMin0(this,'add',0,<?php echo $maxCantidadPlatosCalientes ?>)"
                                                                type="button"
                                                                class="btn btn-sm btn-light">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                }
                                ?>

                            </div>
                        </div>


                    </div>
                <?php } ?>

            </div>


        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <form action="script/cartAction.php" method="get" id="formComprar">
                <div class="row mt-2">
                    <div class="col text-center">

                        <input type="hidden" name="action" value="addToCart">
                        <input type="hidden" class="idProducto" name="id"
                               value="<?php echo $producto['idProducto'] ?>">

                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col">
                        <div class="text-center">

                            <div class="input-group mb-3 d-inline ">
                                <div class="input-group-prepend input-group-append m-auto" style="width: 300px">

                                    <input required
                                           type="hidden"
                                           class="form-control text-center cantidad"
                                           name="cantidad" value="1" placeholder="Cantidad"
                                           aria-label="Cantidad"
                                           aria-describedby="button-addon2">
                                </div>
                            </div>
                            <button
                                <?php echo ($producto['stock'] == 'NOT') ? 'disabled' : '' ?>
                                    type="submit" class="btn btn-danger btn-primary  btn-comprar">COMPRAR
                            </button>
                            <?php echo ($producto['stock'] == 'NOT') ? '<small class="text-danger d-block">Agotado</small>' : '' ?>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
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




<script>
    let categoria = 27;
</script>
<?php include 'templates/footer.php'; ?>
<script>
    const cantidadMakis = '<?php echo $cantidadMakis ?>';
    const cantidadShimis = '<?php echo $cantidadSashimis ?>';
    const cantidadSushis = '<?php echo $cantidadSushis ?>';
    const cantidadPlatosCalientes = '<?php echo $cantidadPlatosCalientes ?>';

    function addFlambeado2(dropDrown) {

        let inputCantidad = dropDrown.parentElement.parentElement.querySelector('.cantidadSushis');

        inputCantidad.setAttribute('data-flambeado', dropDrown.value);


    }

    $(document).ready(function () {

        $('#moriawaseSashimis').click(function () {
            if ($(this).prop("checked") == true) {
                $('#sashimisContainer').find('button').attr('disabled', 'disabled');
                $('#sashimisContainer').find('input[type=number]').val(0);
            } else if ($(this).prop("checked") == false) {
                $('#sashimisContainer').find('button').attr('disabled', false);

            }
        });

        $('#sushiMoriawase').click(function () {
            if ($(this).prop("checked") == true) {

                $('#sushisContainer').find('button').attr('disabled', 'disabled');
                $('#sushisContainer').find('input[type=number]').val(0);
            } else if ($(this).prop("checked") == false) {

                $('#sushisContainer').find('button').attr('disabled', false);

            }
        });
    });


    $('#formComprar').submit(function (event) {
        event.preventDefault();

        let infoSeleccionados = '';
        let totalSeleccionadoMaki = 0;


        /*
        * MAKIS
        * */
        $('.makisContainer input[type=number]').each(function () {
            let cantidad = ($(this).val() * 1);
            totalSeleccionadoMaki += cantidad;
            if (cantidad > 0) {
                infoSeleccionados = infoSeleccionados + $(this).attr("data-nombreIngrediente") + ` (X${cantidad})` + ', ';

            }
        });
        if (totalSeleccionadoMaki !== cantidadMakis * 1) {
            Swal.fire(
                'Puedes elegir como máximo ' + cantidadMakis + ' variedad de maki',
                '',
                'error'
            );
            infoSeleccionados = '';
            totalSeleccionadoMaki = 0;
            return false;
        }
        /*
        * END MAKIS
        * */
        /*
        * SASHIMIS
        * */
        if ($('#moriawaseSashimis').prop("checked") == true) {
            infoSeleccionados = infoSeleccionados + 'SASHIMI MORIAWASE' + ', ';

        } else {
            let totalSeleccionadoSashimi = 0;
            $('.sashimisContainer input[type=number]').each(function () {

                let cantidad = ($(this).val() * 1);
                totalSeleccionadoSashimi += cantidad;
                if (cantidad > 0) {
                    infoSeleccionados = infoSeleccionados + $(this).attr("data-nombreIngrediente") + ` (X${cantidad})` + ', ';
                }
            });

            if (totalSeleccionadoSashimi !== cantidadShimis * 1) {
                Swal.fire(
                    'Puedes elegir como máximo ' + cantidadShimis + ' variedades de sashimi o ' + cantidadShimis + ' sashimis de una misma variedad',
                    '',
                    'error'
                );
                infoSeleccionados = '';
                totalSeleccionadoSashimi = 0;
                return false;
            }

        }

        /*
                * END SASHIMIS
                * */

        /*
       * Sushis
       * */
        if ($('#sushiMoriawase').prop("checked") == true) {
            infoSeleccionados = infoSeleccionados + 'SUSHI MORIAWASE' + ', ';

        } else {
            let totalSeleccionadoSushis = 0;
            $('.sushisContainer input[type=number]').each(function () {

                let cantidad = ($(this).val() * 1);
                totalSeleccionadoSushis += cantidad;
                if (cantidad > 0) {

                    if (this.getAttribute('data-flambeado') !== null) {
                    if (this.getAttribute('data-flambeado').length > 1) {

                        infoSeleccionados = infoSeleccionados + $(this).attr("data-nombreIngrediente")
                            +
                            ' flambeado con ' + this.getAttribute('data-flambeado')
                            + ` (X${cantidad})` + ', ';
                    } else {

                        infoSeleccionados = infoSeleccionados + $(this).attr("data-nombreIngrediente") + ` (X${cantidad})` + ', ';

                    }
                    } else {
                        infoSeleccionados = infoSeleccionados + $(this).attr("data-nombreIngrediente") + ` (X${cantidad})` + ', ';

                    }
                }
            });

            if (totalSeleccionadoSushis !== cantidadSushis * 1) {

                Swal.fire(
                    'Puedes elegir como máximo ' + cantidadSushis + ' variedades de sushis o ' + cantidadSushis + ' sushis de una misma variedad',
                    '',
                    'error'
                );
                infoSeleccionados = '';
                totalSeleccionadoSushis = 0;
                return false;
            }

        }
        /*END SUSHIS*/

        /*PLATOS CALIENTES*/

        let platosCalientesContainer = 0;
        $('.platosCalientesContainer input[type=number]').each(function () {

            let cantidad = ($(this).val() * 1);
            platosCalientesContainer += cantidad;
            if (cantidad > 0) {
                infoSeleccionados = infoSeleccionados + $(this).attr("data-nombreIngrediente") + ` (X${cantidad})` + ', ';
            }
        });

        if (platosCalientesContainer !== cantidadPlatosCalientes * 1) {
            Swal.fire(
                'Puedes elegir ' + cantidadPlatosCalientes + ' plato caliente',
                '',
                'error'
            );
            infoSeleccionados = '';
            platosCalientesContainer = 0;
            return false;
        }

        /*END CALIENTES*/

        let formulario = this;
        let id = formulario.querySelector('.idProducto').value;
        let button = formulario.querySelector('.btn-comprar');
        let cantidad = formulario.querySelector('.cantidad').value;


        let data = new FormData();
        button.disabled = true;

        data.append('id', id);
        data.append('cantidad', cantidad);
        data.append('action', 'addToCart');

        data.append('productoIngredientes', infoSeleccionados);


        fetch('script/cartAction.php', {
            method: 'POST',
            body: data
        }).then(function (response) {
            if (response.ok) {
                return response.text();
            } else {
                alert("Error de conexión, verifica si tu dispositivo esta conectado a internet");
                window.location.reload();
            }
        }).then(function () {
            $('#exampleModal').modal('show');
            button.disabled = false;

        }).catch(function () {
            alert("Error de conexión, verifica si tu dispositivo esta conectado a internet");
        });
    })
</script>

</body>
</html>
