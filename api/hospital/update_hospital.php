<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../db/db.php';
include_once '../../db/Hospital.php';

$database = new Database();
$db = $database->getConnection();

$hospital = new Hospital($db);

$hospital->id = isset($_GET['id']) ? $_GET['id'] : die();

if($_SERVER['REQUEST_METHOD'] === 'PUT') {

    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    $hospital->name = $data['name'];
    $hospital->address = $data['address'];
    $hospital->phone = $data['phone'];

    if ($hospital->updateHospital()) {
        echo json_encode("Hospital data updated.");
    } else {
        echo json_encode("Hospital could not be updated");
    }
}