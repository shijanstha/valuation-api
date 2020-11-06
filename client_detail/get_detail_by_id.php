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
        "area_of_single_floor" => $clientDetail->area_of_single_floor,
        "floor" => $clientDetail->floor,
        "bedroom" => $clientDetail->bedroom,
        "kitchen" => $clientDetail->kitchen,
        "modular_kitchen" => $clientDetail->modular_kitchen,
        "sitting_room" => $clientDetail->sitting_room,
        "common_bathroom" => $clientDetail->common_bathroom,
        "attached_bathroom" => $clientDetail->attached_bathroom,
        "basic_total" => $clientDetail->basic_total,
        "deluxe_total" => $clientDetail->deluxe_total,
        "premium_total" => $clientDetail->premium_total
    );

    http_response_code(200);
    echo json_encode($detail_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Client Detail does not exist."));
}
