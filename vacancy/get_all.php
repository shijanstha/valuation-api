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

$stmt = $vacancy->fetchAllVacancies();
$num = $stmt->rowCount();

if ($num > 0) {

    $vacancy_arr = array();
    $vacancy_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $vacancy_row = array(
            "vacancy_id" => $vacancy_id,
            "vacancy_title" => $vacancy_title,
            "city" => $city,
            "experience" => $experience,
            "opening" => $opening,
            "service_type" => $service_type,
            "created_dt" => $created_dt,
            "expiry_dt" => $expiry_dt
        );

        array_push($vacancy_arr["records"], $vacancy_row);
    }

    http_response_code(200);
    echo json_encode($vacancy_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No vacancy found.")
    );
}
