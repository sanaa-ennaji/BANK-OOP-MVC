<?php

class Account {
    private $id;
    private $rib;
    private $currency;
    private $balance;
    private $userId;

    // Constructor
    public function __construct($id, $rib, $currency, $balance, $userId) {
        $this->id = $id;
        $this->rib = $rib;
        $this->currency = $currency;
        $this->balance = $balance;
        $this->userId = $userId;
    }

    // Getters and setters for properties

    public function getId() {
        return $this->id;
    }

    public function getRib() {
        return $this->rib;
    }

    // ... Add getters and setters for other properties

    // Methods for CRUD operations

    // Create
    public static function create($rib, $currency, $balance, $userId) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO account (rib, currency, balance, user_id) VALUES (:rib, :currency, :balance, :userId)");
        $stmt->bindParam(':rib', $rib);
        $stmt->bindParam(':currency', $currency);
        $stmt->bindParam(':balance', $balance);
        $stmt->bindParam(':userId', $userId);

        return $stmt->execute();
    }

    // Read
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM account WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE account SET rib = :rib, currency = :currency, balance = :balance, user_id = :userId WHERE id = :id");
        $stmt->bindParam(':rib', $this->rib);
        $stmt->bindParam(':currency', $this->currency);
        $stmt->bindParam(':balance', $this->balance);
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM account WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
