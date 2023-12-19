<?php

require_once("db.php");

class Permission extends Database {

    public function search($role, $permission) {
        $db = $this->connect();

        try {
            $sql = "SELECT permission.name FROM permission
                    JOIN permissionOfRole ON permission.id = permissionOfRole.permission_id
                    JOIN role ON permissionOfRole.role_id = role.name
                    WHERE role.name = :role AND permission.name = :permission";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":role", $role);
            $stmt->bindParam(":permission", $permission);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function check($role, $permission) {

        try {
            $data = $this->search($role, $permission);
            if ($data["name"] != $permission) {
                return false;
            } else {
                return true;
            }
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}

?>
