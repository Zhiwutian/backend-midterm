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

if(!$data->id){
    echo json_encode(array("message"=>"Missing Required Parameters"));
    return;
}

// Set ID to update
$author->id = $data->id;


// Delete post

$response = $author->delete();
echo $response;
