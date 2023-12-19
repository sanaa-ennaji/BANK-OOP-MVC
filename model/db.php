<?php
define("HOST", "localhost");
define("DB", "bank8");
define("USER", "root");
define("PW", "new_password");

class Database {

    public function connect() {
        try {
            $dsn = "mysql:host=" . HOST . ";dbname=" . DB;
            return new PDO($dsn, USER, PW);
        } catch(PDOException $e) {
            die("Error: " . $e->getCode());
        }
    }
}






















































// class Database {
//     private static $instance;
//     private $pdo;

//     private function __construct() {
//         $host = "localhost";
//         $username = "root";
//         $password = "new_password";
//         $db = "bank8";

//         try {
//             $this->pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
//             $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//         } catch (PDOException $e) {
//             echo "Connection failed: " . $e->getMessage();
//             die();
//         }
//     }

//     public static function getInstance() {
//         if (!self::$instance) {
//             self::$instance = new self();
//         }
//         return self::$instance;
//     }

//      public function getConnection() {
//         return $this->pdo;
//     }
// }

?>
