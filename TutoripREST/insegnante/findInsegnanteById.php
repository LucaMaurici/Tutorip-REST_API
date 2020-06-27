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

$o = new insegnante($db);

$data = json_decode(file_get_contents("php://input"));
$o->id = $data->id;

$stmt = $o->findByid();
$num = $stmt->rowCount();

if($num>0){
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
		
		$posizione = array(
			"id" => $idPosizione,
			"latitudine" => $latitudine,
			"longitudine" => $longitudine,
			"indirizzo" => $indirizzo
		);
		
		$contatti = array(
			"cellulare" => $cellulare,
			"emailContatto" => $emailContatto,
			//"facebook" => $facebook
		);
		
		/*
		$modalità = array(
			"id" => $idModalità,
			"nome" => $nomeModalità
		);*/

        $item = array(
            "id" => $id,
			"nomeDaVisualizzare" => $nomeDaVisualizzare,
			//"descrizione" => $descrizione,
			"tariffa" => $tariffa,
			"valutazioneMedia" => $valutazioneMedia,
			"numeroValutazioni" => $numeroValutazioni,
			//"promozioni" => $promozioni,
            "gruppo" => $gruppo,
            "profiloPubblico" => $profiloPubblico,
			"posizione" => $posizione,
			"contatti" => $contatti,
			"modalita" => $idModalità
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