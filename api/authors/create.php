<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$author = new Author($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));
if(!isset($data->author)){
    echo json_encode(
        array("message"=>"Missing Required Parameters")
    );
    return;
}
$author->author = $data->author;


// Create post and send to client
$response = $author->create();
echo $response;
