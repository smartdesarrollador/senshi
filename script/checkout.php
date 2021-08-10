<?php
include '../class/Cart.php';
include '../class/Pedido.php';
include '../class/ClienteClass.php';
require '../class/TiendaClass.php';
error_reporting(0);
function my_simple_crypt($string, $action = 'e')
{
    // you may change these values to your own
    $secret_key = 'enfocussoluciones';
    $secret_iv = 'enfocussoluciones';

    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 16);

    if ($action == 'e') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
    } else if ($action == 'd') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    return $output;
}
$objTienda = new TiendaClass();
$cart = new Cart;
$objPedido = new Pedido();

$objCliente = new ClienteClass();
include '../class/Consumo.php';
$objConsumo = new Consumo();

$cliente = $objCliente->getAllInformationUserById($_SESSION['current_customer_idCliente']);
$saldoBilletera = round($cliente['saldoBilletera']);


$costoEnvio = trim($objTienda->getCostoEnvio()['costoDelivery']);


$cartItems = $cart->contents();

//sacar cuantos puntos esta ganando por este pedido
$puntosGanados = 0;

foreach ($cartItems as $item) {
    $puntosGanados += $item['subtotalPuntos'];
}


require '../vendor/autoload.php';




if ($_SESSION['finalStoreTienda'] == 1) {
    //Llave Secreta Integracion Shisoku
    $SECRET_KEY = "sk_test_54114b6d8381cefe";


    //Llave Secreta Produccion Shisoku
    /* $SECRET_KEY = "sk_live_20f93d969f1f1b90"; */
}

if ($_SESSION['finalStoreTienda'] == 2) {
    //Llave Secreta Integracion Fumiko
    //$SECRET_KEY = "sk_test_9f3671c924166f60";


    //Llave Secreta Produccion Fumiko
    $SECRET_KEY = "sk_live_942a8264f26964d1";
}

if ($_SESSION['local'] == 'lince') {
    //Llave Secreta Integracion Shisoku
    //$SECRET_KEY = "sk_test_54114b6d8381cefe";


    //Llave Secreta Produccion Shisoku
    $SECRET_KEY = "sk_live_20f93d969f1f1b90";
}

if ($_SESSION['local'] == 'san_borja') {
    //Llave Secreta Integracion Fumiko
    //$SECRET_KEY = "sk_test_9f3671c924166f60";


    //Llave Secreta Produccion Fumiko
    $SECRET_KEY = "sk_live_942a8264f26964d1";
}



$culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));



$token = $_REQUEST["token"];
$nombre = $_SESSION["current_customer_nombre"];
$apellido = $_SESSION['current_customer_apellido'];
$telefono = $_SESSION['current_customer_telefono'];
$direccion = $_SESSION['current_customer_direccion'];
$email = $_SESSION['current_customer_email'];
$observaciones = $_SESSION['current_customer_mensaje'];

$conPuntos = false;
$descuento = 0;

$firstTotal = $cart->total();


if ($cliente['puntos'] >= 200) {
    $conPuntos = true;
    $observaciones = $observaciones . " - " . "(TIENE 200 PUNTOS, ENVIAR MEDIO MAKI ADICIONAL)";
}
$consaldo = false;
if ($saldoBilletera > 0) {
    $firstTotal = $firstTotal - $saldoBilletera;
    $consaldo = true;
    $observaciones = $observaciones . " - " . "(PEDIDO PAGADO PARCIALMENTE CON BILLETERA VIRTUAL)";
}
/*
 * si solo hay gift cards, reseteamos todo
 * */
if ($_SESSION['solo_gift_cards'] === 'true') {
    $firstTotal = $cart->total();
    $consaldo = false;
    $conPuntos = false;
}

$total = $firstTotal * 100 + ($_SESSION['finalShippingCost'] * 100);


