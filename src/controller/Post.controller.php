<?php

namespace Src\Controller;
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
}