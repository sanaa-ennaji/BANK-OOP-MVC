<?php

class ATM {
    private $id;
    private $longitude;
    private $latitude;
    private $address;
    private $bankId;

    // Constructor
    public function __construct($id, $longitude, $latitude, $address, $bankId) {
        $this->id = $id;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->address = $address;
        $this->bankId = $bankId;
    }

    // Getters and setters for properties

    public function getId() {
        return $this->id;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getBankId() {
        return $this->bankId;
    }

    // Methods for CRUD operations

    // Create
    public static function create($longitude, $latitude, $address, $bankId) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO atm (longitude, latitude, address, bank_id) VALUES (:longitude, :latitude, :address, :bankId)");
        $stmt->bindParam(':longitude', $longitude);
        $stmt->bindParam(':latitude', $latitude);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':bankId', $bankId);

        return $stmt->execute();
    }

    // Read
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM atm WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE atm SET longitude = :longitude, latitude = :latitude, address = :address, bank_id = :bankId WHERE id = :id");
        $stmt->bindParam(':longitude', $this->longitude);
        $stmt->bindParam(':latitude', $this->latitude);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':bankId', $this->bankId);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM atm WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
