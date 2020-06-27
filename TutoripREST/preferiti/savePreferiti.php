<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/preferiti.php';

$database = new Database();
$db = $database->getConnection();
$preferiti = new preferiti($db);
$data = json_decode(file_get_contents("php://input"));

if(true) {
	$preferiti->cod_utente = $data->cod_utente;
	$preferiti->cod_insegnante = $data->cod_insegnante;

	if($preferiti->savePreferiti()){
        http_response_code(201);
        echo json_encode(array("message" => "preferiti creato correttamente."));
	}
	else{
        //503 servizio non disponibile
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare preferiti."));
	}
}
else{
    //400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare preferiti, i dati sono incompleti."));
}
?>