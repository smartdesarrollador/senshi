<?php
error_reporting(0);
// initialize shopping cart class
include '../class/Cart.php';
include '../class/TiendaClass.php';

$objTienda = new TiendaClass();
$costoEnvio = $objTienda->getCostoEnvio()['costoDelivery'];
$cart = new Cart;
$cart->setCostoEnvio($costoEnvio);

// include database configuration file
include 'dbConfig.php';
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {

    if ($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])) {

        $productID = $_REQUEST['id'];
        $cantidad = $_REQUEST['cantidad'];
        if ($cantidad > 0) {
            // get product details
            $query = $db->query("SET NAMES 'utf8'");
            $query = $db->query("SELECT * FROM productos WHERE idProducto = " . $productID);
            $row = $query->fetch_assoc();


            //get product ingredientes ( BOWL,Shawarma premium y falafel premium )
            $productoIngredientes = '';

             /* Tacos */
             if(isset($_REQUEST['shake'])){
                $shake = $_REQUEST['shake']; 
                $productoIngredientes = $productoIngredientes." + ".$shake;
                }
    
                if(isset($_REQUEST['katsuo'])){
                $katsuo = $_REQUEST['katsuo'];
                $productoIngredientes = $productoIngredientes." + ".$katsuo; 
                }
    
                if(isset($_REQUEST['tnt'])){
                $tnt = $_REQUEST['tnt']; 
                $productoIngredientes = $productoIngredientes." + ".$tnt;
                }
                /* End Tacos */

            if (isset($_REQUEST['productoIngredientes'])) {
                $productoIngredientes = $_REQUEST['productoIngredientes'];
            }

            //get
            $giftTipo = '';
            $emailGift = '';
            $dedicatoriaGift = '';
            $acumulaNPuntos = 0;
            if (isset($_REQUEST['dirigidoA'])) {

                $giftTipo = $_REQUEST['dirigidoA'];
                $emailGift = trim($_REQUEST['emailGift']);
                $dedicatoriaGift = trim($_REQUEST['dedicatoriaGift']);
            }
            if ($row['precioProducto']>30 && $row['productoObservaciones'] != 'GIFT_CARD' && $row['productoObservaciones'] != 'SINPUNTOS'){
                $acumulaNPuntos = 10;
            }

            $itemData = array(
                'id' => $row['idProducto'],
                'name' => $row['nombreProducto'],
                'price' => $row['precioProducto'],
                'imagenProducto' => $row['imagenProducto'],
                'qty' => $cantidad,
                'acumulaPuntos' => $acumulaNPuntos,
                'productoObservaciones' => $row['productoObservaciones'],
                'productoIngredientes' => $productoIngredientes,
                'giftTipo' => $giftTipo,
                'emailGift' => $emailGift,
                'dedicatoriaGift' => $dedicatoriaGift,
                'giftValor' => $row['giftValor'],
                'programable' => $row['programable']
            );


            $insertItem = $cart->insert($itemData);
            $redirectLoc = $insertItem ? '../carrito.php' : '../index.php';
            header("Location: " . $redirectLoc);
        } else {
            header("Location: ../index.php");
        }
    } elseif ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])) {

        if ($_REQUEST['qty'] == 0) {

            $deleteItem = $cart->remove($_REQUEST['id']);
            header("Location: ../carrito.php");
            exit();
        }


        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        /*  print_r($itemData);
          exit();*/
        $updateItem = $cart->update($itemData);

        $redirectLoc = $updateItem ? '../carrito.php' : '../index.php';
        header("Location: " . $redirectLoc);

        //ajax
        /*echo $updateItem ? 'ok' : 'err';
        die;*/

    } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: ../carrito.php");
    } elseif ($_REQUEST['action'] == 'destroyCart') {
        $cart->destroy();
        header("Location: ../carrito.php");

    } elseif ($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['current_customer_idCliente'])) {

        $idCliente = $_SESSION['current_customer_idCliente'];
        $direccion = $_SESSION['current_customer_direccion'];
        $telefono = $_SESSION['current_customer_telefono'];
        $observaciones = $_SESSION['current_customer_mensaje'];
        $date = date("Y-m-d H:i:s");
        $total = $cart->total();


        $sqlOrden = "INSERT INTO pedidos (idCliente, direccionPedido, pedidoTelefono,fechaPedido,pedidoObservaciones,precioTotal) 
                     VALUES ('$idCliente','$direccion','$telefono','$date','$observaciones','$total')";

        $insertOrder = $db->query($sqlOrden);

        /*if ($insertOrder) {
            $orderID = $db->insert_id;
            $sql = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach ($cartItems as $item) {
                $sql .= "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('" . $orderID . "', '" . $item['id'] . "', '" . $item['qty'] . "');";
            }
            // insert order items into database
            $insertOrderItems = $db->multi_query($sql);

            if ($insertOrderItems) {
                $cart->destroy();
                header("Location: orderSuccess.php?id=$orderID");
            } else {
                header("Location: checkout.php");
            }
        } else {*/
        header("Location: exito.php");
        /*   }*/
    } else {
        header("Location: index.php");
    }


} else {
    header("Location: ../index.php");
}
