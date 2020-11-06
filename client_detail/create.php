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

if (
    !empty($_POST["name"]) &&
    (!empty($_POST["area_of_single_floor"]) ||
        !empty($_POST["floor"]) ||
        !empty($_POST["bedroom"]) ||
        !empty($_POST["kitchen"]) ||
        !empty($_POST["modular_kitchen"]) ||
        !empty($_POST["sitting_room"]) ||
        !empty($_POST["common_bathroom"]) ||
        !empty($_POST["attached_bathroom"]))
) {
    $clientDetail->name = $_POST["name"];
    $clientDetail->email = $_POST["email"];
    $clientDetail->contact_no = $_POST["contact_no"];
    $clientDetail->address = $_POST["address"];

    $clientDetail->area_of_single_floor = $_POST["area_of_single_floor"];
    $clientDetail->floor = $_POST["floor"];
    $clientDetail->bedroom = $_POST["bedroom"];
    $clientDetail->kitchen = $_POST["kitchen"];
    $clientDetail->modular_kitchen = $_POST["modular_kitchen"];
    $clientDetail->sitting_room = $_POST["sitting_room"];
    $clientDetail->common_bathroom = $_POST["common_bathroom"];
    $clientDetail->attached_bathroom = $_POST["attached_bathroom"];

    $order = array(
        "area_of_single_floor" => $_POST["area_of_single_floor"],
        "floor" => $_POST["floor"],
        "bedroom" => $_POST["bedroom"],
        "kitchen" => $_POST["kitchen"],
        "modular_kitchen" => $_POST["modular_kitchen"],
        "sitting_room" => $_POST["sitting_room"],
        "common_bathroom" => $_POST["common_bathroom"],
        "attached_bathroom" => $_POST["attached_bathroom"]
    );

    $basicAmounts = $estimation->basicCalculation($order);
    $deluxeAmounts = $estimation->deluxeCalculation($order);
    $premiumAmounts = $estimation->premiumCalculation($order);

    if ($clientDetail->createClientDetail($basicAmounts['totalAmount'], $deluxeAmounts['totalAmount'], $premiumAmounts['totalAmount'])) {
        http_response_code(201);
        echo json_encode(array("message" => "Client Detail was created.", "basic" => $basicAmounts, "deluxe" => $deluxeAmounts, "premium" => $premiumAmounts));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create Client Detail or Estimate.."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Client Detail or Estimate. Data is incomplete."));
}
