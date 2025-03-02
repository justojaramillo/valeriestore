<?php

require_once("../database.php");

class Permission_guard
{
    public static function check()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: /login.php');
            exit();
        }
    }
    public function userHasPermission($userId, $permission) {
        $db = new Database(); // Instanciamos la clase
        $result = $db->query(
            "SELECT 1 FROM user_permissions WHERE user_id = :user_id AND permission = :permission", 
            [":user_id"=>$userId, ":permission"=>$permission]
        );
        return !empty($result);
    }
}
