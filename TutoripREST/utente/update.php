<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/utente.php';

$database = new Database();
$db = $database->getConnection();

$utente = new utente($db);

$data = json_decode(file_get_contents("php://input"));

$utente->id = $data->id;
$utente->nome = $data->nome;
$utente->cognome = $data->cognome;
$utente->tipo = $data->tipo;

if($utente->update()){
    http_response_code(200);
    echo json_encode(array("risposta" => "utente aggiornato"));
}else{
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile aggiornare utente"));
}
?>