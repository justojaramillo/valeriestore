<?php
require_once('Database.php');

class Auth {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($username, $password) {
        $query = "SELECT id, username, password FROM user WHERE username = :username";
        $result = $this->db->query($query, ['username' => $username]);

        if (!empty($result)) {
            $user = $result[0];
            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                return true;
            }
        }
        return false;
    }

    public function register($username, $password) {
        // Verificar si el usuario ya existe
        $query = "SELECT id FROM user WHERE username = :username";
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
    

    public function isAuthenticated() {
        session_start();
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_start();
        session_destroy();
    }
}
?>
