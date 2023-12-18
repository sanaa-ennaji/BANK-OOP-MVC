<?php

class Database {
    private static $instance;
    private $pdo;

    private function __construct() {
        $host = "localhost";
        $username = "root";
        $password = "new_password";
        $db = "bank8";

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            die();
        }
    }

    public static function getInstance() {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

     public function getConnection() {
        return $this->pdo;
    }
}

?>
