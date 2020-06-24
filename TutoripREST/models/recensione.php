<?php
include_once "../Service/parameters.php";

class Recensione
{
	private $conn;
    
	// proprietà
    public $cod_utente;
	public $cod_insegnante;
	public $titolo;
	public $corpo;
	public $valutazioneGenerale;
	public $spiegazione;
	public $empatia;
	public $organizzazione;
	public $anonimo;

	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
	
	// findByid
    function findByIdInsegnante(){
		
        $query = "	SELECT r.titolo, r.corpo, r.valutazioneGenerale, r.spiegazione, r.empatia, r.organizzazione, r.anonimo, r.dataOra, u.nome, u.cognome
                  	FROM
						(Insegnanti i JOIN Recensioni r ON r.cod_insegnante = i.id)
						JOIN Utenti u ON i.id = u.id
      				WHERE r.cod_insegnante = :id AND NOT ((r.titolo IS NULL OR r.titolo = '') AND (r.corpo IS NULL OR r.corpo = ''))
					ORDER BY r.dataOra DESC";
                    
        $stmt = $this->conn->prepare($query);
        
		$stmt->bindParam(":id", prepareParam($this->id));
		
		//echo prepareParam($this->id);
		
        // execute query
		$stmt->execute();
		return $stmt;
    }
	
	// create
    function create(){
		
        $query = "	INSERT INTO Recensioni
					SET
						cod_utente=:cod_utente, cod_insegnante=:cod_insegnante, titolo=:titolo, corpo=:corpo, valutazioneGenerale=:valutazioneGenerale, 
						spiegazione=:spiegazione, empatia=:empatia, organizzazione=:organizzazione, anonimo=:anonimo, dataOra=NOW()";
                    
        $stmt = $this->conn->prepare($query);
        
		$stmt->bindParam(":cod_utente", prepareParam($this->cod_utente));
		$stmt->bindParam(":cod_insegnante", prepareParam($this->cod_insegnante));
		$stmt->bindParam(":titolo", prepareParam($this->titolo));
		$stmt->bindParam(":corpo", prepareParam($this->corpo));
		$stmt->bindParam(":valutazioneGenerale", prepareParam($this->valutazioneGenerale));
		$stmt->bindParam(":spiegazione", prepareParam($this->spiegazione));
		$stmt->bindParam(":empatia", prepareParam($this->empatia));
		$stmt->bindParam(":organizzazione", prepareParam($this->organizzazione));
		$stmt->bindParam(":anonimo", prepareParam($this->anonimo));
		
		//echo prepareParam($this->id);
		
        // execute query
		$stmt->execute();
		return $stmt;
    }
    
    //findAllRecensioni //NON SERVE
	function findAllRecensioni() {
	$query = "	SELECT titolo
				FROM Recensioni
				ORDER BY dataOra DESC";

	 $stmt = $this->conn->prepare($query);

	 $stmt->execute();
	 return $stmt;
	}
	
}
?>