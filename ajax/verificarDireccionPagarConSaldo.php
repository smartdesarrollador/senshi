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
$apellido = $_SESSION['current_customer_apellido'];
$telefono = limpiar($_POST['telefono']);
$distrito = $_POST['distrito'];
$referencia = $_POST['referencia'];


$horarioPedido = limpiar($_POST['horario']);

$total = $_POST['total'] * 100;

if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {
} else {
    if ($direccion == '') {
        echo '<h5  class="text-center text-danger">Falta la direccion de Envío</h5>';
        exit();
    }
}

if ($telefono == '') {
    echo '<h5  class="text-center text-danger">Falta el teléfono</h5>';
    exit();
}
if ($_POST['tipoDocumento']=='boleta'){
    if (strlen($dni) < 8) {
        echo '<strong class="text-center" style="color: red">DNI Invalido</strong>';
        exit();
    }
}else{
    $_SESSION['current_customer_ruc'] = $_POST['ruc'];
    $_SESSION['current_customer_razonSocial'] = $_POST['razonSocial'];
    $_SESSION['current_customer_direccionFiscal'] = $_POST['direccionFiscal'];
}
if ($fechaNacimiento == '') {

    echo '<h5 class="text-center text-danger">Falta fecha de Nacimiento</h5>';
    exit();
}
if (!isset($_SESSION['current_customer_idCliente'])) {
    echo '<h5 class="text-center text-danger">Error de autorización, por favor refresca la pagina e intentalo de nuevo</h5>';
    exit();
}
if ($distrito == '') {

    echo '<strong class="text-center" style="color: red">Ingresa un distrito válido</strong>';
    exit();
}


$idCliente = $_SESSION['current_customer_idCliente'];


