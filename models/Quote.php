<?php

class Quote {
    //DB stuff
    private $conn;
    private $table = 'quotes';

    //Properties
    public $id;
    public $author_id;
    public $category_id;
    public $quote;
    public $author;
    public $category;



    // Constructor with DB
    public function __construct($db){
        $this->conn = $db;
    }

    // Get categories
    public function read(){
        // Create query

        $query = 'select "q"."quote",
        "q"."id",
        "a"."author",
        "c"."category"
        from ' . $this->table . ' as "q"
        join "authors" as "a" on a.id = q.author_id
        join "categories" as "c" on c.id = q.category_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
    }
    //Get Single Post
    public function read_single(){

        // create query
        $query = 'select "q"."quote",
        "q"."id",
        "a"."author",
        "c"."category"
        from ' . $this->table . ' as "q"
        join "authors" as "a" on a.id = q.author_id
        join "categories" as "c" on c.id = q.category_id
        where "q"."id" = :id';

        // Prepare statement'

        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(':id', $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if($row){
            $this->quote = $row['quote'];
            $this->id = $row['id'];
            $this->author = $row['author'];
            $this->category = $row['category'];
            return;
        }
        return;
    }

    // Create category
    public function create() {
        // Create query
        $query = 'INSERT INTO ' . $this->table . '
        ("quote", "author_id", "category_id")
        VALUES
        (:quote, :author, :category)
        returning *
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category = htmlspecialchars(strip_tags($this->category));

        //Bind data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category', $this->category);


        // Execute query
        try{
            if ($stmt->execute()) {
                return json_encode($stmt->fetch(PDO::FETCH_ASSOC));
            }
        } catch (PDOException $e){
            $message = $e->getMessage();
            if(str_contains($message, "quotes_author_id_fkey")){
                return json_encode(array("message"=>"author_id Not Found"));
            } else if (str_contains($message, "quotes_category_id_fkey")){
                return json_encode(array("message" => "category_id Not Found"));
            }
        }


    }

    // Update Category
    public function update() {

        // Create query
        $query = 'UPDATE ' . $this->table . '
        SET
        quote = :quote, author_id = :author, category_id = :category
        WHERE
            id = :id
        returning *
        ';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->author = htmlspecialchars(strip_tags($this->author));



        //Bind data
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category', $this->category);
        // Execute query
        try{
            if ($stmt->execute()) {
                $response = $stmt->fetch(PDO::FETCH_ASSOC);
                if(!$response){
                    return json_encode(array("message"=>"No Quotes Found"));
                }
                return json_encode($response);
            }
            } catch (PDOException $e){
            $message = $e->getMessage();
            if (str_contains($message, "quotes_author_id_fkey")) {
                return json_encode(array("message" => "author_id Not Found"));
            } else if (str_contains($message, "quotes_category_id_fkey")) {
                return json_encode(array("message" => "category_id Not Found"));
            }
            }


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
                return json_encode(array("message" => "No Quotes Found"));
            } else {
                return json_encode(array("id" => $response["id"]));
            }

        }

    }


}
