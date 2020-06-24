<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/recensione.php';

$database = new Database();
$db = $database->getConnection();

$o = new recensione($db);

$data = json_decode(file_get_contents("php://input"));
$o->id = $data->id;
$stmt = $o->findByIdInsegnante();
$num = $stmt->rowCount();

if($num>0){
	$arr = array();
	$arr['ElencoRecensioni'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $item = array(
            "titolo" => $titolo,
			"corpo" => $corpo,
			"valutazioneGenerale" => $valutazioneGenerale,
			"spiegazione" => $spiegazione,
			"empatia" =>$empatia,
			"organizzazione" => $organizzazione,
			"anonimo" => $anonimo,
			"dataOra" => $dataOra,
			"utente" => array(
								"nome" => $nome,
								"cognome" => $cognome
						)
        );

        array_push($arr['ElencoRecensioni'], $item);
    }

    http_response_code(200);
    echo json_encode($arr);
}else{

    http_response_code(404);

    echo json_encode(
        array("message" => "Nessuna recensione trovata.")
    );
}
?>