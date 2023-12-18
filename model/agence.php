<?php

class Bank {
    private $id;
    private $name;
    private $logo;

    // Constructor
    public function __construct($id, $name, $logo) {
        $this->id = $id;
        $this->name = $name;
        $this->logo = $logo;
    }
    // Getters and setters for properties (you can generate these automatically)
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLogo() {
        return $this->logo;
    }

    // Methods for CRUD operations

    // Create
    public static function create($name, $logo) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO bank (name, logo) VALUES (:name, :logo)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':logo', $logo);

        return $stmt->execute();
    }

    // Read

    public static function getById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM bank WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    
    public function update() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE bank SET name = :name, logo = :logo WHERE id = :id");
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':logo', $this->logo);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM bank WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
