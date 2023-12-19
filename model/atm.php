<?php

require_once("db.php");

class Atm extends Database {

    public function add($id, $address, $longitude, $latitude, $bankId) {
        $db = $this->connect();

        try {
            $sql = "INSERT INTO atm VALUES (:id, :address, :longitude, :latitude, :bankId)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":longitude", $longitude);
            $stmt->bindParam(":latitude", $latitude);
            $stmt->bindParam(":bankId", $bankId);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function display() {
        $db = $this->connect();

        try {
            $sql = "SELECT * FROM atm";
            $query = $db->query($sql);
            $data = $query->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function search($id) {
        $db = $this->connect();

        try {
            $sql = "SELECT * FROM atm WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function edit($id, $address, $longitude, $latitude, $bankId) {
        $db = $this->connect();


        try {
            $sql = "UPDATE atm SET address = :address, longitude = :longitude, latitude = :latitude, bank_id = :bank_id WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":longitude", $longitude);
            $stmt->bindParam(":latitude", $latitude);
            $stmt->bindParam(":bank_id", $bankId);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function delete($id) {
        $db = $this->connect();

        try {
            $sql = "DELETE FROM atm WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
    public function totalRecords(){
        $db = $this->connect();

        try {
            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM atm ");
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
            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM atm WHERE 1 ".$searchQuery);
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
            $stmt = $db->prepare("SELECT * FROM atm WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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
