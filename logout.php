<?php
require_once('auth.php');

$auth = new Auth();
$auth->logout();

echo "Sesión cerrada.";
?>
<a href="login.php">Iniciar sesión</a>
