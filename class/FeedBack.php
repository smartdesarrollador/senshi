<?php
/**
 * Created by PhpStorm.
 * Developer: Johen Guevara Santos.
 * Email: mguevara@enfocussoluciones.com
 * Date: 25/09/2019
 * Time: 12:17
 */
require_once "ConexionBD.class.php";
require_once("AccesoBD.class.php");

class FeedBack
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

    public function addNewFeedBack($reaction, $message, $idPedido)
    {
        date_default_timezone_set('America/Lima');
        $actualDate = time();
        $sql = "INSERT INTO feedback(reaction,message,date,time,idPedido,dateTime)
					VALUES('$reaction','$message',now(),now(),'$idPedido','$actualDate')";
        $id = AccesoBD::InsertAndGetLastId($this->cn, $sql);
        return $id;
    }

    public function findFeedBackByIdPedido($idPedido)
    {
        try {
            $sql = "SELECT * FROM feedback where idPedido = '$idPedido'";
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


}