if (strlen($direccion) <= 5) {
    $direccion = '--------';
}
try {
    $charge = $culqi->Charges->create(
        array(
            "amount" => $total,
            "capture" => true,
            "currency_code" => "PEN",
            "description" => "Venta de Platos",
            "email" => trim($email),
            "installments" => 0,
            "antifraud_details" => array(
                "address" => $direccion,
                "address_city" => "LIMA",
                "country_code" => "PE",
                "first_name" => preg_replace('/\d+/', '', substr($nombre . ' ' . $apellido, 0, 45)),
                "last_name" => preg_replace('/\d+/', '', substr($nombre . ' ' . $apellido, 0, 45)),
                "phone_number" => str_replace(' ', '', $telefono),
            ),
            "source_id" => $token
        )
    );


    $chargeArr = (array)$charge;

    $tarjeta = (array)$chargeArr['source'];
    $iin = (array)$tarjeta['iin'];

    /*print_r($tarjeta);*/
    $customerID = $_SESSION['current_customer_idCliente'];
    $lastFour = $tarjeta['last_four'];
    $brand = $iin['card_brand'];
    $card_number = $tarjeta['card_number'];
    $totalPipe = $total / 100;
    date_default_timezone_set('America/Lima');
    $fechaPedido = $cart->fechaCastellano(date('d-m-Y H:i:s'));
    $horaPedido = date('H:i:s');


    if ($conPuntos) {
        $objCliente->reducirPuntosCliente($_SESSION['current_customer_idCliente'], 200);
    }
    if ($consaldo) {
        $objCliente->reducirSaldoCliente($_SESSION['current_customer_idCliente'], $saldoBilletera);
        $objConsumo->addNewConsumo($_SESSION['current_customer_idCliente'], $saldoBilletera, 'WEB');
    }

    $horarioPedido = $_SESSION['horario_pedido'];


    //*SI ES BOLETA O FACTURA*/

    $razonSocial = '';
    $direccionFiscal = '';
    $ruc = '';
    if ($_SESSION['current_customer_tipoDocumento'] == 'factura') {
        $razonSocial = $_SESSION['current_customer_razonSocial'];
        $direccionFiscal = $_SESSION['current_customer_direccionFiscal'];
        $ruc = $_SESSION['current_customer_ruc'];
    }


    /* DELIVERY O RECOJO EN TIENDA */

    $distrito = $_SESSION['$current_customer_distrito'];
    $referencia = $_SESSION['$current_customer_referencia'];
    $latitud = $_SESSION['current_customer_lat'];
    $longitud = $_SESSION['current_customer_lng'];

    if ($_SESSION['local'] == 'lince') {
        if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
            $pedidoInsertado = $objPedido->addPedido(
                $customerID,
                '-',
                $telefono,
                $observaciones,
                $totalPipe,
                $puntosGanados,
                $lastFour,
                $card_number,
                $horaPedido,
                $brand,
                $saldoBilletera,
                1,
                'false',
                '-',
                '-',
                $_SESSION['current_customer_tipoDocumento'],
                $razonSocial,
                $direccionFiscal,
                $ruc,
                $latitud,
                $longitud,
                0
            );
        }
    }





    if ($_SESSION['finalStoreTienda'] == 1) {

        $pedidoInsertado = $objPedido->addPedido(
            $customerID,
            $direccion,
            $telefono,
            $observaciones,
            $totalPipe,
            $puntosGanados,
            $lastFour,
            $card_number,
            $horaPedido,
            $brand,
            $saldoBilletera,
            $horarioPedido,
            'true',
            $referencia,
            $distrito,
            $_SESSION['current_customer_tipoDocumento'],
            $razonSocial,
            $direccionFiscal,
            $ruc,
            $latitud,
            $longitud,
            $_SESSION['finalShippingCost']
        );
    }




    if ($_SESSION['local'] == 'san_borja') {
        if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
            $pedidoInsertado = $objPedido->addPedidoSanBorja(
                $customerID,
                '-',
                $telefono,
                $observaciones,
                $totalPipe,
                $puntosGanados,
                $lastFour,
                $card_number,
                $horaPedido,
                $brand,
                $saldoBilletera,
                1,
                'false',
                'san_borja',
                '-',
                '-',
                $_SESSION['current_customer_tipoDocumento'],
                $razonSocial,
                $direccionFiscal,
                $ruc,
                $latitud,
                $longitud,
                0
            );
        }
    }






    if ($_SESSION['finalStoreTienda'] == 2) {

        $pedidoInsertado = $objPedido->addPedidoSanBorja(
            $customerID,
            $direccion,
            $telefono,
            $observaciones,
            $totalPipe,
            $puntosGanados,
            $lastFour,
            $card_number,
            $horaPedido,
            $brand,
            $saldoBilletera,
            $horarioPedido,
            'true',
            'san_borja',
            $referencia,
            $distrito,
            $_SESSION['current_customer_tipoDocumento'],
            $razonSocial,
            $direccionFiscal,
            $ruc,
            $latitud,
            $longitud,
            $_SESSION['finalShippingCost']
        );
    }






    /*  END DELIVERY O RECOJO EN TIENDA */


    $multiquery = '';
    $agregarPuntos = 0;
    $itemsHtml = '';
    $subtotal = 0;

    error_log(print_r($cartItems, true) . '---' . date("Y/m/d") .
        " " . date("h:i:sa") . "\n" . "\n" . "\n", 3, "log/items.log");

    foreach ($cartItems as $item) {

        $subtotal = $subtotal + $item['subtotal'];
        $itemsHtml .= '
 <tr>
    <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #ff0000;  line-height: 18px;  vertical-align: top; padding:10px 0;text-transform: lowercase"
    class="article">
     ' . $item['name'] . '
      </td>
       <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #646a6e;  line-height: 18px;  vertical-align: top; padding:10px 0;"
        align="center">' . $item['qty'] . '
        </td>
        <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #1e2b33;  line-height: 18px;  vertical-align: top; padding:10px 0;"
        align="right">S/ ' . $item['price'] . '
        </td>
         </tr>
';
        $agregarPuntos += $item['subtotalPuntos'];

        /*
          * GIFT para compra personal CARD AGREGADO
          * */
        if ($item['giftTipo'] == 'personal') {
            $multiquery .= "INSERT INTO pedido_items (idPedido,idProducto,cantidad,item_descripcion,giftTipo,giftTotalValorRecargado) VALUES ('" . $pedidoInsertado . "', '" . $item['id'] . "', '" . $item['qty'] . "', '" . $item['productoObservaciones'] . "', '" . $item['giftTipo'] . "', '" . $item['subtotalGiftValor'] . "');";
            $objCliente->updateClienteSaldo($_SESSION['current_customer_idCliente'], $item['subtotalGiftValor']);
        } /*
         *------------------------------------ GIFT para compra a otro usuario  AGREGADO
         * falta algregar el multiquery
         * */ elseif ($item['giftTipo'] == 'regalo') {

            $countCustomer = count($objCliente->getEmailCustomerByEmail($item['emailGift']));
            /*---------------------------------------CLIENTE YA ESTA REGISTRADO*/
            $idDestinatario = '';
            if ($countCustomer > 0) {
                /* EL CLIENTE YA ESTA REGISTRADO Y OBTENEMOS TODOS LOS DATOS */


                $clienteEXistente = $objCliente->getAllInformationUserByEmail($item['emailGift']);
                $idDestinatario = $clienteEXistente['idCliente'];

                /*     $xxx=  $objCliente->updateClienteSaldo($clienteEXistente['idCliente'], $item['subtotalGiftValor']);
                       */
                $mensaje = '<div>
    <div style="background-color:#f2f3f5;padding:20px">
        <div style="max-width:600px;margin:0 auto">
            <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #9C0001;margin-bottom:20px">

                <div style="border-bottom:1px solid #f2f3f5;padding:20px 30px">

                    <img id="m_7479378229902740556logo" width="150" style="max-width:99px;display:block" src="https://senshi.pe/img/logo2.png" alt="Logo Senshi" class="CToWUd">

                </div>


                <div style="margin:0px auto;padding:0px;text-align:center;color:#505763" id="m_7479378229902740556gift-card">
                    <div style="background:#fff;margin:15px auto;width:468px">
                        <div style="background:#fff;color:#505763;padding:15px 15px 0px 15px;text-align:left">
        <span style="display:block;font-size:16px;font-weight:bold">
            <a href="#m_7479378229902740556_" style="text-decoration:none;color:#000">
            ¡' . $_SESSION['current_customer_nombre'] . ' te ha enviado un regalo!
            </a>
        </span>
                        </div>

                        <div style="padding:15px">
                            <div style="background:#fff;padding:0px 5px 5px;text-align:left"><a  style="text-decoration:none;color:#000">
                                    ' . $item['dedicatoriaGift'] . ' -' . $_SESSION['current_customer_nombre'] . '</a></div>
                        </div>

                        <div style="background:#fff;font-size:16px;padding:15px">
                            <img style="max-width:100%" src="https://senshi.pe/img/carta/platos/' . $item['imagenProducto'] . '" class="CToWUd a6T" tabindex="0">
                            <a style="display:inline-block;font-weight:bold;margin-top:10px;color:#505763;text-decoration:none"
                                target="_blank" >' . $item['name'] . '</a>

                        </div>

                        <div style="background:#fff;padding:10px">
                            <div>
                                <a  style="padding:10px 15px;background:#ec5252;display:inline-block;border-radius:2px;color:#fff;font-weight:bold;font-size:17px;text-decoration:none" href="https://senshi.pe" target="_blank" >
                                    INICIA SESIÓN EN TU CUENTA
                                </a>
                            </div>
                            <div style="padding:0px;background:#fff;color:#686f7a">
                                <span style="display:inline-block;padding:10px 10px">O</span>
                            </div>
                            <div style="background:#fff;font-size:12px">
                                Ve a <a href="https://senshi.pe">https://senshi.pe</a>
                            </div>
                        </div>
                        <div style="background:#fff;font-size:12px;padding:20px 0px 15px">
                            Este regalo es para:
                            <b>' . $clienteEXistente['nombre'] . ' ' . $clienteEXistente['apellido'] . '</b> <a href="mailto:' . $clienteEXistente['email'] . '" target="_blank">' . $clienteEXistente['email'] . '</a>
                        </div>
                    </div>
                </div>




            </div>
            <div style="font:11px sans-serif;color:#686f7a">
                <p style="font-size:11px;color:#686f7a">

                    JULIO CESAR TELLO 885, LINCE

                </p>
            </div>
        </div>
    </div>
   </div>';

                $to = $clienteEXistente['email'];
                $subject = "Hola, " . $clienteEXistente['nombre'] . " " . $clienteEXistente['apellido'] . ": ¡" . $_SESSION['current_customer_nombre'] . " te ha enviado un regalo!";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                /*CAMBIAR ESTE ENLACE*/
                $headers .= 'From: SENSHI - AVISOS<noreply@senshi.pe>' . "\r\n";
                mail($to, $subject, $mensaje, $headers);
            } else {
                /*
                TO DO
                EL CLIENTE DESTINATARIO NO ESTA REGISTRADO, tenemos que registrarlo y asociarle un codigo QR */
                $configAccountToken = uniqid('E');
                $idDestinatario = $objCliente->addNewClienteSinCuentaConfigurada($item['emailGift'], $configAccountToken);

                /*generando QR*/
                $idEncriptado = my_simple_crypt($idDestinatario);
                $urlQR = 'https://senshi.pe/r.php?u=' . $idEncriptado;
                $nombreFoto = $idEncriptado . '.png';

                $apiQR = file_get_contents('https://worksafetytech.com/utils/qrGeneratorMaxSize.php?content=' . $urlQR);
                file_put_contents('../img/qrCodes/' . $nombreFoto, $apiQR);
                $objCliente->updateClienteQR($idDestinatario, $nombreFoto);
                /*END*/

                $urlConfigACcount = 'https://senshi.pe/r.php?c=' . $configAccountToken . '&id=' . $idDestinatario;

                $mensaje = '<div>
    <div style="background-color:#f2f3f5;padding:20px">
        <div style="max-width:600px;margin:0 auto">
            <div style="background:#fff;font:14px sans-serif;color:#686f7a;border-top:4px solid #9C0001;margin-bottom:20px">

                <div style="border-bottom:1px solid #f2f3f5;padding:20px 30px">

                    <img id="m_7479378229902740556logo" width="150" style="max-width:99px;display:block" src="https://senshi.pe/img/logo2.png" alt="Logo Senshi" class="CToWUd">

                </div>


                <div style="margin:0px auto;padding:0px;text-align:center;color:#505763" id="m_7479378229902740556gift-card">
                    <div style="background:#fff;margin:15px auto;width:468px">
                        <div style="background:#fff;color:#505763;padding:15px 15px 0px 15px;text-align:left">
        <span style="display:block;font-size:16px;font-weight:bold">
            <a href="#m_7479378229902740556_" style="text-decoration:none;color:#000">
            ¡' . $_SESSION['current_customer_nombre'] . ' te ha enviado un regalo!
            </a>
        </span>
                        </div>

                        <div style="padding:15px">
                            <div style="background:#fff;padding:0px 5px 5px;text-align:left"><a  style="text-decoration:none;color:#000">
                                    ' . $item['dedicatoriaGift'] . ' -' . $_SESSION['current_customer_nombre'] . '</a></div>
                        </div>

                        <div style="background:#fff;font-size:16px;padding:15px">
                            <img style="max-width:100%" src="https://senshi.pe/img/carta/platos/' . $item['imagenProducto'] . '" class="CToWUd a6T" tabindex="0">
                            <a style="display:inline-block;font-weight:bold;margin-top:10px;color:#505763;text-decoration:none"
                                target="_blank" >' . $item['name'] . '</a>

                        </div>

                        <div style="background:#fff;padding:10px">
                            <div>
                                <a  style="padding:10px 15px;background:#ec5252;display:inline-block;border-radius:2px;color:#fff;font-weight:bold;font-size:17px;text-decoration:none" href="' . $urlConfigACcount . '" target="_blank" >
                                    Desenvuelve tu regalo
                                </a>
                            </div>
                            <div style="padding:0px;background:#fff;color:#686f7a">
                                <span style="display:inline-block;padding:10px 10px">O</span>
                            </div>
                            <div style="background:#fff;font-size:12px">
                                Ve a <a href="' . $urlConfigACcount . '">' . $urlConfigACcount . '</a>
                            </div>
                        </div>
                        <div style="background:#fff;font-size:12px;padding:20px 0px 15px">
                            Este regalo es para:</b> <a href="mailto:' . $item['emailGift'] . '" target="_blank">' . $item['emailGift'] . '</a>
                        </div>
                    </div>
                </div>




            </div>
            <div style="font:11px sans-serif;color:#686f7a">
                <p style="font-size:11px;color:#686f7a">

                   
                     JULIO CESAR TELLO 885, LINCE

                </p>
            </div>
        </div>
    </div>
   </div>';

                $to = $item['emailGift'];
                $subject = "Hola, " . $_SESSION['current_customer_nombre'] . " te ha enviado un regalo!";

                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type: text/html; charset=UTF-8\r\n";
                /*CAMBIAR ESTE ENLACE*/
                $headers .= 'From: SENSHI- AVISOS<noreply@senshi.pe>' . "\r\n";
                mail($to, $subject, $mensaje, $headers);
            }
            $multiquery .= "INSERT INTO pedido_items (idPedido,idProducto,cantidad,item_descripcion,giftTipo,giftTotalValorRecargado,giftDestinatario) 
VALUES ('" . $pedidoInsertado . "', '" . $item['id'] . "', '" . $item['qty'] . "', '" . $item['productoObservaciones'] . "', '" . $item['giftTipo'] . "', '" . $item['subtotalGiftValor'] . "', '" . $idDestinatario . "');";
            $objCliente->updateClienteSaldo($idDestinatario, $item['subtotalGiftValor']);
        } else {
            $multiquery .= "INSERT INTO pedido_items (idPedido,idProducto,cantidad,item_descripcion) VALUES ('" . $pedidoInsertado . "', '" . $item['id'] . "', '" . $item['qty'] . "', '" . $item['productoIngredientes'] . "');";
        }
    }
    $objCliente->aumentarPuntosCliente($_SESSION['current_customer_idCliente'], $agregarPuntos);


    $pedidoItems = $objPedido->addItemsPedido($multiquery);


    /*ENVIAR CORREO CON LA ORDEN*/
    $mensaje = '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="robots" content="noindex,nofollow"/>
