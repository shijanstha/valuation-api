<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/clientDetail.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$clientDetail = new ClientDetail($db);

$clientDetail->id = isset($_GET['id']) ? $_GET['id'] : die();

$clientDetail->fetchClientDetail();

if ($clientDetail->name != null) {
    // create array
    $detail_arr = array(
        "id" => $clientDetail->id,
        "name" => $clientDetail->name,
        "email" => $clientDetail->email,
        "address" => $clientDetail->address,
    );

    http_response_code(200);
    echo json_encode($detail_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Client Detail does not exist."));
}
?>