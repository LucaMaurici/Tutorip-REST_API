<?php
//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../models/materia.php';

$database = new Database();
$db = $database->getConnection();

$o = new materia($db);

$stmt = $o->findAllMaterie();
$num = $stmt->rowCount();

if($num>0){
	$arr = array();
	$arr['ElencoMaterie'] = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $item = array(
            "nome" => $nome
        );

        array_push($arr['ElencoMaterie'], $item);
    }

    http_response_code(200);
    echo json_encode($arr);
}else{

    http_response_code(404);

    echo json_encode(
        array("message" => "Nessuna materia trovata.")
    );
}
?>