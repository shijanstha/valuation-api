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

// name of file
$filename = $_FILES['img']['name'];

// destination of the file on the server
$destination = 'uploads/' . $filename;
$uploadDestination = '../uploads/' . $filename;

// the physical file on a temporary uploads directory on the server
$file = $_FILES['img']['tmp_name'];

$project->project_id = $_POST["id"];

$project->project_title = $_POST["project_title"];
$project->project_desc = $_POST["project_desc"];
$project->client = $_POST["client"];
$project->address = $_POST["address"];
$project->project_cost = $_POST["project_cost"];
$project->status = $_POST["status"];
$project->img_path = $destination;

if (move_uploaded_file($file, $uploadDestination)) {
    if ($project->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "Project detail updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update project detail."));
    }
}
