<?php
include_once '../config/database.php';
include_once '../models/utente.php';

$database = new Database();
$db = $database->getConnection();

$utente = new utente($db);
$stmt = $utente->read();
$num = $stmt->rowCount();

if($num>0){
	$utenti_arr = array();
	$utenti_arr['Elenco'] = array();


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $utente_item = array(
            "email" => $email,
            "nome" => $nome,
            "eta" => $eta
        );

        array_push($utenti_arr['Elenco'], $utente_item);
    }

    http_response_code(200);
    echo json_encode($utenti_arr);
}else{

    http_response_code(404);

    echo json_encode(
        array("message" => "Nessun utente trovato.")
    );
}
?>