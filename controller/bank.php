<?php

class BankController
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    // Create (Add a new bank record)
    public function createBank($name, $location)
    {
        $sql = "INSERT INTO banks (name, location) VALUES (:name, :location)";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":location", $location);

        return $stmt->execute();
    }

    // Read (Get bank information)
    public function getBank($bankId)
    {
        $sql = "SELECT * FROM banks WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":id", $bankId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update (Modify bank information)
    public function updateBank($bankId, $name, $location)
    {
        $sql = "UPDATE banks SET name = :name, location = :location WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":id", $bankId);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":location", $location);

        return $stmt->execute();
    }

    // Delete (Remove a bank record)
    public function deleteBank($bankId)
    {
        $sql = "DELETE FROM banks WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(":id", $bankId);

        return $stmt->execute();
    }
}

// Example Usage:
try {
    $pdo = new PDO("mysql:host=localhost;dbname=your_database", "username", "password");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $bankController = new BankController($pdo);

    // Create
    $bankController->createBank("Sample Bank", "City");

    // Read
    $bankInfo = $bankController->getBank(1);
    print_r($bankInfo);

    // Update
    $bankController->updateBank(1, "Updated Bank", "New City");

    // Read again to see the changes
    $updatedBankInfo = $bankController->getBank(1);
    print_r($updatedBankInfo);

    // Delete
    $bankController->deleteBank(1);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
