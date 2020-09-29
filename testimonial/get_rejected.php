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

$stmt = $testimonial->getRejectedTestimonials();
$num = $stmt->rowCount();

if ($num > 0) {

    $testimonials_arr = array();
    $testimonials_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $testimonial_row = array(
            "tes_id" => $tes_id,
            "name" => $name,
            "address" => $address,
            "paragraph" => $paragraph,
            "img_path" => $img_path,
            "status" => $status
        );

        array_push($testimonials_arr["records"], $testimonial_row);
    }

    http_response_code(200);
    echo json_encode($testimonials_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No pending testimonial found.")
    );
}
