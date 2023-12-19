<?php

    require_once("db.php");

    class Bank extends Database {
        
        public function add($id, $name, $logo){
            try {
                $sql = "INSERT INTO bank VALUES (:id, :name, :logo)";
                $stmt = $this->connect()->prepare($sql); 
                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":logo", $logo);
                $stmt->execute();
            } catch (PDOException $e){
                die("Error: ". $e->getMessage());
            }
        }

        public function display(){
            try {
                $sql = "SELECT * FROM bank";
                $query = $this->connect()->query($sql);
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }
        }

        public function search($id){
            try {
                $sql = "SELECT * FROM bank WHERE id = :id";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return $data;
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }
        }

        public function edit($id, $name, $logo){
            try {
                $sql = "UPDATE bank SET name = :name, logo = :logo WHERE id = :id";
                $stmt = $this->connect()->prepare($sql);
                $stmt->bindParam(":name", $name);
                $stmt->bindParam(":logo", $logo);
                $stmt->bindParam(":id", $id);
                $stmt->execute();
            } catch (PDOException $e){
                    die("Error: " . $e->getMessage());
                
            }
        }

        public function delete($id){
            try {
                $sql = "DELETE FROM bank WHERE id = :id";
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
                $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM bank ");
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
                $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM bank WHERE 1 ".$searchQuery);
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
                $stmt = $db->prepare("SELECT * FROM bank WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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