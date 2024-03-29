<?php
    function read() {
         //Headers
        //header('Access-Control-Allow-Origin: *');
        //header('Content-Type: application/json');

        include_once '../../config/Database.php';
        //include_once '../../config/Database_local.php';
        include_once '../../models/Quotes.php';
        
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
            
            //loop through array and create json to return
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) { 
                extract($row);

                $quote_item = array(
                    'id' => $id,
                    'quote' => $quote,
                    'author' => $author_name,
                    'category' => $category_name,
                );

                array_push($quotes_arr, $quote_item);
            }

            if ($num == 1) { //if only one quote return, return single quote but not iside of an array
                echo json_encode($quotes_arr[0]);
            } else { //if more than one quote, return json of array of quotes
                //Turn to json and output
                echo json_encode($quotes_arr);
            }

        } else {
            //No quotes
            echo json_encode(
                array('message' => 'No Quotes Found')
            );
        }
    }
?> 
