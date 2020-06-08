<?php
class Insegnante
{
	private $conn;
	private $table_name = "Insegnanti";
    
	// proprietà di un utente
    public $id=null;
	public $gruppo=null;
	public $descrizione=null;
	public $tariffa=null;
	public $valutazione=null;
	public $promozioni=null;
	public $numeroValutazioni=null;
	public $dataOraRegistrazione=null;
	public $posizione=null;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
	
	// CREARE UTENTE
    function create(){
        $query ="INSERT INTO Posizioni
				SET 
					latitudine=:latitudine, longitudine=:longitudine, indirizzo=:indirizzo;
				INSERT INTO
                    Insegnanti
                SET
                    id=:id, gruppo=:gruppo, descrizione=:descrizione,
					tariffa=:tariffa, promozioni=:promozioni, valutazioneMedia=:valutazione,
					numeroValutazioni=:numeroValutazioni, cod_posizione=LAST_INSERT_ID();";
                    
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
    	$this->gruppo = htmlspecialchars(strip_tags($this->gruppo));
    	$this->descrizione = htmlspecialchars(strip_tags($this->descrizione));
		$this->tariffa = htmlspecialchars(strip_tags($this->tariffa));
    	$this->valutazione = htmlspecialchars(strip_tags($this->valutazione));
		$this->promozioni = htmlspecialchars(strip_tags($this->promozioni));
    	$this->dataOraRegistrazione = htmlspecialchars(strip_tags($this->dataOraRegistrazione));
    	$this->numeroValutazioni = htmlspecialchars(strip_tags($this->numeroValutazioni));
		
		$this->posizione->latitudine = htmlspecialchars(strip_tags($this->posizione->latitudine));
		$this->posizione->longitudine = htmlspecialchars(strip_tags($this->posizione->longitudine));
		$this->posizione->indirizzo = htmlspecialchars(strip_tags($this->posizione->indirizzo));
		
		
        
        // binding
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":gruppo", $this->gruppo);
        $stmt->bindParam(":descrizione", $this->descrizione);
		$stmt->bindParam(":tariffa", $this->tariffa);
        $stmt->bindParam(":valutazione", $this->valutazione);
		$stmt->bindParam(":promozioni", $this->promozioni);
        $stmt->bindParam(":dataOraRegistrazione", $this->dataOraRegistrazione);
        $stmt->bindParam(":numeroValutazioni", $this->numeroValutazioni);
		
		$stmt->bindParam(":latitudine", $this->posizione->latitudine);
		$stmt->bindParam(":longitudine", $this->posizione->longitudine);
		$stmt->bindParam(":indirizzo", $this->posizione->indirizzo);
		
		echo $this->posizione->latitudine . "\n";
		echo $this->posizione->longitudine. "\n";
		echo $this->posizione->indirizzo. "\n";
		echo $this->tariffa. "\n";
		echo $this->id. "\n";
		echo $this->promozioni. "\n";
		echo $this->numeroValutazioni. "\n";
		echo $this->valutazione. "\n";
		echo $this->descrizione. "\n";
		echo $this->gruppo. "\n";
		echo $query. "\n";
        
        // execute query
        if($stmt->execute()){
			return true;
        }
        return false;
    }
}
?>