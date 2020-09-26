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

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->title) &&
    !empty($data->summary) &&
    !empty($data->description) &&
    !empty($data->img_path)
) {

    $journal->title = $data->title;
    $journal->summary = $data->summary;
    $journal->description = $data->description;
    $journal->img_path = $data->img_path;

    if ($journal->createJournal()) {
        http_response_code(201);
        echo json_encode(array("message" => "Journal was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create journal."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create journal. Data is incomplete."));
}
?>