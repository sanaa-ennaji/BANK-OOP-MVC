<?php

    require_once("db.php");

    class Agency extends Db {
        
        public function add($id, $longitude, $latitude, $bank_id, $address_id){
            try {
                $sql = "INSERT INTO agency VALUES (:id, :longitude, :latitude, :bank_id, :address_id)";
                $stmt = $this->connect()->prepare($sql); 
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":longitude", $longitude);
                $stmt->bindParam(":latitude", $latitude);
                $stmt->bindParam(":bank_id", $bank_id);
                $stmt->bindParam(":address_id", $address_id);
                $stmt->execute();
            } catch (PDOException $e){
                die("Error: ". $e->getMessage());
            }
        }

        public function display(){
            try {
                $sql = "SELECT * FROM agency";
                $query = $this->connect()->query($sql);
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }
        }

        public function search($id){
            try {
                $sql = "SELECT * FROM agency WHERE id = :id";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }
        }

        public function searchAll($id){
            $db = $this->connect();

            try {
                $sql = "SELECT agency.id, agency.longitude, agency.latitude, agency.bank_id, address.city, address.district, address.street, address.postal_code, address.email, address.telephone FROM agency JOIN address ON agency.address_id = address.id WHERE agency.id = :id";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function edit($id, $longitude, $latitude, $bank_id){
            try {
                $sql = "UPDATE agency SET longitude = :longitude, latitude = :latitude, bank_id = :bank_id WHERE id = :id";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":longitude", $longitude);
                $stmt->bindParam(":latitude", $latitude);
                $stmt->bindParam(":bank_id", $bank_id);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            } catch (PDOException $e){
                    die("Error: " . $e->getMessage());
                
            }
        }

        public function delete($id){
            try {
                $sql = "DELETE FROM agency WHERE id = :id";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }
        }
        public function totalRecords(){
            $db = $this->connect();

            try {
                $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM agency");
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
                $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM agency WHERE 1 ".$searchQuery);
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
                $stmt = $db->prepare("SELECT * FROM agency WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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