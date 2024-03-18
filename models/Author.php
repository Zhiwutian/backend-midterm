<?php

class Author {
    //DB stuff
    private $conn;
    private $table = 'authors';

    //Properties
    public $id;
    public $author;

    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    // Get categories
    public function read(){
        // Create query
        $query = 'SELECT
            id, 
            author
        FROM
            ' . $this->table . ' 
        ';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
    //Get Single Post
    public function read_single(){

        // create query
        $query = 'SELECT
            id, 
            author
        FROM
            ' . $this->table . '
        WHERE 
            id = :id';

        // Prepare statement'

        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Set properties
        $this->author = $row['author'];
        $this->id = $row['id'];
    }

    // Create category
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
        ("author")
        VALUES 
        (:author)
        returning *
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));

        //Bind data
        $stmt->bindParam(':author', $this->author);


        // Execute query
        if($stmt->execute()){
           return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
    
    // Update Category
    public function update() {

        // Create query
        $query = 'UPDATE ' . $this->table . '
        SET
        author = :author
        WHERE
            id = :id
        returning *
        ';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));


        //Bind data
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
        // Execute query
        if($stmt->execute()){
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$response){
                return json_encode(array("message" => "author_id Not Found"));
            } else {
                return json_encode($response);
            }           
           
        }
        // Print error if something goes wrong
    }

    // Delete Post
    public function delete(){
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id
        returning *';

        // Prepare statment
        $stmt = $this->conn->prepare($query);

        // Clean id
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind id
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()){
            $response = $stmt->fetch(PDO::FETCH_ASSOC);
            if(!$response){
                return json_encode(array("message" => "author_id Not Found"));
            } else {
                return json_encode($response);
            }           
           
        }

    }
    

}