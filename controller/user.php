<?php

    require_once(__DIR__ . "/../models/random.php");
    require_once(__DIR__ . "/../models/address.php");
    require_once(__DIR__ . "/../models/user.php");
    require_once(__DIR__ . "/../models/role.php");
    require_once(__DIR__ . "/../models/roleOfUser.php");

    $address = new Address();
    $user = new User();
    $roleOfUser = new RoleOfUser();
    $role = new Role();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

    // ---------=  ADD =--------- //

        if(isset($_POST['add'])) {

            // ---------  ADDRESS PROPS --------- //
        
            $city = $_POST['city'];
            $district = $_POST['district'];
            $street = $_POST['street'];
            $codePostal = $_POST['postal-code'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];

            // ---------  USER PROPS --------- //

            $username = $_POST['username'];
            $password = password_hash($_POST['pw'], PASSWORD_BCRYPT);
            $nationality = $_POST['nationality'];
            $gendre = $_POST['gendre'];
            $agencyId = $_POST['agency'];

            // ---------  ROLE PROPS --------- //

            $roles = explode(',', $_POST['checkboxes']);

            $random = new Random();

            $id = $random->get();
            $date = date("Y-m-d h:i:s");
            $address->add($id, $city, $district, $street, $codePostal, $email, $telephone, $date);
            $lastAddress = $address->getLast();
            $addressId = $lastAddress['id'];

            $id = $random->get();
            $date = date("Y-m-d h:i:s");
            $user->add($id, $username, $password, $nationality, $gendre, $addressId, $agencyId, $date);
            $lastUser = $user->getLast();
            $userId = $lastUser['id'];

            // some loop through roles in post
            foreach($roles as $role):
                $id = $random->get();
                $roleOfUser->add($id, $userId, $role);
            endforeach;

            echo json_encode($lastUser);

    // ---------=  EDIT =--------- //

        } else if(isset($_POST['edit'])) {

            // ---------  ADDRESS PROPS --------- //
        
            $city = $_POST['city'];
            $district = $_POST['district'];
            $street = $_POST['street'];
            $codePostal = $_POST['postal-code'];
            $email = $_POST['email'];
            $telephone = $_POST['telephone'];

            // ---------  USER PROPS --------- //

            $username = $_POST['username'];
            $nationality = $_POST['nationality'];
            $gendre = $_POST['gendre'];
            $agencyId = $_POST['agency'];

            // ---------  ROLE PROPS --------- //

            $roleId = $_POST['role'];

            $id = $_POST['id'];
            $currentUser = $user->search($id);
            $currentAddressId = $currentUser['address_id'];

            $address->edit($currentAddressId, $city, $district, $street, $codePostal, $email, $telephone);

            $user->edit($id, $username, $nationality, $gendre, $agencyId);
            
        }  else {

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
                    username LIKE :username OR
                    nationality LIKE :nationality OR
                    gendre LIKE :gendre OR
                    role.name LIKE :role) ";
            $searchArray = array( 
                    'id'=>"%$searchValue%",
                    'username'=>"%$searchValue%",
                    'nationality'=>"%$searchValue%",
                    'gendre'=>"%$searchValue%",
                    'role'=>"%$searchValue%"
            );
            }

            try {
                // Total number of records without filtering
                $totalRecords = $user->totalRecords();

                // Total number of records with filtering
                $totalRecordwithFilter = $user->totalRecordwithFilter($searchQuery, $searchArray);

                // Fetch records
                $records = $user->filteredRecordwithSorting($searchQuery, $searchArray, $columnName, $columnSortOrder, $row, $rowperpage);
            } catch (PDOException $e){
                die("Error: " . $e->getMessage());
            }

            $data = array();

            foreach ($records as $row) {
                $data[] = array(
                    "id"=>$row['id'],
                    "username"=>$row['username'],
                    "nationality"=>$row['nationality'],
                    "gendre"=>$row['gendre'],
                    "role"=>$row['name'],
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

    if (isset($_GET['delete'])) {

        if(isset($_GET['id'])) {

            $id = $_GET['id'];

            $currentUser = $user->search($id);
            $currentAddressId = $currentUser['address_id'];
            $address->delete($currentAddressId);

            $user->delete($id);
        }

    } else if (isset($_GET['edit'])) {
            
        if(isset($_GET['id'])) {

            $id = $_GET['id'];
            $data = $user->searchAll($id);

            echo json_encode($data);

        }

    } else if (isset($_GET['get'])) {

        if(isset($_GET['id'])) {

            $id = $_GET['id'];
            $data = $user->getRoles($id);

            echo json_encode($data);

        } else {

            $data = $role->display();
            echo json_encode($data);

        }

    }

    }

    // ---------=  DISPLAY =--------- //
    



?>