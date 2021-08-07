<?php
include "class/Cart.php";
$objCart = new Cart();
echo '<pre>';
print_r($objCart->contents());
