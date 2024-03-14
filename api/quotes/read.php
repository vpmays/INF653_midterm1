<?php
   function read() {
         //Headers
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: application/json');

        include_once '../../config/Database.php';
        //include_once '../../config/Database_local.php';
        include_once '../../models/Quotes.php';
        //include_once 'index.php';

        // Instantiate DB & connect 
        $database = new Database();
        $db = $database->connect();

        //Instantiate blog quote obj
        $quotes = new Quotes($db);

        $quotes->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
        $quotes->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
        $quotes->id = isset($_GET['id']) ? $_GET['id'] : null;
        

        //Blog quotes query
        $result = $quotes->read();
        //Get row count
        $num = $result->rowCount();

        //Check if any quotes
        if ($num > 0) {
            //quote array
            $quotes_arr = array();
            //$quotes_arr['data'] = array();

            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                extract($row);

                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author_name' => $author_name,
                    'category_name' => $category_name,
                );

                // Push to 'data'
                //array_push($quotes_arr['data'], $quote_item);
                array_push($quotes_arr, $quote_item);
            }

            //Turn to json and output
            echo json_encode($quotes_arr);

        } else {
            //No quotes
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    }
?> 
