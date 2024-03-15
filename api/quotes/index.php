<?php 
    
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];
    
    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    } else if ($method == 'GET') { //if GET, call read() function from read.php
        include_once 'read.php';
        read();
        exit;
    } else if ($method == 'POST') { //if POST, call create() function from create.php
        include_once 'create.php'; 
        //header('Access-Control-Allow-Methods: POST');
        //header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        create();
        exit;
    } else if ($method == 'PUT') { //if PUT, call update() function from update.php
        include_once 'update.php';
        //header('Access-Control-Allow-Methods: PUT');
        //header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        update();
        exit;
    } else if ($method == 'DELETE') { //if DELETE, call delete() function from delete.php
        include_once 'delete.php';
        //header('Access-Control-Allow-Methods: DELETE');
        //header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Authorization, X-Requested-With');
        delete();
        exit;
    }

?>