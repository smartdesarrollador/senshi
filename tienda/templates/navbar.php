<?php
require_once 'vendor/autoload.php';

$appId = '1571346533034037'; //Identificador de la Aplicación
$appSecret = '93e480dc1a17ec6f0f4a20b99b5f29f7'; //Clave secreta de la aplicación
if (isset($page)) {

    if ($page == 'carrito') {
        $redirectURL = 'https://senshi.pe/tienda/script/fbConfig.php?redirect=carrito'; //Callback URL
    } elseif ($page == 'inicio') {
        $redirectURL = 'https://senshi.pe/tienda/script/fbConfig.php'; //Callback URL
    } else {
        $redirectURL = 'https://senshi.pe/tienda/script/fbConfig.php'; //Callback URL
    }
} else {

    $redirectURL = 'https://senshi.pe/tienda/script/fbConfig.php'; //Callback URL
}


$fbPermissions = array('');  //Permisos opcionales

$fb = new Facebook\Facebook([
    'app_id' => $appId, // Replace {app-id} with your app id
    'app_secret' => $appSecret,
    'default_graph_version' => 'v3.2',
]);

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email'];
$loginUrl = $helper->getLoginUrl($redirectURL, $permissions);


?>
<nav class="navbar  navbar-expand-lg fixed-top navbar-light pt-0" style="background:#000000;border-bottom:3px solid #ffffff;margin-bottom: 0 !important">
    <div class="container">
        <a class="navbar-brand" href="index.php"><img class="py-2" src="img/logoBlancoV2.png" style="width:140px;" alt="logo senshi"></a>
        <button class="btn d-block d-sm-block  d-lg-none" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span><i class="fas fa-bars" style="color:#ffffff;font-size:35px;"></i></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mx-auto mt-2 mt-lg-0" id="barraNavegacion">

                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($page == "historia") ? 'text-danger' : ''; ?>" href="historia.php">Historia </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($page == "carta") ? 'text-danger' : ''; ?>" href="carta.php">Carta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($page == "giftCards") ? 'text-danger' : ''; ?>" href="senshi-gift-cards.php">Gift Cards</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($page == "reparto") ? 'text-danger' : ''; ?>" href="reparto.php">Reparto</a>
                </li>
                <!-- <li class="nav-item">
        <a class="nav-link px-3 <?php /*echo ($page == "reserva") ? 'text-danger' : ''; */ ?>" href="reserva.php">Reserva</a>
      </li>-->
                <li class="nav-item">
                    <a class="nav-link px-3 <?php echo ($page == "contacto") ? 'text-danger' : ''; ?>" href="contacto.php">Contacto</a>
                </li>

                <!--   <li class="nav-item dropdown">




                    <?php if ($_SESSION['local'] == "lince") { ?>
                        <a class="nav-link dropdown-toggle text-danger" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tienda Lince
                        </a>
                    <?php } else if ($_SESSION['local'] == "san_borja") { ?>
                        <a class="nav-link dropdown-toggle text-danger" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tienda San Borja
                        </a>
                    <?php } else {  ?>
                        <a class="nav-link dropdown-toggle text-danger" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tienda
                        </a>
                    <?php } ?>


                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                        <?php if ($_SESSION['local'] == "lince") { ?>

                            <a class="dropdown-item" href="sesion_zona_reparto_link.php?zona=san_borja&url=<?php echo $url; ?>">Tienda San Borja</a>
                        <?php } else if ($_SESSION['local'] == "san_borja") { ?>
                            <a class="dropdown-item" href="sesion_zona_reparto_link.php?zona=lince&url=<?php echo $url; ?>">Tienda Lince</a>

                        <?php } else {  ?>
                            <a class="dropdown-item" href="sesion_zona_reparto_link.php?zona=lince&url=<?php echo $url; ?>">Tienda Lince</a>
                            <a class="dropdown-item" href="sesion_zona_reparto_link.php?zona=san_borja&url=<?php echo $url; ?>">Tienda San Borja</a>
                        <?php } ?>





                    </div> -->
                </li>
            </ul>
            <ul class="navbar-inline my-2 my-lg-0">
                <a href="carrito.php" class="btn btn-outline-light my-2 my-sm-0 px-1" style="font-size:1rem;font-weight: bold" type="submit"><i class="fas fa-shopping-cart mr-1"></i>Carrito</a>

                <?php if (!isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) { ?>
                    <a href="#" class="btn btn-danger my-2 my-sm-0" data-toggle="modal" data-target="#login-modal" style="font-size:1rem;font-weight:bold"><i class="fas fa-user mr-1"></i>Ingresar</a>

                <?php } ?>
                <?php if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {
                ?>
                    <div class="d-inline dropdown">

                        <a href="#" class="btn btn-danger my-2 my-sm-0 dropdown-toggle" style="font-size:1rem;font-weight:bold" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user mr-1"></i></a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink">

                            <a class="dropdown-header font-weight-bold">Hola, <?php echo $_SESSION['current_customer_nombre'] ?></a>
                            <div class="dropdown-divider"></div>

                            <a class="dropdown-item" href="senshi-mi-cuenta.php">Mi Cuenta</a>
                            <a class="dropdown-item" href="script/logout.php">Cerrar Sesión</a>
                        </div>
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>



</nav>
<!--modal de login-->
<div class="modal fade " id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" align="center">
                <img style="width: 80px" class="" id="img_logo" src="img/logo-senshi2.png" alt="Logo Senshi">
                <button type="button" class=" btn btn-dark" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Begin # DIV Form -->
            <div id="div-forms">

                <!-- Begin # Login Form -->
                <form id="login-form" method="post" action="script/verificarUsuario.php">
                    <div class="modal-body">
                        <div id="div-login-msg" class="text-center">
                            <div id="icon-login-msg" class="glyphicon glyphicon-chevron-right"></div>
                            <h5 id="text-login-msg">Ingresa tu Correo y Contraseña</h5>
                        </div>
                        <input style="text-transform: lowercase" name="correo" id="login_username" class="form-control" type="email" placeholder="Correo" required>
                        <input name="contrasena" id="login_password" class="form-control mt-2" type="password" placeholder="Contraseña" required>

                    </div>
                    <div class="modal-footer">
                        <div>
                            <button type="submit" class="btn btn-dark btn-lg btn-block">Iniciar</button>
                        </div>
                        <div>
                            <button id="login_lost_btn" type="button" class="btn btn-link">Olvidaste tu contraseña?
                            </button>
                            <button id="login_register_btn" type="button" class="btn btn-link">Registrarse</button>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col text-center px-5 py-2">

                            <a href="<?php echo htmlspecialchars($loginUrl) ?>" class="btn  w-100 text-white" style="background-color: #4267B2">
                                <i class="fab fa-facebook mx-2" style="font-size: 1.5rem">
                                </i> Ingresar con Facebook </a>

                        </div>
                    </div>
                    <div class="row mb-3 ">
                        <div class="col text-center px-5 py-2">
                            <!--<div id="my-signin2"></div>-->
                            <div id="gSignInWrapper">
                                <div id="customBtn" class="customGPlusSignIn">
                                    <span class="icon"></span>
                                    <span class="buttonText">Ingresar con Google</span>
                                </div>
                            </div>
                            <div id="name"></div>
                            <script>
                                startApp();
                            </script>
                        </div>
                    </div>

                </form>
                <!-- End # Login Form -->

                <!-- Begin | Lost Password Form -->
                <form id="lost-form" style="display:none;" action="script/passwordRecovery.php" method="post">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-12 col-sm-12 text-center">
                                <div id="div-lost-msg" class="text-center" style="margin-bottom: 20px">
                                    <div id="icon-lost-msg" class="glyphicon glyphicon-chevron-right"></div>
                                    <h5 id="text-lost-msg">Ingresa tu Correo para recuperar tu contraseña</h5>
                                </div>
                            </div>
                        </div>

                        <input style="text-transform: lowercase" id="lost_email" class="form-control" type="email" name="lostEmail" placeholder="Correo" required>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button type="submit" class="btn btn-dark btn-lg btn-block">Enviar</button>
                        </div>
                        <div>
                            <button id="lost_login_btn" type="button" class="btn btn-link">Iniciar</button>
                            <button id="lost_register_btn" type="button" class="btn btn-link">Registrarse</button>
                        </div>
                    </div>
                </form>
                <!-- End | Lost Password Form -->

                <!-- Begin | Register Form -->
                <form id="register-form" style="display:none;" method="post" action="script/registerCustomer.php">
                    <div class="modal-body">
                        <div id="div-register-msg" class="text-center">

                            <h4 class="mb-2" id="text-register-msg">Regístrate</h4>
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="register_username">Nombres</label>
                                <input id="register_username" class="form-control m-0" type="text" aria-describedby="nombreHelper" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="nombre" required>
                                <small id="nombreHelper" class="form-text text-muted">
                                    Ingresa tu nombre
                                </small>

                            </div>
                            <div class="col">

                                <label for="register_lastName">Apellidos</label>
                                <input id="register_lastName" class="form-control m-0" type="text" aria-describedby="apellidoHelper" pattern="[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ\s]+" name="apellido" required>
                                <small id="apellidoHelper" class="form-text text-muted">
                                    Ingresa tus apellidos
                                </small>

                            </div>


                        </div>

                        <div class="form-group">

                        </div>

                        <div class="form-group">
                            <label for="register_email">Correo Electrónico</label>
                            <input onkeyup="toLowerCase(this)" id="register_email" name="correo" class="form-control m-0" aria-describedby="correoHelper" type="email" required>
                            <small id="correoHelper" class="form-text text-muted">
                                Ingresa tu correo electrónico
                            </small>

                        </div>
                        <div class="form-group">
                            <label for="register_phoneNumber">Numero de Celular</label>
                            <input name="celular" id="register_phoneNumber" class="form-control m-0" type="text" onkeypress="return solonumeros(event);" maxlength="15" aria-describedby="phoneNumberHelper" required>
                            <small id="phoneNumberHelper" class="form-text text-muted">
                                Ingresa tu Numero de Celular
                            </small>

                        </div>
                        <div class="form-group">
                            <label for="register_password">Contraseña</label>
                            <input minlength="6" name="password" id="register_password" class="form-control m-0" type="password" aria-describedby="passwordHelper" required>
                            <small id="passwordHelper" class="form-text text-muted">
                                Ingresa tu correo Contraseña
                            </small>

                        </div>
                        <div class="form-group">
                            <label for="register_password2">Repite tu contraseña</label>
                            <input id="register_password2" class="form-control m-0" type="password" placeholder="Repite tu contraseña" aria-describedby="password2Helper" required>
                            <small id="password2Helper" class="form-text text-muted">
                                Repite tu Contraseña
                            </small>

                        </div>
                        <div class="alert-danger d-none" id="alertaContrasenas">
                            Las contraseñas no coinciden
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div>
                            <button type="submit" class="btn btn-dark btn-lg btn-block">Registrarse</button>
                        </div>
                        <div>
                            <button id="register_login_btn" type="button" class="btn btn-link">Iniciar</button>
                            <button id="register_lost_btn" type="button" class="btn btn-link">Olvidaste tu contraseña?
                            </button>
                        </div>
                    </div>
                </form>
                <!-- End | Register Form -->

            </div>
            <!-- End # DIV Form -->

        </div>
    </div>

</div>