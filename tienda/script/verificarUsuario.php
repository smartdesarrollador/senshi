<?php
session_start();
error_reporting(0);
include '../class/ClienteClass.php';


if (isset($_POST['correo']) && isset($_POST['contrasena'])) {
    $userEmail = trim(strtolower($_POST['correo']));
    $userPassword = $_POST['contrasena'];


 $objCliente = new ClienteClass();
  $customerExists = $objCliente->getUserPasswordByEmail($userEmail);

    if (isset($customerExists['password'])) {

        if (password_verify($userPassword, $customerExists['password'])) {
            $verifiedUser = $objCliente->getAllInformationUserByEmail($userEmail);


            $_SESSION['current_customer_idCliente'] = $verifiedUser['idCliente'];
            $_SESSION['current_customer_email'] = $verifiedUser['email'];
            $_SESSION['current_customer_nombre'] = $verifiedUser['nombre'];
            $_SESSION['current_customer_apellido'] = $verifiedUser['apellido'];
            $_SESSION['current_customer_DNI'] = $verifiedUser['DNI'];
            $_SESSION['current_customer_fechaNacimiento'] = $verifiedUser['fechaNacimiento'];
            $_SESSION['current_customer_telefono'] = $verifiedUser['celular'];
            $_SESSION['current_customer_direccion'] = $verifiedUser['direccion'];
            $_SESSION['current_customer_puntos'] = $verifiedUser['puntos'];


         


            $ir = $_SERVER['HTTP_REFERER'];
            header("location:$ir");
        }else{
            header("location:../?code=incorrectPass");
        }

    }else {
        header("location:../?code=notExistUser");
    }


}
