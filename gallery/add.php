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

$fileCount = count($_FILES['img']['name']);

$uploadCount = 0;

for ($i = 0; $i < $fileCount; $i++) {

    // name of file
    $filename = $_FILES['img']['name'][$i];

    // destination of the file on the server
    $destination = 'uploads/' . $filename;
    $uploadDestination = '../uploads/' . $filename;

    // the physical file on a temporary uploads directory on the server
    $temp_file = $_FILES['img']['tmp_name'][$i];

    $gallery->img_desc = "";
    $gallery->img_path = $destination;

    if (move_uploaded_file($temp_file, $uploadDestination)) {
        if ($gallery->addImageToGallery()) {
            $uploadCount++;
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to add image."));
        }
    }
}

if ($uploadCount === $fileCount) {
    http_response_code(201);
    echo json_encode(array("message" => "{$uploadCount} image created."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to create file."));
}
