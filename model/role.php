<?php

class Role {
    private $name;

    // Constructor
    public function __construct($name) {
        $this->name = $name;
    }

    // Getter and setter for property

    public function getName() {
        return $this->name;
    }

    // Methods for CRUD operations

    // Create
    public static function create($name) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO role (name) VALUES (:name)");
        $stmt->bindParam(':name', $name);

        return $stmt->execute();
    }

    // Read
    public static function getByName($name) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM role WHERE name = :name");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update() {
        // Since role names are typically constant, you may not need to update them
        // This method is included for completeness
        // You might want to throw an exception or handle this case differently

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE role SET name = :name WHERE name = :currentName");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':currentName', $this->name);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        // Deleting a role might have implications on the application's logic and security
        // You might want to handle this case differently

        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM role WHERE name = :name");
        $stmt->bindParam(':name', $this->name);

        return $stmt->execute();
    }
}

?>
