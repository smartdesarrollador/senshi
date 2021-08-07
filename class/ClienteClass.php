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
require_once "Helper.php";

class ClienteClass
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

    public function getUserByEmail($email)
    {
        try {
            $sql = "SELECT * FROM clientes where email = '$email'";
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

    public function getClienteByIDAndConfigurationToken($idCliente, $configToken)
    {
        try {
            $sql = "SELECT * FROM clientes where idCliente = '$idCliente' and configAccountToken ='$configToken'";
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

    public function getEmailCustomerByEmail($email)
    {
        try {
            $sql = "SELECT idCliente,email,cuentaConfigurada,configAccountToken FROM clientes where email = '$email'";
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

    public function addNewCustomer($nombre, $apellido, $email, $celular, $password)
    {
        date_default_timezone_set('America/Lima');
        $actualDate = date('Ymd');
        $sql = "INSERT INTO clientes(nombre,apellido,email,celular,password,fechaRegistro)
					VALUES('$nombre','$apellido','$email','$celular','$password','$actualDate')";
        $id = AccesoBD::InsertAndGetLastId($this->cn, $sql);
        return $id;
    }


    public function addNewClienteSinCuentaConfigurada($email, $configAccountToken)
    {
        date_default_timezone_set('America/Lima');
        $actualDate = date('Ymd');
        $sql = "INSERT INTO clientes(email,fechaRegistro,cuentaConfigurada,configAccountToken)
					VALUES('$email','$actualDate','false','$configAccountToken')";
        $id = AccesoBD::InsertAndGetLastId($this->cn, $sql);
        return $id;
    }

    public function getUserPasswordByEmail($email)
    {
        try {
            $sql = "SELECT password FROM clientes where email = '$email'";
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

    public function getAllInformationUserByEmail($email)
    {
        try {
            $sql = "SELECT * FROM clientes where email = '$email'";
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

    public function getAllInformationUserById($idCliente)
    {
        try {
            $sql = "SELECT * FROM clientes where idCliente = '$idCliente'";
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

    public function addAcccountReoveryToken($token, $email)
    {

        $sql = "UPDATE clientes SET passRecoveryToken = '$token' WHERE email =  '$email' ";
        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function updateClienteSaldo($idCliente, $saldo)
    {

        $sql = "UPDATE clientes SET saldoBilletera = saldoBilletera+'$saldo' WHERE idCliente = '$idCliente'";
        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function getUserByTknTokenAndEmail($tkn, $email)
    {
        try {
            $sql = "SELECT * FROM clientes where passRecoveryToken = '$tkn' and email = '$email'";
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

    public function getUserByAccountRecoveryTokenAndEmail($tkn, $email)
    {
        try {
            $sql = "SELECT * FROM clientes where passRecoveryToken = '$tkn' and email = '$email'";
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

    public function changeUserPasswordByRecoveryToken($passRecoveryToken, $email, $password)
    {

        $sql = "UPDATE clientes SET password = '$password', passRecoveryToken ='' WHERE email =  '$email' and passRecoveryToken = '$passRecoveryToken' ";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function updateCustomerDetails($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido = '')
    {

        $sql = "UPDATE clientes SET DNI = '$dni', direccion ='$direccion',celular='$telefono',fechaNacimiento = '$fechaNacimiento',apellido = '$apellido'
                WHERE idCliente =  '$idCliente'  ";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function updateCustomerDetailsWithLatLng($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido = '', $lat, $lng)
    {

        $sql = "UPDATE clientes SET DNI = '$dni', direccion ='$direccion',celular='$telefono',fechaNacimiento = '$fechaNacimiento',apellido = '$apellido',latitud = '$lat',longitud='$lng'
                WHERE idCliente =  '$idCliente'  ";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function updateCustomerAllProfile($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido, $nombre)
    {

        $sql = "UPDATE clientes SET DNI = '$dni', direccion ='$direccion',celular='$telefono',fechaNacimiento = '$fechaNacimiento',apellido = '$apellido',
nombre='$nombre'
                WHERE idCliente =  '$idCliente'  ";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }


    public function configNewCustomerProfile($idCliente, $nombre, $celular, $passoword, $cuentaConfigurada)
    {

        $sql = "UPDATE clientes SET nombre = '$nombre', celular ='$celular',password='$passoword',cuentaConfigurada = '$cuentaConfigurada',configAccountToken = ''
                WHERE idCliente =  '$idCliente'";
        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }


    public function reducirPuntosCliente($idCliente, $puntos)
    {

        $sql = "UPDATE clientes SET puntos = puntos-'$puntos' WHERE idCliente =  '$idCliente'";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function aumentarPuntosCliente($idCliente, $puntos)
    {

        $sql = "UPDATE clientes SET puntos = puntos+'$puntos' WHERE idCliente =  '$idCliente'";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function getUserPuntos($idCliente)
    {
        try {
            $sql = "SELECT puntos FROM clientes where idCliente = '$idCliente'";
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

    public function checkUserFB($email, $oauth_provider, $oauth_uid, $nombre, $apellido)
    {
        $countNombre = count($nombre);
        if (strlen($nombre) <= 3) {
            $nombre = '---';
        }
        if (strlen($apellido) <= 3) {
            $apellido = '---';
        }


        $sql = "SELECT email FROM clientes where email = '$email'";
        $lista = AccesoBD::Consultar($this->cn, $sql);
        if (count($lista) > 0) {
            $sqlUpdate = "UPDATE clientes 
                SET oauth_provider = '$oauth_provider',
                 oauth_uid = '$oauth_uid',
                 nombre = '$nombre',
                 apellido = '$apellido'
                 WHERE email
                =  '$email'";
            AccesoBD::OtroSQL($this->cn, $sqlUpdate);
        } else {

            date_default_timezone_set('America/Lima');
            $actualDate = date('Ymd');
            $sqlInsert = "INSERT INTO clientes(nombre,apellido,email,fechaRegistro)
					VALUES('$nombre','$apellido','$email','$actualDate')";

            /*insertando QR*/
            $objHelper = new Helper();
            $idInsertado = AccesoBD::InsertAndGetLastId($this->cn, $sqlInsert);
            $idEncriptado = $objHelper->my_simple_crypt($idInsertado);
            $urlQR = 'https://senshi.pe/r.php?u=' . $idEncriptado;
            $nombreFoto = $idEncriptado . '.png';
            $apiQR = file_get_contents('https://worksafetytech.com/utils/qrGeneratorMaxSize.php?content=' . $urlQR);
            file_put_contents('../img/qrCodes/' . $nombreFoto, $apiQR);
            $afecteado = $this->updateClienteQR($idInsertado, $nombreFoto);
            /* end insertando qr*/


        }
        return $this->getAllInformationUserByEmail($email);


    }

    public function getAllClients()
    {
        try {
            $sql = "SELECT * FROM clientes";
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

    public function updateClienteQR($idCliente, $imageName)
    {

        $sql = "UPDATE clientes SET qrCode = '$imageName' WHERE idCliente =  '$idCliente'";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }

    public function reducirSaldoCliente($idCliente, $saldo)
    {

        $sql = "UPDATE clientes SET saldoBilletera = saldoBilletera-'$saldo' WHERE idCliente =  '$idCliente'";

        $affectedRows = AccesoBD::OtroSQL($this->cn, $sql);
        return $affectedRows;
    }
}

