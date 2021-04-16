<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../db/db.php';
include_once '../../db/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $set = isset($data['workplace_id']);

    $user->email = $data['email'];
    $user->first_name = $data['first_name'];
    $user->last_name = $data['last_name'];
    $user->type = $data['type'];
    if($user->type === "patient" || !$set) {
        $user->workplace_id = "";
    } else {
        $user->workplace_id = $data['workplace_id'];
    }
    $user->created_at = date('Y-m-d H:i:s');
}

if($user->createUser()){
    echo 'User created successfully.';
} else{
    echo 'User could not be created.';
}


