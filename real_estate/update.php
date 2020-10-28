<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/real_estate.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$re = new RealEstate($db);

$destination = "";
$uploadDestination = "";

$re->re_id = $_POST["id"];

if ($_FILES['img']['name'] != null) {

    // name of file
    $filename = $_FILES['img']['name'];
    // destination of the file on the server
    $destination = 'uploads/' . $filename;
    $uploadDestination = '../uploads/' . $filename;
} else {
    $re->fetchRealEstate();
    $destination = $re->img_path;
}

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

$re->address = $_POST["address"];
$re->frontage = $_POST["frontage"];
$re->area_of_property = $_POST["area_of_property"];
$re->geo_location = $_POST["geo_location"];
$re->contact = $_POST["contact"];
$re->base_rate = $_POST["base_rate"];
$re->img_path = $destination;

if ($file != null) {
    if (move_uploaded_file($file, $uploadDestination)) {
        if ($re->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Real Estate Detail updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update real estate detail."));
        }
    }
} else {
    if ($re->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Real Estate Detail updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update real estate detail."));
    }
}
