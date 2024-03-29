<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$quote = new Quote($db);

// Category read query
$result = $quote->read();
// Get row count
$num = $result->rowCount();

// Check if any categories
if ($num > 0){
    // Cat array
    $quote_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
       extract($row);

       $quote_item = array(
        'id' => $id,
        'quote' => $quote,
        'author' => $author,
        'category'=>$category
       );

       // Push to "data"
       array_push($quote_arr, $quote_item);

    }

    // Turn to JSON & output
    echo json_encode($quote_arr);
} else {
    // No categories found
    echo json_encode(array('message'=>'No Quotes Found'));
}
