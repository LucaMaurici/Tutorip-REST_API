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

$insegnante = new insegnante($db);

$data = json_decode(file_get_contents("php://input"));

//echo "DATA: ".$data->id;
$insegnante->id = $data->id;
$insegnante->nomeDaVisualizzare = $data->nomeDaVisualizzare;
#immagine
$insegnante->tariffa = $data->tariffa;
//$insegnante->valutazioneMedia = $data->valutazioneMedia;
$insegnante->numeroValutazioni = $data->numeroValutazioni; // da togliere
//$insegnante->promozioni = $data->promozioni;
$insegnante->gruppo = $data->gruppo;
$insegnante->dataOraRegistrazione = $data->dataOraRegistrazione;
$insegnante->profiloPubblico = $data->profiloPubblico;
$insegnante->modalita = $data->modalita;
$insegnante->contatti = $data->contatti;
$insegnante->materie = $data->materie;
$insegnante->posizione = $data->posizione;

$stmt = $insegnante->create();
$num = $stmt->rowCount();

if($num>0){
	//echo $num;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
		//echo "dentro";
        extract($row);
        $item = array(
            "idPosizione" => $idPosizione
        );
		//break;
    }

    http_response_code(200);
    echo json_encode($item);
}
else{
    //400 bad request
    http_response_code(400);
    echo json_encode(array("message" => "Impossibile creare insegnante, i dati sono incompleti."));
}
?>