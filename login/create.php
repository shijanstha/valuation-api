<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/login.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$login = new Login($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->user_name) &&
    !empty($data->password)
) {

    $login->user_name = $data->user_name;
    $login->password = $data->password;

    if ($login->createUser()) {
        http_response_code(201);
        echo json_encode(array("message" => "Admin was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create admin."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create admin. Data is incomplete."));
}
?>