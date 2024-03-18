<?php

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog post object
$quote = new Quote($db);

// Get id from URL
$quote->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get Post
$quote->read_single();

// Create array
$quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author,
    'category' => $quote->category
);

if($quote_arr['quote'] === null){
    print_r(json_encode(array('message'=>"No Quotes Found")));
}else {
    print_r(json_encode($quote_arr));
};

// MakeJSON
