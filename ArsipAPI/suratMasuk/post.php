<?php
// Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once "../config/Database.php";
include_once "../models/SuratMasuk.php";

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate blog user object
$suratMasuk = new suratMasuk($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

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
if ($suratMasuk->post()) {
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