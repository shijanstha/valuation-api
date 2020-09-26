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

$stmt = $journal->getAllJournals();
$num = $stmt->rowCount();

if ($num > 0) {

    $journals_arr = array();
    $journals_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $journal_row = array(
            "journal_id" => $journal_id,
            "title" => $title,
            "summary" => $summary,
            "description" => $description,
            "img_path" => $img_path
        );

        array_push($journals_arr["records"], $journal_row);
    }

    http_response_code(200);
    echo json_encode($journals_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No journal found.")
    );
}
?>