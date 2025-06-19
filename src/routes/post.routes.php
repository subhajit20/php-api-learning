<?php
use FastRoute\RouteCollector;
use Rakit\Validation\Validator;
use Model\Post;
use Src\Controller\Post_controller;
require_once __DIR__ . '/../../models/Post.model.php';
require_once __DIR__ . '/../controller/Post.controller.php';


// Instantiate the User model

return function(RouteCollector $r) {
    try {
        $postModel = new Post();
    } catch (\Exception $e) {
        http_response_code(500);
        echo json_encode(["error" => "Failed to initialize database"]);
        exit;
    }
    // User Routes
    $r->addRoute('GET', '/api/posts', [Post_controller::class,'getPosts']);

    $r->addRoute('POST', "/api/post/create", function() use ($postModel) {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $validator = new Validator();

        error_log("Reuqest Body ---------> " . print_r($data, true));

        // // creating validation chain
        $validation = $validator->make($data, [
            'userid' => 'required|numeric|min:1|max:20',
            "postdata" => 'required|min:3|max:200',
        ]);
        $validation->validate();

        if ($validation->fails()) {
            // Validation failed
            $errors = $validation->errors()->firstOfAll();

            http_response_code(422);
            echo json_encode([
                'status' => false,
                'errors' => $errors
            ]);
            return;
        }

        $postModel->createPost($data["userid"], $data["postdata"]);

        echo json_encode([
            "message" => "New Post created succesfully",
            "status" => true
        ]);
    });

    $r->addRoute('GET', "/api/post", function() use ($postModel)  {
        error_log("Id ---------->". print_r($_GET["id"], true));
        $userid = $_GET["userid"];
        $user = $postModel->getAllPostsById($userid);

        error_log("Users". print_r($user, true));
        echo json_encode([
            "message" => "Get all posts belong to a perticular user",
            "User" => $user
        ]);
    });

};