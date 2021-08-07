<?php
session_start();
$page = 'reparto';
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>.:Tu pedido esta en camino:.</title>
    <?php include 'templates/metalink.php'; ?>
    <link rel="stylesheet" href="css/carta.css">
</head>

<body>
    <?php include 'templates/navbar.php'; ?>

    <div class="container text-center" style="margin-top:130px;min-height: 500px">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <img class="m-3" src="assets/images/paymentSuccess.png" alt="">
                        <h4 class="p-2" style="color: green">Hemos recibido tu Orden</h4>
                    </div>
                </div>
                <table class="table ">

                    <tbody>
                        <tr>
                            <th>Nombres</th>
                            <td><?php echo $_SESSION['current_customer_nombre'] . ' ' . $_SESSION['current_customer_apellido'] ?></td>


                        </tr>
                        <tr>
                            <th>Numero de Orden</th>
                            <td><?php echo str_pad($_GET['orderId'], 8, "0", STR_PAD_LEFT); ?> </td>

                        </tr>
                        <tr>
                            <th>Monto Pagado</th>
                            <td>S/ <?php echo $_GET['amount']; ?>.00 </td>


                        </tr>
                        <tr>
                            <th>Correo</th>
                            <td><?php echo $_SESSION['current_customer_email'] ?></td>


                        </tr>
                        <?php if ($_SESSION['solo_gift_cards'] == 'true') { ?>


                        <?php } elseif ($_SESSION['envio'] == 'recojo') { ?>
                            <th>Direccion de recojo</th>
                            <td>AV. AVIACION 3455 - SAN BORJA</td>
                        <?php } else { ?>
                            <tr>
                                <th>Direccion de Envío</th>
                                <td><?php echo $_SESSION['current_customer_direccion'] ?></td>


                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-6 col-xl6 col-sm-6 col-lg-6 col-6 text-center">
                        <button type="button" onclick="javascript:window.print()" class="btn btn-info btn-block">Imprimir</button>
                    </div>
                    <div class="col-md-6 col-xl6 col-sm-6 col-lg-6 col-6 text-center">
                        <a href="carta.php" class="btn btn-success btn-block">Volver a la carta</a>
                    </div>
                </div>
            </div>

        </div>
    </div>









    <?php include 'templates/footer.php'; ?>


</body>

</html>