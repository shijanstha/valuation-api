<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/estimation.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$estimation = new Estimation($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($_POST["area_of_single_floor"]) ||
    !empty($_POST["floor"]) ||
    !empty($_POST["bedroom"]) ||
    !empty($_POST["kitchen"]) ||
    !empty($_POST["modular_kitchen"]) ||
    !empty($_POST["sitting_room"]) ||
    !empty($_POST["common_bathroom"]) ||
    !empty($_POST["attached_bathroom"])
) {
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

    http_response_code(200);
    echo json_encode(array("basic" => $basicAmounts, "deluxe" => $deluxeAmounts, "premium" => $premiumAmounts));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to calculate. Data is incomplete."));
}
