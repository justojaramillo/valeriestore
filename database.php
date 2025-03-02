<?php
class Database {
    private $host = "localhost";
    private $db_name = "valerie_store";
    private $username = "root";
    private $password = "";
    private $pdo;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        try {
            $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            $this->logError($e->getMessage());
            die("Error de conexión a la base de datos.");
        }
    }

    public function query($sql, $params = []) {
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            
            if (stripos($sql, "SELECT") === 0) {
                return $stmt->fetchAll();
            }
            return $stmt->rowCount();
        } catch (PDOException $e) {
            $this->logError($e->getMessage() . " | Query: " . $sql);
            return false;
        }
    }

    private function logError($message) {
        error_log("[" . date("Y-m-d H:i:s") . "] ERROR: " . $message . "\n", 3, __DIR__ . "/error_log.log");
    }
}
?>
