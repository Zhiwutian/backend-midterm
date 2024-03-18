<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';
// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$category = new Category($db);

// Category read query
$result = $category->read();
// Get row count
$num = $result->rowCount();

// Check if any categories
if ($num > 0){
    // Cat array
    $cat_arr = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
       extract($row);
       
       $cat_item = array(
        'id' => $id,
        'category' => $category
       );

       // Push to "data"
       array_push($cat_arr, $cat_item);

    }

    // Turn to JSON & output
    echo json_encode($cat_arr);
} else {
    // No categories found
    echo json_encode(array('message'=>'No categories Found'));
}