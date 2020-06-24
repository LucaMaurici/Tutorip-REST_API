<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/recensione.php';

$database = new Database();
$db = $database->getConnection();
$o = new recensione($db);
$data = json_decode(file_get_contents("php://input"));
 
if(
    true
){
	$o->cod_utente = $data->cod_utente;
    $o->cod_insegnante = $data->cod_insegnante;
	$o->titolo = $data->titolo;
	$o->corpo = $data->corpo;
	$o->valutazioneGenerale = $data->valutazioneGenerale;
    $o->spiegazione = $data->spiegazione;
	$o->empatia = $data->empatia;
	$o->organizzazione = $data->organizzazione;
	$o->anonimo = $data->anonimo;
 
	if($o->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Recensione creata correttamente."));
	}
	else{
        //503 servizio non disponibile
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare recensione."));
	}
}
else{
    //400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare recensione, i dati sono incompleti."));
}
?>