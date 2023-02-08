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

// Get id projek
$suratKeluar->id = isset($_GET['id']) ? $_GET['id'] : die();

// Blog user query
$result = $suratKeluar->getById();

if ($result) {
    // User array
    $surat_arr = array(
        "id" => $suratKeluar->id,
        "nomer" => $suratKeluar->nomer,
        "ditujukan" => $suratKeluar->ditujukan,
        "keperluan" => $suratKeluar->keperluan,
        "keterangan" => $suratKeluar->keterangan,
        "penerima" => $suratKeluar->penerima,
        "tanggal" => $suratKeluar->tanggal,
        "kategori" => $suratKeluar->kategori,
        "status" => $suratKeluar->status,
    );

    // turn to JSON & output
    echo json_encode($surat_arr);
} else {
    // No data
    echo json_encode(array(
        'message' => 'No Data Found'
    ));
}
