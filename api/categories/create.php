<?php
    function create() {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
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
            $category->category = $data->category;

            //Create post
            if($category->create()) {
                echo json_encode(
                    array('message' => 'Category created.')
                );
            } else {
                echo json_encode(
                    array('message' => 'Category not created.')
                );
            } 
        }
    }
?>