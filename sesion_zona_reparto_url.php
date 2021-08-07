<?php
session_start();
$zona = $_GET['zona'];
$url = $_GET['url'];
if ($zona == "san_borja") {
    $_SESSION['local'] = "san_borja";
    $_SESSION['contador_local'] = 'sin_distrito';
    //$_SESSION['contador_local'] = 'con_distrito';
    //header("Location: tienda".$url);
    header("Location: carrito.php");
}
if ($zona == "lince") {
    $_SESSION['local'] = "lince";
    $_SESSION['contador_local'] = 'sin_distrito';
    //header("Location: ".$url);
    header("Location: carrito.php");
}
