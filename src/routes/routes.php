<?php
use FastRoute\RouteCollector;
use Src\Controller\User_controller;

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../models/User.model.php';
require_once __DIR__ . '/../controller/User.controller.php';


// Instantiate the User model

return function(RouteCollector $r) {
    // User Routes
    $r->addRoute('GET', '/api/users',[User_controller::class, "getAllUsers"]);

    $r->addRoute('POST', "/api/register",[User_controller::class,"registerUser"]);

    $r->addRoute('GET', "/api/user", [User_controller::class,"findUserById"]);


    $r->addRoute('GET', "/", function() {
        echo json_encode([
            "message" => "Welcome to the API!"
        ]);
    });

};