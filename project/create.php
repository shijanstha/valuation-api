<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

include_once '../objects/project.php';

$database = new Database();
$db = $database->getConnection();

// initialize object
$project = new Project($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->project_title) &&
    !empty($data->project_desc) &&
    !empty($data->img_path)
) {

    $project->project_title = $data->project_title;
    $project->project_desc = $data->project_desc;
    $project->img_path = $data->img_path;

    if ($project->createProject()) {
        http_response_code(201);
        echo json_encode(array("message" => "Project was created."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create project."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Unable to create project. Data is incomplete."));
}
