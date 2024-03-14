<?php
    function delete() {
        //Headers
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        //include_once '../../config/Database.php';
        include_once '../../config/Database_local.php';
        include_once '../../models/Authors.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog post obj
        $author = new Authors($db);

        //Get raw data
        $data = json_decode(file_get_contents("php://input"));

        //Set id to update
        $author->id = $data->id;

        //Blog quotes query
        $result = $author->delete();
        //Get row count
        $num = $result->rowCount();

        //delete category
        if($num >0) {
            echo json_encode(
                array('message' => '' . $author->id . '')
            );
        } else {
            echo json_encode(
                array('message' => 'No Author Found')
            );
        }
    }
?>