<meta name="viewport" content="width=device-width; initial-scale=1.0;"/>
<style type="text/css">
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);

    body {
        margin: 0;
        padding: 0;
        background: #e1e1e1;
    }

    div, p, a, li, td {
        -webkit-text-size-adjust: none;
    }

    .ReadMsgBody {
        width: 100%;
        background-color: #ffffff;
    }

    .ExternalClass {
        width: 100%;
        background-color: #ffffff;
    }

    body {
        width: 100%;
        height: 100%;
        background-color: #e1e1e1;
        margin: 0;
        padding: 0;
        -webkit-font-smoothing: antialiased;
    }

    html {
        width: 100%;
    }

    p {
        padding: 0 !important;
        margin-top: 0 !important;
        margin-right: 0 !important;
        margin-bottom: 0 !important;
        margin-left: 0 !important;
    }

    .visibleMobile {
        display: none;
    }

    .hiddenMobile {
        display: block;
    }

    @media only screen and (max-width: 600px) {
        body {
            width: auto !important;
        }

        table[class=fullTable] {
            width: 96% !important;
            clear: both;
        }

        table[class=fullPadding] {
            width: 85% !important;
            clear: both;
        }

        table[class=col] {
            width: 45% !important;
        }

        .erase {
            display: none;
        }
    }

    @media only screen and (max-width: 420px) {
        table[class=fullTable] {
            width: 100% !important;
            clear: both;
        }

        table[class=fullPadding] {
            width: 85% !important;
            clear: both;
        }

        table[class=col] {
            width: 100% !important;
            clear: both;
        }

        table[class=col] td {
            text-align: left !important;
        }

        .erase {
            display: none;
            font-size: 0;
            max-height: 0;
            line-height: 0;
            padding: 0;
        }

        .visibleMobile {
            display: block !important;
        }

        .hiddenMobile {
            display: none !important;
        }
    }
