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

$o = new preferiti($db);
$data = json_decode(file_get_contents("php://input"));
$o->cod_utente = $data->idUtente;
$stmt = $o->findPreferitiById();
$num = $stmt->rowCount();

if($num>0){
	$arr = array();
    $arr['ElencoRisultati'] = array();
    
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
	    
        $item = array(
             "id" => $id,
			 "nomeDaVisualizzare" => $nomeDaVisualizzare,
			 "tariffa" => $tariffa,
			 "valutazioneMedia" => $valutazioneMedia,
		);
        array_push($arr['ElencoRisultati'], $item);
	}
    
	http_response_code(200);
    echo json_encode($arr);
}else{
	http_response_code(404);
	echo json_encode(
        array("message" => "Nessun insegnante trovato.")
    );
}
?>