<?php
include 'class/Cart.php';
error_reporting(0);
$cart = new Cart;
$page = 'carrito';
$cartItems = $cart->contents();
require 'class/TiendaClass.php';
require 'class/ProductoClass.php';
$objTienda = new TiendaClass();
$objProducto = new ProductoClass();
$estadoTienda = trim($objTienda->getEstadoTienda()['estado']);
$costoEnvio = trim($objTienda->getCostoEnvio()['costoDelivery']);

/*DESCUENTO POR PUNTOS*/
$descuento = false;
if ($_SESSION['current_customer_puntos'] >= 200) {
    $descuento = true;
}

$totalAPagar = $cart->total();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Senshi Sushi/Bar - Carrito de compras</title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">
    <script src="js/moment.min.js"></script>
    <style>
        .cart-image {
            width: 150px;
        }
    </style>
</head>

<body>
    <?php include 'templates/navbar.php'; ?>


    <div class="container " style="margin-top: 100px">
        <div class="row">
            <div class="col ">
                <h6 class="text-center font-weight-bold text-danger">Nuestro horario de atención es de martes a sábados de
                    12 a 3:30 pm y de 6 pm a 10 pm
                    / domingos de 12 pm a 4 pm.</h6>
                <h6 class="text-center font-weight-bold text-danger">Haz tu pedido para recojo en tienda y
                    lo recoges de 30 a 60 minutos aproximadamente. Consultar el tiempo exacto de espera por
                    whatsapp.</h6>

                <h6 class="text-center font-weight-bolder text-danger">Los pedidos realizados los lunes serán entregados
                    al día siguiente.</h6>


            </div>
        </div>
    </div>

    <div class="container mt-4 mb-5 ">

        <h5 class="">CARRITO DE COMPRAS</h5>
        <div class="mb-3" style="border-bottom: 2px solid black"></div>
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-xl-9 col-lg-9">
                <?php
                $subtotal = 0;
                $puntosAacumular = 0;
                if (count($cartItems) > 0) {

                ?>
                    <?php
                    $totalPaqutes = 0;
                    foreach ($cartItems as $itemCarrito) {
                        $subtotal = $subtotal + $itemCarrito['subtotal'];
                        $puntosAacumular = $puntosAacumular + $itemCarrito['subtotalPuntos'];

                        if (
                            $itemCarrito['productoObservaciones'] == 'MULTI_PAQUETE1'
                            || $itemCarrito['productoObservaciones'] == 'MULTI_PAQUETE2'
                            || $itemCarrito['productoObservaciones'] == 'MULTI_PAQUETE3'
                            || $itemCarrito['productoObservaciones'] == 'MULTI_PAQUETE4'
                        ) {
                            $totalPaqutes = $totalPaqutes + $itemCarrito['qty'];
                        }

                    ?>
                        <div class="row mt-3">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center">
                                <img class="cart-image" src="img/carta/platos/<?php echo $itemCarrito['imagenProducto'] ?>" alt="">
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 d-flex justify-content-center align-items-center text-center">
                                <div>
                                    <h6 class=""><?php echo $itemCarrito['name'] ?></h6>
                                    <!--<small class="text-lowercase d-block text-muted"></small>-->
                                    <small class="text-lowercase d-block text-muted"><?php echo substr($itemCarrito['productoIngredientes'], 0, -2) ?></small>
                                    <?php
                                    if (strlen($itemCarrito['emailGift']) > 0) {
                                    ?>
                                        <small class="font-italic">Para: <?php echo $itemCarrito['emailGift']; ?></small>
                                        <br>
                                    <?php
                                    }
                                    ?>
                                    <?php
                                    if (strlen($itemCarrito['dedicatoriaGift']) > 0) {
                                    ?>
                                        <small class="font-italic">Dedicatoria: <?php echo $itemCarrito['dedicatoriaGift'] ?></small>
                                        <br>
                                    <?php
                                    }
                                    ?>
                                </div>

                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3 text-center d-flex justify-content-center align-items-center">
                                <div>

                                    <h6>Cantidad:</h6>
                                    <a onclick="mostrarLoading()" href="script/cartAction.php?action=updateCartItem&id=<?php echo $itemCarrito['rowid']; ?>&qty=<?php echo $itemCarrito['qty'] - 1; ?>" class="btn btn-sm text-danger d-block d-lg-inline"><i class="fas fa-minus"></i></a>
                                    <?php echo $itemCarrito['qty']; ?>
                                    <a onclick="mostrarLoading()" href="script/cartAction.php?action=updateCartItem&id=<?php echo $itemCarrito['rowid']; ?>&qty=<?php echo $itemCarrito['qty'] + 1; ?>" class="btn btn-sm text-danger d-block d-lg-inline"><i class="fas fa-plus"></i></a>


                                </div>


                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-2 col-xl-2 text-center d-flex justify-content-center align-items-center">
                                <div>
                                    <h6 class="">SubTotal</h6>
                                    <h6 class="">S/ <?php echo $itemCarrito['subtotal']; ?>.00</h6>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-1 col-xl-1 text-center d-flex justify-content-center align-items-center">
                                <div>
                                    <a onclick="mostrarLoading();" href="script/cartAction.php?action=removeCartItem&id=<?php echo $itemCarrito['rowid']; ?>" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash-alt" aria-hidden="true"></i></a>
                                </div>
                            </div>

                        </div>
                        <hr>
                    <?php } ?>
                    <div class="row">
                        <div class="col text-center">
                            <?php
                            if ($_SESSION['envio'] == 'recojo') {
                                if ($totalPaqutes > 0) {
                                    if ($totalPaqutes <= 2) {
                            ?>
                                        <h5 class="text-danger">Tu tiempo de espera para recoger tu pedido es de 1
                                            hora
                                        </h5>

                                    <?php
                                    } else {
                                    ?>
                                        <h5 class="text-danger">Tu tiempo de espera para recoger tu pedido es de 1
                                            hora y
                                            media
                                        </h5>

                            <?php
                                    }
                                }
                            }
                            ?>


                        </div>
                    </div>
                    <div class="mb-3 mt-3" style="border-bottom: 2px solid black"></div>
                    <div class="row">
                        <div class="col-md-6" style="margin-top: 15px;margin-bottom: 15px">
                            <a href="script/cartAction.php?action=destroyCart" class="btn btn-dark">Limpiar
                                Carrito</a>
                            <a href="carta.php" class="btn btn-dark">Volver a la carta</a>
                        </div>


                    </div>
                <?php } else { ?>
                    <div class="row">

                        <div class="col col-12 text-center mt-4">
                            <i style="font-size: 100px;color: #ccc" class="fas fa-shopping-cart"></i>
                            <h5 class="py-3">Tu carrito está vacío</h5>
                            <a href="carta.php" class="btn btn-danger mb-2">IR A COMPRAR<i class="fas fa-shopping-cart mx-3"></i></a>
                        </div>
                    </div>
                <?php } ?>

            </div>
            <div class="col-12 col-sm-12 col-md-12 col-xl-3 col-lg-3">
                <div class="panel panel-default  position-sticky " style="top: 100px">
                    <div>
                        <h5>Resumen de Orden</h5>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col">
                                <span>SUBTOTAL</span>
                            </div>
                            <div class="col text-right">
                                <span>S/. <?php echo $subtotal; ?></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12" style="color: #c08a31">
                                <?php
                                if ($descuento) {

                                ?>
                                    <strong>¡Felicidades! tienes 200 puntos, te enviaremos medio maki adicional a tu
                                        pedido.</strong>
                                <?php
                                }
                                ?>
                            </div>
                        </div>

                        <hr>
                        <div class="row">
                            <?php
                            if ($_SESSION['solo_gift_cards'] == 'false') {
                                if ($_SESSION['envio'] == 'recojo') {
                            ?>
                                    <div class="col ">
                                        <h6 class=" d-inline">Recojo en tienda seleccionado</h6>
                                        <div class="pull-right" style="float: right"><a href="#" data-toggle="modal" data-target="#exampleModal" class="text-danger font-weight-bolder">Cambiar
                                                <i class="far fa-edit"></i></a>
                                        </div>
                                    </div>
                                    <hr>
                                <?php
                                } else {
                                ?>
                                    <div class="col ">
                                        <h6 class=" d-inline">Envío a domicilio seleccionado.</h6>
                                        <div class="pull-right" style="float: right"><a href="#" data-toggle="modal" data-target="#exampleModal" class="text-danger font-weight-bolder">Cambiar
                                                <i class="far fa-edit"></i></a>
                                        </div>
                                    </div>
                                    <hr>
                            <?php
                                }
                            }
                            ?>
                        </div>

                        <div class="row">
                            <div class="col">
                                <hr>
                                <strong>Total</strong>
                                <div class="pull-right" style="float: right">
                                    <span>S/.</span><span><?php echo $totalAPagar; ?></span>
                                </div>
                                <hr>


                            </div>
                        </div>

                        <div class="row">
                            <div class="col text-center">
                                <strong class="text-danger">Acumulas <?php echo $puntosAacumular ?>
                                    puntos</strong>
                                <hr>
                            </div>
                        </div>
                        <?php if ($estadoTienda == 'CERRADO') { ?>
                            <button type="button" disabled class="btn btn-primary btn-lg btn-block">Fuera del horario de atención <i class="fa fa-clock-o" aria-hidden="true"></i></button>

                        <?php } elseif ($subtotal < 24) { ?>
                            <strong class="text-danger">El monto mínimo de compra es 24 soles</strong>
                            <button type="button" disabled class="btn btn-danger btn-lg btn-block">Continuar <i class="fas fa-arrow-right"></i>
                            </button>

                        <?php } elseif (!isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) { ?>

                            <a href="#" role="button" data-target="#login-modal" data-toggle="modal" class="btn btn-danger btn-lg btn-block">Continuar <i class="fas fa-arrow-right"></i></a>
                        <?php } elseif (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {
                        ?>
                            <a href="verificardireccion.php" class="btn btn-danger btn-lg btn-block">Continuar <i class="fas fa-arrow-right"></i></a>
                        <?php
                        } ?>


                    </div>
                </div>
            </div>


        </div>

    </div>
    <!--MODAL DESPUES DE LAS 7-->
    <div class="modal fade" id="modalDespuesDeLas7" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger font-weight-bolder" id="exampleModalLabel"><i class="fas fa-info"></i> ATENCIÓN</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Estas ingresando tu pedido fuera de nuestro horario de atención.
                        Tu pedido será despachado el dia <strong id="twoDaysAfter"></strong>
                    </p>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">OK, entiendo</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col text-center">
                            <img width="120" src="icon/entrega.png" alt="Entrega a Domicilio Senshi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h3 class="text-center">Irashiai (Bienvenido) a Senshi</h3>

                            <!-- <p class="text-center">Nuestro horario de atención es de martes a sábados de 12 pm a 3:30 pm y de
                                6 pm a 10 pm
                                / domingos de 12 pm a 4 pm.</p>
                            <p class="text-center">Haz tu pedido para recojo en tienda y
                                lo recoges de 30 a 60 minutos aproximadamente. Consultar el tiempo exacto de espera por
                                whatsapp.</p>
                            <p class="text-center">Los pedidos
                                realizados de Lunes a Jueves se atienden en el mismo día,
                                los dias viernes y sábados se programa el pedido con un dia de anticipación.</p> -->

                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col text-center">
                            <h4>Elige una opción</h4>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col text-center">
                            <button class="btn btn-outline-danger btnRecojoEnTienda" onclick="cambiarmetodoDeEntrega(this)">Recojo
                                en tienda
                            </button>
                        </div>
                        <div class="col text-center">
                            <button class="btn btn-outline-danger btnDelivery" onclick="cambiarmetodoDeEntrega(this)">
                                Reparto a
                                domicilio
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


    <?php
    $url = $_SERVER['REQUEST_URI'];
    ?>
    <?php if ($_SESSION['local'] == 'lince' && $_SESSION['contador_local'] == 'con_distrito') { ?>
        <div class="modal fade" id="exampleModalcambio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row">
                            <div class="col text-center">
                                <img width="120" src="icon/entrega.png" alt="Entrega a Domicilio Senshi">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Irashiai (Bienvenido) a Senshi</h3>

                                <!-- <p class="text-center">Nuestro horario de atención es de martes a sábados de 12 pm a 3:30 pm y de
                                    6 pm a 10 pm
                                    / domingos de 12 pm a 4 pm.</p>
                                <p class="text-center">Haz tu pedido para recojo en tienda y
                                    lo recoges de 30 a 60 minutos aproximadamente. Consultar el tiempo exacto de espera por
                                    whatsapp.</p>
                                <p class="text-center">Los pedidos
                                    realizados de Lunes a Jueves se atienden en el mismo día,
                                    los dias viernes y sábados se programa el pedido con un dia de anticipación.</p> -->

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col text-center">
                                <h4>Elige una opción</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col text-center">
                                <button class="btn btn-outline-danger btnRecojoEnTienda" onclick="cambiarmetodoDeEntrega(this)">Recojo
                                    en tienda
                                </button>
                            </div>
                            <div class="col text-center">
                                <button class="btn btn-outline-danger btnDelivery" onclick="cambiarmetodoDeEntrega(this)">
                                    Reparto a
                                    domicilio
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    <?php } elseif ($_SESSION['local'] == 'san_borja' && $_SESSION['contador_local'] == 'con_distrito') { ?>
        <div class="modal fade" id="exampleModalcambio" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="row">
                            <div class="col text-center">
                                <img width="120" src="icon/entrega.png" alt="Entrega a Domicilio Senshi">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <h3 class="text-center">Irashiai (Bienvenido) a Senshi</h3>

                                <!--   <p class="text-center">Nuestro horario de atención es de martes a sábados de 12 pm a 3:30 pm y de
                                    6 pm a 10 pm
                                    / domingos de 12 pm a 4 pm.</p>
                                <p class="text-center">Haz tu pedido para recojo en tienda y
                                    lo recoges de 30 a 60 minutos aproximadamente. Consultar el tiempo exacto de espera por
                                    whatsapp.</p>
                                <p class="text-center">Los pedidos
                                    realizados de Lunes a Jueves se atienden en el mismo día,
                                    los dias viernes y sábados se programa el pedido con un dia de anticipación.</p> -->

                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col text-center">
                                <h4>Elige una opción</h4>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col text-center">
                                <button class="btn btn-outline-danger btnRecojoEnTienda" onclick="cambiarmetodoDeEntrega(this)">Recojo
                                    en tienda
                                </button>
                            </div>
                            <div class="col text-center">
                                <button class="btn btn-outline-danger btnDelivery" onclick="cambiarmetodoDeEntrega(this)">
                                    Reparto a
                                    domicilio
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>


    <?php } elseif ($_SESSION['contador_local'] == 'sin_distrito') { ?>

        <div class="modal fade" id="modalHoraDescanso" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-danger font-weight-bolder" id="exampleModalLabel"><i class="fas fa-info"></i></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-2">
                            <img src="icon/icono-reloj.png" style="width: 70px" alt="">
                        </div>
                        <p>
                            Estimado cliente, en estos momentos nuestro local se encuentra cerrado, atenderemos su pedido a las
                            5:30 PM
                        </p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">OK, entiendo</button>
                    </div>
                </div>
            </div>
        </div>

    <?php } else { ?>
        <div class="modal fade" id="exampleModalLocal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
















    <?php include 'templates/footer.php'; ?>
    <script>
        $(document).ready(function() {

            /*console.log(moment().add(1, 'days').format('DD/MM/YYYY'));*/


            let beginningTime = moment('10:00pm', 'h:mma');
            let beginningTimeDomingo = moment('5:00pm', 'h:mma');
            let actualTime = moment();
            let diaActual = moment().isoWeekday() * 1;
            let diasAAgregar = 0;

            if (diaActual === 1) {
                if (actualTime.isAfter(beginningTime)) {
                    diasAAgregar = 1;
                }
            }
            if (diaActual === 2) {
                if (actualTime.isAfter(beginningTime)) {
                    diasAAgregar = 1;
                }
            }
            if (diaActual === 3) {
                if (actualTime.isAfter(beginningTime)) {
                    diasAAgregar = 1;
                }
            }
            if (diaActual === 4) {
                if (actualTime.isAfter(beginningTime)) {
                    diasAAgregar = 1;
                }
            }
            if (diaActual === 5) {
                if (actualTime.isAfter(beginningTime)) {
                    diasAAgregar = 1;
                }
            }
            if (diaActual === 6) {
                if (actualTime.isAfter(beginningTime)) {
                    diasAAgregar = 1;
                }
            }
            if (diaActual === 7) {
                diasAAgregar = 2;
            }

            let fechaDeEnvio = moment().add(diasAAgregar, 'days').format('DD/MM/YYYY');


            document.getElementById('twoDaysAfter').innerText = fechaDeEnvio;

            if (actualTime.isAfter(beginningTime)) {
                $('#modalDespuesDeLas7').modal('show');
            }


            /*HORA DE DESCANSO*/

            const inicioHoraDescanso = moment('4:00pm', 'h:mma')
            const finHoraDescanso = moment('5:30pm', 'h:mma')

            if (actualTime.isAfter(inicioHoraDescanso) && actualTime.isBefore(finHoraDescanso) && diaActual !== 1) {
                $('#modalHoraDescanso').modal('show');
            }


        });

        function mostrarModalHoraDescanso() {

        }

        function cambiarmetodoDeEntrega(element) {
            let elemento = element;
            elemento.disabled = true;
            elemento.insertAdjacentHTML('beforeend', '<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>\n' +
                '<span class="sr-only">Loading...</span>');
            let data = new FormData();
            if (elemento.classList.contains('btnRecojoEnTienda')) {
                data.append('code', 'recojo');
            }
            if (elemento.classList.contains('btnDelivery')) {
                data.append('code', 'reparto');
            }
            fetch('utils/cambiarMetodoDeEnvio.php', {
                method: 'POST',
                body: data
            }).then(function(response) {
                if (response.ok) {
                    return response.text();
                } else {
                    alert("Error de conexión, verifica si tu dispositivo esta conectado a internet");
                    window.location.reload();
                }
            }).then(function() {
                window.location.reload();
            }).catch(function(error) {
                alert("Error de conexión, verifica si tu dispositivo esta conectado a internet");
                window.location.reload();
            })
        }
    </script>

</body>

</html>