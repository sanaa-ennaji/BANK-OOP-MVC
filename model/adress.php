<?php

    require_once("db.php");

    class Address extends Database {
        public function add($id, $city, $district, $street, $code_postal, $email, $telephone, $date){
            $db = $this->connect();

            try {
                $sql = "INSERT INTO address VALUES (:id, :city, :district, :street, :code_postal, :email, :telephone, :date)";

                $stmt = $db->prepare($sql);

                $stmt->bindParam(":id", $id);
                $stmt->bindParam(":city", $city);
                $stmt->bindParam(":district", $district);
                $stmt->bindParam(":street", $street);
                $stmt->bindParam(":code_postal", $code_postal);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":telephone", $telephone);
                $stmt->bindParam(":date", $date);

                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function edit($id, $city, $district, $street, $postal_code, $email, $telephone){
            $db = $this->connect();

            try {
                $sql = "UPDATE address SET city = :city, district = :district, street = :street, postal_code = :postal_code, email = :email, telephone = :telephone WHERE id = :id";

                $stmt = $db->prepare($sql);

                $stmt->bindParam(":city", $city);
                $stmt->bindParam(":district", $district);
                $stmt->bindParam(":street", $street);
                $stmt->bindParam(":postal_code", $postal_code);
                $stmt->bindParam(":email", $email);
                $stmt->bindParam(":telephone", $telephone);
                $stmt->bindParam(":id", $id);

                $stmt->execute();
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function delete($id){
            $db = $this->connect();

            try {
                $sql = "DELETE FROM address WHERE id = :id";

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
                $sql = "SELECT * FROM address WHERE id = :id";

                $stmt = $db->prepare($sql);
                $stmt->bindParam(":id", $id);

                $stmt->execute();

                return $stmt->fetchAll(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function display(){
            $db = $this->connect();

            try {
                $sql = "SELECT * FROM address";

                $data = $db->query($sql);

                return $data->fetchAll(PDO::FETCH_ASSOC);
                
            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }

        public function getLast(){
            $db = $this->connect();

            try {
                $sql = "SELECT * FROM address ORDER BY date DESC LIMIT 1";

                $data = $db->query($sql);

                return $data->fetch(PDO::FETCH_ASSOC);

            } catch (PDOException $e) {
                die("Error: " . $e->getMessage());
            }

        }
    }

?>