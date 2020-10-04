<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/slider_image.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$slider = new SliderImage($db);

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

$slider->slider_id = $_POST["id"];
$slider->slider_desc = "";
$slider->img_path = $destination;

if (move_uploaded_file($file, $uploadDestination)) {
    if ($slider->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Image detail updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update image detail."));
    }
}
