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
$credenziali->email = $data->email;
$stmt = $credenziali->checkEmail();
$num = $stmt->rowCount();

if($num>0){
	//$utenti_arr = array();
	//$utenti_arr['Elenco'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $numero_item = array(
            "n" => $n,
        );

        //array_push($utenti_arr['Elenco'], $utente_item);
    }

    http_response_code(200);
    echo json_encode($numero_item);
}
else{

    http_response_code(404);

    echo json_encode(
        array("message" => "Errore nell'esecuzione della query.")
    );
}
?>