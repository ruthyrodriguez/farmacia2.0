<?php
$db = new PDO('mysql:host=localhost;dbname=2023', 'root', '');

// Obtener el token de la solicitud POST
$token = $_POST['token'];

if (isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    // Verificar si las contraseñas coinciden
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        // Hash de la nueva contraseña usando SHA-256
        $hashed_password = hash("SHA256", $new_password);

        // Actualizar la contraseña en la base de datos para el usuario con el token correspondiente
        $update_query = $db->prepare("UPDATE usuario SET clave = :hashed_password WHERE token = :token");
        $update_query->bindParam(':hashed_password', $hashed_password);
        $update_query->bindParam(':token', $token);
        
        if ($update_query->execute()) {
            echo "La contraseña se ha restablecido correctamente.";
        } else {
            echo "Error al restablecer la contraseña.";
        }
    } else {
        echo "Las contraseñas no coinciden.";
    }
} else {
    echo "Por favor, complete el formulario.";
}
?>
