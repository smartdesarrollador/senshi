<?php
session_start();
error_reporting(0);
if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {

}else{
    header('location: index.php');
    exit();
}
include '../class/ClienteClass.php';
$objCliente = new ClienteClass();
$idCliente = $_SESSION['current_customer_idCliente'];
$telefono = $_POST['telefono'];
$nombre= $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni= $_POST['dni'];
$nacimiento= $_POST['nacimiento'];
$direccion= $_POST['direccion'];

$objCliente->updateCustomerAllProfile($dni,$direccion,$telefono,$idCliente,$nacimiento,$apellido,$nombre);
$_SESSION['message']='success';
header('location:../senshi-mi-cuenta.php?code=success');
