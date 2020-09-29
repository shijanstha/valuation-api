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

$contactUs->id = isset($_GET['id']) ? $_GET['id'] : die();

$contactUs->fetchContactUs();

if ($contactUs->name != null) {
    // create array
    $message_arr = array(
        "id" => $contactUs->id,
        "name" => $contactUs->name,
        "email" => $contactUs->email,
        "message" => $contactUs->message,
    );

    http_response_code(200);
    echo json_encode($message_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Message does not exist."));
}
?>