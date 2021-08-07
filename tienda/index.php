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
                <h5 class="text-left " style="">Si estás fuera de la zona de reparto,
                    contáctanos al <a target="_blank" href="https://api.whatsapp.com/send?phone=51949115822"><i style="color: #128C7E" class="fab fa-2x fa-whatsapp"></i></a></h5>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col">
                <iframe src="https://www.google.com/maps/d/embed?mid=1JG4Tub1V27G5Pk2LPTSPDl50GtoyRFu-" width="100%" height="400"></iframe>
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
            <li><a style="padding: 21px " href="https://www.facebook.com/SenshiSushiRolls" target="_blank" class="icon-facebook">
                    <i class="fab fa-facebook-f"></i>
                </a></li>
            <li><a style="padding: 19px " href="https://www.instagram.com/senshi.sushi/?hl=es-la" target="_blank" class="icon-instagram">
                    <i class="fab fa-instagram"></i>
                </a></li>
            <li><a style="padding: 15px " href="https://api.whatsapp.com/send?phone=51967175915" target="_blank" class="icon-whatsapp">
                    <i class="fab fa-whatsapp"></i><br>
                    <span style="font-size:10px;margin:0px;padding:0%;">Lince</span>
                </a>
            </li>
            <li><a style="padding: 15px; background-color:#1fb154;" href="https://api.whatsapp.com/send?phone=51949115822" target="_blank" class="icon-whatsapp-san-borja">
                    <i class="fab fa-whatsapp"></i><br>
                    <span style="font-size:10px;margin:-10px;padding:0%;">San Borja</span><br>

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
                                        <label for="direccionInput">Dirección</label>
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
                        lat: -12.0850024,
                        lng: -76.9967038
                    },
                    {
                        lat: -12.0845828,
                        lng: -76.9929702
                    },
                    {
                        lat: -12.0839952,
                        lng: -76.9894511
                    },
                    {
                        lat: -12.0830720,
                        lng: -76.9879491
                    },
                    {
                        lat: -12.0817711,
                        lng: -76.9862325
                    },
                    {
                        lat: -12.0886533,
                        lng: -76.9815547
                    },
                    {
                        lat: -12.1104735,
                        lng: -76.9787223
                    },
                    {
                        lat: -12.1113022,
                        lng: -76.9936354
                    },
                    {
                        lat: -12.1289191,
                        lng: -77.0010071
                    },
                    {
                        lat: -12.1365972,
                        lng: -77.0050197
                    },
                    {
                        lat: -12.1352127,
                        lng: -77.0077448
                    },
                    {
                        lat: -12.1347302,
                        lng: -77.0098691
                    },
                    {
                        lat: -12.1336603,
                        lng: -77.0135813
                    },
                    {
                        lat: -12.1338701,
                        lng: -77.0177656
                    },
                    {
                        lat: -12.1335134,
                        lng: -77.0180874
                    },
                    {
                        lat: -12.1336603,
                        lng: -77.0185595
                    },
                    {
                        lat: -12.1334295,
                        lng: -77.0187097
                    },
                    {
                        lat: -12.1339540,
                        lng: -77.0202547
                    },
                    {
                        lat: -12.1355693,
                        lng: -77.0236021
                    },
                    {
                        lat: -12.1379608,
                        lng: -77.0281511
                    },
                    {
                        lat: -12.1323596,
                        lng: -77.0307904
                    },
                    {
                        lat: -12.1300362,
                        lng: -77.0344168
                    },
                    {
                        lat: -12.1232233,
                        lng: -77.0409613
                    },
                    {
                        lat: -12.1229874,
                        lng: -77.0425436
                    },
                    {
                        lat: -12.1208948,
                        lng: -77.0441690
                    },
                    {
                        lat: -12.1198721,
                        lng: -77.0452366
                    },
                    {
                        lat: -12.1189594,
                        lng: -77.0456550
                    },
                    {
                        lat: -12.1086478,
                        lng: -77.0577893
                    },
                    {
                        lat: -12.1061721,
                        lng: -77.0592270
                    },
                    {
                        lat: -12.1033797,
                        lng: -77.0633354
                    },
                    {
                        lat: -12.0997710,
                        lng: -77.0699873
                    },
                    {
                        lat: -12.0965609,
                        lng: -77.0734634
                    },
                    {
                        lat: -12.0937090,
                        lng: -77.0806869
                    },
                    {
                        lat: -12.0896386,
                        lng: -77.0782622
                    },
                    {
                        lat: -12.0878761,
                        lng: -77.0814594
                    },
                    {
                        lat: -12.0849596,
                        lng: -77.0798715
                    },
                    {
                        lat: -12.0835538,
                        lng: -77.0826181
                    },
                    {
                        lat: -12.0785110,
                        lng: -77.0813425
                    },
                    {
                        lat: -12.0749090,
                        lng: -77.0798715
                    },
                    {
                        lat: -12.0730834,
                        lng: -77.0784982
                    },
                    {
                        lat: -12.0686848,
                        lng: -77.0781805
                    },
                    {
                        lat: -12.0678455,
                        lng: -77.0738890
                    },
                    {
                        lat: -12.0674268,
                        lng: -77.0608868
                    },
                    {
                        lat: -12.0664463,
                        lng: -77.0540643
                    },
                    {
                        lat: -12.0656909,
                        lng: -77.0532490
                    },
                    {
                        lat: -12.0666141,
                        lng: -77.0519615
                    },
                    {
                        lat: -12.0654810,
                        lng: -77.0512749
                    },
                    {
                        lat: -12.0664463,
                        lng: -77.0503307
                    },
                    {
                        lat: -12.0652292,
                        lng: -77.0493866
                    },
                    {
                        lat: -12.0661105,
                        lng: -77.0481420
                    },
                    {
                        lat: -12.0652292,
                        lng: -77.0475412
                    },
                    {
                        lat: -12.0663204,
                        lng: -77.0462967
                    },
                    {
                        lat: -12.0653132,
                        lng: -77.0456100
                    },
                    {
                        lat: -12.0637184,
                        lng: -77.0339800
                    },
                    {
                        lat: -12.0736339,
                        lng: -77.0305431
                    },
                    {
                        lat: -12.0824113,
                        lng: -77.0265283
                    },
                    {
                        lat: -12.0812781,
                        lng: -77.0191481
                    },
                    {
                        lat: -12.0849390,
                        lng: -77.0097885
                    },
                    {
                        lat: -12.0833823,
                        lng: -76.9988333
                    },
                    {
                        lat: -12.0825849,
                        lng: -76.9972025
                    },
                    {
                        lat: -12.0850371,
                        lng: -76.9968280
                    },
                    {
                        lat: -12.0850024,
                        lng: -76.9967038
                    }
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
                                    text: 'Estás fuera de la zona de reparto contáctanos al 949115822'
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