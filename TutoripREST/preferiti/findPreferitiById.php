<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/preferiti.php';  

$o = new preferiti($db);
$data = json_decode(file_get_contents("php://input"));
$o->cod_utente = $data->id;
$stmt = $o->findPreferitiById();
$num = $stmt->rowCount();

if($num>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
	    $item = array(
             "id" => $id,
			 "nomeDaVisualizzare" => $nomeDaVisualizzare,
			 "tariffa" => $tariffa,
			 "valutazioneMedia" => $valutazioneMedia,
		);
	}
	http_response_code(200);
    echo json_encode($item);
}else{
	http_response_code(404);
	echo json_encode(
        array("message" => "Nessun insegnante trovato.")
    );
}
?>