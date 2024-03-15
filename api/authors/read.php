<?php
    function read() {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');

        include_once '../../config/Database.php';
        //include_once '../../config/Database_local.php';
        include_once '../../models/Authors.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog author obj
        $authors = new Authors($db);

        $authors->id = isset($_GET['id']) ? $_GET['id'] : null;
        

        //Blog authors query
        $result = $authors->read();
        //Get row count
        $num = $result->rowCount();

        //Check if any authors$authors
        if ($num > 0) {
            //author array
            $authors_arr = array();

            //loop through results and add authors to array
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $author_item = array(
                    'id' => $id,
                    'author' => $author,
                );

                array_push($authors_arr, $author_item);
            }

            if ($num == 1) { //if only one author, return that author data not in array
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