<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../../db/db.php';
include_once '../../db/Hospital.php';
$database = new Database();

$db = $database->getConnection();
$items = new Hospital($db);
$order = isset($_GET['order']) ? $_GET['order'] : "";

if($order === "ASC" || $order === "DESC" || !$order) {
    $records = $items->getHospitals($order);
    $itemCount = $records->num_rows;
    echo json_encode($itemCount);
    if ($itemCount > 0) {
        $employeeArr = array();
        $employeeArr["body"] = array();
        $employeeArr["itemCount"] = $itemCount;
        while ($row = $records->fetch_assoc()) {
            array_push($employeeArr["body"], $row);
        }
        echo json_encode($employeeArr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
} else {
    http_response_code(400);
    echo json_encode(
        array("message" => "Please select ASC/DESC as order or remove it as parameter.")
    );
}
