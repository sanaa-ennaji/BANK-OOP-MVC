<?php

    require_once(__DIR__ . "/../models/random.php");
    require_once(__DIR__ . "/../models/address.php");
    require_once(__DIR__ . "/../models/agency.php");

    $address = new Address();
    $agency = new Agency();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ---------=  ADD =--------- //

        if(isset($_POST['add'])) {

             // ---------  ADDRESS PROPS --------- //
        
            $city = $_POST['city'];
            $district = $_POST['district'];
            $street = $_POST['street'];
            $codePostal = $_POST['codePostal'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];

            // ---------  AGENCY PROPS --------- //

            $longitude = $_POST['longitude'];
            $latitude = $_POST['latitude'];
            $bank_id = $_POST['bank_id'];

            $random = new Random();

            $id = $random->get();
            $date = date("Y-m-d h:i:s");
            $address->add($id, $city, $district, $street, $codePostal, $email, $telephone, $date);
            $lastAddress = $address->getLast();
            $addressId = $lastAddress['id'];

            $id = $random->get();
            $agency->add($id, $longitude, $latitude, $bank_id, $addressId);


    // ---------=  EDIT =--------- //

        } else if(isset($_POST['edit'])) {

             // ---------  ADDRESS PROPS --------- //
        
            $city = $_POST['city'];
            $district = $_POST['district'];
            $street = $_POST['street'];
            $codePostal = $_POST['codePostal'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];

            // ---------  AGENCY PROPS --------- //

            $longitude = $_POST['longitude'];
            $latitude = $_POST['latitude'];
            $bank_id = $_POST['bank_id'];

            $id = $_POST['id'];
            $currentagency = $agency->search($id);
            $currentAddressId = $currentagency['address_id'];

            $address->edit($currentAddressId, $city, $district, $street, $codePostal, $email, $telephone);

            $agency->edit($id, $longitude, $latitude, $bank_id);

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
                    bank_id LIKE :bank_id OR 
                    address_id LIKE :address_id) ";
            $searchArray = array( 
                    'id'=>"%$searchValue%",
                    'longitude'=>"%$searchValue%",
                    'latitude'=>"%$searchValue%",
                    'bank_id'=>"%$searchValue%",
                    'address_id'=>"%$searchValue%"
            );
            }

            try {
                // Total number of records without filtering
                $totalRecords = $agency->totalRecords();

                // Total number of records with filtering
                $totalRecordwithFilter = $agency->totalRecordwithFilter($searchQuery, $searchArray);

                // Fetch records
                $records = $agency->filteredRecordwithSorting($searchQuery, $searchArray, $columnName, $columnSortOrder, $row, $rowperpage);
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }

            $data = array();

            foreach ($records as $row) {
                $data[] = array(
                    "id"=>$row['id'],
                    "longitude"=>$row['longitude'],
                    "latitude"=>$row['latitude'],
                    "bank_id"=>$row['bank_id'],
                    "address_id"=>$row['address_id']
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
    

    // ---------=  DELETE =--------- //

    if($_SERVER['REQUEST_METHOD'] == 'GET') {
        if(isset($_GET['delete'])) {

            if(isset($_GET['id'])) {
                
                $id = $_GET['id'];
                $currentagency = $agency->search($id);
                $currentAddressId = $currentagency['address_id'];
                $address->delete($currentAddressId);
                $agency->delete($id);

            }

        }else if(isset($_GET['edit'])) {
            if(isset($_GET['id'])) {

                $id = $_GET['id'];
                $currentagency = $agency->search($id);

                echo json_encode($currentagency);
        }
}
    }

    


?>