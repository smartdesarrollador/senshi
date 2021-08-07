<?php
session_start();
error_reporting(0);
include '../class/Cart.php';

if ($_REQUEST['code'] == 'recojo') {
    $_SESSION['envio'] = 'recojo';
    $_SESSION['contador_local'] = 'sin_distrito';
}
if ($_REQUEST['code'] == 'reparto') {
    $_SESSION['envio'] = 'reparto';
    $_SESSION['contador_local'] = 'sin_distrito';
}

$cart = new Cart();
$cart->save_cart();

if (isset($_REQUEST['redirect'])) {
    header("location: ../" . $_REQUEST['redirect']);
} else {
    header("location: ../carta.php");
}
