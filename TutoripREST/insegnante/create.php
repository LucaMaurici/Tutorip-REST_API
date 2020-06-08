<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/insegnante.php';

$database = new Database();
$db = $database->getConnection();
$insegnante = new insegnante($db);
$data = json_decode(file_get_contents("php://input"));
 
if(true)
{
    $insegnante->id = $data->id;
	$insegnante->gruppo = $data->gruppo;
	$insegnante->descrizione = $data->descrizione;
    $insegnante->tariffa = $data->tariffa;
	$insegnante->posizione = $data->posizione;
	$insegnante->promozioni = $data->promozioni;
    $insegnante->valutazione = $data->valutazione;
	$insegnante->numeroValutazioni = $data->numeroValutazioni;
	$insegnante->dataOraRegistrazione = $data->dataOraRegistrazione;
 
   if($insegnante->create()){
        http_response_code(201);
        echo json_encode(array("message" => "utente creato correttamente."));
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