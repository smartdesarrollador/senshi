<?php
session_start();
error_reporting(0);
if (isset($_POST['id'], $_POST['token'])) {
} else {
    echo "Esta cuenta ya a sido configurada, si no recuerdas la contraseña, por favor usa la opcion de recuperar contraseña en https://senshi.pe";
    exit();
}
include "../class/ClienteClass.php";
$objCliente = new ClienteClass();
$cliente = $objCliente->getClienteByIDAndConfigurationToken($_POST['id'], $_POST['token']);

if ($cliente['configAccountToken'] != $_POST['token'] || $cliente['idCliente'] != $_POST['id']) {

    echo "Esta cuenta ya a sido configurada, si no recuerdas la contraseña, por favor usa la opcion de recuperar contraseña en https://senshi.pe";
    exit();
}
if ($cliente['cuentaConfigurada'] =='true' ) {

    echo "Esta cuenta ya a sido configurada, si no recuerdas la contraseña, por favor usa la opcion de recuperar contraseña en https://senshi.pe";
    exit();
}

$nombre = $_POST['nombre'];
$celular = trim($_POST['celular']);
$password = $_POST['contrasena'];

$encriptedPassword = password_hash($password, PASSWORD_DEFAULT, ['cost' => 10]);

if ($objCliente->configNewCustomerProfile($cliente['idCliente'],$nombre,$celular,$encriptedPassword,'true')>0){

    $_SESSION['current_customer_idCliente'] = $cliente['idCliente'];
    $_SESSION['current_customer_email'] = $cliente['email'];
    $_SESSION['current_customer_nombre'] = $nombre;
    $_SESSION['current_customer_apellido'] = '';
    $_SESSION['current_customer_DNI'] = '';
    $_SESSION['current_customer_fechaNacimiento'] = '';
    $_SESSION['current_customer_telefono'] = $celular;
    $_SESSION['current_customer_direccion'] = '';
    /*    $_SESSION['current_customer_reputacion'] ='';*/
    $_SESSION['current_customer_puntos'] = 0;

    header("location: ../senshi-mi-cuenta.php?code=newCustomer");
    exit();
}else{
    echo "Esta cuenta ya a sido configurada, si no recuerdas la contraseña, por favor usa la opcion de recuperar contraseña en https://senshi.pe";
    exit();
}
