<?php
    function update() {
        //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');
        header('Access-Control-Allow-Methods: PUT');
        header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');

        include_once '../../config/Database.php';
        //include_once '../../config/Database_local.php';
        include_once '../../models/Quotes.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog quote obj
        $quote = new Quotes($db);

        //Get raw posted data
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->author_id) || !$data->author_id || !isset($data->quote) || !$data->quote || !isset($data->category_id) || !$data->category_id) { //(!isset($data->author_id) || !isset($data->quote) || !isset($data->category_id))
            echo json_encode(
                array('message' => 'Missing Required Parameters')
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

            if ($quote->author_exists == 0) { //check if author exists
                echo json_encode(
                    array('message' => 'author_id Not Found') 
                );
            } else if ($quote->category_exists == 0) { //check if category exists
                echo json_encode(
                    array('message' => 'category_id Not Found') 
                );
            } else { //check if quote was found and updated
                //Get row count
                $num = $result->rowCount();
                //Update post
                if($num > 0) { //quote was updated since at least 1 row, so print updates
                    echo json_encode(
                        array('id' => $data->id,
                        'quote' => $data->quote,
                        'author_id' => $data->author_id,
                        'category_id' => $data->category_id)
                    );
                } else { //no quote found to update
                    echo json_encode(
                        array('message' => 'No Quotes Found')
                    );
                }
            }
        }
    }
?>