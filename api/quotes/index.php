<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }


$categoryId = htmlspecialchars($_GET["category_id"]);
$authorId = htmlspecialchars($_GET["author_id"]);

if($method === "GET"){
    $id = htmlspecialchars($_GET["id"]);
    if($id){
        include_once './read_single.php';
        return;
    }
    include_once './read.php';
} else if($method === "POST"){
    include_once './create.php';

} else if ($method === "PUT"){
    include_once './update.php';
} else if ($method === "DELETE"){
    include_once './delete.php';
}
    
