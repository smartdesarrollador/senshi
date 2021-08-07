<?php
include 'const.php';
class ConexionBD{
	public static function CadenaCN(){
		return array(
			"servidor" => SERVIDOR,
			"usuario" => USUARIO,
			"password" => PASSWORD,
			"basedatos" => BASEDATOS,
		);
	}
}
?>
