<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/Users.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$users = new Users($db);

// Get user_id
$users->id = isset($_GET['id']) ? $_GET['id'] : die();

// Blog user query
$result = $users->get();

if ($result) {
    // User array
    $user_arr = array(
        "id" => $users->id,
        "kode_guru" => $users->kode_guru,
        "nama" => $users->nama,
        "email" => $users->email,
        "status_asn" => $users->status_asn,
        "username" => $users->username,
        "password" => $users->password,
        "status_aktif" => $users->status_aktif,
        "role" => $users->role,
        "created_date" => $users->created_date,
        "last_login" => $users->last_login
    );

    // turn to JSON & output
    echo json_encode($user_arr);
} else {
    // No data
    $user_arr = array(
        "id" => null,
        "kode_guru" => null,
        "nama" => null,
        "email" => null,
        "status_asn" => null,
        "username" => null,
        "password" => null,
        "status_aktif" => null,
        "role" => null,
        "created_date" => null,
        "last_login" => null
    );

    // turn to JSON & output
    echo json_encode($user_arr);
}
