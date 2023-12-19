<?php

    require_once(__DIR__ . "/../models/random.php");
    require_once(__DIR__ . "/../models/atm.php");

    $atm = new Atm();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            

        // ---------  EDIT --------- //

            if(isset($_POST['add'])) {

                $longitude = $_POST['longitude'];
                $latitude = $_POST['latitude'];
                $address = $_POST['address'];
                $bank_id = $_POST['bank_id'];
                $random = new Random();
                
                $id = $random->get();
                $atm->add($id, $longitude, $latitude, $address, $bank_id);

        // ---------  ADD --------- //

            } else if(isset($_POST['edit'])) {

            $id = $_POST['id'];
            $longitude = $_POST['longitude'];
            $latitude = $_POST['latitude'];
            $address = $_POST['address'];
            $bank_id = $_POST['bank_id'];

             $atm->edit($id, $longitude, $latitude, $address, $bank_id);

                 // ---------  DISPLAY --------- //

            }else {

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
                        longitude LIKE :longitude OR 
                        latitude LIKE :latitude OR 
                        address LIKE :address OR 
                        bank_id LIKE :bank_id) ";
                $searchArray = array( 
                        'id'=>"%$searchValue%",
                        'longitude'=>"%$searchValue%",
                        'latitude'=>"%$searchValue%",
                        'address'=>"%$searchValue%",
                        'bank_id'=>"%$searchValue%"
                );
                }
    
                try {
                    // Total number of records without filtering
                    $totalRecords = $atm->totalRecords();
    
                    // Total number of records with filtering
                    $totalRecordwithFilter = $atm->totalRecordwithFilter($searchQuery, $searchArray);
    
                    // Fetch records
                    $records = $atm->filteredRecordwithSorting($searchQuery, $searchArray, $columnName, $columnSortOrder, $row, $rowperpage);
                } catch (PDOException $e){
                    die("Error: " . $e->getMessage());
                }
    
                $data = array();
    
                foreach ($records as $row) {
                    $data[] = array(
                        "id"=>$row['id'],
                        "longitude"=>$row['longitude'],
                        "latitude"=>$row['latitude'],
                        "address"=>$row['address'],
                        "bank_id"=>$row['bank_id']
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
            $atm->delete($id);

        }
    }else if(isset($_GET['edit'])) {
            
        if(isset($_GET['id'])) {

            $id = $_GET['id'];
            $data = $atm->search($id);

            echo json_encode($data);

        }

    }

    }

    



?>