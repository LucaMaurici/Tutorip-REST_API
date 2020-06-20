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

$o = new credenziali($db);

$data = json_decode(file_get_contents("php://input"));
$o->Email = $data->Email;
$stmt = $o->getId();

$num = $stmt->rowCount();
if($num>0){
	
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $item = array(
            "n" => $id
        );
    }

    http_response_code(200);
    echo json_encode($item);
}else{

    http_response_code(404);

    echo json_encode(
        array("message" => "Nessun id trovato.")
    );
}
?>