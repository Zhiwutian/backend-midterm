<?php

include_once '../../config/Database.php';
include_once '../../models/Author.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$author = new Author($db);

// Category read query
$result = $author->read();
// Get row count
$num = $result->rowCount();

// Check if any categories
if ($num > 0){
    // Cat array
    $aut_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
       extract($row);

       $aut_item = array(
        'id' => $id,
        'author' => $author
       );

       // Push to "data"
       array_push($aut_arr, $aut_item);

    }

    // Turn to JSON & output
    echo json_encode($aut_arr);
} else {
    // No categories found
    echo json_encode(array('message'=>'No categories Found'));
}
