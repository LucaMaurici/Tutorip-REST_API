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
    
    
    function savePreferito() {
	$query = "INSERT INTO Preferiti 
			  SET cod_utente=:id_utente, cod_insegnante=:id_insegnante, dataOraCreazione=now()";
			  
	$stmt = $this->conn->prepare($query);
	$this->cod_utente = htmlspecialchars(strip_tags($this->cod_utente));
	$this->cod_insegnante = htmlspecialchars(strip_tags($this->cod_insegnante));
	//ci va anche la data?
	
	//binding
	$stmt->bindParam(":id_utente", $this->cod_utente);
    $stmt->bindParam(":id_insegnante", $this->cod_insegnante);
	//ci va anche la data?
	
	// execute query
    if($stmt->execute()){
		return true;
    }
    return false;
	}
    
} 
?>