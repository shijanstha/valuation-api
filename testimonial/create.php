<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/testimonial.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$testimonial = new Testimonial($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    !empty($data->address) &&
    !empty($data->paragraph) 
) {

    $testimonial->name = $data->name;
    $testimonial->address = $data->address;
    $testimonial->paragraph = $data->paragraph;
    $testimonial->img_path = $data->img_path;

    if ($testimonial->createTestimonial()) {
        http_response_code(201);
        echo json_encode(array("message" => "Testimonial was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create testimonial."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create testimonial. Data is incomplete."));
}
?>