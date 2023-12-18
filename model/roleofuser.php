<?php

class RoleOfUser {
    private $id;
    private $roleId;
    private $userId;

    // Constructor
    public function __construct($id, $roleId, $userId) {
        $this->id = $id;
        $this->roleId = $roleId;
        $this->userId = $userId;
    }

    // Getters and setters for properties

    public function getId() {
        return $this->id;
    }

    public function getRoleId() {
        return $this->roleId;
    }

    public function getUserId() {
        return $this->userId;
    }

    // Methods for CRUD operations

    // Create
    public static function create($roleId, $userId) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO roleOfUser (role_id, user_id) VALUES (:roleId, :userId)");
        $stmt->bindParam(':roleId', $roleId);
        $stmt->bindParam(':userId', $userId);

        return $stmt->execute();
    }

    // Read
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM roleOfUser WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE roleOfUser SET role_id = :roleId, user_id = :userId WHERE id = :id");
        $stmt->bindParam(':roleId', $this->roleId);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM roleOfUser WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
