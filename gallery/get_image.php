<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/gallery.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$gallery = new Gallery($db);

$gallery->img_id = isset($_GET['id']) ? $_GET['id'] : die();

$gallery->fetchImage();

if ($gallery->img_path != null) {
    // create array
    $gallery_arr = array(
        "img_id" => $gallery->img_id,
        "img_desc" => $gallery->img_desc,
        "img_path" => $gallery->img_path
    );

    http_response_code(200);
    echo json_encode($gallery_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Image path does not exist."));
}
?>