<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/vacancy.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$vacancy = new Vacancy($db);

$data = json_decode(file_get_contents("php://input"));

$vacancy->vacancy_id = $data->id;

$vacancy->vacancy_title = $data->vacancy_title;
$vacancy->city = $data->city;
$vacancy->opening = $data->opening;
$vacancy->experience = $data->experience;
$vacancy->vacancy_desc = $data->vacancy_desc;
$vacancy->service_type = $data->service_type;
$vacancy->expiry_dt = $data->expiry_dt;

if ($vacancy->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Vacancy Detail updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update vacancy detail."));
}
