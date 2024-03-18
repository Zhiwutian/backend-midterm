<?php
class Database {
    //DB Params
    private $host;
    private $port;
    private $db_name;
    private $username;
    private $password;
    private $conn;

    public function __construct() {
        $this->username = getenv("DBUSERNAME");
        $this->password = getenv("DBPASSWORD");
        $this->db_name = getenv('DBNAME');
        $this->host = getenv('DBHOST');
        $this->port = getenv('DBPORT');
    }
    // DB Connect
    public function connect(){

        if($this->conn) {
            return $this->conn;
        } else {


        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name};sslcert=blank;";

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            // echo for tutorial, but log the error for production
            echo 'Connection Error: ' . $e->getMessage();
        }

      }
    }
}
