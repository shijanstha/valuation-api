<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/employee.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$employee = new Employee($db);

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

$employee->employee_id = $_POST["id"];

$employee->employee_name = $_POST["employee_name"];
$employee->position = $_POST["position"];
$employee->contact_no = $_POST["contact_no"];
$employee->email = $_POST["email"];
$employee->type = $_POST["type"];
$employee->img_path = $destination;

if (move_uploaded_file($file, $uploadDestination)) {
    if ($employee->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Employee Detail updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update employee detail."));
    }
}
