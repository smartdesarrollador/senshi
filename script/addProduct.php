<?php
session_start();
error_reporting(0);
include '../class/ProductoClass.php';
$objProducto = new ProductoClass();

function limpiar($s)
{
    $s = str_replace('á', 'a', $s);
    $s = str_replace('Á', 'A', $s);
    $s = str_replace('é', 'e', $s);
    $s = str_replace('É', 'E', $s);
    $s = str_replace('í', 'i', $s);
    $s = str_replace('Í', 'I', $s);
    $s = str_replace('ó', 'o', $s);
    $s = str_replace('Ó', 'O', $s);
    $s = str_replace('Ú', 'U', $s);
    $s = str_replace('ú', 'u', $s);
    $s = str_replace('ñ', 'n', $s);

    return $s;
}

function limpiarEspacio($s)
{
    $s = str_replace(" ", "", $s);


    return $s;
}


if ($_POST['action']=='submit'){
$foto = $_FILES["foto"]['name'];
$nombreProducto = trim($_POST['nombreProducto']);
$descripcionProducto = trim($_POST['descripcionProducto']);
$tipoProducto = $_POST['tipoProducto'];
$precioProducto = intval($_POST['precioProducto']);


$nombreFoto = limpiarEspacio(limpiar($nombreProducto.uniqid())).'.jpg';
$destino ='../img/carta/platos/'.$nombreFoto;


    copy($_FILES['foto']['tmp_name'], $destino);


    if ($_FILES['foto']['error'] == UPLOAD_ERR_NO_FILE) {
        $affectedRows = $objProducto->addNewProducto($nombreProducto, $descripcionProducto, 'default.jpg', $tipoProducto, $precioProducto);
    } else {
        $affectedRows = $objProducto->addNewProducto($nombreProducto,$descripcionProducto,$nombreFoto,$tipoProducto,$precioProducto);
    }
    if ($affectedRows > 0) {
            header('location: https://operaciones.senshi.pe/productos?code=success');
        }else{
            echo "Error inesperado, contacte con el administrador";
        }


}
