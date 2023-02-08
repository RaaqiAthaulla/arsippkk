<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/suratKeluar.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$suratKeluar = new suratKeluar($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$suratKeluar->id = $data->id;
$suratKeluar->nomer = $data->nomer;
$suratKeluar->ditujukan = $data->ditujukan;
$suratKeluar->keperluan = $data->keperluan;
$suratKeluar->keterangan = $data->keterangan;
$suratKeluar->penerima = $data->penerima;
$suratKeluar->tanggal = $data->tanggal;
$suratKeluar->kategori = $data->kategori;
$suratKeluar->status = $data->status;

// Post
if ($suratKeluar->put()) {
    echo json_encode(array(
        'message' => 'Update Success'
    ));
} else {
    echo json_encode(array(
        'message' => 'Update Failed'
    ));
}
