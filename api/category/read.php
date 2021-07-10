<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: apllication/json');

include_once('../../config/Database.php');
include_once('../../models/Category.php');

// Instatiate DB & connect
$database = new Database();
$db = $database->connect();

// Instatiate new blog post object
$category  = new Category($db);

// Blog post query
$result = $category->read();

// Get row count
$num = $result->rowCount();

// Check if any posts
if($num > 0){
    // Post Array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while($row= $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            "name" => $name
        );

        // Push to data
        array_push($posts_arr['data'], $post_item);

        // Turn to JSON and output
        echo json_encode($posts_arr);
    }
}else {
    // no posts
    echo json_encode(
        array('message' => 'No posts found!')
    );
}
?>