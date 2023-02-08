<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/Users.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$users = new Users($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$users->id = $data->id;
$users->last_login = $data->last_login;

// Post
if ($users->logout()) {
    echo json_encode(array(
        'result' => true,
        'message' => 'Success'
    ));
} else {
    echo json_encode(array(
        'result' => false,
        'message' => 'Failed'
    ));
}
