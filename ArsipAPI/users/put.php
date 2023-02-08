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
$users->kode_guru = $data->kode_guru;
$users->email = $data->email;
$users->status_asn = $data->status_asn;
$users->password = $data->password;
$users->status_aktif = $data->status_aktif;

// Post
if ($users->put()) {
    echo json_encode(array(
        'result' => true,
        'message' => 'Success'
    ));
} else{
    echo json_encode(array(
        'result' => false,
        'message' => 'Failed'
    ));
}
