<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/journal.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$journal = new Journal($db);

$destination = "";
$uploadDestination = "";

$journal->journal_id = $_POST["id"];

if ($_FILES['img']['name'] != null) {

    // name of file
    $filename = $_FILES['img']['name'];
    // destination of the file on the server
    $destination = 'uploads/' . $filename;
    $uploadDestination = '../uploads/' . $filename;
} else {
    $journal->fetchJournal();
    $destination = $journal->img_path;
}

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

$journal->title = $_POST["title"];
$journal->summary = $_POST["summary"];
$journal->desc_1 = $_POST["desc_1"];
$journal->desc_2 = $_POST["desc_2"];
$journal->desc_3 = $_POST["desc_3"];
$journal->desc_4 = $_POST["desc_4"];
$journal->img_path = $destination;

if ($file != null) {
    if (move_uploaded_file($file, $uploadDestination)) {
        if ($journal->update()) {
            http_response_code(200);
            echo json_encode(array("message" => "Journal detail updated."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to update journal detail."));
        }
    }
} else {
    if ($journal->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Journal detail updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update journal detail."));
    }
}
