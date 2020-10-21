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

$stmt = $ex_employee->fetchAllExEmployees();
$num = $stmt->rowCount();

if ($num > 0) {

    $ex_employees_arr = array();
    $ex_employees_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $ex_employee_row = array(
            "id" => $id,
            "name" => $name,
            "address" => $address,
            "current_work" => $current_work,
            "description" => $description,
            "fb_link" => $fb_link,
            "img_path" => $img_path
        );

        array_push($ex_employees_arr["records"], $ex_employee_row);
    }

    http_response_code(200);
    echo json_encode($ex_employees_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No Ex-employee found.")
    );
}
