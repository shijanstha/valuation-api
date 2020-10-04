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

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

if (
    !empty($_POST["name"]) &&
    !empty($_POST["address"]) &&
    !empty($_POST["paragraph"])
) {

    $testimonial->name = $_POST["name"];
    $testimonial->address = $_POST["address"];
    $testimonial->paragraph = $_POST["paragraph"];
    $testimonial->img_path = $destination;

    if (move_uploaded_file($file, $uploadDestination)) {
        if ($testimonial->createTestimonial()) {
            http_response_code(201);
            echo json_encode(array("message" => "Testimonial was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create testimonial."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create testimonial. Data is incomplete."));
}
