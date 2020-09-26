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

$stmt = $gallery->fetchAllImages();
$num = $stmt->rowCount();

if ($num > 0) {

    $gallerys_arr = array();
    $gallerys_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $gallery_row = array(
            "img_id" => $img_id,
            "img_desc" => $img_desc,
            "img_path" => $img_path
        );

        array_push($gallerys_arr["records"], $gallery_row);
    }

    http_response_code(200);
    echo json_encode($gallerys_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No images found.")
    );
}
?>