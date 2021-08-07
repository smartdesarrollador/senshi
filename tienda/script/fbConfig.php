<?php
if(!session_id()) {
    session_start();
}
error_reporting(0);
require_once '../vendor/autoload.php';
require '../class/ClienteClass.php';

$appId         = '1571346533034037'; //Identificador de la Aplicación
$appSecret     = '93e480dc1a17ec6f0f4a20b99b5f29f7'; //Clave secreta de la aplicación
$redirectURL   = 'https://senshi.pe/tienda/script/fbConfig.php'; //Callback URL
$fbPermissions = array('');  //Permisos opcionales

$objCliente = new ClienteClass();

$fb = new Facebook\Facebook([
    'app_id' => $appId, // Replace {app-id} with your app id
    'app_secret' => $appSecret,
    'default_graph_version' => 'v3.2',
]);


$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

if (! isset($accessToken)) {
    if ($helper->getError()) {
        header("location:../index.php");

        /*   header('HTTP/1.0 401 Unauthorized');
           echo "Error: " . $helper->getError() . "\n";
           echo "Error Code: " . $helper->getErrorCode() . "\n";
           echo "Error Reason: " . $helper->getErrorReason() . "\n";
           echo "Error Description: " . $helper->getErrorDescription() . "\n";*/
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

// Logged in
/*echo '<h3>Access Token</h3>';
var_dump($accessToken->getValue());*/

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
/*echo '<h3>Metadata</h3>';
var_dump($tokenMetadata);*/

// Validation (these will throw FacebookSDKException's when they fail)
$tokenMetadata->validateAppId($appId); // Replace {app-id} with your app id
// If you know the user ID this access token belongs to, you can validate it here
//$tokenMetadata->validateUserId('123');
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
        exit;
    }
    /*    echo '<h3>Long-lived</h3>';
        var_dump($accessToken->getValue());*/
}

/*echo (string) $accessToken;*/

// User is logged in with a long-lived access token.
// You can redirect them to a members-only page.
//header('Location: https://example.com/members.php');

try {
    // Returns a `Facebook\FacebookResponse` object
    $response = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,picture',$accessToken );
} catch(Facebook\Exceptions\FacebookResponseException $e) {
    echo 'Graph returned an error: ' . $e->getMessage();
    exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
}

/*$user = $response->getGraphUser();*/
$user = $response->getGraphNode()->asArray();

if ($user['email'] == ''){
    header("location:../index.php");
    exit();
}
if (!isset($user['email'])){
    header("location:../index.php");
    exit();
}

$existe = $objCliente->checkUserFB($user['email'],'Facebook',$user['id'],$user['first_name'],$user['last_name']);


$_SESSION['current_customer_idCliente'] = $existe['idCliente'];
$_SESSION['current_customer_email'] = $existe['email'];
$_SESSION['current_customer_nombre'] = $existe['nombre'];
$_SESSION['current_customer_apellido'] = $existe['apellido'];
$_SESSION['current_customer_DNI'] =$existe['DNI'] ;
$_SESSION['current_customer_fechaNacimiento'] = $existe['fechaNacimiento'];
$_SESSION['current_customer_telefono'] = $existe['celular'];
$_SESSION['current_customer_direccion'] = $existe['direccion'];
$_SESSION['current_customer_puntos'] = $existe['puntos'];

if (isset($_GET['redirect'])) {
    if ($_GET['redirect'] == 'carrito') {
        header("location:../carrito.php");
    } else {
        header("location:../carta.php");
    }
} else {

    header("location:../carta.php");
}


