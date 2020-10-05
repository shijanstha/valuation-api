<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/clientDetail.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$clientDetail = new ClientDetail($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) 
) {

    $clientDetail->name = $data->name;
    $clientDetail->email = $data->email;
    $clientDetail->contact_no = $data->contact_no;
    $clientDetail->address = $data->address;

    if ($clientDetail->createClientDetail()) {
        http_response_code(201);
        echo json_encode(array("message" => "Client Detail was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create Client Detail."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Client Detail. Data is incomplete."));
}
?>