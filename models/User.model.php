<?php

namespace Model;
use Config\Database;
use PDO;

class User {
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM user"); // assuming "posts" table
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function findById($id) {
        $db = Database::connect(); // must create a DB instance in static methods
        $stmt = $db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
