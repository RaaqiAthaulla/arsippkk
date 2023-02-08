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

// Get status
$suratKeluar->status = isset($_GET['status']) ? $_GET['status'] : die();

// Blog user query
$result = $suratKeluar->getByStatus();

// Get row count
$num = $result->rowCount();

// Check if any data
if ($num > 0) {
    // Project array
    $suratKeluar_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $data_item = array(
            'id' => $id,
            'nomer' => $nomer,
            'ditujukan' => $ditujukan,
            'keperluan' => $keperluan,
            'keterangan' => $keterangan,
            'penerima' => $penerima,
            'tanggal' => $tanggal,
            'kategori' => $kategori,
            'status' => $status,
        );

        // push to array
        array_push($suratKeluar_arr, $data_item);
    }

    // turn to JSON & output
    echo json_encode($suratKeluar_arr);
} else {
    // No data
    echo "[]";
}
