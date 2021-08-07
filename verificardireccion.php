<?php
include 'class/Cart.php';
$cart = new Cart;
date_default_timezone_set('America/Lima');
error_reporting(0);
$cartItems = $cart->contents();
if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {

} else {
    header('location: index.php');
    exit();
}
include 'class/ClienteClass.php';
include 'class/Horario.php';
$objCliente = new ClienteClass();
$objHorario = new Horario();

$cliente = $objCliente->getAllInformationUserById($_SESSION['current_customer_idCliente']);

$listaHorarios = $objHorario->getHorarios();

$descuento = false;
if ($_SESSION['current_customer_puntos'] >= 200) {
    $descuento = true;
}
$cartTotal = $cart->total();

$saldoBilletera = round($cliente['saldoBilletera']);


function calcularHorarios($arrayHorarios)
{
    $dateTime = time();
    $diasemana = date('N', $dateTime);
    $hora = date('H', $dateTime) * 1;

    if ($diasemana <= 7 && $diasemana >= 5) {

        return $arrayHorarios;
    } else {
        if ($hora >= 18) {
            return $arrayHorarios;
        } elseif ($hora > 16) {
            unset($arrayHorarios[0]);
            unset($arrayHorarios[1]);
            return $arrayHorarios;
        } elseif ($hora > 14) {
            unset($arrayHorarios[0]);
            return $arrayHorarios;
        } else {
            return $arrayHorarios;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Senshi Sushi/Bar-Verificar tu dirección</title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD036kBF-olP1CJdVTP7uJnl9IIsAvm7sI&libraries=places"
            ></script>
    <script src="https://checkout.culqi.com/js/v3"></script>
    <style>

    </style>
</head>
<body>
<?php include 'templates/navbar.php'; ?>


<div class="container" style="min-height: 900px;margin-top: 125px">

    <div class="row">
        <div class="col-md-6 offset-md-3">

            <br style="clear:both">
            <h3 style="margin-bottom: 10px; text-align: center;">Verifica tus datos</h3>

            <?php
            if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
                ?>
                <input type="hidden" value="-"
                       class="form-control" id="direccion" name="name"
                > <input type="hidden" value="-"
                         class="form-control" id="distrito" name="name"
                > <input type="hidden" value="-"
                         class="form-control" id="referencia" name="name"
                >
                <input type="hidden" id="longitud" value="<?php echo $cliente['longitud'] ?>">
                <input type="hidden" id="latitud" value="<?php echo $cliente['latitud'] ?>">
                <?php
            } else {
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="direccion">Direccion</label>
                            <input type="text" value="<?php echo $cliente['direccion']; ?>"
                                   class="form-control" id="direccion" name="name"
                                   placeholder="Ingresa tu Dirección"
                                   required>
                            <input type="hidden" id="longitud" value="<?php echo $cliente['longitud'] ?>">
                            <input type="hidden" id="latitud" value="<?php echo $cliente['latitud'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="distrito">Distrito</label>
                            <input value="<?php echo $cliente['distrito'] ?>" type="text"
                                   class="form-control" id="distrito" name="distrito"
                                   placeholder="Ingresa tu distrito"

                                   required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="referencia">Referencia</label>
                            <input value="<?php echo $cliente['referencia'] ?>" type="text"
                                   class="form-control" id="referencia" name="referencia"
                                   placeholder=""
                                   required>
                        </div>
                    </div>
                </div>
                <div id="map-title" class="d-none">
                    <small>
                        <strong>
                            Si es necesario, precisa tu ubicación en el mapa.

                        </strong>
                    </small>
                </div>
                <div id="map"></div>
            <?php } ?>

            <div class="row mt-2">
                <div class="col-6">
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input value="<?php echo $cliente['celular'] ?>" type="text"
                               class="form-control" id="telefono" name="telefono"
                               onkeypress="return solonumeros(event);"
                               placeholder="Ingresa un numero de teléfono"
                               required>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="fechaNacimiento">Fecha de Nacimiento</label>
                        <input type="date"
                               value="<?php echo date('Y-m-d', strtotime($cliente['fechaNacimiento'])) ?>"
                               class="form-control" id="fechaNacimiento" name="dni" placeholder="DNI"
                               minlength="8" required>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col">
                    <div class="form-check">
                        <input class="form-check-input" required type="radio" name="documento" id="factura"
                               value="factura"
                        >
                        <label class="form-check-label" for="factura">
                            Deseo factura
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="documento" id="boleta" value="boleta"
                        >
                        <label class="form-check-label" for="boleta">
                            Deseo Boleta
                        </label>
                    </div>
                </div>
            </div>
            <div id="boletaContainer" class="m-0 p-0 animated fadeIn">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="dni">DNI</label>
                            <input value="<?php echo $cliente['DNI'] ?>" type="text"
                                   onkeypress="return solonumeros(event);" class="form-control" id="dni" name="dni"
                                   placeholder="Ingresa tu DNI"
                                   minlength="8" required>
                        </div>
                    </div>
                </div>
            </div>
            <div id="facturaContainer" class="m-0 p-0 animated fadeIn">
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="rucInput">RUC</label>
                            <input value="" type="text"
                                   onkeypress="return solonumeros(event);" class="form-control" id="rucInput" name="ruc"
                                   placeholder="Ingresa tu RUC"
                                   minlength="11" required>
                        </div>
                        <div class="text-center" id="loaderRuc">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="razSocialInput">Razón Social</label>
                            <input value="" type="text" class="form-control" id="razSocialInput" name="razSocial"
                                   placeholder="Ingresa tu razón social" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="dirFiscal">Dirección fiscal</label>
                            <input value="" type="text" class="form-control" id="dirFiscal" name="dirFiscal"
                                   placeholder="Ingresa dirección fiscal" required>
                        </div>
                    </div>
                </div>

            </div>


            <div class="row" style="margin: 0;padding: 0">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 col-12" style="margin: 0;padding: 0">
                    <div class="form-group">
                        <label for="mensaje"><strong>Mensaje / Programacion de pedido</strong></label>
                        <textarea placeholder="" aria-describedby="direccionHelp" class="form-control" id="mensaje"
                                  rows="2"><?php echo $_SESSION['current_customer_mensaje'] ?></textarea>
                        <small id="direccionHelp" class="form-text text-muted">Ejemplo: Alérgico a mariscos, puerta
                            azul, departamento
                            104</small>
                    </div>
                </div>

            </div>
            <div class="row mb-2 ">
                <div class="col ">
                    <?php
                    if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
                        ?>
                        <input type="radio" checked class="custom-control-input"
                               name="horario"
                               value="-"
                               id="">
                        <?php
                    } else {
                        ?>
                        <?php if (count($listaHorarios) > 0) { ?>

                            <strong class="font-weight-bold">Elige un horario de entrega</strong>
                            <?php foreach (calcularHorarios($listaHorarios) as $horario) { ?>
                                <div class="custom-control custom-radio my-1">
                                    <input type="radio" class="custom-control-input"
                                           name="horario"
                                           value="<?php echo $horario['idHorario']; ?>"
                                           id="<?php echo $horario['idHorario'] ?>">
                                    <label class="custom-control-label" for="<?php echo $horario['idHorario'] ?>">
                                        <?php echo $horario['descripcionHorario'] ?>
                                    </label>
                                </div>
                            <?php } ?>

                        <?php } else { ?>
                            <p class="text-danger text-center font-weight-bolder">Lo sentimos, no tenemos horarios de
                                entrega disponibles.
                                <br> Vuelve a intentarlo mas tarde.</p>
                        <?php }

                    } ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <button type="button" id="btnVerificar" name="submit" class="btn btn1 btn-block ">Verificar <i
                                class="fas fa-search"></i></button>

                </div>
            </div>

            <div class="row">
                <div class="col">
                    <table class="table text-center table-borderless">

                        <tbody>
                        <tr>
                            <td>Saldo actual:</td>
                            <th class="text-info">S/. <?php echo $saldoBilletera;
                                ?></th>


                        </tr>
                        <tr>
                            <td>Sub Total:</td>
                            <td> <?php
                                $total = 0;
                                if ($descuento) {
                                    ?>

                                    <strong>S/. <?php echo $total = $cartTotal ?></strong>


                                    <small class="text-success m-0 d-block">Felicidades! tienes 200 puntos, te
                                        enviaremos medio maki adicional a tu pedido.</small>


                                    <?php
                                } else { ?>

                                    <strong>S/. <?php echo $total = $cartTotal; ?></strong>
                                    <?php
                                }
                               /* if ($saldoBilletera < $total) {
                                    $total = $total - $saldoBilletera;
                                } elseif ($saldoBilletera >= $total) {
                                    $total = 0;
                                }*/
                                if ($_SESSION['solo_gift_cards'] == 'true') {
                                    echo '<small class="text-danger">(No puedes usar tu saldo para comprar giftcards)</small>';
                                    $total = $cartTotal;
                                } else {

                                    if ($saldoBilletera < $total) {
                                        $total = $total - $saldoBilletera;
                                    } elseif ($saldoBilletera >= $total) {
                                        $total = 0;
                                    }
                                }

                                ?>
                            </td>


                        </tr>
                        <tr>
                            <td>TOTAL  :
                                <small class="m-0 p-0 text-info d-block">Aplicando el saldo actual</small></td>
                            <td><strong> S/. <?php echo $total ?></strong></td>


                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>

    </div>
    <hr>
    <div class="row" style="min-height: 400px">

        <div class="col-md-6 offset-md-3">
            <div id="vista"></div>
        </div>
    </div>

</div>


<?php include 'templates/footer.php'; ?>
<script src=""></script>
<script>


    let rucInput = document.getElementById('rucInput');
    let razSocialInput = document.getElementById('razSocialInput');
    let dirFiscal = document.getElementById('dirFiscal');


    $(document).ready(function () {
        $('#boletaContainer').hide();
        $('#facturaContainer').hide();
        $('#loaderRuc').hide();
    });

    let tipoDocumento = '';
    $("input[name=documento]").click(function () {
        let elemento = this;
        if (elemento.value === 'factura') {
            tipoDocumento = 'factura';

            $('#boletaContainer').hide();
            $('#facturaContainer').show();
        }
        if (elemento.value === 'boleta') {
            tipoDocumento = 'boleta';
            $('#boletaContainer').show();
            $('#facturaContainer').hide();
        }
    });


    $('#btnVerificar').on('click', function () {


        let horario = $('input:radio[name=horario]:checked').val();
        if (!horario) {

            Swal.fire(
                'Selecciona un horario por favor',
                '',
                'error'
            );

            return false;
        }

        let documento = $('input:radio[name=documento]:checked').val();
        if (!documento) {

            Swal.fire(
                'Error',
                'Seleccione si desea boleta o factura',
                'error'
            );

            return false;
        }

        let direccion = $("#direccion").val();
        let referencia = $("#referencia").val();
        let distrito = $("#distrito").val();
        let dni = $("#dni").val();
        let fechaNacimiento = $("#fechaNacimiento").val();
        let mensaje = $("#mensaje").val();
        let telefono = $("#telefono").val();
        let total = '<?php echo $total; ?>';

        <?php
        if ($total == 0) {
        ?>
        urlVerificarDatos = 'ajax/verificarDireccionPagarConSaldo.php';

        <?php
        }else{
        ?>
        urlVerificarDatos = 'ajax/verificarDireccion.php';

        <?php
        }
        ?>

        let datos = {
            "direccion": direccion,
            "dni": dni,
            "fechaNacimiento": fechaNacimiento,
            'mensaje': mensaje,
            'telefono': telefono,
            'total': total,
            'horario': horario,
            'referencia': referencia,
            'distrito': distrito,
            'tipoDocumento': tipoDocumento,
            'lat': $("#latitud").val(),
            'lng': $("#longitud").val()
        };

        if (tipoDocumento === 'factura') {

            datos.ruc = rucInput.value;
            datos.razonSocial = razSocialInput.value;
            datos.direccionFiscal = dirFiscal.value;

            if (rucInput.value.length < 11 || razSocialInput.value.length === 0 || dirFiscal.value.length === 0) {
                Swal.fire(
                    'Error',
                    'Rellena todos los campos de tu factura',
                    'error'
                );
                return false
            }


        }

        $.ajax({
            url: urlVerificarDatos,
            type: "post",
            data: datos,
            beforeSend: function () {
                $("#vista").html("<div class=\"d-flex justify-content-center\">\n" +
                    "  <div style='width: 130px;height: 130px;margin-top: 60px' class=\"spinner-border\" role=\"status\">\n" +
                    "    <span class=\"sr-only\">Loading...</span>\n" +
                    "  </div>\n" +
                    "</div>");

                $('#button').attr("disabled", true);

            },

            success: function (data) {
                $("#vista").html(data);
            }
        });

        /* window.scroll({
             top: 900,
             behavior: 'smooth'
         });*/
/*
        let elementPosition = document.getElementById('vista').offsetTop;
*/
        let elementPosition  = $("#vista").offset();
        console.log('POSITION',elementPosition);
         window.scroll({
             top: elementPosition.top - 150,
             behavior: 'smooth'
         });
    });


    rucInput.addEventListener('blur', ev => {
        if (rucInput.value.length === 11) {
            $('#loaderRuc').show();
            let data = new FormData();

            data.append('ruc', rucInput.value);

            fetch('ajax/buscarRuc.php', {
                method: 'POST',
                body: data
            })
                .then(function (response) {
                    return response.json();

                })
                .then(function (json) {
                    razSocialInput.value = json.razon_social;
                    dirFiscal.value = json.domicilio_fiscal;
                    $('#loaderRuc').hide();
                }).catch(() => {
                $('#loaderRuc').hide();
            })
        }
    })

</script>
<script src="js/mapsVerificarDireccion.js"></script>
</body>
</html>
