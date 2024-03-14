<?php
    function read() {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');

        //include_once '../../config/Database.php';
        include_once '../../config/Database_local.php';
        include_once '../../models/Categories.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog category obj
        $categories = new Categories($db);

        $categories->id = isset($_GET['id']) ? $_GET['id'] : null;
        
        //Blog categories query
        $result = $categories->read();
        //Get row count
        $num = $result->rowCount();

        //Check if any categories
        if ($num > 0) {
            //category array
            $categories_arr = array();
            //$categories_arr['data'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $category_item = array(
                    'id' => $id,
                    'category' => $category,
                );

                // Push to 'data'
                array_push($categories_arr, $category_item);
            }

            //Turn to json and output
            echo json_encode($categories_arr);

        } else {
            //No categories
            echo json_encode(
                array('message' => 'category_id Not Found')
            );
        }
    }
?> 