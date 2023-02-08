<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/suratKeluar.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$suratKeluar = new suratKeluar($db);

// Blog user query
$result = $suratKeluar->getAll();

// Get row count
$num = $result->rowCount();

// Check if any data
if ($num > 0) {
    // turn to JSON & output
    echo json_encode($num);
} else {
    // No data
    echo json_encode(array(
        'message' => 'No Data Found'
    ));
}
