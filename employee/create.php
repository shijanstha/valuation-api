<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/employee.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$employee = new Employee($db);

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

if (
    !empty($_POST["employee_name"]) &&
    !empty($_POST["position"]) &&
    !empty($_POST["contact_no"]) &&
    !empty($_POST["email"]) &&
    !empty($_POST["emp_type"])
) {

    $employee->employee_name = $_POST["employee_name"];
    $employee->position = $_POST["position"];
    $employee->contact_no = $_POST["contact_no"];
    $employee->email = $_POST["email"];
    $employee->emp_type_id = $_POST["emp_type"];
    $employee->fb_link = $_POST["fb_link"];
    $employee->img_path = $destination;

    if (move_uploaded_file($file, $uploadDestination)) {
        if ($employee->createEmployee()) {
            http_response_code(201);
            echo json_encode(array("message" => "Employee was created."));
        } else {
            http_response_code(503);
            echo json_encode(array("message" => "Unable to create employee."));
        }
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create Employee. Data is incomplete."));
}
