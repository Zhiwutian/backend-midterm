<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$quote = new Quote($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

print_r($data);
if(!$data->category_id || !$data->author_id || !$data->id || !$data->quote){
    echo json_encode(
        array("message"=>"Missing Required Parameters")
    );
    return;
}
// Set ID to update
$quote->id = $data->id;
$quote->category = $data->category_id;
$quote->author = $data->author_id;
$quote->quote = $data->quote;

// Create post

$response = $quote->update();
echo $response;
