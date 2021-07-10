<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Post.php');

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog post Object
$post = new Post($db);

// Blog Post query
$result = $post->read();
// Get row count
$num = $result->rowCount();

// Check if any posts
if($num > 0){
    // Post Array
    $posts_arr = array();
    $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id' => $id,
            'title' => $title,
            'body' => html_entity_decode($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $category_name
        );

        // Push to data
        array_push($posts_arr['data'], $post_item);

        // Turn to JSON and output
        echo json_encode($posts_arr);
    }
}else{
    // no posts
    echo json_encode(
        array('message' => 'No Posts found!')
    );
}