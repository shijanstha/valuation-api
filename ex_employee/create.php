<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/ex_employee.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$ex_employee = new ExEmployee($db);

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

if (
    !empty($_POST["name"]) &&
    !empty($_POST["address"]) &&
    !empty($_POST["current_work"]) &&
    !empty($_POST["description"]) 
) {

    $ex_employee->name = $_POST["name"];
    $ex_employee->address = $_POST["address"];
    $ex_employee->current_work = $_POST["current_work"];
    $ex_employee->description = $_POST["description"];
    $ex_employee->fb_link = $_POST["fb_link"];
    $ex_employee->img_path = $destination;

    if (move_uploaded_file($file, $uploadDestination)) {
        if ($ex_employee->createExEmployee()) {
            http_response_code(201);
            echo json_encode(array("message" => "Ex-employee was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create Ex-employee."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Ex-employee. Data is incomplete."));
}
