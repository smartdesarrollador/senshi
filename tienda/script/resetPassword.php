<?php
include "../class/ClienteClass.php";
error_reporting(0);
if (isset($_POST['email'],$_POST['password'],$_POST['tkn'])){
$tkn = $_POST['tkn'];
$email = $_POST['email'];
$newPassword = $_POST['password'];

$objUser = new ClienteClass();

$userExist = $objUser->getUserByAccountRecoveryTokenAndEmail($tkn, $email);

    if ($userExist['passRecoveryToken'] == $tkn && $userExist['email'] == $email) {

        $encriptedPassword = password_hash($newPassword, PASSWORD_DEFAULT, ['cost' => 10]);

        $isChanged = $objUser->changeUserPasswordByRecoveryToken($tkn, $email, $encriptedPassword);

        if ($isChanged>0){
            header('location: ../?code=passChanged');
        }else{
            echo "Ocurrió un error al cambiar la contraseña";

        }


    }else{
        echo "no tiene  autorizacion para ver esta pagina";
        exit();
    }


}else{
    echo "no tiene  autorizacion para ver esta pagina";
    exit();
}
