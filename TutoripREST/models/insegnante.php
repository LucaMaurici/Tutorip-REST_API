<?php
class Insegnante
{
	private $conn;
	//private $table_name = "Insegnanti";
    
	// proprietà
    public $id;
	public $nomeDaVisualizzare;
	public $immagine = null;
	public $tariffa;
	//public $valutazioneMedia;
	public $numeroValutazioni;
	public $promozioni;
	public $gruppo;
	public $dataOraRegistrazione;
	public $posizione;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
	
	// CREATE
    function create(){
        $query ="
				INSERT INTO Posizioni
				SET 
					latitudine=:latitudine, longitudine=:longitudine, indirizzo=:indirizzo;
					
				INSERT INTO Insegnanti
                SET
                    id=:id,
					nomeDaVisualizzare=:nomeDaVisualizzare,
					
					tariffa=:tariffa,

					numeroValutazioni=:numeroValutazioni,
					promozioni=:promozioni,
					gruppo=:gruppo,
					dataOraRegistrazione=:dataOraRegistrazione,
					profiloPubblico=:profiloPubblico,
					cod_posizione=LAST_INSERT_ID();
				";
                    
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
		$this->nomeDaVisualizzare = htmlspecialchars(strip_tags($this->nomeDaVisualizzare));
		#immagine
		$this->tariffa = htmlspecialchars(strip_tags($this->tariffa));
    	//$this->valutazioneMedia = htmlspecialchars(strip_tags($this->valutazioneMedia));
		$this->numeroValutazioni = htmlspecialchars(strip_tags($this->numeroValutazioni));
		$this->promozioni = htmlspecialchars(strip_tags($this->promozioni));
		$this->gruppo = htmlspecialchars(strip_tags($this->gruppo));
		$this->dataOraRegistrazione = htmlspecialchars(strip_tags($this->dataOraRegistrazione));
    	$this->profiloPubblico = htmlspecialchars(strip_tags($this->profiloPubblico));
		
		$this->posizione->latitudine = htmlspecialchars(strip_tags($this->posizione->latitudine));
		$this->posizione->longitudine = htmlspecialchars(strip_tags($this->posizione->longitudine));
		$this->posizione->indirizzo = htmlspecialchars(strip_tags($this->posizione->indirizzo));
		
		
		if($this->id=="") $this->id = null;
		if($this->nomeDaVisualizzare=="") $this->nomeDaVisualizzare = null;
		#immagine
		if($this->tariffa=="") $this->tariffa = null;
		//if($this->valutazioneMedia=="") $this->valutazioneMedia = null;
		if($this->numeroValutazioni=="") $this->numeroValutazioni = null;
		if($this->promozioni=="") $this->promozioni = null;
		if($this->gruppo=="") $this->gruppo = null;
		if($this->dataOraRegistrazione=="") $this->dataOraRegistrazione = null;
		if($this->profiloPubblico=="") $this->profiloPubblico = null;
		
		if($this->posizione->latitudine=="") $this->posizione->latitudine = null;
		if($this->posizione->longitudine=="") $this->posizione->longitudine = null;
		if($this->posizione->indirizzo=="") $this->posizione->indirizzo = null;
        
        // binding
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nomeDaVisualizzare", $this->nomeDaVisualizzare);
		#immagine
		$stmt->bindParam(":tariffa", $this->tariffa);
        //$stmt->bindParam(":valutazioneMedia", $this->valutazioneMedia);
		$stmt->bindParam(":numeroValutazioni", $this->numeroValutazioni);
		$stmt->bindParam(":promozioni", $this->promozioni);
		$stmt->bindParam(":gruppo", $this->gruppo);
        $stmt->bindParam(":dataOraRegistrazione", $this->dataOraRegistrazione);
        $stmt->bindParam(":profiloPubblico", $this->profiloPubblico);
		
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