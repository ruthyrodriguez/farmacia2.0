<!DOCTYPE html>
<html>

<head>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/../vendor/autoload.php';

$db = new PDO('mysql:host=localhost;dbname=2023', 'root', '');

// Verificar si se ha enviado un correo electrónico
if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Verificar si el correo electrónico existe en la base de datos
    $query = $db->prepare("SELECT idusuario FROM usuario WHERE email = :email");
    $query->bindParam(':email', $email);
    $query->execute();

    if ($query->rowCount() > 0) {
        // Generar un token único
        $token = bin2hex(random_bytes(32)); // Genera un token de 64 caracteres hexadecimales

        // Actualizar el campo 'token' en la tabla 'usuario' con el nuevo token
        $update_token_query = $db->prepare("UPDATE usuario SET token = :token WHERE email = :email");
        $update_token_query->bindParam(':token', $token);
        $update_token_query->bindParam(':email', $email);
        $update_token_query->execute();

        // Construir el enlace de restablecimiento
        $reset_link = "http://localhost/v3/vistas/passwordnuevo.php?token=$token";

        // Configurar PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username   = 'ruthcita03031989@gmail.com';
            $mail->Password   = 'xsfb ugpx jylc nvhn';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Destinatario
            $mail->setFrom('ruthcita03031989@gmail.com', 'Farmacia Sit Lux');
            $mail->addAddress($email);

            // Contenido del correo electrónico
            $mail->isHTML(true);
            $mail->Subject = 'CREAR NUEVA CONTRASEÑA';
            $mail->Body = "Haga clic en este enlace para crear su nueva contraseña: <a href='$reset_link'>$reset_link</a>";

            // Enviar correo electrónico
            $mail->send();

            echo "Se ha enviado un enlace a su correo electrónico para crear su nueva contraseña.";
        } catch (Exception $e) {
            echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
        }
    } else {
        echo "El correo electrónico no existe en nuestra base de datos.";
    }
}
?>

<!-- Resto del código HTML -->
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
 


<script src="vendor/bootbox/bootbox.min.js"></script>



<!-- Morris chart -->
<!-- Daterange picker -->
</head>

<body class="hold-transition  login-page" style="background-color:#cfdce7;background-image: url('fondo2.jpg'); background-size: cover;">
<div class="row">
    <br><br><br><br><br><br><br><br><br><br>
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
        <h2>Recuperar Contraseña</h2><br>
        <form method="post">
            <label for="email">Ingresar Correo:</label>
            <input type="email" name="email" class="form control" required size="40" required> <br>
            <br>
            <input type="submit" class="btn btn-success" style="margin-rigth:20px;" value="Enviar">
            <a href="login.html" class="btn btn-primary" style="margin-rigth:20px;" >Login</a>
        </form>
    </div>
    <div class="col-md-2">
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

<script>
$(document).ready(function() {
    // Mostrar el mensaje en un popup AQUIIII HACER EL CONTROL
    bootbox.alert("Se ha enviado un enlace a su correo electrónico para crear su nueva contraseña.");
});
</script>

</body>

</html>
