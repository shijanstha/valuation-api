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

$stmt = $clientDetail->getAllClientDetail();
$num = $stmt->rowCount();

if ($num > 0) {

    $detail_arr = array();
    $detail_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $detail_row = array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "contact_no" => $contact_no,
            "address" => $address,
            "area_of_single_floor" => $area_of_single_floor,
            "floor" => $floor,
            "bedroom" => $bedroom,
            "kitchen" => $kitchen,
            "modular_kitchen" => $modular_kitchen,
            "sitting_room" => $sitting_room,
            "common_bathroom" => $common_bathroom,
            "attached_bathroom" => $attached_bathroom,
            "basic_total" => $basic_total,
            "deluxe_total" => $deluxe_total,
            "premium_total" => $premium_total
        );

        array_push($detail_arr["records"], $detail_row);
    }

    http_response_code(200);
    echo json_encode($detail_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No detail found.")
    );
}
