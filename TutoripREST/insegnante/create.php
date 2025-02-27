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

//echo "DATA: ".$data->id;
$insegnante->id = $data->id;
$insegnante->nomeDaVisualizzare = $data->nomeDaVisualizzare;
#immagine
$insegnante->tariffa = $data->tariffa;
//$insegnante->valutazioneMedia = $data->valutazioneMedia;
$insegnante->numeroValutazioni = $data->numeroValutazioni; // da togliere
//$insegnante->promozioni = $data->promozioni;
$insegnante->gruppo = $data->gruppo;
$insegnante->dataOraRegistrazione = $data->dataOraRegistrazione;
$insegnante->profiloPubblico = $data->profiloPubblico;
$insegnante->modalita = $data->modalita;
$insegnante->contatti = $data->contatti;
$insegnante->materie = $data->materie;
$insegnante->descrizione = $data->Descrizione;
$insegnante->posizione = $data->posizione;

if($insegnante->create()){
	http_response_code(201);
	echo json_encode(array("message" => "utente creato correttamente."));
}
else{
	//503 servizio non disponibile
	http_response_code(503);
	echo json_encode(array("message" => "Impossibile creare insegnante."));
}

?>