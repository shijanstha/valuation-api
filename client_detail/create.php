<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Credentials: true");

// get database connection
include_once '../config/database.php';
include_once '../objects/clientDetail.php';
include_once '../objects/estimation.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$clientDetail = new ClientDetail($db);
$estimation = new Estimation($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->name) &&
    (!empty($data->area_of_single_floor) ||
        !empty($data->floor) ||
        !empty($data->bedroom) ||
        !empty($data->kitchen) ||
        !empty($data->modular_kitchen) ||
        !empty($data->sitting_room) ||
        !empty($data->common_bathroom) ||
        !empty($data->attached_bathroom))
) {
    $clientDetail->name = $data->name;
    $clientDetail->email = $data->email;
    $clientDetail->contact_no = $data->contact_no;
    $clientDetail->address = $data->address;

    $clientDetail->area_of_single_floor = $data->area_of_single_floor;
    $clientDetail->floor = $data->floor;
    $clientDetail->bedroom = $data->bedroom;
    $clientDetail->kitchen = $data->kitchen;
    $clientDetail->modular_kitchen = $data->modular_kitchen;
    $clientDetail->sitting_room = $data->sitting_room;
    $clientDetail->common_bathroom = $data->common_bathroom;
    $clientDetail->attached_bathroom = $data->attached_bathroom;

    $order = array(
        "area_of_single_floor" => $data->area_of_single_floor,
        "floor" => $data->floor,
        "bedroom" => $data->bedroom,
        "kitchen" => $data->kitchen,
        "modular_kitchen" => $data->modular_kitchen,
        "sitting_room" => $data->sitting_room,
        "common_bathroom" => $data->common_bathroom,
        "attached_bathroom" => $data->attached_bathroom
    );

    $basicAmounts = $estimation->basicCalculation($order);
    $deluxeAmounts = $estimation->deluxeCalculation($order);
    $premiumAmounts = $estimation->premiumCalculation($order);

    if ($clientDetail->createClientDetail($basicAmounts['totalAmount'], $deluxeAmounts['totalAmount'], $premiumAmounts['totalAmount'])) {
        http_response_code(201);
        echo json_encode(array("message" => "Client Detail was created.", "basic" => $basicAmounts, "deluxe" => $deluxeAmounts, "premium" => $premiumAmounts));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create Client Detail."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Client Detail or Estimate. Data is incomplete."));
}
