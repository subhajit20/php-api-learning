<?php
require 'vendor/autoload.php';
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: http://127.0.0.1:5500");
header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// require_once "./includes/db.php";

// $method = $_SERVER['REQUEST_METHOD'];
// $uri = $_SERVER['REQUEST_URI'];
// $route = trim(parse_url($uri, PHP_URL_PATH), '/');

$router = new AltoRouter();
$request = $_SERVER['REQUEST_URI'];

$router->map('GET', '/', function() {
    echo json_encode([
        "message"=> "Hello World"
    ]);
});

$match = $router->match();

if ($match && is_callable($match['target'])) {
    call_user_func_array($match['target'], $match['params']);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}

// try {
//     // Route handling
//     if ($route === 'api/get') {
//         // Fetch all users
//         $stmt = $conn->query("SELECT * FROM user"); // Make sure table exists
//         $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

//         echo json_encode([
//             "status" => "success",
//             "data" => $users
//         ]);
//     } else if ($route === 'api/create') {
//         $data = json_decode(file_get_contents('php://input'), true);

//         error_log("Incoming Data:\n" . print_r($data["name"], true));
//         error_log("Incoming Data:\n" . print_r($data["roll"], true));
//         $stmt = $conn->prepare("INSERT INTO user (username) VALUES (?)");
//         $stmt->execute([$data['name']]);
//         echo json_encode([
//             "message" => "Hello, World!",
//             "received_data" => $data,
//             "status" => "success"
//         ]);
//     } else if ($route === 'api/update') {
//         echo json_encode([
//             "message" => "Hello, World! Update",
//             "status" => "success"
//         ]);
//     } else {
//         echo json_encode([
//             "message" => "No routes hit",
//             "status" => "error"
//         ]);
//     }
// } catch (PDOException $e) {
//     echo json_encode([
//         "status" => "error",
//         "message" => "Database error: " . $e->getMessage()
//     ]);
// }

// php -S localhost:8000 this command to start the the server log in terminal
?>