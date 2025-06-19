<?php

namespace Model;
use Config\Database;
use PDO;


class Post {
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function createPost($userid, $postdata){
        $stmt = $this->db->prepare("INSERT INTO todo (data, owner) value (:data, owner)");
        $stmt->execute([
            ":data" => $postdata,
            ":owner" => $userid
        ]);
    }

    public function getAllPosts(){
        $stmt = $this->db->query("SELECT * from todo");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPostsById($id){
        $stmt = $this->db->prepare("SELECT * FROM todo where owner = :id");
        $stmt->execute([
            ":id"=> $id
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}