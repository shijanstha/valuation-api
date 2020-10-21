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

$project->project_id = isset($_GET['id']) ? $_GET['id'] : die();

$project->fetchProject();

if ($project->project_title != null) {
    // create array
    $project_arr = array(
        "project_id" => $project->project_id,
        "project_title" => $project->project_title,
        "project_desc" => $project->project_desc,
        "client" => $project->client,
        "address" => $project->address,
        "project_cost" => $project->project_cost,
        "status" => $project->status,
        "img_path" => $project->img_path
    );

    http_response_code(200);
    echo json_encode($project_arr);
} else {
    http_response_code(404);
    echo json_encode(array("message" => "Project does not exist."));
}
