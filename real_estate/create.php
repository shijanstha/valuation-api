<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/real_estate.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$re = new RealEstate($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->re_name) &&
    !empty($data->address) &&
    !empty($data->cost) &&
    !empty($data->contact_no) &&
    !empty($data->img_path)
) {

    $re->re_name = $data->re_name;
    $re->address = $data->address;
    $re->cost = $data->cost;
    $re->contact_no = $data->contact_no;
    $re->img_path = $data->img_path;

    if ($re->createRealEstate()) {
        http_response_code(201);
        echo json_encode(array("message" => "Real Estate was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create real estate."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create real estate. Data is incomplete."));
}
