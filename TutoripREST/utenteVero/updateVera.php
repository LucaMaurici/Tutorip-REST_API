<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/utenteVero.php';

$database = new Database();
$db = $database->getConnection();

$utente = new utente($db);

$data = json_decode(file_get_contents("php://input"));

$utente->email = $data->email;
$utente->password = $data->password;
$utente->nome = $data->nome;
$utente->eta = $data->eta;

//AUTENTICAZIONE
include_once '../models/credenziali.php';
$credenziali = new Credenziali($db);
$credenziali->email = $data->email;
$credenziali->password = $data->password;
if(!$credenziali->checkEmailEPasswordBoolean()) {
	//503 service unavailable
    http_response_code(401);
    echo json_encode(array("risposta" => "Utente non autenticato."));
	exit();
}

if($utente->update()){
    http_response_code(200);
    echo json_encode(array("risposta" => "Utente aggiornato"));
}else{
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile aggiornare utente"));
}
?>