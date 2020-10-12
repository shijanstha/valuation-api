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

$data = json_decode(file_get_contents("php://input"));

$testimonial->tes_id = $data->id;

$testimonial->status = 'AP';


if ($testimonial->approve()) {
    http_response_code(200);
    echo json_encode(array("message" => "Testimonial approved."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to approve testimonial."));
}