</style>

<!-- Header -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    <tr>
        <td height="20"></td>
    </tr>
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                   bgcolor="#ffffff" style="border-radius: 10px 10px 0 0;">
                <tr class="hiddenMobile">
                    <td height="40"></td>
                </tr>
                <tr class="visibleMobile">
                    <td height="30"></td>
                </tr>

                <tr>
                    <td>
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                               class="fullPadding">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="left"
                                           class="col">
                                        <tbody>
                                        <tr>
                                            <td align="left"><img src="https://senshi.pe/img/logo2.png" width="100"
                                                                  alt="logo" border="0"/></td>
                                        </tr>
                                        <tr class="hiddenMobile">
                                            <td height="40"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; color: #5b5b5b; font-family: \'Open Sans\', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                                Hola, ' . $nombre . '
                                                <br> Gracias por comprar en nuestra tienda.
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="right"
                                           class="col">
                                        <tbody>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td height="5"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 21px; color: #ff0000; letter-spacing: -1px; font-family: \'Open Sans\', sans-serif; line-height: 1; vertical-align: top; text-align: right;">
                                                Tu Orden
                                            </td>
                                        </tr>
                                        <tr>
                                        <tr class="hiddenMobile">
                                            <td height="50"></td>
                                        </tr>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; color: #5b5b5b; font-family: \'Open Sans\', sans-serif; line-height: 18px; vertical-align: top; text-align: right;">
                                                <small>ORDEN</small> ' . str_pad($pedidoInsertado, 8, "0", STR_PAD_LEFT) . '<br/>
                                                <small>' . $fechaPedido . '</small>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<!-- /Header -->
