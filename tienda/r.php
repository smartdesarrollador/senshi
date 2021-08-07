<?php
if (isset($_GET['c'])){
    header('location: senshi-configurar-cuenta.php?token='.$_GET['c'].'&id='.$_GET['id']);
}elseif (isset($_GET['u'])){
    header('location: https://operaciones.senshi.pe/giftCards?token='.$_GET['u']);
}elseif (isset($_GET['i'])){

    header('location: feedback.php?id='.$_GET['i'].'&token='.$_GET['t']);
}

