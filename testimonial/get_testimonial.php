<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/testimonial.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$testimonial = new Testimonial($db);

$testimonial->tes_id = isset($_GET['id']) ? $_GET['id'] : die();

$testimonial->fetchTestimonial();

if ($testimonial->name != null) {
    // create array
    $testimonial_arr = array(
        "tes_id" => $testimonial->tes_id,
        "name" => $testimonial->name,
        "address" => $testimonial->address,
        "paragraph" => $testimonial->paragraph,
        "img_path" => $testimonial->img_path,
        "status" => $testimonial->status
    );

    http_response_code(200);
    echo json_encode($testimonial_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Testimonial does not exist."));
}
