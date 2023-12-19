<?php

    require_once(__DIR__ . "/../models/random.php");
    require_once(__DIR__ . "/../models/transaction.php");

    $transaction = new Transaction();

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            

        // ---------  EDIT --------- //

            if(isset($_POST['add'])) {

                $type = $_POST['type'];
                $amount = $_POST['amount'];
                $account_id = $_POST['account_id'];
                $random = new Random();
                
                $id = $random->get();
                $transaction->add($id, $type, $amount, $account_id);

        // ---------  ADD --------- //

            } else if(isset($_POST['edit'])) {

            $id = $_POST['id'];
            $type = $_POST['type'];
            $amount = $_POST['amount'];
            $account_id = $_POST['account_id'];

             $transaction->edit($id, $type, $amount, $account_id);

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
                        type LIKE :type OR 
                        amount LIKE :amount OR 
                        account_id LIKE :account_id) ";
                $searchArray = array( 
                        'id'=>"%$searchValue%",
                        'type'=>"%$searchValue%",
                        'amount'=>"%$searchValue%",
                        'account_id'=>"%$searchValue%",
                );
                }
    
                try {
                    // Total number of records without filtering
                    $totalRecords = $transaction->totalRecords();
    
                    // Total number of records with filtering
                    $totalRecordwithFilter = $transaction->totalRecordwithFilter($searchQuery, $searchArray);
    
                    // Fetch records
                    $records = $transaction->filteredRecordwithSorting($searchQuery, $searchArray, $columnName, $columnSortOrder, $row, $rowperpage);
                } catch (PDOException $e){
                    die("Error: " . $e->getMessage());
                }
    
                $data = array();
    
                foreach ($records as $row) {
                    $data[] = array(
                        "id"=>$row['id'],
                        "type"=>$row['type'],
                        "amount"=>$row['amount'],
                        "account_id"=>$row['account_id'],
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
            $transaction->delete($id);

        }
    }else if(isset($_GET['edit'])) {
            
        if(isset($_GET['id'])) {

            $id = $_GET['id'];
            $data = $transaction->search($id);

            echo json_encode($data);

        }

    }

    }

    



?>