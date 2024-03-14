<?php
    function update () {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        include_once '../../config/Database.php';
        //include_once '../../config/Database_local.php';
        include_once '../../models/Categories.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog post obj
        $category = new Categories($db);

        //Get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->category)) {
            echo json_encode(
                array('message' => 'Missing Required Parameters')
            );
        } else {
            //Set id to update
            $category->id = $data->id;

            //Set other properties
            $category->category = $data->category;

            //Blog quotes query
            $result = $category->update();
            //Get row count
            $num = $result->rowCount();

            //update category
            if($num >0) {
                echo json_encode(
                    array('message' => '' . $category->id . '')
                );
            } else {
                echo json_encode(
                    array('message' => 'No Category Found')
                );
            }
        }
    }
?>