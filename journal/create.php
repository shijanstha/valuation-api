<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/journal.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$journal = new Journal($db);

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

if (!empty($_POST["title"])) {

    $journal->title = $_POST["title"];
    $journal->summary = $_POST["summary"];
    $journal->desc_1 = $_POST["desc_1"];
    $journal->desc_2 = $_POST["desc_2"];
    $journal->desc_3 = $_POST["desc_3"];
    $journal->desc_4 = $_POST["desc_4"];
    $journal->img_path = $destination;

    if (move_uploaded_file($file, $uploadDestination)) {
        if ($journal->createJournal()) {
            http_response_code(201);
            echo json_encode(array("message" => "Journal was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create journal."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create journal. Data is incomplete."));
}
