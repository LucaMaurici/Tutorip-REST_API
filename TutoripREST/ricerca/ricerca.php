<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/ricerca.php';

$database = new Database();
$db = $database->getConnection();

$o = new ricerca($db);

$data = json_decode(file_get_contents("php://input"));
$o->nomeMateria = $data->nomeMateria;
$o->valutazioneMedia = $data->valutazioneMedia;
$o->tariffaMassima = $data->tariffaMassima;
$o->distanzaMassima = $data->distanzaMassima;
$o->posizione = $data->posizione;
$stmt = $o->read();
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
            "distanza" => $distanza
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