<?php
class Category{
    // Db stuff
    private $conn;
    private $table = "categories";

    // properties
    private $id;
    private $name;
    private $created_at;

    // create constructor with db
    public function __construct($db){
        $this->conn = $db;
    }

    // Get posts
    public function read(){
        $query = "SELECT id, name FROM  categories
        ORDER BY created_at DESC";

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // execute statement
        $stmt->execute();

        return $stmt;
    }

    // Get Single Post
    public function readSinglePost(){
        // create query
        $query = "SELECT name FROM " .$this->table.
         "WHERE id = ?";

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind id
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->name = $row['name'];
    }
}
?>