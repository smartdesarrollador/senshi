<?php
session_start();
error_reporting(0);
$page = "index";
include "./class/TipoProductoClass.php";

$objTipoProducto = new TipoProductoClass();

$listaCategorias = $objTipoProducto->getTipoProductos();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Senshi Sushi/Bar</title>

    <?php include 'templates/metalink.php'; ?>

    <script src="js/registerWorker.js"></script>
    <link rel="stylesheet" href="css/video-js.css">
    <link rel="stylesheet" href="css/cityVideoJs.css">

    <style>
        input[type="radio"] {
            /* remove standard background appearance */
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            /* create custom radiobutton appearance */
            display: inline-block;
            width: 18px;
            height: 18px;

            /* background-color only for content */
            background-clip: content-box;
            border: 2px solid #bbbbbb;
            background-color: #e7e6e7;
            border-radius: 50%;
        }

        /* appearance for checked radiobutton */
        input[type="radio"]:checked {
            background-color: black;
        }
    </style>
</head>

<body>
    <?php if ($_GET['code'] == "emailExiste") {
    ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-danger emailExiste alert-dismissible fade show" role="alert">
                <strong>Error!</strong> El correo ya esta registrado.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>


            </div>
        </div>
        <?php
    } ?><?php if ($_GET['code'] == "incorrectPass") {
        ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-danger emailExiste alert-dismissible fade show" role="alert">
                <strong>Error!</strong> Tu contraseña es incorrecta.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
        <?php
        } ?><?php if ($_GET['code'] == "notExistUser") {
            ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-danger emailExiste alert-dismissible fade show" role="alert">
                <strong>Error!</strong> El Correo no existe, regístrate.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php
            } ?>

    <?php if ($_GET['code'] == "sendResetMail") {
    ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-success emailExiste alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> Se ha enviado un link de recuperación a tu correo.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php
    } ?>

    <?php if ($_GET['code'] == "passChanged") {
    ?>

        <div style="position: fixed;z-index: 999;margin-top: 20px " class="container alertaCorreo  ">
            <div class="alert alert-success emailExiste alert-dismissible fade show" role="alert">
                <strong>Correcto!</strong> Se ha cambiado la contraseña correctamente.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    <?php
    } ?>
    <?php include 'templates/navbar.php'; ?>


    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="margin-top:95px">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/bannersv2/banner-1-min.jpg" class="d-none d-md-block w-100" alt="banner senshi">
                <img src="img/bannersv2/bannerMovil.jpg" class="d-block d-md-none w-100" alt="banner senshi">
            </div>

            <div class="carousel-item">
                <img src="img/bannersv2/banner-2-min.jpg" class="d-none d-md-block w-100" alt="banner senshi">
                <img src="img/bannersv2/bannerNovil2.jpg" class="d-block d-md-none w-100" alt="banner senshi">
            </div>


        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>





    <div class="row mx-0 px-0 my-5">
        <div class="col-sm-12 col-sm-12 text-center mx-0 px-0">
            <a href="carta.php" class="btn btn-danger bg-danger text-white font-weight-bolder">
                ORDENA AQUÍ
            </a>
        </div>
    </div>


    <div class="row px-0 mx-0">
        <div class="col mx-0 px-0 pt-5" style="padding-top: 65px;background-color: #c1c1c152">
            <!-- Slider main container -->
            <div class="swiper-container">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">


                    <?php foreach ($listaCategorias

                        as $categoria) { ?>
                        <div class="swiper-slide">
                            <div <?php
                                    //si es sushi lo manda a otra pagina
                                    if ($categoria['idTipoProducto'] == 31) { ?> onclick='window.location = "senshi-sushi.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"' <?php } elseif ($categoria['idTipoProducto'] == 27) {
                                                                                                                                                                                ?> onclick='window.location = "senshi-paquetes.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"' <?php
                                                                                                                                                                                                                                                                                    } elseif ($categoria['idTipoProducto'] == 29) {
                                                                                                                                                                                                                                                                                        ?> onclick='window.location = "senshi-gift-cards.php"' <?php
                                                                                                                                                                                                                                                                                                                                            } elseif ($categoria['idTipoProducto'] == 25) {
                                                                                                                                                                                                                                                                                                                                                ?> onclick='window.location = "senshi-makis.php?tipo=25"' <?php
                                                                                                                                                                                                                                                                                                                                                                                                        } elseif ($categoria['idTipoProducto'] == 33) {
                                                                                                                                                                                                                                                                                                                                                                                                            ?> onclick='window.location = "senshi-tacos.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"' <?php
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            } else { ?> onclick='window.location = "platos.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"' <?php } ?> class="card mr-auto ml-auto card-categoria">

                                <div class="card-body">
                                    <img class="img-categoria" src="img/carta/categorias/<?php echo $categoria['imageUrl'] ?>" alt="<?php echo $categoria['nombre'] ?> - Senshi Sushi Bar">
                                </div>
                                <div style="margin-top: -120px;z-index: 1">
                                    <h3 onclick='window.location = "platos.php?tipo=<?php echo $categoria['idTipoProducto'] ?>"' class="text-white text-center font-weight-bolder"><?php echo $categoria['nombre'] ?></h3>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <!-- Add Arrows -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row my-4">
            <div class="col">
                <h5 class="text-left ">Si estás fuera de la zona de reparto,
                    contáctanos al <a target="_blank" href="https://api.whatsapp.com/send?phone=51967175915"><i style="color: #128C7E" class="fab fa-2x fa-whatsapp"></i></a></h5>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <!--  <iframe src="https://www.google.com/maps/d/embed?mid=1JG4Tub1V27G5Pk2LPTSPDl50GtoyRFu-" width="100%" height="400"></iframe> -->


                <iframe src="https://www.google.com/maps/d/embed?mid=1L3g8tc58sSF6bMCZFDeyAbDeQli07i6N" width="100%" height="400"></iframe>
            </div>
        </div>
    </div>

    <!-- Video Senshi -->


    <div class="row mb-5 mx-0">
        <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-4 offset-xl-4 offset-lg-3">
            <video style="width: 100%" id="my-video" class="video-js vjs-theme-city" controls preload="auto" poster="" data-setup="{}">
                <source src="videos/video_senshi.mp4" type="video/mp4" />
                <p class="vjs-no-js">
                    To view this video please enable JavaScript, and consider upgrading to a
                    web browser that
                    <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                </p>
            </video>
        </div>
    </div>



    <!-- /Video Senshi -->


    <div class="social">
        <ul>
            <li><a style="padding: 19px " href="https://www.facebook.com/SenshiSushiRolls" target="_blank" class="icon-facebook">
                    <i class="fab fa-facebook-f"></i>
                </a></li>
            <li><a style="padding: 20px " href="https://www.instagram.com/senshi.sushi/?hl=es-la" target="_blank" class="icon-instagram">
                    <i class="fab fa-instagram"></i>
                </a></li>
            <li><a style="padding: 15px " href="https://api.whatsapp.com/send?phone=51967175915" target="_blank" class="icon-whatsapp">
                    <i class="fab fa-whatsapp"></i><br>
                    <span style="font-size:10px;margin:0px;padding:0%;">Lince</span>
                </a>
            </li>
            <li><a style="padding: 15px; background-color:#1fb154;" href="https://api.whatsapp.com/send?phone=51949115822" target="_blank" class="icon-whatsapp-san-borja">
                    <i class="fab fa-whatsapp"></i><br>
                    <span style="font-size:10px;margin:0px;padding:0px;">San</span><br>
                    <span style="font-size:10px;margin:0px;padding:0px;">Borja</span>
                </a>

            </li>
        </ul>
    </div>
    <div class="modal fade" id="staticBackdrop" data-keyboard="false" tabindex="-1" role="dialog" style="z-index: 20001;" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-body mb-5">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <div class="row">
                        <div class="col text-center">
                            <img class="my-3" style="width: 180px" src="img/logoNegroV2.png" alt="Entrega a Domicilio Senshi">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <h5 class="text-center text-danger">IRASHIAI (BIENVENIDO) A SENSHI</h5>


                            <p class="text-center">Si no te encuentras dentro de nuestra zona de reparto, consultanos al whatsApp. Podemos llegar.</p>
                            <p class="text-center">Nuestro horario de atención es de martes a sábados de 12 pm a 3:30 pm y de 6 pm a 10 pm
                                / domingos de 12 pm a 4 pm.</p>

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6 col-sm-6 col-md-6 text-center text-md-center text-xl-center text-lg-center">

                            <div class="form-check form-check-inline">


                                <input style="transform: scale(1);" class="form-check-input" name="escogerReparto" type="radio" id="inlineCheckbox1" value="optionDireccion">

                                <label class="form-check-label d-block" for="inlineCheckbox1"></label>
                            </div>
                            <div>Quiero que me traigan el
                                pedido</div>

                        </div>
                        <div class="col-6 col-sm-6 col-md-6 text-center text-md-center text-xl-center text-lg-center">
                            <div class="form-check form-check-inline">


                                <input style="transform: scale(1);" class="form-check-input" name="escogerReparto" type="radio" id="inlineCheckbox2" value="optionRecogerPedido">

                                <label class="form-check-label d-block " for="inlineCheckbox2"></label>
                            </div>
                            <div>
                                Quiero recoger mi pedido
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3" id="rowRecogerPedido">
                        <div class="col text-center">
                            <a href="utils/cambiarMetodoDeEnvio.php?code=recojo" class="btn btn-secondary  animated fadeIn">
                                Continuar
                            </a>
                        </div>
                    </div>

                    <div class="row mt-3 " id="rowDireccion">
                        <div class="col text-center animated fadeIn">
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="direccionInput"> <strong>Verifica si tu dirección esta dentro de nuestra zona de cobertura</strong> </label>
                                        <input id="direccionInput" type="text" class="form-control " placeholder="Ingresa tu dirección ">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button id="btnVerificarDirección" class="btn btn-secondary ">
                                        Continuar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script>
        let categoria = 0;
    </script>
    <?php include 'templates/footer.php'; ?>
    <script src="js/video.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD036kBF-olP1CJdVTP7uJnl9IIsAvm7sI&libraries=geometry" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>
        $(document).ready(function() {


            $('#rowDireccion').hide();
            $('#rowRecogerPedido').hide();

            $('#staticBackdrop input[type="radio"]').on('change', function(e) {
                if (this.value === 'optionDireccion') {

                    $('#rowDireccion').show();
                    $('#rowRecogerPedido').hide();
                }
                if (this.value === 'optionRecogerPedido') {

                    $('#rowRecogerPedido').show();
                    $('#rowDireccion').hide();
                }

            });

            $('#btnVerificarDirección').click(function() {
                let direccion = $('#direccionInput').val();
                let hasNumber = /\d/;
                if (!hasNumber.test(direccion)) {
                    alert("ingrese un numero por favor");
                    return false;
                }
                $('#staticBackdrop').modal('hide');
                var geocoder = new google.maps.Geocoder();
                let deliveryCoords = [{
                        lat: -12.1410192,
                        lng: -77.0176193
                    },
                    {
                        lat: -12.1389844,
                        lng: -77.0177051
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
                        lat: -12.1357619,
                        lng: -76.9770065
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
                        lat: -12.1219411,
                        lng: -76.9649681
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
                    {
                        lat: -12.078217,
                        lng: -76.9761072
                    },
                    {
                        lat: -12.0849781,
                        lng: -76.9821524
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
                        lat: -12.081187,
                        lng: -77.0194649
                    },
                    {
                        lat: -12.0818584,
                        lng: -77.0240997
                    },
                    {
                        lat: -12.0824459,
                        lng: -77.0266532
                    },
                    {
                        lat: -12.0736173,
                        lng: -77.0303603
                    },
                    {
                        lat: -12.063755,
                        lng: -77.0341154
                    },
                    {
                        lat: -12.0654337,
                        lng: -77.0456811
                    },
                    {
                        lat: -12.0663256,
                        lng: -77.0464268
                    },
                    {
                        lat: -12.0653341,
                        lng: -77.0475801
                    },
                    {
                        lat: -12.0661997,
                        lng: -77.0482346
                    },
                    {
                        lat: -12.065161,
                        lng: -77.0494255
                    },
                    {
                        lat: -12.0664069,
                        lng: -77.0504447
                    },
                    {
                        lat: -12.0655596,
                        lng: -77.0514452
                    },
                    {
                        lat: -12.0665354,
                        lng: -77.0522472
                    },
                    {
                        lat: -12.0657275,
                        lng: -77.0532288
                    },
                    {
                        lat: -12.0664525,
                        lng: -77.0540532
                    },
                    {
                        lat: -12.0674977,
                        lng: -77.0612517
                    },
                    {
                        lat: -12.0676393,
                        lng: -77.0648673
                    },
                    {
                        lat: -12.0678591,
                        lng: -77.0738459
                    },
                    {
                        lat: -12.0686389,
                        lng: -77.0778816
                    },
                    {
                        lat: -12.0730874,
                        lng: -77.0784609
                    },
                    {
                        lat: -12.0749706,
                        lng: -77.0799683
                    },
                    {
                        lat: -12.0782595,
                        lng: -77.0813424
                    },
                    {
                        lat: -12.0836468,
                        lng: -77.0826004
                    },
                    {
                        lat: -12.0849241,
                        lng: -77.0799128
                    },
                    {
                        lat: -12.0880441,
                        lng: -77.0815455
                    },
                    {
                        lat: -12.0896754,
                        lng: -77.0782725
                    },
                    {
                        lat: -12.0937484,
                        lng: -77.0804857
                    },
                    {
                        lat: -12.0965669,
                        lng: -77.0734341
                    },
                    {
                        lat: -12.0996616,
                        lng: -77.0700706
                    },
                    {
                        lat: -12.1061786,
                        lng: -77.0592439
                    },
                    {
                        lat: -12.1087697,
                        lng: -77.0577526
                    },
                    {
                        lat: -12.1181128,
                        lng: -77.0464978
                    },
                    {
                        lat: -12.1193086,
                        lng: -77.0457253
                    },
                    {
                        lat: -12.1207352,
                        lng: -77.0442769
                    },
                    {
                        lat: -12.1229485,
                        lng: -77.0425603
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
                        lat: -12.1490302,
                        lng: -77.0225748
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
                        lat: -12.1477905,
                        lng: -77.0198935
                    },
                    {
                        lat: -12.1429795,
                        lng: -77.0181583
                    },
                    {
                        lat: -12.1410192,
                        lng: -77.0176193
                    },
                ];


                var polygon = new google.maps.Polygon({
                    paths: deliveryCoords
                });
                let resultado;
                geocoder.geocode({
                        'address': direccion,
                        componentRestrictions: {
                            country: 'PE'
                        }
                    },
                    function(results, status) {
                        if (status === google.maps.GeocoderStatus.OK) {

                            var correcto = google.maps.geometry.poly.containsLocation(results[0].geometry.location, polygon);


                            if (correcto) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Felicidades',
                                    text: '¡Haz tu pedido ahora!',
                                    onAfterClose: redirigir

                                });

                                function redirigir() {
                                    window.location = 'utils/cambiarMetodoDeEnvio.php?code=reparto';
                                }

                            } else {
                                Swal.fire({
                                    icon: 'info',
                                    title: 'Lo Sentimos',
                                    text: 'Estás fuera de la zona de reparto contáctanos al 967175915'
                                })
                            }

                            /*onAfterClose: redirigir*/
                        } else if (status === google.maps.GeocoderStatus.ZERO_RESULTS) {

                            Swal.fire(
                                'Error!',
                                'No se encontró la dirección',
                                'error'
                            )
                        } else {
                            Swal.fire(
                                'Error!',
                                'Hubo un problema obteniendo la dirección',
                                'error'
                            )
                        }
                    });

            })
        });
    </script>


</body>

</html>