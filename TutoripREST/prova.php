<?php
if(true) {
    http_response_code(200);
    echo "Ciao";
}else{
    http_response_code(404);
    echo json_encode(
        array("message" => "Nessuna materia trovata.")
    );
}
?>