<!-- Order Details -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    <tbody>
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                   bgcolor="#ffffff">
                <tbody>
                <tr>
                <tr class="hiddenMobile">
                    <td height="60"></td>
                </tr>
                <tr class="visibleMobile">
                    <td height="40"></td>
                </tr>
                <tr>
                    <td>
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                               class="fullPadding">
                            <tbody>
                            <tr>
                                <th style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 10px 7px 0;"
                                    width="52%" align="left">
                                    Producto
                                </th>
                                <th style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #5b5b5b; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                    align="center">
                                    Cantidad
                                </th>
                                <th style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #1e2b33; font-weight: normal; line-height: 1; vertical-align: top; padding: 0 0 7px;"
                                    align="right">
                                    Subtotal
                                </th>
                            </tr>
                            <tr>
                                <td height="1" style="background: #bebebe;" colspan="4"></td>
                            </tr>
                            <tr>
                                <td height="10" colspan="4"></td>
                            </tr>
                            
                          ' . $itemsHtml . '
                            
                            
                            <tr>
                                <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
                            </tr>

                            <tr>
                                <td height="1" colspan="4" style="border-bottom:1px solid #e4e4e4"></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="20"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- /Order Details -->
<!-- Total -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    <tbody>
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                   bgcolor="#ffffff">
                <tbody>
                <tr>
                    <td>

                        <!-- Table Total -->
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                               class="fullPadding">
                            <tbody>
                            <tr>
                                <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    Subtotal
                                </td>
                                <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                    width="80">
                                  S/ ' . $subtotal . '
                                </td>
                            </tr> 
                            
                            <tr>
                                <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    Descuento
                                </td>
                                <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; white-space:nowrap;"
                                    width="80">
                                  S/ ' . $descuento . '
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    Costo de Envío
                                </td>
                                <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #646a6e; line-height: 22px; vertical-align: top; text-align:right; ">
                                    S/ ' . $_SESSION['finalShippingCost'] . '
                                </td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                    <strong>Total (Incl.Envio)</strong>
                                </td>
                                <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #000; line-height: 22px; vertical-align: top; text-align:right; ">
                                    <strong>S/ ' . $totalPipe . '</strong>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <!-- /Table Total -->

                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- /Total -->
