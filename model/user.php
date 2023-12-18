<?php

    require_once("db.php");

    class User extends Db {
        public function add($id, $username, $password, $nationality, $gendre, $address_id, $agency_id, $date){
            $db = $this->connect();

            try {
                $sql = "INSERT INTO user VALUES (:id, :username, :password, :nationality, :gendre, :address_id, :agency_id, :date)";

                $stmt = $db->prepare($sql);

                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":password", $password);
                $stmt->bindParam(":nationality", $nationality);
                $stmt->bindParam(":gendre", $gendre);
                $stmt->bindParam(":address_id", $address_id);
                $stmt->bindParam(":agency_id", $agency_id);
                $stmt->bindParam(":date", $date);

                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function edit($id, $username, $nationality, $gendre, $agency_id){
            $db = $this->connect();

            try {
                $sql = "UPDATE user SET username = :username, nationality = :nationality, gendre = :gendre, agency_id = :agency_id WHERE id = :id";

                $stmt = $db->prepare($sql);

                $stmt->bindParam(":username", $username);
                $stmt->bindParam(":nationality", $nationality);
                $stmt->bindParam(":gendre", $gendre);
                $stmt->bindParam(":agency_id", $agency_id);
                $stmt->bindParam(":id", $id);

                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function delete($id){
            $db = $this->connect();

            try {
                $sql = "DELETE FROM user WHERE id = :id";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":id", $id);

                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function search($id){
            $db = $this->connect();

            try {
                $sql = "SELECT * FROM user WHERE id = :id";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function searchAll($id){
            $db = $this->connect();

            try {
                $sql = "SELECT user.id, user.username, user.nationality, user.gendre, user.agency_id, address.city, address.district, address.street, address.postal_code, address.email, address.telephone, role.name FROM user JOIN roleOfUser ON user.id = roleOfUser.user_id JOIN role ON roleOfUser.role_id = role.name JOIN address ON user.address_id = address.id WHERE user.id = :id";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function display(){
            $db = $this->connect();

            try {
                $sql = "SELECT * FROM user";

                $data = $db->query($sql);

                return $data->fetchAll(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function displayAll(){
            $db = $this->connect();

            try {
                $sql = "SELECT user.id, user.username, user.nationality, user.gendre, user.agency_id address.city, address.district, address.street, address.postal_code, address.email, address.telephone, role.name FROM user JOIN roleOfUser ON user.id = roleOfUser.user_id JOIN role ON roleOfUser.role_id = role.name JOIN address ON user.address_id = address.id";

                $data = $db->query($sql);

                return $data->fetchAll(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function getLast(){
            $db = $this->connect();

            try {
                $sql = "SELECT * FROM user ORDER BY date DESC LIMIT 1";

                $data = $db->query($sql);

                return $data->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function getId($username){
            $db = $this->connect();

            try {
                $sql = "SELECT * FROM user WHERE username = :username";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":username", $username);

                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function getRoles($id){
            $db = $this->connect();

            try {
                $sql = "SELECT role.name FROM user JOIN roleOfUser ON user.id = roleOfUser.user_id JOIN role ON roleOfUser.role_id = role.name JOIN address ON user.address_id = address.id WHERE user.id = :id";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function totalRecords(){
            $db = $this->connect();

            try {
                $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM user ");
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
                $stmt = $db->prepare("SELECT COUNT(*) AS allcount FROM user WHERE 1 ".$searchQuery);
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
                $stmt = $db->prepare("SELECT user.id, user.username, user.nationality, user.gendre, role.name FROM user JOIN roleOfUser ON user.id = roleOfUser.user_id JOIN role ON roleOfUser.role_id = role.name WHERE 1 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT :limit,:offset");

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