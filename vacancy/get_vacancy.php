<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/vacancy.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$vacancy = new Vacancy($db);

$vacancy->vacancy_id = isset($_GET['id']) ? $_GET['id'] : die();

$vacancy->fetchVacancy();

if ($vacancy->vacancy_title != null) {
    // create array
    $vacancy_arr = array(
        "vacancy_id" => $vacancy->vacancy_id,
        "vacancy_title" => $vacancy->vacancy_title,
        "city" => $vacancy->city,
        "experience" => $vacancy->experience,
        "opening" => $vacancy->opening,
        "service_type" => $vacancy->service_type,
        "created_dt" => $vacancy->created_dt,
        "expiry_dt" => $vacancy->expiry_dt
    );

    http_response_code(200);
    echo json_encode($vacancy_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Vacancy does not exist."));
}
