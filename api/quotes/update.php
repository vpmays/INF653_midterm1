<?php
    function update() {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        //include_once '../../config/Database.php';
        include_once '../../config/Database_local.php';
        include_once '../../models/Quotes.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog post obj
        $quote = new Quotes($db);

        //Get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->author_id) || !isset($data->quote) || !isset($data->category_id)) {
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
        } else if (!$data->author_id) {
            echo json_encode(
                array('message' => 'author_id Not Found')
            );
        } else if (!$data->category_id) {
            echo json_encode(
                array('message' => 'category_id Not Found')
            );
        } else {
            //Set id to update
            $quote->id = $data->id;

            //Set other properties
            $quote->quote = $data->quote;
            $quote->author_id = $data->author_id;
            $quote->category_id = $data->category_id;

            //Blog quotes query
            $result = $quote->update();
            //Get row count
            $num = $result->rowCount();

            //Update post
            if($num > 0) {
                echo json_encode(
                    array('message' => '' . $quote->id . '')
                );
            } else {
                echo json_encode(
                    array('message' => 'No Quotes Found')
                );
            }
        }
    }
?>