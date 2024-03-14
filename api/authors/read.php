<?php
    function read() {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');

        //include_once '../../config/Database.php';
        include_once '../../config/Database_local.php';
        include_once '../../models/Authors.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog author obj
        $authors = new Authors($db);

        $authors->id = isset($_GET['id']) ? $_GET['id'] : null;
        

        //Blog categories query
        $result = $authors->read();
        //Get row count
        $num = $result->rowCount();

        //Check if any authors$authors
        if ($num > 0) {
            //author array
            $authors_arr = array();
            $authors_arr = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $author_item = array(
                    'id' => $id,
                    'author' => $author,
                );

                // Push to 'data'
                array_push($authors_arr, $author_item);
            }

            if ($num == 1) {
                echo json_encode($authors_arr[0]);
            } else {
                //Turn to json and output
                echo json_encode($authors_arr);
            }
        } else {
            //No authors$authors
            echo json_encode(
                array('message' => 'author_id Not Found')
            );
        }
    }
?> 