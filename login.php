<?php
require_once('Auth.php');

$auth = new Auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($auth->login($username, $password)) {
        echo "Login exitoso. Bienvenido, " . $_SESSION['username'];
    } else {
        echo "Credenciales incorrectas.";
    }
}
?>

<form method="POST">
    <input type="text" name="username" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit">Iniciar sesión</button>
</form>
