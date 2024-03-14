<?php
    function create() {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: POST');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        include_once '../../config/Database.php';
        //include_once '../../config/Database_local.php';
        include_once '../../models/Quotes.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog post obj
        $quote = new Quotes($db);

        //Get raw posted data
        $data = json_decode(file_get_contents("php://input"));
        /*
        if (!isset($data->author_id) || !isset($data->quote) || !isset($data->category_id)) { //(!isset($data->author_id) || !isset($data->quote) || !isset($data->category_id))
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
            );*/
        if (!isset($data->author_id) || !$data->author_id || !isset($data->quote) || !$data->quote || !isset($data->category_id) || !$data->category_id) { //(!isset($data->author_id) || !isset($data->quote) || !isset($data->category_id))
            echo json_encode(
                array('message' => 'Missing Required Parameters') //'Missing Required Parameters'
            );
        } else {
            $quote->quote = $data->quote;
            $quote->author_id = $data->author_id;
            $quote->category_id = $data->category_id;

            //Create post
            if($quote->create()) {

                if ($quote->author_exists == 0) { //!$data->author_id
                    echo json_encode(
                        array('message' => 'author_id Not Found') //'author_id Not Found'
                    );
                } else if ($quote->category_exsits == 0) { //!$data->category_id
                    echo json_encode(
                        array('message' => 'category_id Not Found') //'category_id Not Found'
                    );
                } else { 

                    $quote_item = array(
                        'id' => $quote->id,
                        'quote' => $data->quote,
                        'author_id' => $data->author_id,
                        'category_id' => $data->category_id,
                    );
                    echo json_encode($quote_item);
                } 
            } else {
                echo json_encode(
                    array('message' => 'Quote not created.')
                );
            }
        }
    }
?>