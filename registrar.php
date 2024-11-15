<?php
session_start();

$host = 'localhost';
$user = 'root'; 
$password = ''; 
$dbname = 'mi_base_de_datos'; 

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli($host, $user, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $message = "Las contraseñas no coinciden.";
    } else {
        
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = "El nombre de usuario ya está en uso.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT); 

            $sql = "INSERT INTO usuarios (username, password) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $username, $hashed_password);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Su registro fue realizado con éxito.";
                header("Location: login.html");
                exit();
            } else {
                $message = "Error al registrar: " . $stmt->error;
            }
        }

        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="registr.css"> 
</head>
<body>
    <div class="container">
        <h2>Crear Cuenta</h2>
        <form action="registrar.php" method="post">
            <input type="text" name="username" placeholder="Nombre de Usuario" required>
            <input type="password" name="password" placeholder="Contraseña" required>
            <input type="password" name="confirm_password" placeholder="Confirmar Contraseña" required>
            <input type="submit" value="Registrar">
        </form>
        <div class="message">
            <?php if ($message): ?>
                <div class="success-message">
                    <p><?php echo htmlspecialchars($message); ?></p>
                </div>
            <?php endif; ?>
        </div>
        <p>¿Ya tienes una cuenta? <a href="login.html">Inicia sesión</a></p>
    </div>
</body>
</html>
