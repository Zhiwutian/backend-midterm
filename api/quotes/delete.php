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

if(!$data->id){
    echo json_encode(array("message"=>"Missing Required Parameters"));
    return;
}

// Set ID to update
$quote->id = $data->id;


// Delete post

$response = $quote->delete();
echo $response;
