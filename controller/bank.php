<?php

    require_once(__DIR__ . "/../models/random.php");
    require_once(__DIR__ . "/../models/bank.php");

    $bank = new Bank();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ---------  ADD --------- //
        
        if(isset($_POST['add'])) {

            $name = $_POST['name'];

            $valid_extensions = array('jpeg', 'jpg', 'png');
            $path = __DIR__ . "/../../public/uploads/";

            $img = $_FILES['logo']['name'];
            $tmp = $_FILES['logo']['tmp_name'];

            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

            $logo = rand(1000,1000000).$img;

            if(in_array($ext, $valid_extensions)) { 
                $path = $path.strtolower($logo); 
                if(move_uploaded_file($tmp,$path)) {
                    echo "Upload Failed";
                } else {
                    echo "Upload Successful";
                }
            }

            $logo = strtolower($logo);

            $random = new Random();
            
            $id = $random->get();
            try{
                $bank->add($id, $name, $logo);
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }

    // ---------  EDIT --------- //


        } else if(isset($_POST['edit'])) {

            $id = $_POST['id'];
            $name = $_POST['name'];
            $valid_extensions = array('jpeg', 'jpg', 'png');
            $path = __DIR__ . "/../../public/uploads/";

            $img = $_FILES['logo']['name'];
            $tmp = $_FILES['logo']['tmp_name'];

            $ext = strtolower(pathinfo($img, PATHINFO_EXTENSION));

            $logo = rand(1000,1000000).$img;

            if(in_array($ext, $valid_extensions)) { 
                $path = $path.strtolower($logo); 
                if(move_uploaded_file($tmp,$path)) {
                    echo "Upload Failed";
                } else {
                    echo "Upload Successful";
                }
            }

            try{
                $bank->edit($id, $name, $logo);
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }

    // ---------  DISPLAY --------- //

        } else {

            // Reading value
            $draw = $_POST['draw'];
            $row = $_POST['start'];
            $rowperpage = $_POST['length']; // Rows display per page
            $columnIndex = $_POST['order'][0]['column']; // Column index
            $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
            $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
            $searchValue = $_POST['search']['value']; // Search value

            $searchArray = array();

            // Search
            $searchQuery = " ";
            if($searchValue != ''){
            $searchQuery = " AND (id LIKE :id OR 
                    name LIKE :name) ";
            $searchArray = array( 
                    'id'=>"%$searchValue%",
                    'name'=>"%$searchValue%"
            );
            }

            try {
                // Total number of records without filtering
                $totalRecords = $bank->totalRecords();

                // Total number of records with filtering
                $totalRecordwithFilter = $bank->totalRecordwithFilter($searchQuery, $searchArray);

                // Fetch records
                $records = $bank->filteredRecordwithSorting($searchQuery, $searchArray, $columnName, $columnSortOrder, $row, $rowperpage);
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }

            $data = array();

            foreach ($records as $row) {
                $data[] = array(
                    "id"=>$row['id'],
                    "name"=>$row['name'],
                    "logo"=>$row['logo']
                );
            }

            // Response
            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordwithFilter,
                "aaData" => $data
            );

            echo json_encode($response);

        }
    }

    // ---------  DELETE --------- //

    if($_SERVER['REQUEST_METHOD'] == 'GET') {

        if(isset($_GET['delete'])) {

            if(isset($_GET['id'])) {

                $id = $_GET['id'];
                $bank->delete($id);

            }

        } else if (isset($_GET['edit'])) {
            
            if(isset($_GET['id'])) {

                $id = $_GET['id'];
                $data = $bank->search($id);

                echo json_encode($data);

            }

        }

    }

?>