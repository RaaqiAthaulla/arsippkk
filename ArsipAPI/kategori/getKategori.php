<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/Kategori.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$kategori = new kategori($db);

// Blog user query
$result = $kategori->getKategori();

// Get row count
$num = $result->rowCount();

// Check if any data
if ($num > 0) {
    // User array
    $kategori_arr = array();
    // $kategori_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $data_item = array(
            'id_kategori' => $id_kategori,
            'nama_kategori' => $nama_kategori,
        );

        // push to array
        array_push($kategori_arr, $data_item);
    }

    // turn to JSON & output
    echo json_encode($kategori_arr);
} else {
    // No data
    echo json_encode(array(
        'message' => 'No Kategori Data Found'
    ));
}
