<?php

class User {
    private $id;
    private $username;
    private $password;
    private $nationality;
    private $gender;
    private $addressId;
    private $agencyId;
    private $date;

    // Constructor
    public function __construct($id, $username, $password, $nationality, $gender, $addressId, $agencyId, $date) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->nationality = $nationality;
        $this->gender = $gender;
        $this->addressId = $addressId;
        $this->agencyId = $agencyId;
        $this->date = $date;
    }

    // Getters and setters for properties

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    // ... Add getters and setters for other properties

    // Methods for CRUD operations

    // Create
    public static function create($username, $password, $nationality, $gender, $addressId, $agencyId) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("INSERT INTO user (username, password, nationality, gender, address_id, agency_id, date) VALUES (:username, :password, :nationality, :gender, :addressId, :agencyId, NOW())");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':nationality', $nationality);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':addressId', $addressId);
        $stmt->bindParam(':agencyId', $agencyId);

        return $stmt->execute();
    }

    // Read
    public static function getById($id) {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update
    public function update() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("UPDATE user SET username = :username, password = :password, nationality = :nationality, gender = :gender, address_id = :addressId, agency_id = :agencyId WHERE id = :id");
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':nationality', $this->nationality);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':addressId', $this->addressId);
        $stmt->bindParam(':agencyId', $this->agencyId);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    // Delete
    public function delete() {
        $db = Database::getInstance()->getConnection();

        $stmt = $db->prepare("DELETE FROM user WHERE id = :id");
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

?>
