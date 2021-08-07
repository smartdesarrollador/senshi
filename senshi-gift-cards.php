<?php
session_start();
$page = 'giftCards';
require 'class/ProductoClass.php';
require 'class/TiendaClass.php';
$objTienda = new TiendaClass();
$objProducto = new ProductoClass();
$lista = $objProducto->getTipoProductos(29);
$estadoTienda = trim($objTienda->getEstadoTienda()['estado']);

if (count($lista) < 1) {
    header("Status: 302 Found");
    header('location: carta.php');
    exit();
}

//GENERANDO LOS META TAGS
$nombres = '';
foreach ($lista as $item) {
    $nombres = $nombres . ', ' . $item['nombreProducto'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Senshi Sushi/Bar-Reparto</title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">
    <link rel="stylesheet" href="css/seleccion_multiple.css">
</head>

<body>
    <?php include 'templates/navbar.php'; ?>

    <div class="container text-center" style="margin-top:140px">
        <div class="row">
            <div class="col-sm-12 col-xs-12">

                <h1 class="piqueos mb-4">Gift Cards</h1>

            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-3 mb-4 justify-content-center">
            <?php foreach ($lista as $campo) { ?>
                <div class="col mb-5">
                    <div class="card border-dark h-100 card-products">
                        <img data-zoomable="true" src="img/carta/platos/<?php echo $campo['imagenProducto'] ?>" class="card-img-top" alt="...">
                        <div class="card-body p-2 d-flex flex-column">
                            <h4 class="card-title parrafoHelvetica text-center tituloProducto"><?php echo $campo['nombreProducto'] ?></h4>
                            <p class="card-text"><?php echo $campo['descripcionProducto'] ?></p>
                            <h4 class="text-center"><span class="badge badge-dark">S/ <?php echo $campo['precioProducto'] ?>.00</span></h4>
                            <p class="card-points-description">

                                <?php
                                if ($campo['acumulaNPuntos'] > 0) {
                                ?>
                                    ¡Acumula <?php echo $campo['acumulaNPuntos'] ?> Pts!

                                <?php
                                }
                                ?>

                            </p>


                            <?php if ($estadoTienda == 'ABIERTO') {
                                if ($campo['stock'] == 'YES') {

                                    //SI ES UN PRODUCTO DE SELECCIÓN MULTIPLE
                                    if ($campo['productoObservaciones'] == 'GIFT_CARD') {
                            ?>
                                        <a data-toggle="modal" data-target=".modalArmaTuBowl" data-whatever="<?php echo $campo['idProducto'] ?>" href="#" class="btn btn-warning w-100 align-self-end mt-auto">Comprar <i class="fas fa-cart-plus"></i></a>
                                    <?php
                                    } else {
                                    ?>
                                        <a onclick="mostrarLoading();" href="script/cartAction.php?action=addToCart&id=<?php echo $campo['idProducto'] ?>&cantidad=1" class="btn btn-warning w-100 align-self-end mt-auto">Comprar <i class="fas fa-cart-plus"></i></a>
                                    <?php
                                    }
                                } else {
                                    ?>
                                    <button type="button" class="btn btn-warning w-100 align-self-end mt-auto">AGOTADO
                                    </button>
                                <?php
                                }
                            } else {
                                ?>
                                <button type="button" class="btn btn-warning w-100 align-self-end mt-auto">CERRADO</button>
                            <?php
                            }
                            ?>


                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>


    <div class="modal fade modalArmaTuBowl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <form id="formSeleccion" method="post" action="script/cartAction.php">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-times" aria-hidden="true"></i>
                        </button>
                        <h3 class="text-center text-egipcio m-0">¿A quien va dirigido el gift card?</h3>
                        <!--  <h5 class="text-center">A quien va dirigido el gift card ?<i
                                  class="fa fa-arrow-down animated bounce infinite slow" aria-hidden="true"></i></h5>-->

                        <input type="hidden" class="form-control" id="idModal" name="id">

                        <div class="row row-cols-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-3  p-3 justify-content-center">

                            <div class="col mb-2 mx-auto justify-content-center d-flex mt-2">
                                <div class="card h-100 card-products">
                                    <div class="p-4">
                                        <img src="icon/electronico.png" class="card-img-top" alt="Billetera electrónica Senshi">

                                    </div>

                                    <div class="card-body p-2 d-flex flex-column">
                                        <h5 class="card-title titulo-cards parrafoHelvetica">ES PARA MI</h5>
                                        <input value="personal" name="dirigidoA" class="d-none" type="radio" id="panIntegral">
                                        <label for="panIntegral" class="ingrediente-button w-100 align-self-end mt-auto">Elegir
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col mb-2 mx-auto justify-content-center d-flex mt-2">
                                <div class="card h-100 card-products">
                                    <div class="p-4">
                                        <img src="icon/regalo-de-navidad.png" class="card-img-top" alt="Gift Card Cevicheria Senshi">

                                    </div>

                                    <div class="card-body p-2 d-flex flex-column">
                                        <h5 class="card-title titulo-cards parrafoHelvetica">ES UN REGALO</h5>
                                        <input value="regalo" name="dirigidoA" class="d-none" type="radio" id="panFinasYerbas">
                                        <label for="panFinasYerbas" class="ingrediente-button w-100 align-self-end mt-auto">Elegir
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row mt-2 justify-content-center animated fadeIn" id="correoDestinatarioRow">
                            <div class="col-12 col-sm-12 col-md-6 col-xl-4 col-lg-4 text-center">
                                <div class="form-group">
                                    <label for="emailGift">Correo electrónico del destinatario:</label>
                                    <input onkeyup="return forceLower(this);" id="emailGift" class="form-control m-0" type="text" name="emailGift">
                                </div>

                                <div class="form-group">
                                    <label for="dedicatoriaGift">Dedicatoria:</label>
                                    <input id="dedicatoriaGift" class="form-control m-0" type="text" name="dedicatoriaGift">
                                </div>

                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col text-center">
                                <input type="hidden" name="action" value="addToCart">
                                <input type="hidden" name="cantidad" value="1">
                                <button type="submit" class="btn btn-success btn-lg">COMPRAR</button>
                            </div>
                        </div>

                    </form>
                </div>


            </div>
        </div>
    </div>



    <?php include 'templates/footer.php'; ?>

    <script>
        $('.modalArmaTuBowl').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var recipient = button.data('whatever'); // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            var modal = $(this);
            modal.find('.modal-body #idModal').val(recipient)
        });

        $(document).ready(function() {
            $('#emailGift').prop('required', false);
            $('#emailGift').prop("type", "text");
            $('#correoDestinatarioRow').hide();


            $('#formSeleccion input[type="radio"]').on('change', function(e) {

                /*console.log(this.value);*/
                if ($(this).val() == 'regalo') {
                    $('#correoDestinatarioRow').show();
                    $('#emailGift').prop('required', true);

                    $('#emailGift').prop("type", "email")
                } else {
                    $('#correoDestinatarioRow').hide();
                    $('#emailGift').prop('required', false);
                    $('#emailGift').prop("type", "text")
                }

            });


            $("#formSeleccion").submit(function() {
                console.log($('#formSeleccion input[name="dirigidoA"]:checked').length);
                if ($('#formSeleccion input[name="dirigidoA"]:checked').length == 0) {
                    alert('Por favor seleccione una opción antes de continuar');
                    return false;
                } else {
                    return true;
                }

            });

        });
    </script>
</body>

</html>