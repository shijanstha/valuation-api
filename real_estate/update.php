<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/real_estate.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$re = new RealEstate($db);

$data = json_decode(file_get_contents("php://input"));

$re->re_id = $data->id;

$re->re_name = $data->re_name;
$re->address = $data->address;
$re->contact_no = $data->contact_no;
$re->cost = $data->cost;
$re->img_path = $data->img_path;

if ($re->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Real Estate Detail updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update real estate detail."));
}
