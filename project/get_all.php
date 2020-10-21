<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/project.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$project = new Project($db);

$stmt = $project->getAllProjects();
$num = $stmt->rowCount();

if ($num > 0) {

    $projects_arr = array();
    $projects_arr["records"] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $project_row = array(
            "project_id" => $project_id,
            "project_title" => $project_title,
            "project_desc" => $project_desc,
            "client" => $client,
            "address" => $address,
            "project_cost" => $project_cost,
            "status" => $status,
            "img_path" => $img_path
        );

        array_push($projects_arr["records"], $project_row);
    }

    http_response_code(200);
    echo json_encode($projects_arr);
} else {
    http_response_code(404);

    echo json_encode(
        array("message" => "No project found.")
    );
}
?>