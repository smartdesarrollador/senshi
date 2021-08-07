<?php
session_start();
error_reporting(0);
require '../class/ClienteClass.php';
require_once '../vendor/autoload.php';
$objCliente = new ClienteClass();

$token = $_POST['token'];
$client = new Google_Client(['client_id' => '356037621835-e50hsoqemit6j6hmp6259ccn4ttv938t.apps.googleusercontent.com']);  // Specify the CLIENT_ID of the app that accesses the backend
$payload = $client->verifyIdToken($token);
if ($payload) {
    $existe = $objCliente->checkUserFB($payload['email'],'Google',$payload['sub'],$payload['given_name'],$payload['family_name']);

    $_SESSION['current_customer_idCliente'] = $existe['idCliente'];
    $_SESSION['current_customer_email'] = $existe['email'];
    $_SESSION['current_customer_nombre'] = $existe['nombre'];
    $_SESSION['current_customer_apellido'] = $existe['apellido'];
    $_SESSION['current_customer_DNI'] =$existe['DNI'] ;
    $_SESSION['current_customer_fechaNacimiento'] = $existe['fechaNacimiento'];
    $_SESSION['current_customer_telefono'] = $existe['celular'];
    $_SESSION['current_customer_direccion'] = $existe['direccion'];
    $_SESSION['current_customer_puntos'] = $existe['puntos'];

} else {
    // Invalid ID token
    echo "Token inválido";
}
