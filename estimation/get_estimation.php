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
    !empty($data->area_of_single_floor) ||
    !empty($data->floor) ||
    !empty($data->bedroom) ||
    !empty($data->kitchen) ||
    !empty($data->modular_kitchen) ||
    !empty($data->sitting_room) ||
    !empty($data->common_bathroom) ||
    !empty($data->attached_bathroom)
) {
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

    http_response_code(200);
    echo json_encode(array("basic" => $basicAmounts, "deluxe" => $deluxeAmounts, "premium" => $premiumAmounts));
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to calculate. Data is incomplete."));
}


// await fetch('http://localhost/valuation-api/estimation/get_estimation.php', {
//     method: 'POST',
//     mode: 'no-cors',
//     headers: { 'Content-Type': 'application/json' ,'Access-Control-Allow-Origin': '*'},
//     body: JSON.stringify({
//       area_of_single_floor : '1800',
//       floor : '2',
//       bedroom : '5',
//       kitchen : '1',
//       modular_kitchen : 'Y',   
//       sitting_room: '2',
//       common_bathroom : '2',
//       attached_bathroom : '2'
//     })
// },
// { withCredentials: true,
//   credentials: 'same-origin',}
//   )  .then(response => {
//       console.log(response);
//   })