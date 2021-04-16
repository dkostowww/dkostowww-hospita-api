<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../db/db.php';
include_once '../../db/User.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$user->id = isset($_GET['id']) ? $_GET['id'] : die();

if($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);
    $set = isset($data['workplace_id']);

// User values
    $user->email = $data['email'];
    $user->first_name = $data['first_name'];
    $user->last_name = $data['last_name'];
    $user->type = $data['type'];
    if($user->type === "patient" || !$set) {
        $user->workplace_id = "NULL";
    } else {
        $user->workplace_id = $data['workplace_id'];
    }
    $user->created_at = date('Y-m-d H:i:s');

    if ($user->updateUser()) {
        echo json_encode("User data updated.");
    } else {
        echo json_encode("User could not be updated");
    }
}