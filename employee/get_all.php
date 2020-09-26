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

$stmt = $employee->fetchAllEmployees();
$num = $stmt->rowCount();

if ($num > 0) {

    $employees_arr = array();
    $employees_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $employee_row = array(
            "employee_id" => $employee_id,
            "employee_name" => $employee_name,
            "position" => $position,
            "contact_no" => $contact_no,
            "email" => $email,
            "type" => $type,
            "img_path" => $img_path
        );

        array_push($employees_arr["records"], $employee_row);
    }

    http_response_code(200);
    echo json_encode($employees_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No employee found.")
    );
}
?>