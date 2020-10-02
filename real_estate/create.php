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
    !empty($_POST["cost"])
) {

    $re->address = $_POST["address"];
    $re->cost = $_POST["cost"];
    $re->img_path = $_POST["img_path"];

    if (file_exists($uploadDestination)) {
        echo json_encode(array("message" => "Image already exists."));
    } elseif (move_uploaded_file($file, $uploadDestination)) {
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
