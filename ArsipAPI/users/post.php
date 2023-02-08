<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
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

$users->kode_guru = $data->kode_guru;
$users->nama = $data->nama;
$users->email = $data->email;
$users->status_asn = $data->status_asn;
$users->username = $data->username;
$users->password = $data->password;
$users->status_aktif = $data->status_aktif;
$users->role = $data->role;
$users->created_date = $data->created_date;
// $users->last_login = $data->last_login;

$temp = $users->validasi();
if ($temp) {
    // Post
    if ($users->post()) {
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
} else {
    echo json_encode(array(
        'result' => false,
        'message' => 'Username sudah ada'
    ));
}
