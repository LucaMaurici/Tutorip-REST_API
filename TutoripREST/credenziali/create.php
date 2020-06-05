<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/credenziali.php';

$database = new Database();
$db = $database->getConnection();
$credenziali = new credenziali($db);
$data = json_decode(file_get_contents("php://input"));
 
if(
    //!empty($data->email) &&
    //!empty($data->password)
    true
){
	$credenziali->Email = $data->Email;
    $credenziali->Token = $data->Token;
 
	if($credenziali->create()){
        http_response_code(201);
        echo json_encode(array("message" => "Credenziali creato correttamente."));
	}
	else{
        //503 servizio non disponibile
        http_response_code(503);
        echo json_encode(array("message" => "Impossibile creare credenziali."));
	}
}
else{
    //400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare credenziali, i dati sono incompleti."));
}
?>