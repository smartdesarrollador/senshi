<?php
include '../class/FeedBack.php';
include '../class/Pedido.php';
$objFeedBack = new FeedBack();
$objPedido = new Pedido();


$comments = trim($_POST['comments']);
$idPedido = trim($_POST['idPedido']);

$primero = $_POST['primero'];
$segundo = $_POST['segundo'];
$tercero = $_POST['tercero'];
$cuarto = $_POST['cuarto'];
$quinto = $_POST['quinto'];
$sexto = $_POST['sexto'];
$septimo = $_POST['septimo'];
$octavo = $_POST['octavo'];
$noveno = $_POST['noveno'];
$decimo = $_POST['decimo'];
$once = $_POST['once'];

$data = array(
        array('pregunta'=>'¿Como calificas el tiempo de espera de tu pedido?',
            'respuesta'=>$primero,
            'tipo'=>'3'),
    array('pregunta'=>'¿Como calificas las medidas de higiene que tuvo el motorizado al entregar el pedido?',
            'respuesta'=>$segundo,
        'tipo'=>'3'),
    array('pregunta'=>'¿El motorizado mantuvo el metro de distancia mínima al entregar el pedido?',
            'respuesta'=>$tercero,
        'tipo'=>'2'),
    array('pregunta'=>'¿Como calificas la presentación del empaque de tu pedido?',
        'respuesta'=>$cuarto,
        'tipo'=>'3'),
    array('pregunta'=>'¿El empaque tuvo los precintos completamente intactos al momento de la entrega?',
        'respuesta'=>$quinto,
        'tipo'=>'2'),
    array('pregunta'=>'¿Recibió lo que ordenó sin variaciones?',
        'respuesta'=>$sexto,
        'tipo'=>'2'),
    array('pregunta'=>'¿Como califica el punto de cocción y sabor de los alimentos contenidos en su pedido?',
        'respuesta'=>$septimo,
        'tipo'=>'3'),
    array('pregunta'=>'¿El producto que recibiste cumplió con la calidad descrita en la carta?',
        'respuesta'=>$octavo,
        'tipo'=>'2'),
    array('pregunta'=>'¿Recomendaría nuestro restaurante a sus amigos o familiares?',
        'respuesta'=>$noveno,
        'tipo'=>'2'),
    array('pregunta'=>'¿Te encuentras satisfecho con nuestro servicio delivery?',
        'respuesta'=>$decimo,
        'tipo'=>'2'),
    array('pregunta'=>'¿Volverías a realizar pedidos por nuestra web?',
        'respuesta'=>$once,
        'tipo'=>'2'),
);

$json = json_encode($data);
$base = base64_encode($json);

$feedbackExiste = $objFeedBack->findFeedBackByIdPedido($idPedido);

if (count($feedbackExiste) == 0) {
    $objFeedBack->addNewFeedBack($base, $comments, $idPedido);
}

$affected = $objPedido->updateFeedBackStatus($idPedido);

?>

<strong class="text-success">Muchas gracias por tus comentarios, ya puedes cerrar esta pestaña.</strong>
