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

// Blog user query
$result = $users->getAll();

// Get row count
$num = $result->rowCount();

// Check if any data
if ($num > 0) {
    // User array
    $users_arr = array();
    // $users_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $data_item = array(
            'id' => $id,
            'kode_guru' => $kode_guru,
            'nama' => $nama,
            'email' => $email,
            'status_asn' => $status_asn,
            'username' => $username,
            'password' => $password,
            'status_aktif' => $status_aktif,
            'role' => $role,
        );

        // push to array
        array_push($users_arr, $data_item);
    }

    // turn to JSON & output
    echo json_encode($users_arr);
} else {
    // No data
    echo json_encode(array(
        'message' => 'No Users Data Found'
    ));
}
