<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/gallery.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$gallery = new Gallery($db);

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];


if (!empty($_POST["id"])) {
    $gallery->img_id = $_POST['id'];
    $gallery->img_desc = $_POST["img_desc"];
    $gallery->img_path = $destination;

    if (file_exists($uploadDestination)) {
        echo json_encode(array("message" => "Image already exists."));
    } elseif (move_uploaded_file($file, $uploadDestination)) {
        if ($gallery->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Image detail updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update image detail."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to add image."));
}
