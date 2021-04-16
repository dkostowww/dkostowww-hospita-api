<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
include_once '../../db/db.php';
include_once '../../db/User.php';
$database = new Database();

$db = $database->getConnection();
$items = new User($db);

if(isset($_GET['workplace'])){
    $hospital_id = isset($_GET['workplace']) ? $_GET['workplace'] : die();

    $records = $items->getUsersByHospitalId($hospital_id);
    $itemCount = $records->num_rows;
    echo json_encode($itemCount);

    if($itemCount > 0){
        $employeeArr = array();
        $employeeArr["body"] = array();
        $employeeArr["itemCount"] = $itemCount;
        while ($row = $records->fetch_assoc())
        {
            array_push($employeeArr["body"], $row);
        }
        echo json_encode($employeeArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No records found.")
        );
    }
} elseif (isset($_GET['title'])){
    $hospital_name = isset($_GET['title']) ? $_GET['title'] : die();

    $records = $items->getUsersByHospitalName($hospital_name);
    $itemCount = $records->num_rows;
    echo json_encode($itemCount);

    if($itemCount > 0){
        $employeeArr = array();
        $employeeArr["body"] = array();
        $employeeArr["itemCount"] = $itemCount;
        while ($row = $records->fetch_assoc())
        {
            array_push($employeeArr["body"], $row);
        }
        echo json_encode($employeeArr);
    }
    else{
        http_response_code(404);
        echo json_encode(
            array("message" => "No records found.")
        );
    }
}else {
    http_response_code(404);
    echo json_encode(
        array("message" => "You can only search by Workplace and Title")
    );
}
