<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/suratMasuk.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$suratMasuk = new suratMasuk($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

$suratMasuk->id = $data->id;
$suratMasuk->tgl_terima = $data->tgl_terima;
$suratMasuk->nomer = $data->nomer;
$suratMasuk->pengirim = $data->pengirim;
$suratMasuk->nomer_tertulis = $data->nomer_tertulis;
$suratMasuk->tgl_tertulis = $data->tgl_tertulis;
$suratMasuk->keperluan = $data->keperluan;
$suratMasuk->keterangan = $data->keterangan;
$suratMasuk->kategori = $data->kategori;
$suratMasuk->status = $data->status;

// Post
if ($suratMasuk->put()) {
    echo json_encode(array(
        'message' => 'Update Success'
    ));
} else {
    echo json_encode(array(
        'message' => 'Update Failed'
    ));
}
