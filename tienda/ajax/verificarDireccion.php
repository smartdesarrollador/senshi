<?php
session_start();
error_reporting(0);
function limpiar($s)
{
    $s = str_replace('á', 'a', $s);
    $s = str_replace('Á', 'A', $s);
    $s = str_replace('é', 'e', $s);
    $s = str_replace('É', 'E', $s);
    $s = str_replace('í', 'i', $s);
    $s = str_replace('Í', 'I', $s);
    $s = str_replace('ó', 'o', $s);
    $s = str_replace('Ó', 'O', $s);
    $s = str_replace('Ú', 'U', $s);
    $s = str_replace('ú', 'u', $s);

    //Quitando Caracteres Especiales
    $s = str_replace('"', '', $s);
    $s = str_replace(':', '', $s);
    $s = str_replace('.', '', $s);
    $s = str_replace(',', '', $s);
    $s = str_replace(';', '', $s);
    return $s;
}

include '../class/Cart.php';
$cart = new Cart;
include '../class/ClienteClass.php';
$objCliente = new ClienteClass();


if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
    $direccion = $_SESSION['current_customer_direccion'];
} else {
    $direccion = $_POST['direccion'];
}


$dni = limpiar($_POST['dni']);
$fechaNacimiento = $_POST['fechaNacimiento'];
$mensaje = $_POST['mensaje'];
$telefono = limpiar($_POST['telefono']);
$distrito = $_POST['distrito'];
$referencia = $_POST['referencia'];


$horarioPedido = limpiar($_POST['horario']);
$apellido = $_SESSION['current_customer_apellido'];

$total = $_POST['total'] * 100;

if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
} else {
    if ($direccion == '') {
        echo '<strong  class="text-center" style="color: red">Falta la direccion de Envío</strong>';
        exit();
    }
}
if ($telefono == '') {
    echo '<strong  class="text-center" style="color: red">Falta el teléfono</strong>';
    exit();
}
if ($_POST['tipoDocumento'] == 'boleta') {
    if (strlen($dni) < 8) {
        echo '<strong class="text-center" style="color: red">DNI Invalido</strong>';
        exit();
    }
} else {
    $_SESSION['current_customer_ruc'] = $_POST['ruc'];
    $_SESSION['current_customer_razonSocial'] = $_POST['razonSocial'];
    $_SESSION['current_customer_direccionFiscal'] = $_POST['direccionFiscal'];
}
if ($fechaNacimiento == '') {

    echo '<strong class="text-center" style="color: red">Falta fecha de Nacimiento</strong>';
    exit();
}
if ($distrito == '') {

    echo '<strong class="text-center" style="color: red">Ingresa un distrito válido</strong>';
    exit();
}


$idCliente = $_SESSION['current_customer_idCliente'];

//si se envia latitud y longitud válida, se actualiza la info del cliente.
if (strlen($_POST['lat']) > 2) {
    $clienteActualizado = $objCliente->updateCustomerDetailsWithLatLng($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido, $_POST['lat'], $_POST['lng']);
    $_SESSION['current_customer_lat'] = trim($_POST['lat']);
    $_SESSION['current_customer_lng'] = trim($_POST['lng']);
} else {
    $clienteActualizado = $objCliente->updateCustomerDetails($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido);
    $_SESSION['current_customer_lat'] = trim($_POST['lat']);
    $_SESSION['current_customer_lng'] = trim($_POST['lng']);
}

$_SESSION['current_customer_DNI'] = $dni;
$_SESSION['current_customer_fechaNacimiento'] = $fechaNacimiento;

$_SESSION['current_customer_direccion'] = $direccion;
$_SESSION['current_customer_tipoDocumento'] = $_POST['tipoDocumento'];

$_SESSION['current_customer_mensaje'] = $mensaje;
$_SESSION['current_customer_telefono'] = $telefono;
$_SESSION['$current_customer_distrito'] = $distrito;
$_SESSION['$current_customer_referencia'] = $referencia;
$_SESSION['horario_pedido'] = $horarioPedido;


?>

<script>
    /* Integracion */
    /* Culqi.publicKey = 'pk_test_5533d6f78dbbb7b2'; */


    /* Produccion */
    Culqi.publicKey = 'pk_live_eef5c93e21246cc7';
</script>
<?php

if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
?>
    <div class="row">
        <div class="col text-center">
            <p class="text-info"><strong>Click en pagar para completar tu pedido.</strong></p>
            <button type="button" class="btn btn-primary btn-lg" id="buyButton">PAGAR <i class="far fa-credit-card"></i>
            </button>
        </div>
    </div>
    <script>
        var finalShippingCost = 0;

        Culqi.options({
            style: {
                logo: 'https://senshi.pe/tienda/img/logo2.png',
                maincolor: '#000000',
                buttontext: '#ffffff',
                maintext: '#4A4A4A',
                desctext: '#4A4A4A'
            }
        });


        Culqi.settings({
            title: 'Senshi Sushi & Rolls',
            currency: 'PEN',
            description: 'Delivery Web',
            amount: <?php echo $total ?>
        });

        $('#buyButton').on('click', function(e) {
            // Abre el formulario con la configuración en Culqi.settings

            Culqi.open();
            e.preventDefault();
        });


        function culqi() {
            if (Culqi.token) { // ¡Objeto Token creado exitosamente!


                let token = Culqi.token.id;
                console.log('Se ha creado un token:' + token);


                let url = "script/checkout.php";

                let datos = {
                    token: token
                };
                document.getElementById("loading").style.display = "block";
                window.location = 'script/checkout.php?token=' + token;
                /* $.post(url,datos,function(data) {

                     console.log(data);

                 });*/


            } else { // ¡Hubo algún problema!

                // Mostramos JSON de objeto error en consola

                console.log(Culqi.error);
                alert('Error 500, contacte al administrador');
                console.log(Culqi.error.user_message);


            }

        }
    </script>
