<?php
    function update () {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        include_once '../../config/Database.php';
        //include_once '../../config/Database_local.php';
        include_once '../../models/Authors.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog author obj
        $author = new Authors($db);

        //Get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->author)) { //check that author is in given json data
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
        } else {
            //Set id to update
            $author->id = $data->id;

            //Set other properties
            $author->author = $data->author;

            //Blog authors query
            $result = $author->update();
            //Get row count
            $num = $result->rowCount();

            //Update post
            if($num > 0) {
                echo json_encode(
                    array('id' => $data->id,
                    'author' => $data->author)
                );
            } else {
                echo json_encode(
                    array('message' => 'No Author Found')
                );
            }
        }
    }
?>