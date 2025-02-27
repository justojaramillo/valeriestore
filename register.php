<?php
require_once('auth.php');
require_once('middleware/auth_middleware.php');
AuthMiddleware::check();

$auth = new Auth();
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (strlen($password) < 6) {
        $message = "La contraseña debe tener al menos 6 caracteres.";
    } else {
        $message = $auth->register($username, $password);
    }
}
?>

<form method="POST" action="register.php">
    <input type="text" name="username" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Registrarse</button>
</form>
<p><?php echo $message; ?></p>
<a href="login.php">Iniciar sesión</a>
