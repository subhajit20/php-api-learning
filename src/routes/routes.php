<?php
use Config\Database;
use FastRoute\RouteCollector;
use Rakit\Validation\Validator;
use Model\User;

require_once __DIR__ . '/../../db/db.php';
require_once __DIR__ . '/../../models/User.model.php';

return function(RouteCollector $r) {
    // User Routes
    $r->addRoute('GET', '/api/users', function(){
        header('Content-Type: application/json');
        $db = Database::connect();
        $stmt = $db->query("SELECT id, username FROM user");
        $users = $stmt->fetchAll();

        error_log("User's Data --------> ". print_r($users, true));
        echo json_encode([
            "message" => "Hello World...",
            "users" => $users
        ]);
    });

    $r->addRoute('POST', "/api/register", function() {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $validator = new Validator();

        error_log("Reuqest Body ---------> " . print_r($data, true));

        // creating validation chain
        $validation = $validator->make($data, [
            'username' => 'required|alpha_num|min:3|max:20',
            'password' => 'required|alpha_num|min:3|max:20',
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

        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO user (username) VALUES (:username)");
        $stmt->execute([
            ":username" => $data->username
        ]);

        echo json_encode([
            "message" => "New User created succesfully",
            "status" => true
        ]);
    });

    $r->addRoute('GET', "/api/user", function() {
        error_log("Id ---------->". print_r($_GET["id"], true));
        $id = $_GET["id"];
        $user = User::findById($id);

        error_log("Users". print_r($user, true));
        echo json_encode([
            "message" => "Get User Id",
            "User" => $user
        ]);
    });

};