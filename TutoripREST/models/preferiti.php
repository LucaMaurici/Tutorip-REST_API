<?php
include_once "../Service/parameters.php";

class Preferiti {
	private $conn;
    
	public $cod_utente;
	public $cod_insegnante;
	//public dataOraCreazione;
    
    public function __construct($db)
	{
		$this->conn = $db;
	}
    
    function findPreferitiById() {
	$query = "SELECT i.id, i.nomeDaVisualizzare, i.valutazioneMedia, i.tariffa
			  FROM (Insegnanti i JOIN Preferiti p ON p.cod_insegnante = i.id) 
			  WHERE p.cod_utente = :idUtente
			  ORDER BY p.dataOraCreazione";
			  
	$stmt = $this->conn->prepare($query);
    $this->cod_utente = htmlspecialchars(strip_tags($this->cod_utente));
	$this->cod_insegnante = htmlspecialchars(strip_tags($this->cod_insegnante));
    //BINDING
	$stmt->bindParam(":idUtente", prepareParam($this->cod_utente));
	$stmt->execute();
	return $stmt;
	}
    
    
    function savePreferiti() {
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