<!DOCTYPE html>
<html>

<head>


<?php
$db = new PDO('mysql:host=localhost;dbname=2023', 'root', '');

// Obtener el token de la solicitud POST
$token = isset($_GET['token']) ? $_GET['token'] : '';


if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        
        $hashed_password = hash("SHA256", $new_password);

        
        $update_query = $db->prepare("UPDATE usuario SET clave = :hashed_password WHERE token = :token");
        $update_query->bindParam(':hashed_password', $hashed_password);
        $update_query->bindParam(':token', $token);
        
        if ($update_query->execute()) {
            echo "La contraseña se ha creado correctamente.";
        } else {
            echo "Error al crear la contraseña.";
        }
    } else {
        echo "Las contraseñas no coinciden.";
    }
} else {
    echo "Por favor, complete el formulario.";
}
?>








    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="../public/css/bootstrap.min.css">
    <!-- Font Awesome -->

    <link rel="stylesheet" href="../public/css/font-awesome.min.css">

    <link rel="stylesheet" href="../public/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../public/css/_all-skins.min.css">
    <!-- Morris chart -->
    <!-- Daterange picker -->
</head>

<body class="hold-transition  login-page" style="background-color:#cfdce7;background-image: url('fondo2.jpg'); background-size: cover;">
    <div class="row">
        <br><br><br><br><br><br><br><br><br><br>
        <div class="col-md-4">


        </div>
        <div class="col-md-4">

            <h2>Crear nueva Contraseña</h2> <br>
            <form method="post" action="">
                <label for="new_password">Nueva Contraseña:</label><br>
                <input type="password" class="form-control" name="new_password" required><br>
                <label for="confirm_password">Confirmar Contraseña:</label><br>
                <input type="password" class="form-control" name="confirm_password" required><br>
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                <input type="submit" class="btn btn-primary" style="margin-right: 20px;" value="Crear nueva">
                <a href="login.html" class="btn btn-primary" style="margin-right: 20px;">Login</a>
            </form>
        </div>
        <div class="col-md-4">


        </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="../public/js/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <!-- Bootstrap 3.3.7 -->
    <script src="../public/js/bootstrap.min.js"></script>
    <script src="../public/js/bootbox.min.js"></script>
    <script src="scripts/login.js"></script>
    <!-- iCheck -->

</body>

</html>