<?php
if (isset($_GET['id']) && isset($_GET['token'])) {
} else {
    echo "No autorizado";
    exit();
}
include 'class/Pedido.php';
$objPedido = new Pedido();

$idPedidoRecibido = trim($_GET['id']);
$tokenRecibido = trim($_GET['token']);
$pedido = $objPedido->getFeedBackTokenByIdPedido($idPedidoRecibido);

if ($pedido['feedBackToken'] == '') {
    echo "No autorizado";
    exit();
}


if ($idPedidoRecibido == $pedido['idPedido'] && $tokenRecibido == $pedido['feedBackToken']) {
} else {
    echo "No autorizado";
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senshi Sushi/ FeedBack</title>
     <?php include 'templates/metalink.php';?>
     <link rel="stylesheet" href="css/carta.css">
</head>
<body> 

    <div class="container text-center" style="margin-top:50px">
	     <div class="row">
		      <div class="col-sm-12 col-xs-12"> 

			           <h3 class="piqueos mb-4">Ayúdanos a seguir mejorando <i class="fa fa-thumbs-o-up"
                                                                               aria-hidden="true"></i></h3>


				   
			  </div>
		 </div>
        <div class="row mb-5 mt-4">
            <div class="col">
                <form action="feedbackForm" id="feedbackForm">

                    <div class="row">
                        <div class="col">
                            <h4 class="text-center text-primary">Delivery</h4>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>1. ¿Como calificas el tiempo de espera de tu pedido? ?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="malo" name="primero" type="radio"
                                               id="1Malo">
                                        <label for="1Malo"
                                               class="custom-control-label">
                                            Malo
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="regular" name="primero" type="radio"
                                               id="1Regular">
                                        <label for="1Regular"
                                               class="custom-control-label">
                                            Regular
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="bueno" name="primero" type="radio"
                                               id="1Bueno">
                                        <label for="1Bueno"
                                               class="custom-control-label">
                                            Bueno
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>2. ¿Como calificas las medidas de higiene que tuvo el motorizado al entregar el pedido?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="malo" name="segundo" type="radio"
                                               id="2Malo">
                                        <label for="2Malo"
                                               class="custom-control-label">
                                            Malo
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="regular" name="segundo" type="radio"
                                               id="2Regular">
                                        <label for="2Regular"
                                               class="custom-control-label">
                                            Regular
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="bueno" name="segundo" type="radio"
                                               id="2Bueno">
                                        <label for="2Bueno"
                                               class="custom-control-label">
                                            Bueno
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>3. ¿El motorizado mantuvo el metro de distancia mínima al entregar el pedido?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="si" name="tercero" type="radio"
                                               id="3si">
                                        <label for="3si"
                                               class="custom-control-label">
                                            Si
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="no" name="tercero" type="radio"
                                               id="3no">
                                        <label for="3no"
                                               class="custom-control-label">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>4. ¿Como calificas la presentación del empaque de tu pedido?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="malo" name="cuarto" type="radio"
                                               id="4Malo">
                                        <label for="4Malo"
                                               class="custom-control-label">
                                            Malo
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="regular" name="cuarto" type="radio"
                                               id="4Regular">
                                        <label for="4Regular"
                                               class="custom-control-label">
                                            Regular
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="bueno" name="cuarto" type="radio"
                                               id="4Bueno">
                                        <label for="4Bueno"
                                               class="custom-control-label">
                                            Bueno
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>5. ¿El empaque tuvo los precintos completamente intactos al momento de la entrega?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="si" name="quinto" type="radio"
                                               id="5si">
                                        <label for="5si"
                                               class="custom-control-label">
                                            Si
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="no" name="quinto" type="radio"
                                               id="5no">
                                        <label for="5no"
                                               class="custom-control-label">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col">
                            <h4 class="text-center text-primary">Producto</h4>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>6. ¿Recibió lo que ordenó sin variaciones?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="si" name="sexto" type="radio"
                                               id="6si">
                                        <label for="6si"
                                               class="custom-control-label">
                                            Si
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="no" name="sexto" type="radio"
                                               id="6no">
                                        <label for="6no"
                                               class="custom-control-label">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>7. ¿Como califica el punto de cocción y sabor de los alimentos contenidos en su pedido?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="malo" name="septimo" type="radio"
                                               id="7Malo">
                                        <label for="7Malo"
                                               class="custom-control-label">
                                            Malo
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="regular" name="septimo" type="radio"
                                               id="7Regular">
                                        <label for="7Regular"
                                               class="custom-control-label">
                                            Regular
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="bueno" name="septimo" type="radio"
                                               id="7Bueno">
                                        <label for="7Bueno"
                                               class="custom-control-label">
                                            Bueno
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>8. ¿El producto que recibiste cumplió con la calidad descrita en la carta?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="si" name="octavo" type="radio"
                                               id="8si">
                                        <label for="8si"
                                               class="custom-control-label">
                                            Si
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="no" name="octavo" type="radio"
                                               id="8no">
                                        <label for="8no"
                                               class="custom-control-label">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row my-3">
                        <div class="col">
                            <h4 class="text-center text-primary">Servicio</h4>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>9. ¿Recomendaría nuestro restaurante a sus amigos o familiares?</h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="si" name="noveno" type="radio"
                                               id="9si">
                                        <label for="9si"
                                               class="custom-control-label">
                                            Si
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="no" name="noveno" type="radio"
                                               id="9no">
                                        <label for="9no"
                                               class="custom-control-label">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>10. ¿Te encuentras satisfecho con nuestro servicio delivery? </h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="si" name="decimo" type="radio"
                                               id="10si">
                                        <label for="10si"
                                               class="custom-control-label">
                                            Si
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="no" name="decimo" type="radio"
                                               id="10no">
                                        <label for="10no"
                                               class="custom-control-label">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <h6>11. ¿Volverías a realizar pedidos por nuestra web? </h6>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col pl-5">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="si" name="once" type="radio"
                                               id="11si">
                                        <label for="11si"
                                               class="custom-control-label">
                                            Si
                                        </label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input required class="custom-control-input" value="no" name="once" type="radio"
                                               id="11no">
                                        <label for="11no"
                                               class="custom-control-label">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col">

                            <label class="text-primary" for="comentarios">Comentarios (opcional)</label>
                            <textarea maxlength="255" class="form-control" name="comentarios" id="comentarios" cols="30"
                                      rows="3"></textarea>
                            <small id="comentariosHelp" class="form-text text-muted">Todos tus comentarios son
                                anónimos.</small>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col text-center">
                            <div id="vista">
                                <input id="idPedido" type="hidden" value="<?php echo $pedido['idPedido']; ?>">
                                <button type="submit" class="btn btn-lg btn-primary">Enviar</button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>

	</div>
    
   
	
		


 


<?php include 'templates/footer.php';?>
    <script>

        $("#feedbackForm").submit(function () {


            let reaction = $("#feedbackForm input[name='reaction']:checked").val();
     let primero = $("#feedbackForm input[name='primero']:checked").val();
            let segundo = $("#feedbackForm input[name='segundo']:checked").val();
            let tercero = $("#feedbackForm input[name='tercero']:checked").val();
            let cuarto = $("#feedbackForm input[name='cuarto']:checked").val();
            let quinto = $("#feedbackForm input[name='quinto']:checked").val();
            let sexto = $("#feedbackForm input[name='sexto']:checked").val();
            let septimo = $("#feedbackForm input[name='septimo']:checked").val();
            let octavo = $("#feedbackForm input[name='octavo']:checked").val();
            let noveno = $("#feedbackForm input[name='noveno']:checked").val();
            let decimo = $("#feedbackForm input[name='decimo']:checked").val();
            let once = $("#feedbackForm input[name='once']:checked").val();




            let comments = $("#comentarios").val();
            let idPedido = $("#idPedido").val();
            let datos = {
                "reaction": reaction,
                "comments": comments,
                "idPedido": idPedido,
                "primero": primero,
                "segundo": segundo,
                "tercero": tercero,
                "cuarto": cuarto,
                "quinto": quinto,
                "sexto": sexto,
                "septimo": septimo,
                "octavo": octavo,
                "noveno": noveno,
                "decimo": decimo,
                "once": once
            };

            $.ajax({
                url: "ajax/addFeedBack.php",
                type: "post",
                data: datos,
                beforeSend: function () {
                    $("#vista").html('<div class="spinner-border text-egipcio" style="width: 3rem; height: 3rem;" role="status">\n' +
                        '  <span class="sr-only">Loading...</span>\n' +
                        '</div>');
                    $('#button').attr("disabled", true);
                },
                success: function (data) {
                    $("#vista").html(data);
                }
            });
            return false;
        });
    </script>
    
</body>
</html>
