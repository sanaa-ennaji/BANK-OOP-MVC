<?php

    require_once("db.php");

    class account extends Database {
        
        public function add($id, $rib, $currency, $balance, $user_id){
            try {
                $sql = "INSERT INTO account VALUES (:id, :rib, :currency, :balance, :user_id)";
                $stmt = $this->connect()->prepare($sql); 
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":rib", $rib);
                $stmt->bindParam(":currency", $currency);
                $stmt->bindParam(":balance", $balance);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->execute();
            } catch (PDOException $e){
                die("Error: ". $e->getMessage());
            }
        }

        public function display(){
            try {
                $sql = "SELECT * FROM account";
                $query = $this->connect()->query($sql);
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }
        }

        public function search($id){
            try {
                $sql = "SELECT * FROM account WHERE id = :id";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }
        }

        public function edit($id, $rib, $currency, $balance, $user_id){
            try {
                $sql = "UPDATE account SET rib = :rib, currency = :currency, balance = :balance, user_id = :user_id WHERE id = :id";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":rib", $rib);
                $stmt->bindParam(":currency", $currency);
                $stmt->bindParam(":balance", $balance);
                $stmt->bindParam(":user_id", $user_id);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            } catch (PDOException $e){
                    die("Error: " . $e->getMessage());
                
            }
        }

        public function delete($id){
            try {
                $sql = "DELETE FROM account WHERE id = :id";
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
            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM account ");
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
            $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM account WHERE 1 ".$searchQuery);
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
            $stmt = $db->prepare("SELECT * FROM account WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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


