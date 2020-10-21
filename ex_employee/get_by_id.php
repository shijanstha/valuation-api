<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/ex_employee.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$ex_employee = new ExEmployee($db);

$ex_employee->id = isset($_GET['id']) ? $_GET['id'] : die();

$ex_employee->fetchExEmployee();

if ($ex_employee->name != null) {
    // create array
    $ex_employee_arr = array(
        "id" => $ex_employee->id,
        "name" => $ex_employee->name,
        "address" => $ex_employee->address,
        "current_work" => $ex_employee->current_work,
        "description" => $ex_employee->description,
        "fb_link" => $ex_employee->fb_link,
        "img_path" => $ex_employee->img_path,
    );

    http_response_code(200);
    echo json_encode($ex_employee_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Ex-employee does not exist."));
}
?>