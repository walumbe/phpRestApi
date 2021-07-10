<?php
class Post{
    // DB stuff
    private $conn;
    private $table = 'posts';

    // Post properties
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $author;
    public $created_at;

    // constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // Get posts
    public function read(){
        // Create query
        $query = 'SELECT
        c.name as category_name,
        posts.id,
        posts.category_id,
        posts.title,
        posts.author,
        posts.created_at
        FROM 
            posts
        LEFT JOIN
            categories c ON posts.category_id = c.id
        ORDER BY
            posts.created_at DESC';

        // Prepare  statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;

    }

    // Get single post
    public function readSinglePost(){
         // Create query
         $query = 'SELECT
         c.name as category_name,
         posts.id,
         posts.category_id,
         posts.title,
         posts.author,
         posts.created_at
         FROM 
             posts
         LEFT JOIN
             categories c ON posts.category_id = c.id
        WHERE 
            posts.id = ?
        LIMIT 0,1';

        // prepare statement
        $stmt = $this->conn->prepare($query);  
        
        // Bind id
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set properties
        $this->title = $row['title'];
        $this->bosy = $row['body'];
        $this->author = $row['author'];
        $this->category_id = $row['category_id'];
        $this->catgory_name = $row['category_name'];
     }

    //  Create Post
    public function create(){
        // create query
        $query = 'INSERT INTO ' . 
        $this->table .'
        SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));

        // Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute query
        if($stmt ->execute()){
            return true;
        }
        // Print error if something goes wrong
        printf("Error %s.\n" , $stmt->error);

        return false;
    }

    // update  post
    public function update(){
        // create query
        $query = 'UPDATE  posts
        SET 
            title = :title,
            body = :body,
            author = :author,
            category_id = :category_id
        WHERE
            id = :id';
        
        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));
        // Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt ->execute()){
            return true;
        }
        // Print error if something goes wrong
        printf("Error %s.\n" , $stmt->error);
        
        return false;
    }

    // Delete Post
    public function delete(){
        // create query
        $query = 'DELETE FROM posts WHERE id = :id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);
        // Clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':id', $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        }
        // Print error if something goes wrong
        printf("Error %s.\n" , $stmt->error);
        
        return false;
    }
}
?>