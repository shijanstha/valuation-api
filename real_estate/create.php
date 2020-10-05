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

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

if (
    !empty($_POST["address"]) &&
    !empty($_POST["base_rate"])
) {

    $re->address = $_POST["address"];
    $re->frontage = $_POST["frontage"];
    $re->area_of_property = $_POST["area_of_property"];
    $re->geo_location = $_POST["geo_location"];
    $re->contact = $_POST["contact"];
    $re->base_rate = $_POST["base_rate"];
    $re->img_path = $destination;

    if (move_uploaded_file($file, $uploadDestination)) {
        if ($re->createRealEstate()) {
            http_response_code(201);
            echo json_encode(array("message" => "Real Estate was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create real estate."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create real estate. Data is incomplete."));
}
