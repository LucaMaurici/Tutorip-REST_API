<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/utenza.php';

$database = new Database();
$db = $database->getConnection();

$utenza = new utenza($db);

$data = json_decode(file_get_contents("php://input"));

$utenza->email = $data->email;

if($utenza->delete()){
    http_response_code(200);
    echo json_encode(array("risposta" => "L'utenza e' stato eliminata"));
}else{
    //503 service unavailable
    http_response_code(503);
    echo json_encode(array("risposta" => "Impossibile eliminare l'utenza."));
}
?>