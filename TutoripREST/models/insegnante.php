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
	//public $promozioni;
	public $gruppo;
	public $dataOraRegistrazione;
	public $profiloPubblico;
	public $modalita;
	public $contatti;
	public $materie; //= array();
	public $posizione;
	
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
	
	// CREATE con id anzichè id
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
					
					gruppo=:gruppo,
					
					profiloPubblico=:profiloPubblico,
					cod_posizione=LAST_INSERT_id();
				";
        $query .="
				INSERT INTO Insegnanti_Modalità
				SET
					cod_insegnante=:id, cod_modalità=:modalita;
					
				INSERT INTO Contatti
				SET
					id=:id, cellulare=:cellulare, emailContatto=:emailContatto;
				";
		$i = 1;
		foreach($this->materie as &$materia) {
			$query .= "	INSERT INTO Materie
						SET
							nome=:nomeMateria".$i.", prioritàVisualizzazione=1
						ON DUPLICATE KEY
						UPDATE
							prioritàVisualizzazione = prioritàVisualizzazione + 1;
							
						INSERT INTO Insegnanti_Materie
						SET
							cod_insegnante=:id, cod_materia=(SELECT id FROM Materie WHERE nome=:nomeMateria".$i.");";
			$i++;
		}	
                    
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
		$this->nomeDaVisualizzare = htmlspecialchars(strip_tags($this->nomeDaVisualizzare));
		#immagine
		$this->tariffa = htmlspecialchars(strip_tags($this->tariffa));
    	//$this->valutazioneMedia = htmlspecialchars(strip_tags($this->valutazioneMedia));
		$this->numeroValutazioni = htmlspecialchars(strip_tags($this->numeroValutazioni));
		//$this->promozioni = htmlspecialchars(strip_tags($this->promozioni));
		$this->gruppo = htmlspecialchars(strip_tags($this->gruppo));
		//$this->dataOraRegistrazione = htmlspecialchars(strip_tags($this->dataOraRegistrazione));
    	$this->profiloPubblico = htmlspecialchars(strip_tags($this->profiloPubblico));
		
		$this->modalita = htmlspecialchars(strip_tags($this->modalita));
		
		$this->contatti->cellulare = htmlspecialchars(strip_tags($this->contatti->cellulare));
		$this->contatti->emailContatto = htmlspecialchars(strip_tags($this->contatti->emailContatto));
		//$this->contatti->facebook = htmlspecialchars(strip_tags($this->contatti->facebook));
		
		foreach($this->materie as &$materia)
			$materia->nome = htmlspecialchars(strip_tags($materia->nome));
		
		$this->posizione->latitudine = htmlspecialchars(strip_tags($this->posizione->latitudine));
		$this->posizione->longitudine = htmlspecialchars(strip_tags($this->posizione->longitudine));
		$this->posizione->indirizzo = htmlspecialchars(strip_tags($this->posizione->indirizzo));
		
		
		if($this->id=="") $this->id = null;
		if($this->nomeDaVisualizzare=="") $this->nomeDaVisualizzare = null;
		#immagine
		if($this->tariffa=="") $this->tariffa = null;
		//if($this->valutazioneMedia=="") $this->valutazioneMedia = null;
		if($this->numeroValutazioni=="") $this->numeroValutazioni = null;
		//if($this->promozioni=="") $this->promozioni = null;
		if($this->gruppo=="") $this->gruppo = null;
		//if($this->dataOraRegistrazione=="") $this->dataOraRegistrazione = null;
		if($this->profiloPubblico=="") $this->profiloPubblico = null;
		
		if($this->modalita=="") $this->modalita = null;
		
		if($this->contatti->cellulare=="") $this->contatti->cellulare = null;
		if($this->contatti->emailContatto=="") $this->contatti->emailContatto = null;
		//if($this->contatti->facebook=="") $this->contatti->facebook = null;
		
		foreach($this->materie as &$materia)
			if($materia->nome=="")
				$materia->nome = null;
		
		if($this->posizione->latitudine=="") $this->posizione->latitudine = null;
		if($this->posizione->longitudine=="") $this->posizione->longitudine = null;
		if($this->posizione->indirizzo=="") $this->posizione->indirizzo = null;
        
        // binding
        echo $stmt->bindParam(":id", $this->id);
        echo $stmt->bindParam(":nomeDaVisualizzare", $this->nomeDaVisualizzare);
		#immagine
		echo $stmt->bindParam(":tariffa", $this->tariffa);
        //$stmt->bindParam(":valutazioneMedia", $this->valutazioneMedia);
		echo $stmt->bindParam(":numeroValutazioni", $this->numeroValutazioni);
		//$stmt->bindParam(":promozioni", $this->promozioni);
		echo $stmt->bindParam(":gruppo", $this->gruppo);
        //$stmt->bindParam(":dataOraRegistrazione", $this->dataOraRegistrazione);
        echo $stmt->bindParam(":profiloPubblico", $this->profiloPubblico);
		
		echo $stmt->bindParam(":modalita", $this->modalita);
		
		echo $stmt->bindParam(":cellulare", $this->contatti->cellulare);
		echo $stmt->bindParam(":emailContatto", $this->contatti->emailContatto);
		//$stmt->bindParam(":facebook", $this->$this->contatti->facebook);
		echo " ";
		$i = 1;
		foreach($this->materie as &$materia) {
			echo $stmt->bindParam(":nomeMateria".$i, $materia->nome);
			$i++;
		}	
		echo " ";
		echo $stmt->bindParam(":latitudine", $this->posizione->latitudine);
		echo $stmt->bindParam(":longitudine", $this->posizione->longitudine);
		echo $stmt->bindParam(":indirizzo", $this->posizione->indirizzo);
		
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
	
	// findByid
    function findByid(){
        $query = "	
					SELECT i.id, i.nomeDaVisualizzare, i.tariffa, i.valutazioneMedia, i.numeroValutazioni, i.gruppo, i.profiloPubblico, p.latitudine, p.longitudine, p.indirizzo
                  	FROM
						(((Insegnanti i LEFT JOIN Insegnanti_Materie im ON i.id = im.cod_insegnante) 
						LEFT JOIN Materie m ON im.cod_materia = m.id) 
						LEFT JOIN Posizioni p ON i.cod_posizione = p.id)
      				WHERE i.id = :id";
                    
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
		/*
		$this->nomeDaVisualizzare = htmlspecialchars(strip_tags($this->nomeDaVisualizzare));
		#immagine
		#sezioneProfilo
		$this->tariffa = htmlspecialchars(strip_tags($this->tariffa));
    	$this->valutazioneMedia = htmlspecialchars(strip_tags($this->valutazioneMedia));
		$this->numeroValutazioni = htmlspecialchars(strip_tags($this->numeroValutazioni));
		//$this->promozioni = htmlspecialchars(strip_tags($this->promozioni));
		$this->gruppo = htmlspecialchars(strip_tags($this->gruppo));
		$this->profiloPubblico = htmlspecialchars(strip_tags($this->profiloPubblico));
		
		$this->posizione->latitudine = htmlspecialchars(strip_tags($this->posizione->latitudine));
		$this->posizione->longitudine = htmlspecialchars(strip_tags($this->posizione->longitudine));
		$this->posizione->indirizzo = htmlspecialchars(strip_tags($this->posizione->indirizzo));
		*/
		
		if($this->id=="") $this->id = null;
		/*
		if($this->nomeDaVisualizzare=="") $this->nomeDaVisualizzare = null;
		#immagine
		#sezioneProfilo
		if($this->tariffa=="") $this->tariffa = null;
		if($this->valutazioneMedia=="") $this->valutazioneMedia = null;
		if($this->numeroValutazioni=="") $this->numeroValutazioni = null;
		//if($this->promozioni=="") $this->promozioni = null;
		if($this->gruppo=="") $this->gruppo = null;
		if($this->profiloPubblico=="") $this->profiloPubblico = null;
		
		if($this->posizione->latitudine=="") $this->posizione->latitudine = null;
		if($this->posizione->longitudine=="") $this->posizione->longitudine = null;
		if($this->posizione->indirizzo=="") $this->posizione->indirizzo = null;
        */
        // binding
        $stmt->bindParam(":id", $this->id);
		/*
        $stmt->bindParam(":nomeDaVisualizzare", $this->nomeDaVisualizzare);
		#immagine
		#sezioneProfilo
		$stmt->bindParam(":tariffa", $this->tariffa);
        $stmt->bindParam(":valutazioneMedia", $this->valutazioneMedia);
		$stmt->bindParam(":numeroValutazioni", $this->numeroValutazioni);
		//$stmt->bindParam(":promozioni", $this->promozioni);
		$stmt->bindParam(":gruppo", $this->gruppo);
        $stmt->bindParam(":profiloPubblico", $this->profiloPubblico);
		
		$stmt->bindParam(":latitudine", $this->posizione->latitudine);
		$stmt->bindParam(":longitudine", $this->posizione->longitudine);
		$stmt->bindParam(":indirizzo", $this->posizione->indirizzo);
		*/
		
		/*
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
        */
		
		//echo $this->id;
		
        // execute query
		$stmt->execute();
		return $stmt;
    }
	
}
?>