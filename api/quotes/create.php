<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();
// Instantiate blog post object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

if(!isset($data->category_id) || !isset($data->author_id) || !isset($data->quote)){
    echo json_encode(
        array("message"=>"Missing Required Parameters")
    );
    return;
}
$quote->category = $data->category_id;
$quote->author = $data->author_id;
$quote->quote = $data->quote;

// Create post and send to client
$response = $quote->create();
echo $response;
