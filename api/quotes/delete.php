<?php
    function delete() {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        //include_once '../../config/Database.php';
        include_once '../../config/Database_local.php';
        include_once '../../models/Quotes.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog post obj
        $quote = new Quotes($db);

        //Get raw data
        $data = json_decode(file_get_contents("php://input"));

        //Set id to update
        $quote->id = $data->id;

        //Blog quotes query
        $result = $quote->delete();
        //Get row count
        $num = $result->rowCount();

        //delete quote
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
?>