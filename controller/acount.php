<?php

    require_once(__DIR__ . "/../models/random.php");
    require_once(__DIR__ . "/../models/account.php");

    $account = new Account();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {

            

        // ---------  EDIT --------- //

            if(isset($_POST['add'])) {

                $rib = $_POST['rib'];
                $currency = $_POST['currency'];
                $balance = $_POST['balance'];
                $user_id = $_POST['user_id'];
                $random = new Random();
                
                $id = $random->get();
                $account->add($id, $rib, $currency, $balance, $user_id);

        // ---------  ADD --------- //

            } else if(isset($_POST['edit'])) {

            $id = $_POST['id'];
            $rib = $_POST['rib'];
            $currency = $_POST['currency'];
            $balance = $_POST['balance'];
            $user_id = $_POST['user_id'];

             $account->edit($id, $rib, $currency, $balance, $user_id);

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
                        rib LIKE :rib OR 
                        currency LIKE :currency OR 
                        balance LIKE :balance OR 
                        user_id LIKE :user_id) ";
                $searchArray = array( 
                        'id'=>"%$searchValue%",
                        'rib'=>"%$searchValue%",
                        'currency'=>"%$searchValue%",
                        'balance'=>"%$searchValue%",
                        'user_id'=>"%$searchValue%"
                );
                }
    
                try {
                    // Total number of records without filtering
                    $totalRecords = $account->totalRecords();
    
                    // Total number of records with filtering
                    $totalRecordwithFilter = $account->totalRecordwithFilter($searchQuery, $searchArray);
    
                    // Fetch records
                    $records = $account->filteredRecordwithSorting($searchQuery, $searchArray, $columnName, $columnSortOrder, $row, $rowperpage);
                } catch (PDOException $e){
                    die("Error: " . $e->getMessage());
                }
    
                $data = array();
    
                foreach ($records as $row) {
                    $data[] = array(
                        "id"=>$row['id'],
                        "rib"=>$row['rib'],
                        "currency"=>$row['currency'],
                        "balance"=>$row['balance'],
                        "user_id"=>$row['user_id']
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
            $account->delete($id);

        }
    }else if(isset($_GET['edit'])) {
            
        if(isset($_GET['id'])) {

            $id = $_GET['id'];
            $data = $account->search($id);

            echo json_encode($data);

        }

    }

    }

    



?>