if (strlen($_POST['lat']) > 2) {
    $clienteActualizado = $objCliente->updateCustomerDetailsWithLatLng($dni, $direccion, $telefono, $idCliente, $fechaNacimiento, $apellido,$_POST['lat'],$_POST['lng']);
    $_SESSION['current_customer_lat'] = trim($_POST['lat']);
    $_SESSION['current_customer_lng'] = trim($_POST['lng']);

}else{
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
$_SESSION['current_customer_apellido'] = $apellido;

$_SESSION['horario_pedido'] = $horarioPedido;
$_SESSION['$current_customer_distrito'] = $distrito;
$_SESSION['$current_customer_referencia'] = $referencia;


if ($_SESSION['envio'] == 'recojo' || $_SESSION['solo_gift_cards'] == 'true') {

    ?>
    <script>
        var finalShippingCost = 0;
    </script>
    <div class="row">
        <div class="col text-center">
            <button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-primary btn-lg"
                    id="buyButton">
                PAGAR
            </button>
            <strong class="text-info d-block">Tienes saldo suficiente para realizar esta compra</strong>
        </div>
    </div>

    <?php
} else {
    ?>

    <script>
        var finalShippingCost = 0;
        document.getElementById("checkout").style.display = "none";
        document.getElementById("checkoutError").style.display = "none";
        var direccion = '<?php echo $direccion.' '.$distrito; ?>';

        var geocoder = new google.maps.Geocoder();
        var hasNumber = /\d/;

        if (hasNumber.test(direccion)) {


            console.log("DIRECCION CONTIENE NUMEROS");

           const allPolyCords = [
                {
                    coords: [
                        {lat: -12.1032740, lng: -77.0339785},
                        {lat: -12.1031634, lng: -77.0360879},
                        {lat: -12.1027591, lng: -77.0385836},
                        {lat: -12.1034934, lng: -77.0386694},
                        {lat: -12.1018569, lng: -77.0461152},
                        {lat: -12.1028640, lng: -77.0464585},
                        {lat: -12.1029479, lng: -77.0515226},
                        {lat: -12.0990455, lng: -77.0511363},
                        {lat: -12.0991713, lng: -77.0532392},
                        {lat: -12.0981223, lng: -77.0560287},
                        {lat: -12.0961081, lng: -77.0598052},
                        {lat: -12.0934225, lng: -77.0594190},
                        {lat: -12.0929609, lng: -77.0620368},
                        {lat: -12.0901680, lng: -77.0659054},
                        {lat: -12.0722071, lng: -77.0513142},
                        {lat: -12.0753965, lng: -77.0474518},
                        {lat: -12.0751447, lng: -77.0420444},
                        {lat: -12.0736339, lng: -77.0305431},
                        {lat: -12.0907274, lng: -77.0227975},
                        {lat: -12.1027285, lng: -77.0273052},
                        {lat: -12.1035258, lng: -77.0315323},
                        {lat: -12.1029173, lng: -77.0316932},
                        {lat: -12.1032740, lng: -77.0339785},
                    ],
                    price: 6
                },
                {
                    coords: [
                        {lat: -12.0824113, lng: -77.0265283},
                        {lat: -12.0736339, lng: -77.0305431},
                        {lat: -12.0637184, lng: -77.0339800},
                        {lat: -12.0653132, lng: -77.0456100},
                        {lat: -12.0663204, lng: -77.0462967},
                        {lat: -12.0652292, lng: -77.0475412},
                        {lat: -12.0661105, lng: -77.0481420},
                        {lat: -12.0652292, lng: -77.0493866},
                        {lat: -12.0664463, lng: -77.0503307},
                        {lat: -12.0654810, lng: -77.0512749},
                        {lat: -12.0666141, lng: -77.0519615},
                        {lat: -12.0656909, lng: -77.0532490},
                        {lat: -12.0664463, lng: -77.0540643},
                        {lat: -12.0674955, lng: -77.0611883},
                        {lat: -12.0676633, lng: -77.0648790},
                        {lat: -12.0688804, lng: -77.0650078},
                        {lat: -12.0696358, lng: -77.0670248},
                        {lat: -12.0703072, lng: -77.0659948},
                        {lat: -12.0722796, lng: -77.0674539},
                        {lat: -12.0721118, lng: -77.0686985},
                        {lat: -12.0768120, lng: -77.0696641},
                        {lat: -12.0768959, lng: -77.0691491},
                        {lat: -12.0798964, lng: -77.0702005},
                        {lat: -12.0815121, lng: -77.0712090},
                        {lat: -12.0820318, lng: -77.0702005},
                        {lat: -12.0891334, lng: -77.0731845},
                        {lat: -12.0951971, lng: -77.0753088},
                        {lat: -12.0959314, lng: -77.0731845},
                        {lat: -12.0965609, lng: -77.0734634},
                        {lat: -12.0997710, lng: -77.0699873},
                        {lat: -12.1033797, lng: -77.0633354},
                        {lat: -12.1066526, lng: -77.0584859},
                        {lat: -12.1079954, lng: -77.0559110},
                        {lat: -12.1091703, lng: -77.0528211},
                        {lat: -12.1109326, lng: -77.0505895},
                        {lat: -12.1116040, lng: -77.0499887},
                        {lat: -12.1108907, lng: -77.0492162},
                        {lat: -12.1117299, lng: -77.0483579},
                        {lat: -12.1111424, lng: -77.0478429},
                        {lat: -12.1103032, lng: -77.0471563},
                        {lat: -12.1112263, lng: -77.0464696},
                        {lat: -12.1128208, lng: -77.0447960},
                        {lat: -12.1136600, lng: -77.0439806},
                        {lat: -12.1148769, lng: -77.0428862},
                        {lat: -12.1130306, lng: -77.0408907},
                        {lat: -12.1121495, lng: -77.0399894},
                        {lat: -12.1131145, lng: -77.0390668},
                        {lat: -12.1106389, lng: -77.0370926},
                        {lat: -12.1094430, lng: -77.0361485},
                        {lat: -12.1107018, lng: -77.0341529},
                        {lat: -12.1096528, lng: -77.0337023},
                        {lat: -12.1095689, lng: -77.0323290},
                        {lat: -12.1096319, lng: -77.0304408},
                        {lat: -12.1092332, lng: -77.0295395},
                        {lat: -12.1086877, lng: -77.0264926},
                        {lat: -12.1056928, lng: -77.0186551},
                        {lat: -12.1021045, lng: -77.0187311},
                        {lat: -12.1022509, lng: -77.0173908},
                        {lat: -12.0978858, lng: -77.0180200},
                        {lat: -12.0957297, lng: -77.0139626},
                        {lat: -12.0951261, lng: -77.0129951},
                        {lat: -12.0898388, lng: -77.0143254},
                        {lat: -12.0860621, lng: -77.0153769},
                        {lat: -12.0833764, lng: -77.0138427},
                        {lat: -12.0812781, lng: -77.0191481},
                        {lat: -12.0819076, lng: -77.0242685},
                        {lat: -12.0824113, lng: -77.0265283},
                    ],
                    price: 7.5
                },
                {
                    coords: [
                        {lat: -12.0833764, lng: -77.0138427},
                        {lat: -12.0849390, lng: -77.0097885},
                        {lat: -12.0841417, lng: -77.0042310},
                        {lat: -12.0882752, lng: -77.0033941},
                        {lat: -12.0943389, lng: -77.0026860},
                        {lat: -12.0947165, lng: -77.0059690},
                        {lat: -12.0966468, lng: -77.0056043},
                        {lat: -12.0981575, lng: -77.0060763},
                        {lat: -12.1009899, lng: -77.0063338},
                        {lat: -12.1040950, lng: -77.0061836},
                        {lat: -12.1043258, lng: -77.0095095},
                        {lat: -12.1044517, lng: -77.0102176},
                        {lat: -12.1053749, lng: -77.0099172},
                        {lat: -12.1053958, lng: -77.0108828},
                        {lat: -12.1073890, lng: -77.0104751},
                        {lat: -12.1079554, lng: -77.0104322},
                        {lat: -12.1081443, lng: -77.0110974},
                        {lat: -12.1089415, lng: -77.0109687},
                        {lat: -12.1089415, lng: -77.0112262},
                        {lat: -12.1099066, lng: -77.0110116},
                        {lat: -12.1099486, lng: -77.0116339},
                        {lat: -12.1105150, lng: -77.0116553},
                        {lat: -12.1122983, lng: -77.0110116},
                        {lat: -12.1124662, lng: -77.0114514},
                        {lat: -12.1125081, lng: -77.0121060},
                        {lat: -12.1126025, lng: -77.0126692},
                        {lat: -12.1127389, lng: -77.0147774},
                        {lat: -12.1128019, lng: -77.0163331},
                        {lat: -12.1162216, lng: -77.0159898},
                        {lat: -12.1161272, lng: -77.0182643},
                        {lat: -12.1186762, lng: -77.0184145},
                        {lat: -12.1194944, lng: -77.0184145},
                        {lat: -12.1196622, lng: -77.0204530},
                        {lat: -12.1199979, lng: -77.0237145},
                        {lat: -12.1191797, lng: -77.0258603},
                        {lat: -12.1199664, lng: -77.0257208},
                        {lat: -12.1204437, lng: -77.0266811},
                        {lat: -12.1204175, lng: -77.0276413},
                        {lat: -12.1223056, lng: -77.0278237},
                        {lat: -12.1224315, lng: -77.0291326},
                        {lat: -12.1230189, lng: -77.0291540},
                        {lat: -12.1228799, lng: -77.0298943},
                        {lat: -12.1225102, lng: -77.0313964},
                        {lat: -12.1233887, lng: -77.0322654},
                        {lat: -12.1243944, lng: -77.0331184},
                        {lat: -12.1238483, lng: -77.0337916},
                        {lat: -12.1233551, lng: -77.0337883},
                        {lat: -12.1233654, lng: -77.0368963},
                        {lat: -12.1234701, lng: -77.0390601},
                        {lat: -12.1229874, lng: -77.0425436},
                        {lat: -12.1208948, lng: -77.0441690},
                        {lat: -12.1198721, lng: -77.0452366},
                        {lat: -12.1189594, lng: -77.0456550},
                        {lat: -12.1147949, lng: -77.0503864},
                        {lat: -12.1086478, lng: -77.0577893},
                        {lat: -12.1061721, lng: -77.0592270},
                        {lat: -12.1033797, lng: -77.0633354},
                        {lat: -12.0997710, lng: -77.0699873},
                        {lat: -12.0965609, lng: -77.0734634},
                        {lat: -12.0937090, lng: -77.0806869},
                        {lat: -12.0896386, lng: -77.0782622},
                        {lat: -12.0893448, lng: -77.0784553},
                        {lat: -12.0878761, lng: -77.0814594},
                        {lat: -12.0849596, lng: -77.0798715},
                        {lat: -12.0835538, lng: -77.0826181},
                        {lat: -12.0783647, lng: -77.0812999},
                        {lat: -12.0749090, lng: -77.0798715},
                        {lat: -12.0730834, lng: -77.0784982},
                        {lat: -12.0686848, lng: -77.0781805},
                        {lat: -12.0678455, lng: -77.0738890},
                        {lat: -12.0676633, lng: -77.0648790},
                        {lat: -12.0674955, lng: -77.0611883},
                        {lat: -12.0664463, lng: -77.0540643},
                        {lat: -12.0656909, lng: -77.0532490},
                        {lat: -12.0666141, lng: -77.0519615},
                        {lat: -12.0654810, lng: -77.0512749},
                        {lat: -12.0664463, lng: -77.0503307},
                        {lat: -12.0652292, lng: -77.0493866},
                        {lat: -12.0661105, lng: -77.0481420},
                        {lat: -12.0652292, lng: -77.0475412},
                        {lat: -12.0663204, lng: -77.0462967},
                        {lat: -12.0653132, lng: -77.0456100},
                        {lat: -12.0637184, lng: -77.0339800},
                        {lat: -12.0736339, lng: -77.0305431},
                        {lat: -12.0824113, lng: -77.0265283},
                        {lat: -12.0812781, lng: -77.0191481},
                        {lat: -12.0833764, lng: -77.0138427},
                    ],
                    price: 10
                },
                {
                    coords: [
                        {lat: -12.0841417, lng: -77.0042310},
                        {lat: -12.0833823, lng: -76.9988333},
                        {lat: -12.0825849, lng: -76.9972025},
                        {lat: -12.1007550, lng: -76.9944559},
                        {lat: -12.1033147, lng: -76.9941984},
                        {lat: -12.1034196, lng: -76.9966232},
                        {lat: -12.1061051, lng: -76.9963228},
                        {lat: -12.1061680, lng: -76.9974386},
                        {lat: -12.1068394, lng: -76.9973313},
                        {lat: -12.1070282, lng: -77.0006143},
                        {lat: -12.1117068, lng: -77.0002710},
                        {lat: -12.1120320, lng: -77.0022987},
                        {lat: -12.1126299, lng: -77.0022129},
                        {lat: -12.1135006, lng: -77.0021271},
                        {lat: -12.1136475, lng: -77.0027064},
                        {lat: -12.1140566, lng: -77.0025777},
                        {lat: -12.1141090, lng: -77.0029317},
                        {lat: -12.1143503, lng: -77.0032214},
                        {lat: -12.1171196, lng: -77.0059894},
                        {lat: -12.1162909, lng: -77.0067726},
                        {lat: -12.1165217, lng: -77.0072876},
                        {lat: -12.1169728, lng: -77.0071589},
                        {lat: -12.1177595, lng: -77.0087789},
                        {lat: -12.1197735, lng: -77.0074056},
                        {lat: -12.1221022, lng: -77.0103668},
                        {lat: -12.1221652, lng: -77.0108818},
                        {lat: -12.1243260, lng: -77.0108174},
                        {lat: -12.1243470, lng: -77.0130276},
                        {lat: -12.1231722, lng: -77.0130490},
                        {lat: -12.1235078, lng: -77.0180701},
                        {lat: -12.1264029, lng: -77.0180701},
                        {lat: -12.1261722, lng: -77.0190142},
                        {lat: -12.1268435, lng: -77.0189284},
                        {lat: -12.1269064, lng: -77.0214175},
                        {lat: -12.1275987, lng: -77.0242285},
                        {lat: -12.1282700, lng: -77.0238422},
                        {lat: -12.1274099, lng: -77.0260094},
                        {lat: -12.1292560, lng: -77.0260094},
                        {lat: -12.1288994, lng: -77.0266317},
                        {lat: -12.1298644, lng: -77.0265030},
                        {lat: -12.1309763, lng: -77.0269965},
                        {lat: -12.1307455, lng: -77.0275973},
                        {lat: -12.1317105, lng: -77.0275115},
                        {lat: -12.1313749, lng: -77.0283483},
                        {lat: -12.1324867, lng: -77.0284556},
                        {lat: -12.1323596, lng: -77.0307904},
                        {lat: -12.1300362, lng: -77.0344168},
                        {lat: -12.1232233, lng: -77.0409613},
                        {lat: -12.1229874, lng: -77.0425436},
                        {lat: -12.1208948, lng: -77.0441690},
                        {lat: -12.1198721, lng: -77.0452366},
                        {lat: -12.1189594, lng: -77.0456550},
                        {lat: -12.1086478, lng: -77.0577893},
                        {lat: -12.1061721, lng: -77.0592270},
                        {lat: -12.1033797, lng: -77.0633354},
                        {lat: -12.0997710, lng: -77.0699873},
                        {lat: -12.0965609, lng: -77.0734634},
                        {lat: -12.0937090, lng: -77.0806869},
                        {lat: -12.0896386, lng: -77.0782622},
                        {lat: -12.0878761, lng: -77.0814594},
                        {lat: -12.0849596, lng: -77.0798715},
                        {lat: -12.0835538, lng: -77.0826181},
                        {lat: -12.0783647, lng: -77.0812999},
                        {lat: -12.0749090, lng: -77.0798715},
                        {lat: -12.0730834, lng: -77.0784982},
                        {lat: -12.0686848, lng: -77.0781805},
                        {lat: -12.0678455, lng: -77.0738890},
                        {lat: -12.0674268, lng: -77.0608868},
                        {lat: -12.0664463, lng: -77.0540643},
                        {lat: -12.0656909, lng: -77.0532490},
                        {lat: -12.0666141, lng: -77.0519615},
                        {lat: -12.0654810, lng: -77.0512749},
                        {lat: -12.0664463, lng: -77.0503307},
                        {lat: -12.0652292, lng: -77.0493866},
                        {lat: -12.0661105, lng: -77.0481420},
                        {lat: -12.0652292, lng: -77.0475412},
                        {lat: -12.0663204, lng: -77.0462967},
                        {lat: -12.0653132, lng: -77.0456100},
                        {lat: -12.0637184, lng: -77.0339800},
                        {lat: -12.0736339, lng: -77.0305431},
                        {lat: -12.0824113, lng: -77.0265283},
                        {lat: -12.0812781, lng: -77.0191481},
                        {lat: -12.0833764, lng: -77.0138427},
                        {lat: -12.0849390, lng: -77.0097885},
                        {lat: -12.0841417, lng: -77.0042310},
                    ],
                    price: 11
                }, {
                    coords: [
                        {lat: -12.1340914, lng: -77.0290991},
                        {lat: -12.1401211, lng: -77.0275465},
                        {lat: -12.1360094, lng: -77.0241991},
                        {lat: -12.1339955, lng: -77.0193068},
                        {lat: -12.1339116, lng: -77.0157877},
                        {lat: -12.1342473, lng: -77.0118395},
                        {lat: -12.1430999, lng: -77.0056597},
                        {lat: -12.1425126, lng: -76.9976345},
                        {lat: -12.1221980, lng: -76.9979498},
                        {lat: -12.1200353, lng: -76.9761282},
                        {lat: -12.0868859, lng: -76.9809347},
                        {lat: -12.0814305, lng: -76.9859558},
                        {lat: -12.0839903, lng: -76.9895607},
                        {lat: -12.0849975, lng: -76.9966417},
                        {lat: -12.0827078, lng: -76.9969106},
                        {lat: -12.0847385, lng: -77.0103363},
                        {lat: -12.0806634, lng: -77.0196072},
                        {lat: -12.0822581, lng: -77.0262590},
                        {lat: -12.0634699, lng: -77.0340296},
                        {lat: -12.0650227, lng: -77.0452735},
                        {lat: -12.0659040, lng: -77.0464751},
                        {lat: -12.0652325, lng: -77.0475050},
                        {lat: -12.0661558, lng: -77.0483634},
                        {lat: -12.0652325, lng: -77.0495650},
                        {lat: -12.0659879, lng: -77.0504233},
                        {lat: -12.0653164, lng: -77.0514533},
                        {lat: -12.0662397, lng: -77.0521828},
                        {lat: -12.0656732, lng: -77.0532557},
                        {lat: -12.0667853, lng: -77.0542213},
                        {lat: -12.0664495, lng: -77.0546075},
                        {lat: -12.0673737, lng: -77.0627511},
                        {lat: -12.0677011, lng: -77.0741537},
                        {lat: -12.0683725, lng: -77.0780590},
                        {lat: -12.0738875, lng: -77.0789991},
                        {lat: -12.0779162, lng: -77.0816598},
                        {lat: -12.0842109, lng: -77.0826040},
                        {lat: -12.0853020, lng: -77.0799432},
                        {lat: -12.0880087, lng: -77.0815311},
                        {lat: -12.0893096, lng: -77.0790420},
                        {lat: -12.0934639, lng: -77.0820032},
                        {lat: -12.0975741, lng: -77.0728266},
                        {lat: -12.0999659, lng: -77.0708954},
                        {lat: -12.1055468, lng: -77.0616257},
                        {lat: -12.1057900, lng: -77.0613366},
                        {lat: -12.1060226, lng: -77.0615495},
                        {lat: -12.1076710, lng: -77.0602683},
                        {lat: -12.1146783, lng: -77.0501403},
                        {lat: -12.1166504, lng: -77.0500115},
                        {lat: -12.1196997, lng: -77.0459729},
                        {lat: -12.1239932, lng: -77.0419005},
                        {lat: -12.1285319, lng: -77.0361453},
                        {lat: -12.1318257, lng: -77.0319315},
                        {lat: -12.1340914, lng: -77.0290991},
                    ],
                    price: 12
                },

            ];





            let gMapsPolygons = [];


            for (let i = 0; i < allPolyCords.length; i++) {

                const polyObject = {
                    polygon: new google.maps.Polygon({paths: allPolyCords[i].coords}),
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
                function (results, status) {
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
                                break;
                            }

                        }

                        if (!polygonsContainAddress) {
                            document.getElementById("checkoutError").style.display = "block";
                            console.log("NO ESTA EN LA ZONA");
                            document.getElementById('mensajeError').innerHTML = 'Lo sentimos, Estás fuera de la zona de reparto contáctanos al 967175915';
                            document.getElementById("direccionFormateadaError").value = results[0].formatted_address;
                        }




                    } else if (status === google.maps.GeocoderStatus.ZERO_RESULTS) {
                        document.getElementById("checkoutError").style.display = "block";
                        console.log(results);
                        console.log("No hay resultados para tu busqueda");
                        document.getElementById('mensajeError').innerHTML = 'Lo sentimos, Estás fuera de la zona de reparto contáctanos al 967175915';
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

        <h3 id="mensajeExito" style="color: green">Felicidades! Estas en la zona de reparto</h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                                                    aria-hidden="true"></i></span>
            </div>
            <input id="direccionFormateada" readonly type="text" class="form-control" aria-label="Username"
                   aria-describedby="basic-addon1">
        </div>


        <button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-primary btn-lg"
                id="buyButton">
            PAGAR
        </button>
        <strong class="text-info d-block">Tienes saldo suficiente para realizar esta compra</strong>
    </div>
    <div id="checkoutError" class="text-center">

        <h3 id="mensajeError" style="color: #000000"></h3>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1"><i class="fa fa-map-marker"
                                                                    aria-hidden="true"></i></span>
            </div>
            <input id="direccionFormateadaError" readonly type="text" class="form-control" aria-label="Username"
                   aria-describedby="basic-addon1">
        </div>

    </div>
    <?php
}
?>
<div class="modal fade" data-backdrop="static" id="exampleModal" tabindex="-1" role="dialog"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="col text-center">
                        <img style="width: 130px" src="assets/images/logoMain.png" alt="">
                    </div>
                </div>

                <div class="row">
                    <div class="col text-center">
                        <h6>Tienes saldo suficiente en tu cuenta para realizar este pedido, se te descontará el total
                            del pedido de tu saldo</h6>
                        <h6>Puedes revisar tu saldo en tu cuenta</h6>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <a onclick="checkountConSaldo()" class="btn btn-primary btn-lg text-white">Realizar Pedido</a>
            </div>
        </div>
    </div>
</div>
<script>
    function checkountConSaldo() {

        let datos = new FormData();

        datos.append('finalShippingCost', finalShippingCost);
        fetch('utils/changeShippingCost.php', {body: datos, method: 'POST'}).then(value => {
                if (value.ok) {

                    return value.text()
                }
            }
        ).then(value => {
            window.location = 'script/checkoutConSaldo.php?token=' + '2zKcGKn5dF7xGXCAuyw89v1j9D1b48N8h0XOIYX2sVbVTsAiL5WAw7nUL6w4';
            mostrarLoading();
        })
    }
</script>
<div style="display: none" id="loading" class="loading">Loading&#8230;</div>
