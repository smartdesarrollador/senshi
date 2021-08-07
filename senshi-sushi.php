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
require 'class/Producto_ingrediente.php';
require 'class/ProductoClass.php';
require 'class/TiendaClass.php';

$objProductoIngrediente = new Producto_ingrediente();
$objTienda = new TiendaClass();
$objProducto = new ProductoClass();
$idProducto = trim($_GET['tipo']);
$lista = $objProducto->getTipoProductos($idProducto);
$categoria = $objProducto->getTipoProductoById($idProducto);
$listaIngredientes = $objProductoIngrediente->getAllIngredientes();
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
                <h3 class="piqueos mt-5 mb-3 text-uppercase"><?php echo $nombreCategoria ?></h3>
                <hr>

            </div>
        </div>

        <?php
        foreach ($lista as $campo) {
            if (strlen($campo['productoVariacion']) > 0) {
                if ($campo['stock'] == 'NOT') {
                } else {
                    $uniqueId = uniqid();
        ?>
                    <form data-maxChecked='<?php echo $campo['productoObservaciones'] ?>' action="script/cartAction.php" method="get" class="formCard">
                        <div class="row pt-2 pb-3 py-md-4">
                            <div class="col-12 col-md-6 col-lg-4 col-xl-4 d-flex justify-content-center align-items-center">
                                <div class="text-center">
                                    <input type="hidden" name="action" value="addToCart">
                                    <input class="idProducto" type="hidden" name="id" value="<?php echo $campo['idProducto'] ?>">

                                    <input class="productoVariacion" type="hidden" name="productoVariacion" value="<?php echo $campo['productoVariacion'] ?>">


                                    <h5 class="text-danger"><?php echo $campo['nombreProducto'] ?></h5>
                                    <p><?php echo $campo['descripcionProducto'] ?></p>
                                </div>

                            </div>
                            <div class="col-12 col-md-6 col-lg-2 col-xl-2 d-flex align-items-center">
                                <img data-zoomable="true" src="img/carta/platos/<?php echo $campo['imagenProducto'] ?>" class="img-fluid" alt="">

                            </div>
                            <div class="col-12 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center">
                                <span class="my-2">
                                    S/. <?php echo $campo['precioProducto'] ?>.00
                                    <?php if ($campo['productoObservaciones'] == 'SUSHI_SIN_FLAMBEADO') { ?>
                                    <?php } else { ?>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input chkMostrarIngredientes " id="<?php echo $uniqueId ?>">
                                            <label class="custom-control-label " for="<?php echo $uniqueId ?>">Flambeado Adicional (+ S/.2)</label>
                                        </div>
                                    <?php } ?>
                                    <div class="row my-2 ingredientesContainer">
                                        <div class="col text-left animated fadeIn">

                                            <?php foreach ($listaIngredientes as $ingrediente) {

                                                if ($ingrediente['idProducto'] == $campo['idProducto']) {
                                                    $uniqueIdIng = uniqid();
                                            ?>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" id="<?php echo $uniqueIdIng ?>" name="radioIngrediente" value="<?php echo $ingrediente['nombre'] ?>" class="custom-control-input">
                                                        <label class="custom-control-label" for="<?php echo $uniqueIdIng ?>"><?php echo $ingrediente['nombre'] ?></label>
                                                    </div>
                                            <?php
                                                }
                                            } ?>
                                        </div>
                                    </div>
                                </span>

                            </div>

                            <div class="col-12 col-md-6 col-lg-3 col-xl-3 d-flex align-items-center">
                                <div class="text-center my-3" style="width: 100%;">
                                    <div class="input-group mb-3 justify-content-center">
                                        <div class="input-group-prepend input-group-append">
                                            <button onclick="changeQty(this,'minus')" class="btn btn-sm" type="button">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                            <input style="width: 80px" required onkeypress="return solonumeros(event);" type="number" minlength="1" class="form-control text-center cantidad" min="1" name="cantidad" value="1" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="button-addon2">
                                            <button onclick="changeQty(this,'add')" type="button" class="btn btn-sm">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <button <?php /* echo ($campo['stock'] == 'NOT') ? 'disabled' : '' */ ?> class="btn btn-sm btn-danger btn-comprar" style="font-size:1.3rem;font-weight:bold" type="submit">
                                        <i class="fas fa-shopping-cart mr-1"></i>Comprar
                                    </button>
                                    <?php /* echo ($campo['stock'] == 'NOT') ? '<small class="text-danger d-block">Agotado</small>' : '' */ ?>
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

        <?php }
            }
        } ?>

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
    <script>
        function checkboxlimit(checkgroup, limit) {
            for (var i = 0; i < checkgroup.length; i++) {

                let checkedcount = 0;
                for (let i = 0; i < checkgroup.length; i++)
                    checkedcount += (checkgroup[i].checked) ? 1 : 0;

                if (checkedcount !== limit) {
                    alert("En este paquete puedes elegir " + limit + " makis.");
                    return false;
                    /* this.checked = false*/
                }
                return true;


            }
        }

        $(document).ready(function() {
            $('.ingredientesContainer').hide();

            $('.chkMostrarIngredientes').change(function() {

                let checkboxIngredientes = $(this);

                let ingredienteSeleccionado = checkboxIngredientes.parent().parent()[0];
                ingredienteSeleccionado = ingredienteSeleccionado.querySelector('.ingredientesContainer');


                if (checkboxIngredientes.is(':checked')) {
                    ingredienteSeleccionado.querySelector('.custom-control-input').setAttribute("required", "required");
                    ingredienteSeleccionado.style.display = null;

                } else {
                    ingredienteSeleccionado.querySelector('.custom-control-input').removeAttribute("required");
                    ingredienteSeleccionado.style.display = 'none';


                }
            });


            $('.formCard').submit(function(event) {
                event.preventDefault();

                let formulario = this;
                let chkIngredientes = formulario.querySelector('.ingredientesContainer input[name="radioIngrediente"]:checked');


                /* let campo = '<input type="hidden"   name="productoIngredientes" value="Flambeado con ' + ingredientes + ', " />';

                 let adicional = '<input type="hidden"   name="adicional" value="2' + ingredientes + ', " />';*/


                /* $(this).append(campo);
                 $(this).append(adicional);*/


                // AGREGANDO EL FETCH PARA AGREGAR AL CARRITO 18062020
                let id = formulario.querySelector('.idProducto').value;
                let productoVariacion = formulario.querySelector('.productoVariacion').value;
                let button = formulario.querySelector('.btn-comprar');
                let cantidad = formulario.querySelector('.cantidad').value;


                let data = new FormData();
                button.disabled = true;


                data.append('cantidad', cantidad);
                data.append('action', 'addToCart');
                if (chkIngredientes) {
                    data.append('id', productoVariacion);
                    let ingredientes = chkIngredientes.value;
                    data.append('productoIngredientes', "Flambeado con " + ingredientes + ", ");
                    data.append('adicional', '0');

                } else {
                    data.append('id', id);
                }

                fetch('script/cartAction.php', {
                    method: 'POST',
                    body: data
                }).then(function(response) {
                    if (response.ok) {
                        return response.text();
                    } else {
                        alert("Error de conexión, verifica si tu dispositivo esta conectado a internet");
                        window.location.reload();
                    }
                }).then(function(response) {
                    $('#exampleModal').modal('show');
                    button.disabled = false;

                }).catch(function(error) {
                    alert("Error de conexión, verifica si tu dispositivo esta conectado a internet");
                });

            });

        });


        mybutton = document.getElementById("myBtn");

        // When the user scrolls down 20px from the top of the document, show the button
        window.onscroll = function() {
            scrollFunction()
        };

        function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                mybutton.style.display = "block";
            } else {
                mybutton.style.display = "none";

            }
        }

        // When the user clicks on the button, scroll to the top of the document
        function topFunction() {
            document.body.scrollTop = 0; // For Safari
            document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
        }
    </script>
</body>

</html>