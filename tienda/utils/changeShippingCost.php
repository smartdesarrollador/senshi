<?php
session_start();


$shippingCost = $_POST['finalShippingCost'];
if(isset($shippingCost))

$_SESSION['finalShippingCost'] = $shippingCost;
echo $shippingCost;
