<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/SuratKeluar.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$suratKeluar = new SuratKeluar($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$suratKeluar->nomer = $data->nomer;
$suratKeluar->ditujukan = $data->ditujukan;
$suratKeluar->keperluan = $data->keperluan;
$suratKeluar->keterangan = $data->keterangan;
$suratKeluar->penerima = $data->penerima;
$suratKeluar->tanggal = $data->tanggal;
$suratKeluar->kategori = $data->kategori;
$suratKeluar->status = $data->status;

// Post
if ($suratKeluar->post()) {
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
