<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Post.php';

    $database = new Database();
    $db = $database->connect();

    $post = new Post($db);

    $post->id = isset($_GET['id']) ? $_GET['id'] : die();

    $post->read_single();

    $post_item = array(
        'id' => $post->id,
        'title' => $post->title,
        'body' => html_entity_decode($post->body),
        'author' => $post->author,
        'category_id' => $post->category_id,
        'category_name' => $post->category_name
    );

    echo json_encode($post_item);
    

