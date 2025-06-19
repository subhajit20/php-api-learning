<?php

namespace Model;

use Config\Database;
use PDO;

class User {
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getAllUsers(): array
    {
        $stmt = $this->db->query("SELECT * FROM user");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registerUser(string $username): void
    {
        $stmt = $this->db->prepare("INSERT INTO user (username) VALUES (:username)");
        $stmt->execute([
            ':username' => $username
        ]);
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM user WHERE id = :id");
        $stmt->execute([
            ':id' => $id
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}