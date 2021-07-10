<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once('../../config/Database.php');
include_once('../../models/Category.php');

// Instatiate Db and connect;
$database = new Database();
$db = $database->connect();

// Instatiate Blog post object
$category = new Category($db);

// Get id
$category->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get Post
$category -> readSinglePost();

// create array
$post_arr = array(
    'id' => $category->id,
    'name' => $category->name
);

// make json
print_r(json_encode($post_arr));