<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/Users.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$users = new Users($db);

// Get Username & Password
$users->username = isset($_GET['username']) ? $_GET['username'] : die();
$users->password = isset($_GET['password']) ? $_GET['password'] : die();

$message = "";

if ($users->login()) {
    $message = array(
        'result' => true,
        'message' => 'Username dan Password sesuai',
        'id' => $users->id,
        'username' => $users->username,
        'nama' => $users->nama,
        'email' => $users->email,
        'status_aktif' => $users->status_aktif,
        'role' => $users->role,
    );
} else {
    $message = array(
        'result' => false,
        'message' => 'Username atau Password tidak sesuai',
        'id' => null,
        'username' => null,
        'nama' => null,
        'email' => null,
        'status_aktif' => null,
        'role' => null,
    );
}

// turn to JSON & output
echo json_encode($message);
