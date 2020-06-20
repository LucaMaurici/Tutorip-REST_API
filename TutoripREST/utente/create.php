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
 
if(
    //!empty($data->id) &&
    //!empty($data->nome) &&
    //!empty($data->cognome) &&
    //!empty($data->tipo)
    true
){
	$utente->id = $data->id;
    $utente->nome = $data->nome;
	$utente->cognome = $data->cognome;
    $utente->età = $data->età;
 
	if($utente->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Utente creato correttamente."));
	}
	else{
        //503 servizio non disponibile
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare utente."));
	}
}
else{
    //400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare utente, i dati sono incompleti."));
}
?>