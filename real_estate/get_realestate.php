<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/real_estate.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$re = new RealEstate($db);

$re->re_id = isset($_GET['id']) ? $_GET['id'] : die();

$re->fetchRealEstate();

if ($re->re_name != null) {
    // create array
    $re_arr = array(
        "re_id" => $re->re_id,
        "address" => $re->address,
        "frontage" => $re->frontage,
        "area_of_property" => $re->area_of_property,
        "geo_location" => $re->geo_location,
        "contact" => $re->contact,
        "base_rate" => $re->base_rate,
        "img_path" => $re->img_path
    );

    http_response_code(200);
    echo json_encode($re_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Real Estate does not exist."));
}
