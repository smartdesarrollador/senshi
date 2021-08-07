<?php
include '../class/const.php';
//DB details
$dbHost = SERVIDOR;
$dbUsername = USUARIO;
$dbPassword = PASSWORD;
$dbName = BASEDATOS;

//Create connection and select DB
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if ($db->connect_error) {
    die("Unable to connect database: " . $db->connect_error);
}
