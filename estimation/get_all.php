<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/estimation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$estimation = new Estimation($db);

// $basicRates = $estimation->getBasicEstimationRates();

if (true) {
    http_response_code(200);
    echo json_encode($estimation->getBasicEstimationRates());
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Estimation error."));
}
