<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/contact_us.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$contactUs = new ContactUs($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) 
) {

    $contactUs->name = $data->name;
    $contactUs->email = $data->email;
    $contactUs->contact_no = $data->contact_no;
    $contactUs->message = $data->message;

    if ($contactUs->createContactUs()) {
        http_response_code(201);
        echo json_encode(array("message" => "Message was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create Message."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create message. Data is incomplete."));
}
?>