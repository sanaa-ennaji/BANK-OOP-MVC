<?php

class Transaction {
    private $id;
    private $type;
    private $amount;
    private $compteCourantId;  // Assuming compte_courant_id is the foreign key linking to the compte_courant table

    // Constructor
    public function __construct($id, $type, $amount, $compteCourantId) {
        $this->id = $id;
        $this->type = $type;
        $this->amount = $amount;
        $this->compteCourantId = $compteCourantId;
    }

    // Getters and setters for properties

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getAmount() {
        return $this->amount;
    }

    public function getCompteCourantId() {
        return $this->compteCourantId;
    }

    // Methods for CRUD operations

    // Create
    public static function create($type, $amount, $compteCourantId) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO transaction (type, amount, compte_courant_id) VALUES (:type, :amount, :compteCourantId)");
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':amount', $amount);
        $stmt->bindParam(':compteCourantId', $compteCourantId);

        return $stmt->execute();
    }

    // Read
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM transaction WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE transaction SET type = :type, amount = :amount, compte_courant_id = :compteCourantId WHERE id = :id");
        $stmt->bindParam(':type', $this->type);
        $stmt->bindParam(':amount', $this->amount);
        $stmt->bindParam(':compteCourantId', $this->compteCourantId);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM transaction WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
