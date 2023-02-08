<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: GET");
// header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/suratMasuk.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$suratMasuk = new suratMasuk($db);

// Get status
$suratMasuk->status = isset($_GET['status']) ? $_GET['status'] : die();

// Blog user query
$result = $suratMasuk->getByStatus();

// Get row count
$num = $result->rowCount();

// Check if any data
if ($num > 0) {
    // Project array
    $suratMasuk_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $data_item = array(
            'id' => $id,
            'tgl_terima' => $tgl_terima,
            'nomer' => $nomer,
            'pengirim' => $pengirim,
            'nomer_tertulis' => $nomer_tertulis,
            'tgl_tertulis' => $tgl_tertulis,
            'keperluan' => $keperluan,
            'keterangan' => $keterangan,
            'kategori' => $kategori,
            'status' => $status,
        );

        // push to array
        array_push($suratMasuk_arr, $data_item);
    }

    // turn to JSON & output
    echo json_encode($suratMasuk_arr);
} else {
    // No data
    echo "[]";
}
