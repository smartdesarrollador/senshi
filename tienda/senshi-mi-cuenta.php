<?php
session_start();
$page = 'perfil';
include 'class/ClienteClass.php';
$objCliente = new ClienteClass();
$clienteActual = $objCliente->getAllInformationUserById($_SESSION['current_customer_idCliente']);
if (isset($_SESSION['current_customer_idCliente'], $_SESSION['current_customer_email'])) {

}else{
    header('location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Senshi Sushi/Bar-Reparto</title>
     <?php include 'templates/metalink.php';?>
     <link rel="stylesheet" href="css/carta.css">
     <link rel="stylesheet" href="css/viewer.min.css">
    <script src="js/viewer.min.js"></script>
</head>
<body> 
    <?php include 'templates/navbar.php';?>

    <div class="container text-center" style="margin-top:95px">
        <?php if (isset($_SESSION['message'])){
            unset($_SESSION['message']);
            ?>

            <div class="alert alert-success  alert-dismissible fade show animated tada slow text-center" role="alert">
                <strong>Correcto!</strong> datos personales actualizados correctamente.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <div class="row mb-3">
            <div class="col-12 col-sm-12 col-md-3 col-xl-3 col-lg-3 p-2 p-sm-2 p-md-1 p-xl-4 p-lg-4">
                <div class="card card-egipcio" style="width: 100%;">
                    <div class="card-body text-center">
                        <img src="icon/man.png" alt="" style="width: 100px">
                        <h6 class="font-weight-lighter mt-1"><?php echo $clienteActual['nombre'] . ' ' . $clienteActual['apellido']; ?></h6>
                        <h5>Bienvenido a Senshi</h5>
                        <h6 class="text-info font-weight-bolder">Tienes <?php echo $_SESSION['current_customer_puntos']?> puntos</h6>
                    </div>
                </div>
                <div class="card card-egipcio mt-2 mt-sm-2 mt-md-3 mt-xl-4 mt-lg-4" style="width: 100%;">
                    <div class="card-body text-center">


                        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                            <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#home" role="tab"
                               aria-controls="home" aria-selected="true">Billetera Virtual</a>
                            <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#profile" role="tab"
                               aria-controls="profile" aria-selected="false">Perfil</a>
                            <!--<a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#messages" role="tab"
                               aria-controls="messages" aria-selected="false">Mis Pedidos</a>-->
                            <a href="script/logout.php" class="nav-link">Cerrar Sesión</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-9 col-xl-9 col-lg-9 p-2 p-sm-2 p-md-1 p-xl-4 p-lg-4">

                <div class="card card-egipcio w-100 h-100">
                    <div class="card-body ">


                        <div class="tab-content">
                            <div class="tab-pane animated fadeIn active" id="home" role="tabpanel"
                                 aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col">
                                        <h5>Billetera Virtual</h5>
                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col">
                                        <h2 class="text-center">Saldo: S/. <?php echo $clienteActual['saldoBilletera']?></h2>

                                    </div>
                                </div>

                                <div class="row my-3">
                                    <div class="col text-center docs-galley">
                                        <ul class="docs-pictures list-unstyled">
                                            <li>
                                                <img style="cursor: zoom-in"
                                                     data-original="img/qrCodes/<?php echo $clienteActual['qrCode'] ?>"
                                                     class="w-50"
                                                     src="img/qrCodes/<?php echo $clienteActual['qrCode'] ?>"
                                                     alt="">
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane animated fadeIn" id="profile" role="tabpanel"
                                 aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col">
                                        <h5>Datos Personales <button id="btnEditProfile" class="btn btn-outline-info float-right ">Editar <i class="fa fa-pencil" aria-hidden="true"></i></button>
                                        </h5>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <form action="script/updateCustomerProfile.php" method="post">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="perfilEmail">Email</label>
                                                    <input readonly type="email" value="<?php echo $clienteActual['email']?>" class="form-control m-0" id="perfilEmail">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="perfilCelular">Teléfono / Celular</label>
                                                    <input onkeypress="return isNumberKey(event)" name="telefono" readonly type="text" value="<?php echo $clienteActual['celular']?>" class="form-control canEdit" id="perfilCelular">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="perfilNombre">Nombre</label>
                                                    <input name="nombre" readonly type="text" value="<?php echo $clienteActual['nombre']?>" class="form-control canEdit" id="perfilNombre">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="perfilApellido">Apellidos</label>
                                                    <input name="apellido" readonly type="text" value="<?php echo $clienteActual['apellido']?>" class="form-control canEdit" id="perfilApellido">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="perfilDni">DNI</label>
                                                    <input onkeypress="return isNumberKey(event)"  name="dni" readonly type="text" value="<?php echo $clienteActual['DNI']?>" class="form-control canEdit" id="perfilDni">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="perfilFecNac">Fecha de Nacimiento</label>
                                                    <input name="nacimiento" readonly type="date" value="<?php echo date('Y-m-d', strtotime( $clienteActual['fechaNacimiento'])) ?>" class="form-control canEdit" id="perfilFecNac">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-12">
                                                    <label for="perfilDni">Dirección</label>
                                                    <input name="direccion" readonly type="text" value="<?php echo $clienteActual['direccion']?>" class="form-control canEdit" id="perfilDni">
                                                </div>

                                            </div>
                                            <div class="row animated fadeIn slow" id="botonesActualizar">
                                                <div class="col-12 text-right">
                                                    <a onclick="window.location.reload()" class="btn btn-secondary text-white">Cancelar</a>
                                                    <button type="submit" class="btn btn-primary btn-lg">Actualizar Datos</button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="tab-pane animated fadeIn" id="messages" role="tabpanel"
                                  aria-labelledby="messages-tab">3
                             </div>-->

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

<?php include 'templates/footer.php';?>
    <script>
        window.onload = function () {
            'use strict';

            var Viewer = window.Viewer;
            var pictures = document.querySelector('.docs-pictures');

            var options = {
                // inline: true,
                url: 'data-original',
                title: function () {
                    return 'CODIGO QR';
                },
                toolbar: {
                    zoomIn: 1,
                    zoomOut: 1,
                    oneToOne: 0,
                    reset: 0,
                    prev: 0,
                    play: {
                        show: 1,
                        size: 'large',
                    },
                },

            };
            var viewer = new Viewer(pictures, options);

        };

    </script>
    <script>
        $('#botonesActualizar').hide();
        $('#btnEditProfile').click(function () {
            $('.canEdit').removeAttr('readonly');
            $(this).prop('disabled', true);
            $('#perfilCelular').focus();
            $('#botonesActualizar').show();
        });
    </script>
    
</body>
</html>
