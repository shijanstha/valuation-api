<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/journal.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$journal = new Journal($db);

$journal->journal_id = isset($_GET['id']) ? $_GET['id'] : die();

$journal->fetchJournal();

if ($journal->title != null) {
    // create array
    $journal_arr = array(
        "journal_id" => $journal->journal_id,
        "title" => $journal->title,
        "summary" => $journal->summary,
        "description" => $journal->description,
        "img_path" => $journal->img_path
    );

    http_response_code(200);
    echo json_encode($journal_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Journal does not exist."));
}
?>