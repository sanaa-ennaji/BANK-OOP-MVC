<?php

require_once("db.php");

class Role extends Database {

    public function add($name) {
        $db = $this->connect();

        try {
            $sql = "INSERT INTO role VALUES (:name)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

      public function display() {
        $db = $this->connect();

        try {
            $sql = "SELECT name FROM role";
            $query = $db->query($sql);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function delete($name) {
        $db = $this->connect();

        try {
            $sql = "DELETE FROM role WHERE name = :name";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

?>
