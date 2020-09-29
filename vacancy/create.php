<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/vacancy.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$vacancy = new Vacancy($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->vacancy_title) &&
    !empty($data->city) &&
    !empty($data->opening) &&
    !empty($data->experience) &&
    !empty($data->vacancy_desc) &&
    !empty($data->service_type) &&
    !empty($data->expiry_dt)
) {

    $vacancy->vacancy_title = $data->vacancy_title;
    $vacancy->city = $data->city;
    $vacancy->opening = $data->opening;
    $vacancy->experience = $data->experience;
    $vacancy->vacancy_desc = $data->vacancy_desc;
    $vacancy->service_type = $data->service_type;
    $vacancy->expiry_dt = $data->expiry_dt;

    if ($vacancy->createVacancy()) {
        http_response_code(201);
        echo json_encode(array("message" => "Vacancy was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create vacancy."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create vacancy. Data is incomplete."));
}
?>