<?php
} else {
?>
    <script>
        var finalShippingCost = 0;

        document.getElementById("checkout").style.display = "none";
        document.getElementById("checkoutError").style.display = "none";
        var direccion = '<?php echo $direccion . ' ' . $distrito; ?>';

        var geocoder = new google.maps.Geocoder();
        var hasNumber = /\d/;

        if (hasNumber.test(direccion)) {
            console.log("DIRECCION CONTIENE NUMEROS");


            const allPolyCords = [{
                    coords: [{
                            lat: -12.0975179,
                            lng: -76.9806652
                        },
                        {
                            lat: -12.0976018,
                            lng: -76.9816094
                        },
                        {
                            lat: -12.0966367,
                            lng: -76.9835405
                        },
                        {
                            lat: -12.0960072,
                            lng: -76.9836693
                        },
                        {
                            lat: -12.0960912,
                            lng: -76.9856434
                        },
                        {
                            lat: -12.091769,
                            lng: -76.9859009
                        },
                        {
                            lat: -12.0912235,
                            lng: -76.9865446
                        },
                        {
                            lat: -12.0903003,
                            lng: -76.9881754
                        },
                        {
                            lat: -12.089461,
                            lng: -76.9908791
                        },
                        {
                            lat: -12.0887057,
                            lng: -76.9907932
                        },
                        {
                            lat: -12.0886637,
                            lng: -76.9922094
                        },
                        {
                            lat: -12.0891253,
                            lng: -76.995471
                        },
                        {
                            lat: -12.0872369,
                            lng: -76.9956427
                        },
                        {
                            lat: -12.0873628,
                            lng: -76.996501
                        },
                        {
                            lat: -12.0874048,
                            lng: -76.9980888
                        },
                        {
                            lat: -12.0896708,
                            lng: -77.0145254
                        },
                        {
                            lat: -12.0920627,
                            lng: -77.0136671
                        },
                        {
                            lat: -12.0942868,
                            lng: -77.013238
                        },
                        {
                            lat: -12.0945805,
                            lng: -77.0166712
                        },
                        {
                            lat: -12.0956715,
                            lng: -77.0164566
                        },
                        {
                            lat: -12.0970143,
                            lng: -77.0174007
                        },
                        {
                            lat: -12.0969304,
                            lng: -77.0184307
                        },
                        {
                            lat: -12.0978116,
                            lng: -77.0185165
                        },
                        {
                            lat: -12.0988607,
                            lng: -77.0185595
                        },
                        {
                            lat: -12.1009168,
                            lng: -77.0175295
                        },
                        {
                            lat: -12.1023435,
                            lng: -77.0173578
                        },
                        {
                            lat: -12.1020078,
                            lng: -77.018817
                        },
                        {
                            lat: -12.1163583,
                            lng: -77.0183449
                        },
                        {
                            lat: -12.1160226,
                            lng: -77.0130234
                        },
                        {
                            lat: -12.1172394,
                            lng: -77.0129161
                        },
                        {
                            lat: -12.1181625,
                            lng: -77.0121007
                        },
                        {
                            lat: -12.1198829,
                            lng: -77.0114999
                        },
                        {
                            lat: -12.1205122,
                            lng: -77.010942
                        },
                        {
                            lat: -12.1212675,
                            lng: -77.0108562
                        },
                        {
                            lat: -12.1208899,
                            lng: -77.009912
                        },
                        {
                            lat: -12.1236172,
                            lng: -77.0077233
                        },
                        {
                            lat: -12.1205542,
                            lng: -77.0035606
                        },
                        {
                            lat: -12.1236172,
                            lng: -77.001801
                        },
                        {
                            lat: -12.12282,
                            lng: -77.0011144
                        },
                        {
                            lat: -12.1236172,
                            lng: -77.0002561
                        },
                        {
                            lat: -12.1225682,
                            lng: -76.9996982
                        },
                        {
                            lat: -12.1231976,
                            lng: -76.9985824
                        },
                        {
                            lat: -12.1226521,
                            lng: -76.9984107
                        },
                        {
                            lat: -12.1229039,
                            lng: -76.9971232
                        },
                        {
                            lat: -12.12282,
                            lng: -76.9950204
                        },
                        {
                            lat: -12.1236591,
                            lng: -76.9950633
                        },
                        {
                            lat: -12.1243724,
                            lng: -76.9943338
                        },
                        {
                            lat: -12.123785,
                            lng: -76.9939475
                        },
                        {
                            lat: -12.1233235,
                            lng: -76.9945054
                        },
                        {
                            lat: -12.122736,
                            lng: -76.9943767
                        },
                        {
                            lat: -12.1230717,
                            lng: -76.99369
                        },
                        {
                            lat: -12.1191066,
                            lng: -76.9896131
                        },
                        {
                            lat: -12.119778,
                            lng: -76.9890122
                        },
                        {
                            lat: -12.1199458,
                            lng: -76.9883256
                        },
                        {
                            lat: -12.1214983,
                            lng: -76.987124
                        },
                        {
                            lat: -12.1204073,
                            lng: -76.9862657
                        },
                        {
                            lat: -12.1196101,
                            lng: -76.9870381
                        },
                        {
                            lat: -12.1191066,
                            lng: -76.9867377
                        },
                        {
                            lat: -12.119694,
                            lng: -76.9857078
                        },
                        {
                            lat: -12.1187709,
                            lng: -76.9854074
                        },
                        {
                            lat: -12.119694,
                            lng: -76.9842916
                        },
                        {
                            lat: -12.1188129,
                            lng: -76.9839912
                        },
                        {
                            lat: -12.1195262,
                            lng: -76.9832187
                        },
                        {
                            lat: -12.1144491,
                            lng: -76.9788842
                        },
                        {
                            lat: -12.1104629,
                            lng: -76.9793563
                        },
                        {
                            lat: -12.1102951,
                            lng: -76.9781976
                        },
                        {
                            lat: -12.0975179,
                            lng: -76.9806652
                        },
                    ],
                    price: 6
                },
                {
                    coords: [{
                            lat: -12.0975179,
                            lng: -76.9806652
                        },
                        {
                            lat: -12.1102895,
                            lng: -76.9781976
                        },
                        {
                            lat: -12.1102931,
                            lng: -76.9781919
                        },
                        {
                            lat: -12.1102704,
                            lng: -76.9779593
                        },
                        {
                            lat: -12.1099754,
                            lng: -76.9749321
                        },
                        {
                            lat: -12.1025391,
                            lng: -76.9720796
                        },
                        {
                            lat: -12.1020356,
                            lng: -76.9735816
                        },
                        {
                            lat: -12.099455,
                            lng: -76.9727018
                        },
                        {
                            lat: -12.0980702,
                            lng: -76.9732168
                        },
                        {
                            lat: -12.0849567,
                            lng: -76.980963
                        },
                        {
                            lat: -12.0849987,
                            lng: -76.9838169
                        },
                        {
                            lat: -12.0776338,
                            lng: -76.9890097
                        },
                        {
                            lat: -12.081054,
                            lng: -76.9934729
                        },
                        {
                            lat: -12.0815576,
                            lng: -76.9954899
                        },
                        {
                            lat: -12.0823969,
                            lng: -76.9970134
                        },
                        {
                            lat: -12.083467,
                            lng: -76.9990304
                        },
                        {
                            lat: -12.0849987,
                            lng: -77.0099094
                        },
                        {
                            lat: -12.0833201,
                            lng: -77.0140508
                        },
                        {
                            lat: -12.0900133,
                            lng: -77.0177415
                        },
                        {
                            lat: -12.0907897,
                            lng: -77.022548
                        },
                        {
                            lat: -12.1008817,
                            lng: -77.0269897
                        },
                        {
                            lat: -12.1051407,
                            lng: -77.0274618
                        },
                        {
                            lat: -12.1085396,
                            lng: -77.026346
                        },
                        {
                            lat: -12.113323,
                            lng: -77.0259169
                        },
                        {
                            lat: -12.1168476,
                            lng: -77.0263031
                        },
                        {
                            lat: -12.1253442,
                            lng: -77.0242002
                        },
                        {
                            lat: -12.1256799,
                            lng: -77.0219472
                        },
                        {
                            lat: -12.1276519,
                            lng: -77.0210674
                        },
                        {
                            lat: -12.1273163,
                            lng: -77.0206383
                        },
                        {
                            lat: -12.1272953,
                            lng: -77.0202091
                        },
                        {
                            lat: -12.1276309,
                            lng: -77.0202306
                        },
                        {
                            lat: -12.127589,
                            lng: -77.0180848
                        },
                        {
                            lat: -12.1286379,
                            lng: -77.0180634
                        },
                        {
                            lat: -12.1286799,
                            lng: -77.0168832
                        },
                        {
                            lat: -12.1290365,
                            lng: -77.0162395
                        },
                        {
                            lat: -12.129582,
                            lng: -77.0154884
                        },
                        {
                            lat: -12.1294561,
                            lng: -77.0137504
                        },
                        {
                            lat: -12.1286169,
                            lng: -77.0116261
                        },
                        {
                            lat: -12.1287009,
                            lng: -77.0107463
                        },
                        {
                            lat: -12.1286379,
                            lng: -77.0095661
                        },
                        {
                            lat: -12.1319735,
                            lng: -77.0092657
                        },
                        {
                            lat: -12.1331903,
                            lng: -77.0058969
                        },
                        {
                            lat: -12.1319945,
                            lng: -77.0054462
                        },
                        {
                            lat: -12.1331273,
                            lng: -77.0031503
                        },
                        {
                            lat: -12.1317008,
                            lng: -77.0025495
                        },
                        {
                            lat: -12.1323302,
                            lng: -77.0013264
                        },
                        {
                            lat: -12.1337147,
                            lng: -77.0001462
                        },
                        {
                            lat: -12.1314281,
                            lng: -76.999481
                        },
                        {
                            lat: -12.1334,
                            lng: -76.9979361
                        },
                        {
                            lat: -12.1329595,
                            lng: -76.9972494
                        },
                        {
                            lat: -12.1314491,
                            lng: -76.9963696
                        },
                        {
                            lat: -12.1322882,
                            lng: -76.9949749
                        },
                        {
                            lat: -12.1283023,
                            lng: -76.9928291
                        },
                        {
                            lat: -12.1278617,
                            lng: -76.9875505
                        },
                        {
                            lat: -12.128554,
                            lng: -76.9851258
                        },
                        {
                            lat: -12.1260785,
                            lng: -76.9840959
                        },
                        {
                            lat: -12.1251135,
                            lng: -76.9834307
                        },
                        {
                            lat: -12.1260995,
                            lng: -76.9823363
                        },
                        {
                            lat: -12.1232044,
                            lng: -76.9793966
                        },
                        {
                            lat: -12.120582,
                            lng: -76.979461
                        },
                        {
                            lat: -12.120519,
                            lng: -76.9772079
                        },
                        {
                            lat: -12.1200995,
                            lng: -76.9771865
                        },
                        {
                            lat: -12.1199736,
                            lng: -76.975427
                        },
                        {
                            lat: -12.117456,
                            lng: -76.9719508
                        },
                        {
                            lat: -12.1131972,
                            lng: -76.9742468
                        },
                        {
                            lat: -12.1097774,
                            lng: -76.9727018
                        },
                        {
                            lat: -12.1102951,
                            lng: -76.9781976
                        },
                        {
                            lat: -12.1104629,
                            lng: -76.9793563
                        },
                        {
                            lat: -12.1144491,
                            lng: -76.9788842
                        },
                        {
                            lat: -12.1195262,
                            lng: -76.9832187
                        },
                        {
                            lat: -12.1188129,
                            lng: -76.9839912
                        },
                        {
                            lat: -12.119694,
                            lng: -76.9842916
                        },
                        {
                            lat: -12.1187709,
                            lng: -76.9854074
                        },
                        {
                            lat: -12.119694,
                            lng: -76.9857078
                        },
                        {
                            lat: -12.1191066,
                            lng: -76.9867377
                        },
                        {
                            lat: -12.1196101,
                            lng: -76.9870381
                        },
                        {
                            lat: -12.1204073,
                            lng: -76.9862657
                        },
                        {
                            lat: -12.1214983,
                            lng: -76.987124
                        },
                        {
                            lat: -12.1199458,
                            lng: -76.9883256
                        },
                        {
                            lat: -12.119778,
                            lng: -76.9890122
                        },
                        {
                            lat: -12.1191066,
                            lng: -76.9896131
                        },
                        {
                            lat: -12.1230717,
                            lng: -76.99369
                        },
                        {
                            lat: -12.122736,
                            lng: -76.9943767
                        },
                        {
                            lat: -12.1233235,
                            lng: -76.9945054
                        },
                        {
                            lat: -12.123785,
                            lng: -76.9939475
                        },
                        {
                            lat: -12.1243724,
                            lng: -76.9943338
                        },
                        {
                            lat: -12.1236591,
                            lng: -76.9950633
                        },
                        {
                            lat: -12.12282,
                            lng: -76.9950204
                        },
                        {
                            lat: -12.1229039,
                            lng: -76.9971232
                        },
                        {
                            lat: -12.1226521,
                            lng: -76.9984107
                        },
                        {
                            lat: -12.1231976,
                            lng: -76.9985824
                        },
                        {
                            lat: -12.1225682,
                            lng: -76.9996982
                        },
                        {
                            lat: -12.1236172,
                            lng: -77.0002561
                        },
                        {
                            lat: -12.12282,
                            lng: -77.0011144
                        },
                        {
                            lat: -12.1236172,
                            lng: -77.001801
                        },
                        {
                            lat: -12.1205542,
                            lng: -77.0035606
                        },
                        {
                            lat: -12.1236172,
                            lng: -77.0077233
                        },
                        {
                            lat: -12.1208899,
                            lng: -77.009912
                        },
                        {
                            lat: -12.1212675,
                            lng: -77.0108562
                        },
                        {
                            lat: -12.1205122,
                            lng: -77.010942
                        },
                        {
                            lat: -12.1198829,
                            lng: -77.0114999
                        },
                        {
                            lat: -12.1181625,
                            lng: -77.0121007
                        },
                        {
                            lat: -12.1172394,
                            lng: -77.0129161
                        },
                        {
                            lat: -12.1160226,
                            lng: -77.0130234
                        },
                        {
                            lat: -12.1163583,
                            lng: -77.0183449
                        },
                        {
                            lat: -12.1020078,
                            lng: -77.018817
                        },
                        {
                            lat: -12.1023435,
                            lng: -77.0173578
                        },
                        {
                            lat: -12.1009168,
                            lng: -77.0175295
                        },
                        {
                            lat: -12.0988607,
                            lng: -77.0185595
                        },
                        {
                            lat: -12.0969304,
                            lng: -77.0184307
                        },
                        {
                            lat: -12.0970143,
                            lng: -77.0174007
                        },
                        {
                            lat: -12.0956715,
                            lng: -77.0164566
                        },
                        {
                            lat: -12.0945805,
                            lng: -77.0166712
                        },
                        {
                            lat: -12.0942868,
                            lng: -77.013238
                        },
                        {
                            lat: -12.0920627,
                            lng: -77.0136671
                        },
                        {
                            lat: -12.0896708,
                            lng: -77.0145254
                        },
                        {
                            lat: -12.0874048,
                            lng: -76.9980888
                        },
                        {
                            lat: -12.0873628,
                            lng: -76.996501
                        },
                        {
                            lat: -12.0872369,
                            lng: -76.9956427
                        },
                        {
                            lat: -12.0891253,
                            lng: -76.995471
                        },
                        {
                            lat: -12.0886637,
                            lng: -76.9922094
                        },
                        {
                            lat: -12.0887057,
                            lng: -76.9907932
                        },
                        {
                            lat: -12.089461,
                            lng: -76.9908791
                        },
                        {
                            lat: -12.0903003,
                            lng: -76.9881754
                        },
                        {
                            lat: -12.0912235,
                            lng: -76.9865446
                        },
                        {
                            lat: -12.091769,
                            lng: -76.9859009
                        },
                        {
                            lat: -12.0960912,
                            lng: -76.9856434
                        },
                        {
                            lat: -12.0960072,
                            lng: -76.9836693
                        },
                        {
                            lat: -12.0966367,
                            lng: -76.9835405
                        },
                        {
                            lat: -12.0976018,
                            lng: -76.9816094
                        },
                        {
                            lat: -12.0975179,
                            lng: -76.9806652
                        },
                    ],
                    price: 7.5
                },
                {
                    coords: [{
                            lat: -12.0849781,
                            lng: -76.9821524
                        },
                        {
                            lat: -12.0849567,
                            lng: -76.980963
                        },
                        {
                            lat: -12.0980702,
                            lng: -76.9732168
                        },
                        {
                            lat: -12.099455,
                            lng: -76.9727018
                        },
                        {
                            lat: -12.1020356,
                            lng: -76.9735816
                        },
                        {
                            lat: -12.1025391,
                            lng: -76.9720796
                        },
                        {
                            lat: -12.109987,
                            lng: -76.9749365
                        },
                        {
                            lat: -12.1097774,
                            lng: -76.9727018
                        },
                        {
                            lat: -12.1131972,
                            lng: -76.9742468
                        },
                        {
                            lat: -12.117456,
                            lng: -76.9719508
                        },
                        {
                            lat: -12.1199736,
                            lng: -76.975427
                        },
                        {
                            lat: -12.1200995,
                            lng: -76.9771865
                        },
                        {
                            lat: -12.120519,
                            lng: -76.9772079
                        },
                        {
                            lat: -12.120582,
                            lng: -76.979461
                        },
                        {
                            lat: -12.1232044,
                            lng: -76.9793966
                        },
                        {
                            lat: -12.1260995,
                            lng: -76.9823363
                        },
                        {
                            lat: -12.1251135,
                            lng: -76.9834307
                        },
                        {
                            lat: -12.1260785,
                            lng: -76.9840959
                        },
                        {
                            lat: -12.128554,
                            lng: -76.9851258
                        },
                        {
                            lat: -12.1278617,
                            lng: -76.9875505
                        },
                        {
                            lat: -12.1283023,
                            lng: -76.9928291
                        },
                        {
                            lat: -12.1322882,
                            lng: -76.9949749
                        },
                        {
                            lat: -12.1314491,
                            lng: -76.9963696
                        },
                        {
                            lat: -12.1329595,
                            lng: -76.9972494
                        },
                        {
                            lat: -12.1334,
                            lng: -76.9979361
                        },
                        {
                            lat: -12.1314281,
                            lng: -76.999481
                        },
                        {
                            lat: -12.1337147,
                            lng: -77.0001462
                        },
                        {
                            lat: -12.1323302,
                            lng: -77.0013264
                        },
                        {
                            lat: -12.1317008,
                            lng: -77.0025495
                        },
                        {
                            lat: -12.1331273,
                            lng: -77.0031503
                        },
                        {
                            lat: -12.1319945,
                            lng: -77.0054462
                        },
                        {
                            lat: -12.1331903,
                            lng: -77.0058969
                        },
                        {
                            lat: -12.1319735,
                            lng: -77.0092657
                        },
                        {
                            lat: -12.1286379,
                            lng: -77.0095661
                        },
                        {
                            lat: -12.1287009,
                            lng: -77.0107463
                        },
                        {
                            lat: -12.1286169,
                            lng: -77.0116261
                        },
                        {
                            lat: -12.1294561,
                            lng: -77.0137504
                        },
                        {
                            lat: -12.129582,
                            lng: -77.0154884
                        },
                        {
                            lat: -12.1290365,
                            lng: -77.0162395
                        },
                        {
                            lat: -12.1286799,
                            lng: -77.0168832
                        },
                        {
                            lat: -12.1286379,
                            lng: -77.0180634
                        },
                        {
                            lat: -12.127589,
                            lng: -77.0180848
                        },
                        {
                            lat: -12.1276309,
                            lng: -77.0202306
                        },
                        {
                            lat: -12.1272953,
                            lng: -77.0202091
                        },
                        {
                            lat: -12.1273163,
                            lng: -77.0206383
                        },
                        {
                            lat: -12.1276519,
                            lng: -77.0210674
                        },
                        {
                            lat: -12.1256799,
                            lng: -77.0219472
                        },
                        {
                            lat: -12.1253442,
                            lng: -77.0242002
                        },
                        {
                            lat: -12.1190356,
                            lng: -77.0257495
                        },
                        {
                            lat: -12.1204308,
                            lng: -77.0258032
                        },
                        {
                            lat: -12.1204308,
                            lng: -77.0276807
                        },
                        {
                            lat: -12.1224238,
                            lng: -77.0277665
                        },
                        {
                            lat: -12.1223819,
                            lng: -77.0291935
                        },
                        {
                            lat: -12.1230532,
                            lng: -77.0292364
                        },
                        {
                            lat: -12.1224867,
                            lng: -77.0313178
                        },
                        {
                            lat: -12.1244588,
                            lng: -77.0330559
                        },
                        {
                            lat: -12.1238504,
                            lng: -77.033764
                        },
                        {
                            lat: -12.1233259,
                            lng: -77.0337425
                        },
                        {
                            lat: -12.123284,
                            lng: -77.0408664
                        },
                        {
                            lat: -12.1304377,
                            lng: -77.0344077
                        },
                        {
                            lat: -12.1325775,
                            lng: -77.0305238
                        },
                        {
                            lat: -12.1381158,
                            lng: -77.0280348
                        },
                        {
                            lat: -12.1382626,
                            lng: -77.0257602
                        },
                        {
                            lat: -12.1395003,
                            lng: -77.0234857
                        },
                        {
                            lat: -12.1392696,
                            lng: -77.0187221
                        },
                        {
                            lat: -12.138892,
                            lng: -77.0173274
                        },
                        {
                            lat: -12.1413883,
                            lng: -77.0144091
                        },
                        {
                            lat: -12.139794,
                            lng: -77.0130788
                        },
                        {
                            lat: -12.1408639,
                            lng: -77.0118342
                        },
                        {
                            lat: -12.1413673,
                            lng: -77.0116626
                        },
                        {
                            lat: -12.1416401,
                            lng: -77.0111261
                        },
                        {
                            lat: -12.1403814,
                            lng: -77.0105038
                        },
                        {
                            lat: -12.1418498,
                            lng: -77.0070062
                        },
                        {
                            lat: -12.1413254,
                            lng: -77.0069204
                        },
                        {
                            lat: -12.1417449,
                            lng: -77.0058904
                        },
                        {
                            lat: -12.1412205,
                            lng: -77.0059763
                        },
                        {
                            lat: -12.1404443,
                            lng: -77.0055257
                        },
                        {
                            lat: -12.140717,
                            lng: -77.0053111
                        },
                        {
                            lat: -12.1401087,
                            lng: -77.0049892
                        },
                        {
                            lat: -12.1420386,
                            lng: -77.002307
                        },
                        {
                            lat: -12.1417869,
                            lng: -77.0017277
                        },
                        {
                            lat: -12.1396681,
                            lng: -76.9994317
                        },
                        {
                            lat: -12.140738,
                            lng: -76.9978867
                        },
                        {
                            lat: -12.1401087,
                            lng: -76.9976078
                        },
                        {
                            lat: -12.1416191,
                            lng: -76.9953547
                        },
                        {
                            lat: -12.1392486,
                            lng: -76.9936596
                        },
                        {
                            lat: -12.1402555,
                            lng: -76.9927369
                        },
                        {
                            lat: -12.1409478,
                            lng: -76.9922434
                        },
                        {
                            lat: -12.1402765,
                            lng: -76.9918357
                        },
                        {
                            lat: -12.1364375,
                            lng: -76.9906126
                        },
                        {
                            lat: -12.1377382,
                            lng: -76.9841753
                        },
                        {
                            lat: -12.1384095,
                            lng: -76.980506
                        },
                        {
                            lat: -12.135011,
                            lng: -76.9796477
                        },
                        {
                            lat: -12.1357243,
                            lng: -76.9788967
                        },
                        {
                            lat: -12.1359131,
                            lng: -76.97821
                        },
                        {
                            lat: -12.1357662,
                            lng: -76.9770084
                        },
                        {
                            lat: -12.1351998,
                            lng: -76.9761072
                        },
                        {
                            lat: -12.1290741,
                            lng: -76.9766222
                        },
                        {
                            lat: -12.1305217,
                            lng: -76.9727169
                        },
                        {
                            lat: -12.1295357,
                            lng: -76.9710003
                        },
                        {
                            lat: -12.1292,
                            lng: -76.9689403
                        },
                        {
                            lat: -12.1275846,
                            lng: -76.9662581
                        },
                        {
                            lat: -12.1219623,
                            lng: -76.9649707
                        },
                        {
                            lat: -12.1182489,
                            lng: -76.9646273
                        },
                        {
                            lat: -12.1147873,
                            lng: -76.9632755
                        },
                        {
                            lat: -12.1147873,
                            lng: -76.967567
                        },
                        {
                            lat: -12.1137383,
                            lng: -76.9688974
                        },
                        {
                            lat: -12.1112417,
                            lng: -76.9670306
                        },
                        {
                            lat: -12.1090388,
                            lng: -76.9646703
                        },
                        {
                            lat: -12.1067729,
                            lng: -76.96555
                        },
                        {
                            lat: -12.1041923,
                            lng: -76.961988
                        },
                        {
                            lat: -12.1026397,
                            lng: -76.9629966
                        },
                        {
                            lat: -12.102346,
                            lng: -76.9639407
                        },
                        {
                            lat: -12.1013179,
                            lng: -76.9647775
                        },
                        {
                            lat: -12.1003318,
                            lng: -76.9650136
                        },
                        {
                            lat: -12.098968,
                            lng: -76.9691764
                        },
                        {
                            lat: -12.0968699,
                            lng: -76.9699274
                        },
                        {
                            lat: -12.0958838,
                            lng: -76.9687901
                        },
                        {
                            lat: -12.0950236,
                            lng: -76.9679104
                        },
                        {
                            lat: -12.0925058,
                            lng: -76.9672237
                        },
                        {
                            lat: -12.087722,
                            lng: -76.9669019
                        },
                        {
                            lat: -12.0861693,
                            lng: -76.9677602
                        },
                        {
                            lat: -12.08533,
                            lng: -76.969112
                        },
                        {
                            lat: -12.0815952,
                            lng: -76.9705067
                        },
                        {
                            lat: -12.0801474,
                            lng: -76.9706569
                        },
                        {
                            lat: -12.0808188,
                            lng: -76.9738756
                        },
                        {
                            lat: -12.0792242,
                            lng: -76.9738541
                        },
                        {
                            lat: -12.0793501,
                            lng: -76.9746266
                        },
                        {
                            lat: -12.0787835,
                            lng: -76.9747554
                        },
                        {
                            lat: -12.078217,
                            lng: -76.9761072
                        },
                        {
                            lat: -12.0849781,
                            lng: -76.9821524
                        },
                    ],
                    price: 10
                },
                {
                    coords: [{
                            lat: -12.1389844,
                            lng: -77.0177051
                        },
                        {
                            lat: -12.1392696,
                            lng: -77.0187221
                        },
                        {
                            lat: -12.1395003,
                            lng: -77.0234857
                        },
                        {
                            lat: -12.1382626,
                            lng: -77.0257602
                        },
                        {
                            lat: -12.1381158,
                            lng: -77.0280348
                        },
                        {
                            lat: -12.1447952,
                            lng: -77.0251724
                        },
                        {
                            lat: -12.1496619,
                            lng: -77.0243141
                        },
                        {
                            lat: -12.1497039,
                            lng: -77.0230266
                        },
                        {
                            lat: -12.1490326,
                            lng: -77.022576
                        },
                        {
                            lat: -12.149599,
                            lng: -77.0206878
                        },
                        {
                            lat: -12.1487809,
                            lng: -77.0206234
                        },
                        {
                            lat: -12.147795,
                            lng: -77.0198938
                        },
                        {
                            lat: -12.1429911,
                            lng: -77.0181558
                        },
                        {
                            lat: -12.1410192,
                            lng: -77.0176193
                        },
                        {
                            lat: -12.1389844,
                            lng: -77.0177051
                        },
                    ],
                    price: 11
                }, {
                    coords: [{
                            lat: -12.1384095,
                            lng: -76.980506
                        },
                        {
                            lat: -12.1364375,
                            lng: -76.9906126
                        },
                        {
                            lat: -12.1402765,
                            lng: -76.9918357
                        },
                        {
                            lat: -12.1409478,
                            lng: -76.9922434
                        },
                        {
                            lat: -12.1402555,
                            lng: -76.9927369
                        },
                        {
                            lat: -12.1392486,
                            lng: -76.9936596
                        },
                        {
                            lat: -12.1416191,
                            lng: -76.9953547
                        },
                        {
                            lat: -12.1401087,
                            lng: -76.9976078
                        },
                        {
                            lat: -12.140738,
                            lng: -76.9978867
                        },
                        {
                            lat: -12.1396681,
                            lng: -76.9994317
                        },
                        {
                            lat: -12.1417869,
                            lng: -77.0017277
                        },
                        {
                            lat: -12.1420386,
                            lng: -77.002307
                        },
                        {
                            lat: -12.1401087,
                            lng: -77.0049892
                        },
                        {
                            lat: -12.140717,
                            lng: -77.0053111
                        },
                        {
                            lat: -12.1404443,
                            lng: -77.0055257
                        },
                        {
                            lat: -12.1412205,
                            lng: -77.0059763
                        },
                        {
                            lat: -12.1417449,
                            lng: -77.0058904
                        },
                        {
                            lat: -12.1428043,
                            lng: -77.0056759
                        },
                        {
                            lat: -12.1438007,
                            lng: -77.0040558
                        },
                        {
                            lat: -12.1443784,
                            lng: -77.0043654
                        },
                        {
                            lat: -12.1463712,
                            lng: -77.0012755
                        },
                        {
                            lat: -12.1457,
                            lng: -77.0005031
                        },
                        {
                            lat: -12.1476718,
                            lng: -76.9983144
                        },
                        {
                            lat: -12.1476299,
                            lng: -76.9976706
                        },
                        {
                            lat: -12.148448,
                            lng: -76.9964905
                        },
                        {
                            lat: -12.1482382,
                            lng: -76.9960184
                        },
                        {
                            lat: -12.1462664,
                            lng: -76.9947953
                        },
                        {
                            lat: -12.1481123,
                            lng: -76.9918127
                        },
                        {
                            lat: -12.1455741,
                            lng: -76.9884009
                        },
                        {
                            lat: -12.147483,
                            lng: -76.9867487
                        },
                        {
                            lat: -12.1496856,
                            lng: -76.9826932
                        },
                        {
                            lat: -12.1384095,
                            lng: -76.980506
                        },
                    ],
                    price: 11
                }, {
                    coords: [{
                            lat: -12.078217,
                            lng: -76.9761072
                        },
                        {
                            lat: -12.0787835,
                            lng: -76.9747554
                        },
                        {
                            lat: -12.0793501,
                            lng: -76.9746266
                        },
                        {
                            lat: -12.0792242,
                            lng: -76.9738541
                        },
                        {
                            lat: -12.0808188,
                            lng: -76.9738756
                        },
                        {
                            lat: -12.0801474,
                            lng: -76.9706569
                        },
                        {
                            lat: -12.0815952,
                            lng: -76.9705067
                        },
                        {
                            lat: -12.08533,
                            lng: -76.969112
                        },
                        {
                            lat: -12.0861693,
                            lng: -76.9677602
                        },
                        {
                            lat: -12.087722,
                            lng: -76.9669019
                        },
                        {
                            lat: -12.0925058,
                            lng: -76.9672237
                        },
                        {
                            lat: -12.0950236,
                            lng: -76.9679104
                        },
                        {
                            lat: -12.0968699,
                            lng: -76.9699274
                        },
                        {
                            lat: -12.098968,
                            lng: -76.9691764
                        },
                        {
                            lat: -12.1003318,
                            lng: -76.9650136
                        },
                        {
                            lat: -12.1013179,
                            lng: -76.9647775
                        },
                        {
                            lat: -12.102346,
                            lng: -76.9639407
                        },
                        {
                            lat: -12.1026397,
                            lng: -76.9629966
                        },
                        {
                            lat: -12.1041923,
                            lng: -76.961988
                        },
                        {
                            lat: -12.1067729,
                            lng: -76.96555
                        },
                        {
                            lat: -12.1090388,
                            lng: -76.9646703
                        },
                        {
                            lat: -12.1112417,
                            lng: -76.9670306
                        },
                        {
                            lat: -12.1137383,
                            lng: -76.9688974
                        },
                        {
                            lat: -12.1147873,
                            lng: -76.967567
                        },
                        {
                            lat: -12.1147873,
                            lng: -76.9632755
                        },
                        {
                            lat: -12.1104198,
                            lng: -76.958961
                        },
                        {
                            lat: -12.109077,
                            lng: -76.958725
                        },
                        {
                            lat: -12.1085106,
                            lng: -76.9590468
                        },
                        {
                            lat: -12.1104827,
                            lng: -76.954884
                        },
                        {
                            lat: -12.108091,
                            lng: -76.9539184
                        },
                        {
                            lat: -12.1065804,
                            lng: -76.953618
                        },
                        {
                            lat: -12.103748,
                            lng: -76.954648
                        },
                        {
                            lat: -12.1033913,
                            lng: -76.9550342
                        },
                        {
                            lat: -12.0925651,
                            lng: -76.9599051
                        },
                        {
                            lat: -12.076595,
                            lng: -76.9634779
                        },
                        {
                            lat: -12.0751498,
                            lng: -76.963789
                        },
                        {
                            lat: -12.0725269,
                            lng: -76.9646258
                        },
                        {
                            lat: -12.0728417,
                            lng: -76.9672007
                        },
                        {
                            lat: -12.0711421,
                            lng: -76.9683809
                        },
                        {
                            lat: -12.0718765,
                            lng: -76.9690676
                        },
                        {
                            lat: -12.0709112,
                            lng: -76.9703979
                        },
                        {
                            lat: -12.0736181,
                            lng: -76.9731016
                        },
                        {
                            lat: -12.0730096,
                            lng: -76.9740887
                        },
                        {
                            lat: -12.078217,
                            lng: -76.9761072
                        },
                    ],
                    price: 11
                }, {
                    coords: [{
                            lat: -12.0730096,
                            lng: -76.9740887
                        },
                        {
                            lat: -12.0736181,
                            lng: -76.9731016
                        },
                        {
                            lat: -12.0709112,
                            lng: -76.9703979
                        },
                        {
                            lat: -12.0718765,
                            lng: -76.9690676
                        },
                        {
                            lat: -12.0711421,
                            lng: -76.9683809
                        },
                        {
                            lat: -12.0728417,
                            lng: -76.9672007
                        },
                        {
                            lat: -12.0725269,
                            lng: -76.9646258
                        },
                        {
                            lat: -12.0751498,
                            lng: -76.963789
                        },
                        {
                            lat: -12.0925651,
                            lng: -76.9599051
                        },
                        {
                            lat: -12.1033913,
                            lng: -76.9550342
                        },
                        {
                            lat: -12.103748,
                            lng: -76.954648
                        },
                        {
                            lat: -12.1065804,
                            lng: -76.953618
                        },
                        {
                            lat: -12.108091,
                            lng: -76.9539184
                        },
                        {
                            lat: -12.1104827,
                            lng: -76.954884
                        },
                        {
                            lat: -12.1086603,
                            lng: -76.9506377
                        },
                        {
                            lat: -12.1045901,
                            lng: -76.9489211
                        },
                        {
                            lat: -12.1003729,
                            lng: -76.9437927
                        },
                        {
                            lat: -12.0891059,
                            lng: -76.9479769
                        },
                        {
                            lat: -12.0814265,
                            lng: -76.9523972
                        },
                        {
                            lat: -12.0806711,
                            lng: -76.950745
                        },
                        {
                            lat: -12.0794961,
                            lng: -76.9508952
                        },
                        {
                            lat: -12.0769992,
                            lng: -76.9541353
                        },
                        {
                            lat: -12.0628774,
                            lng: -76.9607872
                        },
                        {
                            lat: -12.0656473,
                            lng: -76.9680613
                        },
                        {
                            lat: -12.0669692,
                            lng: -76.9698208
                        },
                        {
                            lat: -12.0671581,
                            lng: -76.971516
                        },
                        {
                            lat: -12.0730096,
                            lng: -76.9740887
                        },
                    ],
                    price: 12
                },

            ];



            let gMapsPolygons = [];


            for (let i = 0; i < allPolyCords.length; i++) {

                const polyObject = {
                    polygon: new google.maps.Polygon({
                        paths: allPolyCords[i].coords
                    }),
                    price: allPolyCords[i].price
                }

                gMapsPolygons.push(polyObject);

            }
            geocoder.geocode({
                    'address': direccion,
                    componentRestrictions: {
                        country: 'PE'
                    }
                },
                function(results, status) {
                    if (status === google.maps.GeocoderStatus.OK) {


                        let polygonsContainAddress = false;

                        for (let i = 0; i < gMapsPolygons.length; i++) {

                            if (google.maps.geometry.poly.containsLocation(results[0].geometry.location, gMapsPolygons[i].polygon)) {


                                finalShippingCost = gMapsPolygons[i].price;
                                console.warn(finalShippingCost);

                                document.getElementById("checkout").style.display = "block";
                                document.getElementById("renderedShippingCost").innerText = finalShippingCost;
                                console.log("SI ESTA EN LA ZONA");

                                document.getElementById("direccionFormateada").value = results[0].formatted_address;

                                polygonsContainAddress = true;


                                Culqi.options({
                                    style: {
                                        logo: 'https://senshi.pe/tienda/img/logo2.png',
                                        maincolor: '#000000',
                                        buttontext: '#ffffff',
                                        maintext: '#4A4A4A',
                                        desctext: '#4A4A4A'
                                    }
                                });


                                Culqi.settings({
                                    title: 'Senshi Sushi & Rolls',
                                    currency: 'PEN',
                                    description: 'Delivery Web',
                                    amount: <?php echo $total ?> + finalShippingCost * 100
                                });

                                $('#buyButton').on('click', function(e) {
                                    // Abre el formulario con la configuración en Culqi.settings

                                    Culqi.open();
                                    e.preventDefault();
                                });

                                break;
                            }

                        }

                        if (!polygonsContainAddress) {
                            document.getElementById("checkoutError").style.display = "block";
                            console.log("NO ESTA EN LA ZONA");
                            document.getElementById('mensajeError').innerHTML = 'Lo sentimos, Estás fuera de la zona de reparto contáctanos al 949115822';
                            document.getElementById("direccionFormateadaError").value = results[0].formatted_address;
                        }


                    } else if (status === google.maps.GeocoderStatus.ZERO_RESULTS) {
                        document.getElementById("checkoutError").style.display = "block";
                        console.log(results);
                        console.log("No hay resultados para tu busqueda");
                        document.getElementById('mensajeError').innerHTML = 'Lo sentimos, Estás fuera de la zona de reparto contáctanos al 949115822';
                        document.getElementById("direccionFormateadaError").value = results[0].formatted_address;

                    } else {
                        document.getElementById("checkoutError").style.display = "block";
                        console.log(results);
                        console.log("NO ESTA EN LA ZONA");
                        document.getElementById('mensajeError').innerHTML = 'Hubo un problema obteniendo la dirección';


                    }
                });
        } else {
            document.getElementById("checkoutError").style.display = "block";

            console.log("NO ESTA EN LA ZONA");
            document.getElementById('mensajeError').innerHTML = 'Inserte una dirección con numero por favor';
        }
    </script>
    <div id="checkout" class="text-center">


        <table class="table text-center table-borderless">

            <tbody>
                <tr>
                    <td>Costo de Envío</td>
                    <th class="text-info">S/. <span id="renderedShippingCost">0</span></th>


                </tr>
            </tbody>
        </table>


        <h4 id="mensajeExito" style="color: green">Felicidades! Estas en la zona de reparto</h4>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
            </div>
            <input id="direccionFormateada" readonly type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
            <input type="hidden" id="finalShippingCost" value="0">
        </div>


        <button type="button" class="btn btn-primary btn-lg" id="buyButton">PAGAR</button>
    </div>
    <div id="checkoutError" class="text-center">

        <h4 id="mensajeError" style="color: #000000"></h4>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
            </div>
            <input id="direccionFormateadaError" readonly type="text" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div>

    </div>
<?php
}
?>
<script>
    function culqi() {
        if (Culqi.token) { // ¡Objeto Token creado exitosamente!


            let token = Culqi.token.id;
            console.log('Se ha creado un token:' + token);


            let url = "script/checkout.php";

            let datos = new FormData();

            datos.append('finalShippingCost', finalShippingCost);


            document.getElementById("loading").style.display = "block";


            fetch('utils/changeShippingCost.php', {
                body: datos,
                method: 'POST'
            }).then(value => {
                if (value.ok) {

                    return value.text()
                }
            }).then(value => {
                console.warn(value);
                window.location = 'script/checkout.php?token=' + token;
            })


        } else {

            console.log(Culqi.error);
            alert('Error 500, contacte al administrador');
            console.log(Culqi.error.user_message);


        }

    }
</script>
<div style="display: none" id="loading" class="loading">Loading&#8230;</div>