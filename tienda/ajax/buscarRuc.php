<?php
session_start();
error_reporting(0);
header('Content-Type: application/json');
if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {
} else {
    http_response_code(500);
    exit();
}


$ruc = trim($_REQUEST['ruc']);

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
);

echo file_get_contents('http://api.sunat.cloud/ruc/'.$ruc,false,stream_context_create(array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false))));
