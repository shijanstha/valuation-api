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

$data = json_decode(file_get_contents("php://input"));

$employee->employee_id = $data->id;

$employee->employee_name = $data->employee_name;
$employee->position = $data->position;
$employee->contact_no = $data->contact_no;
$employee->email = $data->email;
$employee->type = $data->type;
$employee->img_path = $data->img_path;

if ($employee->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Employee Detail updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update employee detail."));
}
?>