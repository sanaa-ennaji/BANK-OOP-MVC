<?php

class CompteEpargne {
    private $id;
    private $userId;  // Assuming user_id is the foreign key linking to the user table
    private $accountId;  // Assuming account_id is the foreign key linking to the account table

    // Constructor
    public function __construct($id, $userId, $accountId) {
        $this->id = $id;
        $this->userId = $userId;
        $this->accountId = $accountId;
    }

    // Getters and setters for properties

    public function getId() {
        return $this->id;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getAccountId() {
        return $this->accountId;
    }

    // Methods for CRUD operations

    // Create
    public static function create($userId, $accountId) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO compte_epargne (user_id, account_id) VALUES (:userId, :accountId)");
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':accountId', $accountId);

        return $stmt->execute();
    }

    // Read
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM compte_epargne WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE compte_epargne SET user_id = :userId, account_id = :accountId WHERE id = :id");
        $stmt->bindParam(':userId', $this->userId);
        $stmt->bindParam(':accountId', $this->accountId);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM compte_epargne WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
