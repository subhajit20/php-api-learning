<?php

namespace Src\Controller;
use Rakit\Validation\Validator;
use Model\Post;

class Post_controller{
    protected Post $post;
    public function __construct(){
        $this->post = new Post();
    }

    public function getPosts(){
        try{
            $posts = $this->post->getAllPosts();

            echo json_encode([
                "message" => count($posts) > 0 ? "Found posts" : "No post found",
                "data"=> $posts,
                "status" => true
            ]);
        }
        catch(\Exception $e){
            http_response_code(500);
            echo json_encode([
                "message" => "Something went wrong"
            ]);
        }
    }

    public function createPost(){
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

        $this->post->createPost($data["userid"], $data["postdata"]);

        echo json_encode([
            "message" => "New Post created succesfully",
            "status" => true
        ]);
    }
}