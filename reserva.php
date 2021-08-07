<?php
session_start();
$page = 'reserva';

header('Location:index.php');
exit;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senshi Sushi/Bar-Reservas-Tiraditos</title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pickerjs@1.2.1/dist/picker.min.css">
</head>
<body>
<?php include 'templates/navbar.php'; ?>

<div class="container text-center" style="margin-top:140px">
    <div class="row">
        <div class="col-sm-12 col-xs-12">

            <h1 class="piqueos mb-4">RESERVAS</h1>

        </div>
    </div>
</div>


<div class="container mb-5" style="">

    <div class="row">
        <div class="col-md-12 col-xl-6 col-sm-6 col-lg-6">
            <h2 class="satisfy">Importante:</h2>
            <h6>Las reservas se solicitan con 3 horas de anticipación</h6>
            <hr>
            <form class="my-5" method="post" action="script/sendReservation.php" name="formReserva">
                <div class="form-group">
                    <label for="nombreCompleto">Nombres y Apellidos</label>
                    <input required type="text" name="nombreCompleto" class="form-control" id="nombreCompleto">

                </div>

                <div class="form-group">
                    <label for="empresa">Empresa</label>
                    <input type="text" name="empresa" class="form-control" id="empresa">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input style="text-transform: lowercase" required type="email" name="email" class="form-control"
                           id="email">
                </div>
                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input name="telefono" required type="tel" class="form-control" id="telefono">
                </div>

                <div class="row m-0 p-0">

                    <div class="form-group col-md-6 col-6 pl-0 ">
                        <label for="hora">Hora</label>
                        <input name="hora" required type="text" class="form-control" id="hora">
                    </div>

                    <div class="form-group col-md-6 col-6 pr-0 ">
                        <label for="fecha">Fecha</label>
                        <input name="fecha" required type="text" class="form-control" id="fecha">
                    </div>
                </div>


                <div class="form-group">
                    <label for="motivo">Motivo de la Reserva</label>
                    <textarea required name="motivo" id="motivo" class="form-control" rows="3"></textarea>
                </div>

                <div class="row p-0 m-0">

                    <div class="form-group col-md-6 col-6 pl-0 ">
                        <label for="numeroPersonas">Numero de Personas</label>
                        <input min="1" name="numPersonas" required type="number" class="form-control"
                               id="numeroPersonas">
                    </div>

                    <div class="form-group col-md-6 col-6 pr-0 ">
                        <label for="dni">DNI</label>
                        <input name="dni" required type="text" class="form-control" maxlength="8" minlength="8"
                               id="dni">

                    </div>
                </div>
                <div class="row p-0 m-0">
                    <div class="col-md-12 col-sm-12 col-xl-12 col-lg-12 text-center">
                        <div style="display: inline-block;" data-theme="dark" class="g-recaptcha"
                             data-sitekey="6Ld-sMcUAAAAAEgCFmhMra757oUJfa6oKLVBijr_"></div>
                    </div>

                </div>


                <button type="submit" name="submit" class="btn btn-lg btn-dark btn-block">Enviar</button>
            </form>
        </div>
        <div class="col-md-12 col-xl-6 col-sm-6 col-lg-6">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 text-center">
                    <h6>Aceptamos todas las tarjetas:</h6>
                    <img class="img-fluid" src="icon/mastercard.png" alt="Tarjetas que aceptamos, Senshi Sushi/Bar">
                    <img class="img-fluid" src="icon/visa.png" alt="Tarjetas que aceptamos, Senshi Sushi/Bar">
                    <img class="img-fluid" src="icon/diners.png" alt="Tarjetas que aceptamos, Senshi Sushi/Bar">
                    <img class="img-fluid" src="icon/american.png" alt="Tarjetas que aceptamos, Senshi Sushi/Bar">

                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xl-12 text-center mt-5">
                    <img data-zoomable="true" class="img-fluid" style="" src="img/senshifoto1.jpg"
                         alt="Senshi Sushi/Bar Reservas">
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/pickerjs@1.2.1/dist/picker.min.js"></script>
<script src="js/reservas.js"></script>


<?php include 'templates/footer.php'; ?>

</body>
</html>
