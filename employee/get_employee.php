<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/employee.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$employee = new Employee($db);

$employee->employee_id = isset($_GET['id']) ? $_GET['id'] : die();

$employee->fetchEmployee();

if ($employee->employee_name != null) {
    // create array
    $employee_arr = array(
        "employee_id" => $employee->employee_id,
        "employee_name" => $employee->employee_name,
        "position" => $employee->position,
        "contact_no" => $employee->contact_no,
        "email" => $employee->email,
        "emp_type_name" => $employee->emp_type_name,
        "fb_link" => $employee->fb_link,
        "img_path" => $employee->img_path,
    );

    http_response_code(200);
    echo json_encode($employee_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Employee does not exist."));
}
?>