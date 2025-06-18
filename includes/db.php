<?php
    // Database config
    $host = "localhost";
    $dbname = "test";
    $username = "root";
    $password = ""; // Change if needed

    try {
        // Create PDO connection
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        // Set error mode
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo json_encode([
            "status" => "error",
            "message" => "Database connection failed: " . $e->getMessage()
        ]);
        exit;
    }
?>