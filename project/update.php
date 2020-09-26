<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/project.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

$project = new Project($db);

$data = json_decode(file_get_contents("php://input"));

$project->project_id = $data->id;

$project->project_title = $data->project_title;
$project->project_desc = $data->project_desc;
$project->img_path = $data->img_path;

if ($project->update()) {
    http_response_code(200);
    echo json_encode(array("message" => "Project detail updated."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to update project detail."));
}
?>