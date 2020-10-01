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

$login->id = isset($_GET['id']) ? $_GET['id'] : die();

$login->fetchUser();

if ($login->user_name != null) {
    // create array
    $login_arr = array(
        "user_name" => $login->user_name,
        "password" => $login->password
    );

    http_response_code(200);
    echo json_encode($login_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "login does not exist."));
}
