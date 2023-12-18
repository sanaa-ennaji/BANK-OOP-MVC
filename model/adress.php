<?php

class Address {
    private $id;
    private $city;
    private $district;
    private $street;
    private $postalCode;
    private $email;
    private $telephone;

    // Constructor
    public function __construct($id, $city, $district, $street, $postalCode, $email, $telephone) {
        $this->id = $id;
        $this->city = $city;
        $this->district = $district;
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->email = $email;
        $this->telephone = $telephone;
    }

    // Getters and setters for properties

    public function getId() {
        return $this->id;
    }

    public function getCity() {
        return $this->city;
    }

    // ... Add getters and setters for other properties

    // Methods for CRUD operations

    // Create
    public static function create($city, $district, $street, $postalCode, $email, $telephone) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO address (city, district, street, postal_code, email, telephone) VALUES (:city, :district, :street, :postalCode, :email, :telephone)");
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':district', $district);
        $stmt->bindParam(':street', $street);
        $stmt->bindParam(':postalCode', $postalCode);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telephone', $telephone);

        return $stmt->execute();
    }

    // Read
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM address WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE address SET city = :city, district = :district, street = :street, postal_code = :postalCode, email = :email, telephone = :telephone WHERE id = :id");
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':district', $this->district);
        $stmt->bindParam(':street', $this->street);
        $stmt->bindParam(':postalCode', $this->postalCode);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telephone', $this->telephone);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM address WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
