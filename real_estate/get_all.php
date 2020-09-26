<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/real_estate.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$re = new RealEstate($db);

$stmt = $re->getAllRealEstate();
$num = $stmt->rowCount();

if ($num > 0) {

    $re_arr = array();
    $re_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $re_row = array(
            "re_id" => $re_id,
            "re_name" => $re_name,
            "address" => $address,
            "cost" => $cost,
            "contact_no" => $contact_no,
            "img_path" => $img_path
        );

        array_push($re_arr["records"], $re_row);
    }

    http_response_code(200);
    echo json_encode($re_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No Real Estate found.")
    );
}
