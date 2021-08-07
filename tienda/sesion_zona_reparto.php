<?php
session_start();
$zona = $_GET['zona'];
if ($zona == "san_borja") {
    $_SESSION['local'] = "san_borja";
    header("Location: platos.php?tipo=24");
}
if ($zona == "lince") {
    $_SESSION['local'] = "lince";
    header("Location: ../platos.php?tipo=24");
}
?>


