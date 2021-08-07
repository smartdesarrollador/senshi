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

class Pedido
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

    function calcularDiaEnvio($timeStamp)
    {
        date_default_timezone_set('America/Lima');
        $hora = date('H', $timeStamp) * 1;
        $minuto = date('i', $timeStamp) * 1;
        $diasASumar = 0;
        $ultimaHoraDeAtencion = 21;


        $diasemana = date('N', $timeStamp);


        if ($diasemana == 1) {
            $diasASumar = 1;

            /* if ($hora > 18) {
                 $diasASumar = 1;
             } elseif ($hora == 18) {

                 if ($minuto > 30) {
                     $diasASumar = 1;
                 } else {
                     $diasASumar = 0;
                 }
             } elseif ($hora < 18) {
                 $diasASumar = 0;
             }*/


        }
        if ($diasemana == 2) {
            if ($hora > $ultimaHoraDeAtencion) {

                $diasASumar = 1;


            } elseif ($hora == $ultimaHoraDeAtencion) {


                if ($minuto > 30) {
                    $diasASumar = 1;
                } else {
                    $diasASumar = 0;
                }

            } elseif ($hora < $ultimaHoraDeAtencion) {
                $diasASumar = 0;
            }
        }


        if ($diasemana == 3) {
            if ($hora > $ultimaHoraDeAtencion) {

                $diasASumar = 1;


            } elseif ($hora == $ultimaHoraDeAtencion) {


                if ($minuto > 30) {
                    $diasASumar = 1;
                } else {
                    $diasASumar = 0;
                }

            } elseif ($hora < $ultimaHoraDeAtencion) {
                $diasASumar = 0;
            }
        }
        if ($diasemana == 4) {
            if ($hora > $ultimaHoraDeAtencion) {

                $diasASumar = 1;


            } elseif ($hora == $ultimaHoraDeAtencion) {


                if ($minuto > 30) {
                    $diasASumar = 1;
                } else {
                    $diasASumar = 0;
                }

            } elseif ($hora < $ultimaHoraDeAtencion) {
                $diasASumar = 0;
            }
        }
        if ($diasemana == 5) {
            if ($hora > $ultimaHoraDeAtencion) {

                $diasASumar = 1;


            } elseif ($hora == $ultimaHoraDeAtencion) {


                if ($minuto > 30) {
                    $diasASumar = 1;
                } else {
                    $diasASumar = 0;
                }

            } elseif ($hora < $ultimaHoraDeAtencion) {
                $diasASumar = 0;
            }
        }
        if ($diasemana == 6) {
            if ($hora > $ultimaHoraDeAtencion) {

                $diasASumar = 1;


            } elseif ($hora == $ultimaHoraDeAtencion) {


                if ($minuto > 30) {
                    $diasASumar = 1;
                } else {
                    $diasASumar = 0;
                }

            } elseif ($hora < $ultimaHoraDeAtencion) {
                $diasASumar = 0;
            }
        }
        if ($diasemana == 7) {
            $diasASumar = 2;
        }


        $fechaDeEnvio = date('Ymd', strtotime(date('Y-m-d', $timeStamp) . " + $diasASumar days"));
        return $fechaDeEnvio;

    }

    public function addPedido($idCliente, $direccionPedido,
                              $pedidoTelefono, $pedidoObservaciones, $precioTotal, $puntosGanados, $lastFour,
                              $cardNumber, $horaPedido, $brand, $saldoReducido = 0, $idHorario, $delivery = 'true',
                              $referencia, $distrito,$documento,$razonSocial,$direccionFiscal,$ruc,$latitud,$longitud,$costoEnvioPagado = 0)
    {
        date_default_timezone_set('America/Lima');
        $actualDate = date('Ymd');
        $dateTime = time();

        $fechaEnvio = $this->calcularDiaEnvio($dateTime);

        $sql = "INSERT INTO pedidos (idCliente, direccionPedido, pedidoTelefono,fechaPedido,
pedidoObservaciones,precioTotal,puntosGanados,last_four,card_number,horaPedido,brand,saldoReducido,dateTime,idHorario,delivery,fechaEnvio,referencia,distrito,documento,razonSocial,direccionFiscal,ruc,latitud,longitud,costoEnvioPagado)
                     VALUES ('$idCliente','$direccionPedido','$pedidoTelefono','$actualDate','$pedidoObservaciones','$precioTotal','$puntosGanados','$lastFour'
                     ,'$cardNumber','$horaPedido','$brand','$saldoReducido','$dateTime','$idHorario','$delivery','$fechaEnvio','$referencia','$distrito','$documento','$razonSocial','$direccionFiscal','$ruc','$latitud','$longitud','$costoEnvioPagado')";
        $id = AccesoBD::InsertAndGetLastId($this->cn, $sql);
        return $id;
    }

    public function addPedidoSanBorja($idCliente, $direccionPedido,
                              $pedidoTelefono, $pedidoObservaciones, $precioTotal, $puntosGanados, $lastFour,
                              $cardNumber, $horaPedido, $brand, $saldoReducido = 0, $idHorario, $delivery = 'true', $local_distrito ,
                              $referencia, $distrito,$documento,$razonSocial,$direccionFiscal,$ruc,$latitud,$longitud,$costoEnvioPagado = 0)
    {
        date_default_timezone_set('America/Lima');
        $actualDate = date('Ymd');
        $dateTime = time();

        $fechaEnvio = $this->calcularDiaEnvio($dateTime);

        $sql = "INSERT INTO pedidos (idCliente, direccionPedido, pedidoTelefono,fechaPedido,
pedidoObservaciones,precioTotal,puntosGanados,last_four,card_number,horaPedido,brand,saldoReducido,dateTime,idHorario,delivery, local_distrito, fechaEnvio,referencia,distrito,documento,razonSocial,direccionFiscal,ruc,latitud,longitud,costoEnvioPagado)
                     VALUES ('$idCliente','$direccionPedido','$pedidoTelefono','$actualDate','$pedidoObservaciones','$precioTotal','$puntosGanados','$lastFour'
                     ,'$cardNumber','$horaPedido','$brand','$saldoReducido','$dateTime','$idHorario','$delivery', '$local_distrito', '$fechaEnvio','$referencia','$distrito','$documento','$razonSocial','$direccionFiscal','$ruc','$latitud','$longitud','$costoEnvioPagado')";
        $id = AccesoBD::InsertAndGetLastId($this->cn, $sql);
        return $id;
    }

    public function addItemsPedido($sql)
    {

        $id = AccesoBD::addMultiQuery($this->cn, $sql);
        return $id;
    }

    public function getFeedBackTokenByIdPedido($idPedido)
    {
        try {
            $sql = "SELECT idPedido,feedBackToken FROM pedidos where idPedido = '$idPedido'";
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

    public function updateFeedBackStatus($idPedido)
    {

        $sql = "UPDATE pedidos SET feedBackToken = '' WHERE idPedido = '$idPedido'";
        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }


}