<!-- Information -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">
    <tbody>
    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                   bgcolor="#ffffff">
                <tbody>
                <tr>
                <tr class="hiddenMobile">
                    <td height="60"></td>
                </tr>
                <tr class="visibleMobile">
                    <td height="40"></td>
                </tr>
                <tr>
                    <td>
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                               class="fullPadding">
                            <tbody>
                            <tr>
                                <td>
                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="left"
                                           class="col">

                                        <tbody>
                                        <tr>
                                            <td style="font-size: 11px; font-family: \'Open Sans\', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                <strong>INFORMACIÓN DE ENVÍO</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                ' . $_SESSION['current_customer_direccion'] . ' <br>
                                                ' . $_SESSION['current_customer_mensaje'] . '
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>


                                    <table width="220" border="0" cellpadding="0" cellspacing="0" align="right"
                                           class="col">
                                        <tbody>
                                        <tr class="visibleMobile">
                                            <td height="20"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 11px; font-family: \'Open Sans\', sans-serif; color: #5b5b5b; line-height: 1; vertical-align: top; ">
                                                <strong>METODO DE PAGO</strong>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="100%" height="10"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px; font-family: \'Open Sans\', sans-serif; color: #5b5b5b; line-height: 20px; vertical-align: top; ">
                                                Tarjeta de crédito<br> Tarjeta de crédito: ' . $brand . '

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <tr class="hiddenMobile">
                    <td height="60"></td>
                </tr>
                <tr class="visibleMobile">
                    <td height="30"></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<!-- /Information -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable" bgcolor="#e1e1e1">

    <tr>
        <td>
            <table width="600" border="0" cellpadding="0" cellspacing="0" align="center" class="fullTable"
                   bgcolor="#ffffff" style="border-radius: 0 0 10px 10px;">
                <tr>
                    <td>
                        <table width="480" border="0" cellpadding="0" cellspacing="0" align="center"
                               class="fullPadding">
                            <tbody>
                            <tr>
                                <td style="font-size: 12px; color: #5b5b5b; font-family: \'Open Sans\', sans-serif; line-height: 18px; vertical-align: top; text-align: left;">
                                    Que tenga un buen día.
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr class="spacer">
                    <td height="50"></td>
                </tr>

            </table>
        </td>
    </tr>
    <tr>
        <td height="20"></td>
    </tr>
</table>';
    $to = "$email";
    $subject = "Su Orden - Senshi";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: text/html; charset=UTF-8\r\n";
    /*CAMBIAR ESTE ENLACE*/
    $headers .= 'From: SENSHI - AVISOS<noreply@senshi.pe>' . "\r\n";
    mail($to, $subject, $mensaje, $headers);


    //ACTUALIZAR PUNTOS EN SESION
    $_SESSION['current_customer_puntos'] = $objCliente->getUserPuntos($_SESSION['current_customer_idCliente'])['puntos'];


    $cart->destroy();
    header('location: ../paymentSuccess.php?orderId=' . $pedidoInsertado . '&amount=' . $totalPipe);
} catch (Exception $ex) {

    date_default_timezone_set('America/Lima');

    $log = "Compra Fallida IDCLIENTE: " . $_SESSION['current_customer_idCliente'] . "\n" .
        "EMAIL: " . $email . "\n" .
        "Mensaje" . $ex->getMessage() .
        "Hora y fecha: " . date("Y/m/d") . " " . date("h:i:sa") . "\n" . "\n";

    error_log($log, 3, "log/payments.log");

    header('location: ../paymentError.php');
}
