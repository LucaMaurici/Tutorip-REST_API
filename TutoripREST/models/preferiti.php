<?php
include_once "../Service/parameters.php";

class Preferiti {
	private $conn;
    
	public cod_utente;
	public cod_insegnante;
	public dataOraCreazione;
    
    public function __construct($db)
	{
		$this->conn = $db;
	}
    
    function findPreferitiById() {
	$query = "Select i.nomeDaVisualizzare, i.valutazioneMedia, i.tariffa
			  from ((Insegnanti i join Preferiti p) on (p.cod_insegnante = i.id)) 
			  where ((p.cod_utente =: id)
			  order by p.dataOraCreazione";
			  
	$stmt = $this->conn->prepare($query);
	$stmt->bindParam(":id", prepareParam($this->cod_utente));
	$stmt->execute();
	return $stmt;
	}
    
} 
?>