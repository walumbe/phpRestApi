<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-allow-Methods: PUT');
// header('Access-Control-Allow-Headers:Access-Control-Allow-Headers, Content-Type,
// Access-Control-Allow-Methods, Authorization, X-Requested-with');

include_once('../../config/Database.php');
include_once('../../models/Post.php');

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate Blog post Object
$post = new Post($db);

// Get raw posted data
$data = json_decode(file_get_contents('php://input'));

// set id to update
$post->id = $data->id;  

$post->title = $data->title;
$post->body = $data->body;
$post->author = $data->author;
$post->category_id = $data->category_id;

// Update post
if($post->update()){
    echo json_encode(
        array('message' => 'Post Updated')
    );
}else{
  echo json_encode(
      array('message' => 'Post not updated!')
  );
}