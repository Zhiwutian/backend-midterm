<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Author.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$author = new Author($db);

// Get id from URL
$author->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get Post
$author->read_single();

// Create array
$aut_arr = array(
    'id' => $author->id,
    'author' => $author->author
);

if($aut_arr['id'] === null){
    print_r(json_encode(array('message'=>"category_id Not Found")));
}else {
    print_r(json_encode($aut_arr));
};

