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

if ($_POST['action'] == 'submit') {

    $idProducto = trim($_POST['idProducto']);
    $foto = $_FILES["foto"]['name'];
    $nombreProducto = trim($_POST['nombreProducto']);
    $descripcionProducto = trim($_POST['descripcionProducto']);
    $tipoProducto = $_POST['tipoProducto'];
    $precioProducto = intval($_POST['precioProducto']);

    //SIN FOTO
    if ($_FILES['foto']['error'] == UPLOAD_ERR_NO_FILE) {
        $objProducto->updateProductWithoutPhoto($idProducto,$nombreProducto,$descripcionProducto,$tipoProducto,$precioProducto);
        header('location: https://operaciones.senshi.pe/productos?code=updateSuccess');
    }else{//con foto
        $producto = $objProducto->getProductoById($idProducto);
        $oldImageUrl = "../img/carta/platos/".trim($producto['imagenProducto']);

        $nombreNuevoArchivo = limpiar(limpiarEspacio($nombreProducto . uniqid())).'.jpg';
        $destinoUrl = "../img/carta/platos/".$nombreNuevoArchivo;

        if (copy($_FILES['foto']['tmp_name'], $destinoUrl)) {
            if ($objProducto->updateProductWithPhoto($idProducto,$nombreProducto,$descripcionProducto,$nombreNuevoArchivo,$tipoProducto,$precioProducto)>=0){

                if ($producto['imagenProducto'] != 'default.jpg') {
                    unlink($oldImageUrl);
                }
                    header('location: https://operaciones.senshi.pe/productos?code=updateSuccess');

            };

        }




    }


}
