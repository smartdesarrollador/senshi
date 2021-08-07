<?php
error_reporting(0);
if (!isset($_GET['mail'],$_GET['tkn'])){
    echo "no tiene autorizacion para ver esta pagina";
    exit();
}else{
include 'class/ClienteClass.php';
$objCliente = new ClienteClass();

$email = trim($_GET['mail']);
$tkn = trim($_GET['tkn']);
$userExist = $objCliente->getUserByTknTokenAndEmail($tkn,$email);

if ($userExist['passRecoveryToken'] == $tkn && $userExist['email'] == $email) {



    ?>
<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">
    <title>.:Cambiar Contraseña:</title>
    <?php include 'templates/metalink.php' ?>

</head>
<body>
<?php include 'templates/navbar.php' ?>
<div class="container" style="min-height: 900px">
    <div class="col-md-6 offset-md-3">
        <form id="resetPass-form" action="script/resetPassword.php" method="post">
        <br style="clear:both">
        <h3 style="margin-bottom: 25px; text-align: center;">Cambiar Contraseña</h3>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="email">Correo</label>
                    <input readonly type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>"
                           required>

                    <input readonly type="hidden"  name="tkn" value="<?php echo $tkn; ?>"
                           required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="passwordReset">Nueva Contraseña</label>
                    <input value="" type="password"
                           class="form-control" id="passwordReset" name="password"
                           placeholder=""
                           required>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-md-12">
                <div class="form-group">
                    <label for="passwordReset2">Repite tu nueva contraseña </label>
                    <input value="" type="password"
                           class="form-control" id="passwordReset2"
                           placeholder=""
                           required>
                </div>
            </div>
        </div>
        <br>
            <strong id="nocoinciden" class="text-center" style="color: red">Las contraseñas no coinciden</strong>
        <button type="submit" id="btnVerificar" name="submit" class="btn btn-primary pull-right">Cambiar</button>

        </form>
    </div>
</div>
<?php include 'templates/footer.php' ?>
<script>
    $('#nocoinciden').hide();
</script>
</body>
</html>
<?php
}
else{
    echo "no tiene autorización para ver esta pagina";
    exit();
}
}
?>
