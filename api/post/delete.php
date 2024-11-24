<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: DELETE');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);

    $post->id = isset($_GET['id']) ? $_GET['id'] : die();
    
    if ($post->delete()) {
        echo json_encode(
            array('Message" => "Post deleted!')
        );
    } else {
        echo json_encode(
            array('Message" => "Post not deleted!')
        );
    }