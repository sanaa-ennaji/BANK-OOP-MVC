<?php

class AgenceController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Create (Add a new agency record)
    public function createAgence($name, $location)
    {
        $sql = "INSERT INTO agences (name, location) VALUES (:name, :location)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":location", $location);

        return $stmt->execute();
    }

    // Read (Get agency information)
    public function getAgence($agenceId)
    {
        $sql = "SELECT * FROM agences WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":id", $agenceId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update (Modify agency information)
    public function updateAgence($agenceId, $name, $location)
    {
        $sql = "UPDATE agences SET name = :name, location = :location WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":id", $agenceId);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":location", $location);

        return $stmt->execute();
    }

    // Delete (Remove an agency record)
    public function deleteAgence($agenceId)
    {
        $sql = "DELETE FROM agences WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":id", $agenceId);

        return $stmt->execute();
    }
}

// Example Usage:
try {
    $pdo = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $agenceController = new AgenceController($pdo);

    // Create
    $agenceController->createAgence("Sample Agence", "City");

    // Read
    $agenceInfo = $agenceController->getAgence(1);
    print_r($agenceInfo);

    // Update
    $agenceController->updateAgence(1, "Updated Agence", "New City");

    // Read again to see the changes
    $updatedAgenceInfo = $agenceController->getAgence(1);
    print_r($updatedAgenceInfo);

    // Delete
    $agenceController->deleteAgence(1);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
