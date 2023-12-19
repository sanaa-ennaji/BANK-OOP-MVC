<?php

require_once("db.php");

class RoleOfUser extends Database {

    public function add($id, $user, $role) {
        try {
            $sql = "INSERT INTO roleOfUser VALUES (:id, :role, :user)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":user", $user);
            $stmt->bindParam(":role", $role);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function display() {
        try {
            $sql = "SELECT * FROM roleOfUser";
            $query = $this->connect()->query($sql);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM roleOfUser WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function deleteAll($user) {
        try {
            $sql = "DELETE FROM roleOfUser WHERE user_id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $user);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

?>