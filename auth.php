<?php
require_once('Database.php');

class Auth {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($username, $password) {
        $query = "SELECT user_id, username, password FROM user WHERE username = :username";
        $result = $this->db->query($query, ['username' => $username]);

        if (!empty($result)) {
            $user = $result[0];
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                return true;
            }
        }
        return false;
    }

    public function register($username, $password) {
        // Verificar si el usuario ya existe
        $query = "SELECT user_id FROM user WHERE username = :username";
        $result = $this->db->query($query, ['username' => $username]);
    
        if (!empty($result)) {
            return "El usuario ya existe.";
        }
    
        // Hashear la contraseña
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
        // Insertar nuevo usuario
        $query = "INSERT INTO user (username, password) VALUES (:username, :password)";
        $params = ['username' => $username, 'password' => $hashedPassword];
    
        if ($this->db->query($query, $params)) {
            return "Usuario registrado con éxito.";
        } else {
            return "Error al registrar usuario.";
        }
    }
    

    public function getAuthenticatedUserId() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}
?>
