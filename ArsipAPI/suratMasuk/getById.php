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

// Get id projek
$suratMasuk->id = isset($_GET['id']) ? $_GET['id'] : die();

// Blog user query
$result = $suratMasuk->getById();

if ($result) {
    // User array
    $surat_arr = array(
        "id" => $suratMasuk->id,
        "tgl_terima" => $suratMasuk->tgl_terima,
        "nomer" => $suratMasuk->nomer,
        "pengirim" => $suratMasuk->pengirim,
        "nomer_tertulis" => $suratMasuk->nomer_tertulis,
        "tgl_tertulis" => $suratMasuk->tgl_tertulis,
        "keperluan" => $suratMasuk->keperluan,
        "keterangan" => $suratMasuk->keterangan,
        "kategori" => $suratMasuk->kategori,
        "status" => $suratMasuk->status,
    );

    // turn to JSON & output
    echo json_encode($surat_arr);
} else {
    // No data
    echo json_encode(array(
        'message' => 'No Data Found'
    ));
}
