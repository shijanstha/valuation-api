<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/testimonial.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$testimonial = new Testimonial($db);

$destination = "";
$uploadDestination = "";

$testimonial->tes_id = $_POST["id"];

if ($_FILES['img']['name'] != null) {

    // name of file
    $filename = $_FILES['img']['name'];
    // destination of the file on the server
    $destination = 'uploads/' . $filename;
    $uploadDestination = '../uploads/' . $filename;
} else {
    $testimonial->fetchTestimonial();
    $destination = $testimonial->img_path;
}

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

$testimonial->name = $_POST["name"];
$testimonial->address = $_POST["address"];
$testimonial->paragraph = $_POST["paragraph"];
$testimonial->status = $_POST["status"];
$testimonial->img_path = $destination;

if ($file != null) {
    if (move_uploaded_file($file, $uploadDestination)) {
        if ($testimonial->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Testimonial detail updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update testimonial detail."));
        }
    }
} else {
    if ($testimonial->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Testimonial detail updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update testimonial detail."));
    }
}
