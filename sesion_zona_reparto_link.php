<?php
session_start();
$zona = $_GET['zona'];
$url = $_GET['url'];
if ($zona == "san_borja") {
    $_SESSION['local'] = "san_borja";
    header("Location: tienda" . $url);
}
if ($zona == "lince") {
    $_SESSION['local'] = "lince";
    header("Location: " . $url);
}
