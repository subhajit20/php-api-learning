<?php
use FastRoute\RouteCollector;
use Src\Controller\Post_controller;
require_once __DIR__ . '/../../models/Post.model.php';
require_once __DIR__ . '/../controller/Post.controller.php';


// Instantiate the User model

return function(RouteCollector $r) {
    // User Routes
    $r->addRoute('GET', '/api/posts', [Post_controller::class,'getPosts']);

    $r->addRoute('POST', "/api/post/create", [Post_controller::class,"createPost"]);
};