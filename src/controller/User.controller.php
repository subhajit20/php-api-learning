<?php

namespace Src\Controller;
use Rakit\Validation\Validator;
use Model\User;

$usermodel = new User();

class User_controller{
    protected User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }
    public function getAllUsers(): void
    {
        header('Content-Type: application/json');

        try {
            $users = $this->userModel->getAllUsers();

            echo json_encode([
                "message" => count($users) > 0 ? "Users found" : "No users found",
                "data" => $users,
                "status" => true
            ]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode([
                "error" => "Failed to fetch users"
            ]);
        }
    }

    public function registerUser(): void{
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $validator = new Validator();

        error_log("Reuqest Body ---------> " . print_r($data, true));

        // creating validation chain
        $validation = $validator->make($data, [
            'username' => 'required|alpha_num|min:3|max:20',
            // 'password' => 'required|alpha_num|min:3|max:20',
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

        $this->userModel->registerUser($data["username"]);

        echo json_encode([
            "message" => "New User created succesfully",
            "status" => true
        ]);
    }

    public function findUserById(){
        try{
            if(!$_GET["userid"]){
                echo json_encode([
                    "message" => "No user found",
                    "status" => false,
                ]);
                return;
            }
            $user = $this->userModel->findById($_GET["userid"]);

            if(!$user){
                echo json_encode([
                    "message" => "No user found",
                    "status" => false,
                ]);
                return;
            }

            echo json_encode([
                "message" => "Found user",
                "status"=> true,
                "user" => $user
            ]);

        }
        catch(\Exception $e){
            http_response_code(500);
            echo json_encode([
                "error"=> "Something went wrong!!"
            ]);
        };
    }
}