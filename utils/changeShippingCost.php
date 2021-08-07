<?php
session_start();


$shippingCost = $_POST['finalShippingCost'];

$_SESSION['finalShippingCost'] = $shippingCost;

if(isset($_POST['finalStoreLocal'])){
    $finalStoreTienda = $_POST['finalStoreLocal'];
    $_SESSION['finalStoreTienda'] = $finalStoreTienda;
}




echo $shippingCost;
