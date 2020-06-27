<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/insegnante.php';
include_once '../models/materia.php';
include_once '../models/recensione.php';
include_once '../models/sezioneProfilo.php';

$database = new Database();
$db = $database->getConnection();

$o = new insegnante($db);

$data = json_decode(file_get_contents("php://input"));
$o->id = $data->id;

$stmt = $o->findByid();
$num = $stmt->rowCount();

if($num>0){
	$array = array();
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

        $array = array(
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
	
	$o = new materia($db);
	$o->id = $data->id;
	$stmt = $o->findByIdInsegnante();
	$num = $stmt->rowCount();
	if($num>0){
		$array["Materie"] = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			
			$item = array(
				"nome" => $nome
			);
			array_push($array["Materie"], $item);
		}
	}
	
	$o = new recensione($db);
	$o->id = $data->id;
	$stmt = $o->findByIdInsegnante();
	$num = $stmt->rowCount();
	if($num>0){
		$array["Recensioni"] = array();
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
			array_push($array["Recensioni"], $item);
		}
	}
	
	$o = new sezioneProfilo($db);
	$o->id = $data->id;
	$stmt = $o->findByIdInsegnante();
	$num = $stmt->rowCount();
	if($num>0){
		$array["Descrizione"] = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			extract($row);
			
			$item = array(
				"id" => $id,
				"indice" => $indice,
				"titolo" => $titolo,
				"corpo" => $corpo,
        );
			array_push($array["Descrizione"], $item);
		}
	}
	
    echo json_encode($array);
}else{

    http_response_code(404);

    echo json_encode(
        array("message" => "Nessun insegnante trovato.")
    );
}
?>