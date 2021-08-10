<?php
session_start();
$page = 'carta';
include 'class/ProductoClass.php';
include 'class/Producto_ingrediente.php';
$objProducto = new ProductoClass();
$objProductoIngrediente = new Producto_ingrediente();

$producto = $objProducto->getProductoById(268);
$ingredientes = $objProductoIngrediente->getIngredientesByIdProducto(268);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Senshi Sushi/Bar-Reparto</title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">
    <link rel="stylesheet" href="css/paquetes.css">
</head>

<body>
    <?php include 'templates/navbar.php'; ?>

    <div class="container" style="margin-top:95px">

        <div class="row ">
            <div class="col text-center">
                <h5 class="my-4">COMIENZA TU ORDEN AQUÍ</h5>
                <h6 class="text-danger font-weight-bolder mb-5">CATEGORIAS</h6>
            </div>
        </div>
    </div>
    <?php include 'templates/categoryBar.php' ?>
    <div class="container">
        <div class="row mt-3">
            <div class="col mx-0 mx-md-5">
                <h5 class="mb-2"><?php echo $producto['nombreProducto'] ?></h5>
                <div class="mb-3" style="border-bottom: 2px solid black"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">

                <div class="row m-0 p-0">
                    <div class="col-12 m-0 p-0">
                        <form action="script/cartAction.php" method="get" id="formComprar" class="mx-2">

                            <div class="row mt-2">
                                <div class="col text-center">
                                    <input type="hidden" name="action" value="addToCart">
                                    <input type="hidden" name="id" class="idProducto" value="<?php echo $producto['idProducto'] ?>">
                                </div>
                            </div>


                            <div class="row jumbotron">
                                <div class="col mx-3">
                                    <div class="row mb-2">
                                        <div class="col text-left px-0">
                                            <h6>Escoge 2 variedades de Maki</h6>

                                        </div>
                                    </div>


                                    <div class="row makisContainer">
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                                            <div class="card h-100 m-2 border-0 rounded">
                                                <div class="card-body">
                                                    <?php for ($i = 0; $i < 7; $i++) {
                                                        $ingrediente = $ingredientes[$i];
                                                        if ($ingrediente['estado'] == 'ACTIVO') {
                                                    ?>
                                                            <div class="row mt-2">
                                                                <div class="col">

                                                                    <small>
                                                                        <?php echo $ingrediente['nombre'] ?>

                                                                    </small>


                                                                </div>
                                                                <div class="col">
                                                                    <div class="input-group justify-content-center">
                                                                        <div class="input-group-prepend input-group-append">
                                                                            <button onclick="changeQtyMin0(this,'minus',0,2)" class="btn btn-light btn-sm" type="button">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>
                                                                            <input required onkeypress="return solonumeros(event);" type="number" readonly data-nombreIngrediente="<?php echo $ingrediente['nombre'] ?>" minlength="1" class="form-control text-center" min="0" name="cantidad" value="0" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="button-addon2">
                                                                            <button onclick="changeQtyMin0(this,'add',0,2)" type="button" class="btn btn-sm btn-light">
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
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                                            <div class="card h-100 m-2 border-0 rounded">
                                                <div class="card-body">
                                                    <?php for ($i = 7; $i < 14; $i++) {
                                                        $ingrediente = $ingredientes[$i];
                                                        if ($ingrediente['estado'] == 'ACTIVO') {
                                                    ?>
                                                            <div class="row mt-2">
                                                                <div class="col">
                                                                    <small>
                                                                        <?php echo $ingrediente['nombre'] ?>
                                                                    </small>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="input-group justify-content-center">
                                                                        <div class="input-group-prepend input-group-append">
                                                                            <button onclick="changeQtyMin0(this,'minus',0,2)" class="btn btn-sm btn-light" type="button">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>
                                                                            <input required onkeypress="return solonumeros(event);" type="number" readonly data-nombreIngrediente="<?php echo $ingrediente['nombre'] ?>" minlength="1" class="form-control text-center" min="0" name="cantidad" value="0" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="button-addon2">
                                                                            <button onclick="changeQtyMin0(this,'add',0,2)" type="button" class="btn btn-sm btn-light">
                                                                                <i class="fas fa-plus"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    <?php }
                                                    }
                                                    ?>
                                                    <div class="row mt-2">
                                                        <div class="col"><small>YAKUZA MAKI</small></div>
                                                        <div class="col">
                                                            <div class="input-group justify-content-center">
                                                                <div class="input-group-prepend input-group-append">
                                                                    <button onclick="changeQtyMin0(this,'minus',0,2)" class="btn btn-sm btn-light" type="button">
                                                                        <i class="fas fa-minus"></i>
                                                                    </button>
                                                                    <input required onkeypress="return solonumeros(event);" type="number" readonly data-nombreIngrediente="YAKUZA MAKI" minlength="1" class="form-control text-center" min="0" name="cantidad" value="0" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="button-addon2">
                                                                    <button onclick="changeQtyMin0(this,'add',0,2)" type="button" class="btn btn-sm btn-light">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-12 col-lg-4 col-xl-4 mx-0 px-0 mb-3">
                                            <div class="card h-100 m-2 border-0 rounded">
                                                <div class="card-body">
                                                    <?php for ($i = 14; $i < 22; $i++) {
                                                        $ingrediente = $ingredientes[$i];
                                                        if ($ingrediente['estado'] == 'ACTIVO') {
                                                    ?>
                                                            <div class="row mt-2">
                                                                <div class="col"><small><?php echo $ingrediente['nombre'] ?></small></div>
                                                                <div class="col">
                                                                    <div class="input-group justify-content-center">
                                                                        <div class="input-group-prepend input-group-append">
                                                                            <button onclick="changeQtyMin0(this,'minus',0,2)" class="btn btn-sm btn-light" type="button">
                                                                                <i class="fas fa-minus"></i>
                                                                            </button>
                                                                            <input required onkeypress="return solonumeros(event);" type="number" readonly data-nombreIngrediente="<?php echo $ingrediente['nombre'] ?>" minlength="1" class="form-control text-center" min="0" name="cantidad" value="0" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="button-addon2">
                                                                            <button onclick="changeQtyMin0(this,'add',0,2)" type="button" class="btn btn-sm btn-light">
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
                                    </div>


                                    <div class="row justify-content-center">
                                        <div class="col-8 col-sm-8 col-md-6 col-xl-3 col-lg-3">
                                            <div class="text-center">

                                                <div class="input-group mb-3 d-inline ">
                                                    <div class="input-group-prepend input-group-append">

                                                        <input required type="hidden" minlength="1" class="form-control btn-comprar text-center cantidad" min="1" name="cantidad" value="1" placeholder="Cantidad" aria-label="Cantidad" aria-describedby="button-addon2">

                                                    </div>
                                                </div>
                                                <button <?php echo ($producto['stock'] == 'NOT') ? 'disabled' : '' ?> type="submit" class="btn btn-danger mt-2">
                                                    COMPRAR
                                                </button>
                                                <?php echo ($producto['stock'] == 'NOT') ? '<small class="text-danger d-block">Agotado</small>' : '' ?>

                                            </div>

                                        </div>
                                    </div>


                                </div>
                            </div>

                        </form>
                    </div>
                </div>


            </div>
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




    <script>
        let categoria = 27;
    </script>
    <?php include 'templates/footer.php'; ?>
    <script>
        $('#formComprar').submit(function(event) {
            event.preventDefault();
            let infoSeleccionados = '';
            let totalSeleccionado = 0;
            $('.makisContainer input[type=number]').each(function() {
                let cantidad = ($(this).val() * 1);
                totalSeleccionado += cantidad;
                if (cantidad > 0) {
                    infoSeleccionados = infoSeleccionados + $(this).attr("data-nombreIngrediente") + ` (X${cantidad})` + ', ';

                }
            });
            if (totalSeleccionado !== 2) {
                Swal.fire(
                    'Puedes elegir como máximo 2 variedades de maki o 2 makis de una misma variedad',
                    '',
                    'error'
                );
                infoSeleccionados = '';
                totalSeleccionado = 0;
                return false;
            }

            /* let campo = '<input type="hidden"   name="productoIngredientes" value="' + infoSeleccionados + '" />';
             $(this).append(campo);*/
            // AGREGANDO EL FETCH PARA AGREGAR AL CARRITO 18062020
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


        })
    </script>
</body>

</html>