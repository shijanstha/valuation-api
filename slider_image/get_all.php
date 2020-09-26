<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/slider_image.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$slider = new sliderImage($db);

$stmt = $slider->fetchAllImages();
$num = $stmt->rowCount();

if ($num > 0) {

    $slider_arr = array();
    $slider_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $slider_row = array(
            "slider_id" => $slider_id,
            "slider_desc" => $slider_desc,
            "img_path" => $img_path
        );

        array_push($slider_arr["records"], $slider_row);
    }

    http_response_code(200);
    echo json_encode($slider_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No images found.")
    );
}
?>