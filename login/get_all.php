<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/login.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$login = new Login($db);

$stmt = $login->getAllUsers();
$num = $stmt->rowCount();

if ($num > 0) {

    $user_arr = array();
    $user_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $user_row = array(
            "id" => $id,
            "user_name" => $user_name,
            "password" => $password
        );

        array_push($user_arr["records"], $user_row);
    }

    http_response_code(200);
    echo json_encode($user_arr);
} else {
    http_response_code(404);
    echo json_encode(
        array("message" => "No user found.")
    );
}
