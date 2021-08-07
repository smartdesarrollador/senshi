<?php
/**
 * Created by PhpStorm.
 * Developer: Johen Guevara Santos.
 * Email: mguevara@enfocussoluciones.com
 * Date: 1/10/2019
 * Time: 10:49
 */
require_once "ConexionBD.class.php";
require_once("AccesoBD.class.php");

class ProductoClass
{
    private $cn;

    //EL CONSTRUCTOR CONSTRUYE LA VARIABLE $cn
    function __construct()
    {
        try {
            $con = ConexionBD::CadenaCN();
            $this->cn = AccesoBD::ConexionBD($con);
            $this->cn->query("SET NAMES 'utf8'");   //ACENTOS UTF8
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getTipoProductos($tipoProducto)
    {
        try {
            $sql = "SELECT * FROM productos where idTipoProducto = '$tipoProducto'
 AND estado = 'ACTIVO' ORDER BY productos.posicion DESC";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }
    public function getMakis()
    {
        try {
            $sql = "SELECT * FROM productos where idTipoProducto = '25'
 AND estado = 'ACTIVO' AND LENGTH(productos.mediaPorcion)>0 ORDER BY productos.posicion DESC";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }


    public function addNewProducto($nombreProducto, $descripcionProducto, $imagenProducto, $idTipoProducto, $precioProducto)
    {

        $sql = "INSERT INTO 
        productos(nombreProducto,descripcionProducto,imagenProducto,idTipoProducto,precioProducto) 
					VALUES('$nombreProducto','$descripcionProducto','$imagenProducto','$idTipoProducto','$precioProducto')";
        $id = AccesoBD::Insertar($this->cn, $sql);
        return $id;
    }

    public function updateProductWithoutPhoto($idProducto, $nombreProducto, $descripcionProducto, $idTipoProducto, $precioProducto)
    {


        $sql = "UPDATE productos set  
                nombreProducto = '$nombreProducto',
                descripcionProducto = '$descripcionProducto',
                idTipoProducto = '$idTipoProducto',
                precioProducto = '$precioProducto'
            
					WHERE idProducto = $idProducto";
        $id = AccesoBD::Insertar($this->cn, $sql);
        return $id;
    }

    public function getProductoById($id)
    {
        try {
            $sql = "SELECT * FROM productos where idProducto = '$id'";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista[0];
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

    public function updateProductWithPhoto($idProducto, $nombreProducto, $descripcionProducto, $imageProducto, $idTipoProducto, $precioProducto)
    {


        $sql = "UPDATE productos set  
                nombreProducto = '$nombreProducto',
                descripcionProducto = '$descripcionProducto',
                imagenProducto = '$imageProducto',
                idTipoProducto = '$idTipoProducto',
                precioProducto = '$precioProducto'
            
					WHERE idProducto = $idProducto";
        $id = AccesoBD::Insertar($this->cn, $sql);
        return $id;
    }

    public function getRandomProducts($limit)
    {
        try {
            $sql = "SELECT * FROM productos where imagenProducto not LIKE 'default.jpg' AND estado = 'ACTIVO' ORDER BY RAND() LIMIT $limit";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }
    public function getProductsByTipoProducto($idTipoProducto,$limit)
    {
        try {
            $sql = "SELECT * FROM productos where imagenProducto not LIKE 'default.jpg' and estado = 'ACTIVO' and idTipoProducto = '$idTipoProducto' ORDER BY RAND() LIMIT $limit";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista;
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

    public function getTipoProductoById($idTipoProducto)
    {
        try {
            $sql = "SELECT * FROM tipoproducto where idTipoProducto = '$idTipoProducto'";
            $lista = AccesoBD::Consultar($this->cn, $sql);
            return $lista[0];
        } catch (Exception $e) {
            $mensaje = "Fecha: " . date("Y-m-d H:i:s") . "\n" .
                "Archivo: " . $e->getFile() . "\n" .
                "Linea: " . $e->getLine() . "\n" .
                "Mensaje: " . $sql . "\n\n";
            error_log($mensaje, 3, "log/proyecto.log");
            throw $e;
        }
    }

}

