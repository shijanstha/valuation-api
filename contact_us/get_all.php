<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/contact_us.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$contactUs = new ContactUs($db);

$stmt = $contactUs->getAllContactUs();
$num = $stmt->rowCount();

if ($num > 0) {

    $message_arr = array();
    $message_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $message_row = array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "contact_no" => $contact_no,
            "message" => $message,
        );

        array_push($message_arr["records"], $message_row);
    }

    http_response_code(200);
    echo json_encode($message_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No message found.")
    );
}
