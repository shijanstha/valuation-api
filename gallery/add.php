<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/gallery.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$gallery = new Gallery($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->img_desc) &&
    !empty($data->img_path)
) {

    $gallery->img_desc = $data->img_desc;
    $gallery->img_path = $data->img_path;

    if ($gallery->addImageToGallery()) {
        http_response_code(201);
        echo json_encode(array("message" => "Image was added."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to add image."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to add image."));
}