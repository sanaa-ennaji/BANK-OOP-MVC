<?php

require_once("db.php");

class Transaction extends Database {

    public function add($id, $type, $amount, $account_id) {
        try {
            $sql = "INSERT INTO transaction VALUES (:id, :type, :amount, :account_id)";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":type", $type);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":account_id", $account_id); 
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function edit($id, $type, $amount, $account_id) {
        try {
            $sql = "UPDATE transaction SET type = :type, amount = :amount, account_id = :account_id WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":type", $type);
            $stmt->bindParam(":amount", $amount);
            $stmt->bindParam(":account_id", $account_id); 
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function display() {
        try {
            $sql = "SELECT * FROM transaction";
            $query = $this->connect()->query($sql);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function search($id) {
        try {
            $sql = "SELECT * FROM transaction WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM transaction WHERE id = :id";
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function totalRecords(){
        $db = $this->connect();

        try {
            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM transaction ");
            $stmt->execute();
            $records = $stmt->fetch();
            $data = $records['allcount'];
            return $data;
        } catch (PDOException $e){
            die("Error: " . $e->getMessage());
        }
    }

    public function totalRecordwithFilter($searchQuery, $searchArray){
        $db = $this->connect();

        try {
            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM transaction WHERE 1 ".$searchQuery);
            $stmt->execute($searchArray);
            $records = $stmt->fetch();
            $data = $records['allcount'];
            return $data;
        } catch (PDOException $e){
            die("Error: " . $e->getMessage());
        }
    }

    public function filteredRecordwithSorting($searchQuery, $searchArray, $columnName, $columnSortOrder, $row, $rowperpage){
        $db = $this->connect();

        try {
            $stmt = $db->prepare("SELECT * FROM transaction WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

            foreach ($searchArray as $key=>$search) {
                $stmt->bindValue(':'.$key, $search,PDO::PARAM_STR);
            }

            $stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll();
            return $data;
        } catch (PDOException $e){
            die("Error: " . $e->getMessage());
        }
    }
}

?>
