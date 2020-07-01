<?php
include_once "../Service/parameters.php";

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
	//public $numeroValutazioni; //da cambiare nell'altro file
	//public $promozioni;
	public $gruppo;
	public $dataOraRegistrazione;
	public $profiloPubblico;
	public $modalita;
	public $contatti;
	public $materie; //= array();
	public $descrizione;
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
					
					gruppo=:gruppo,
					
					profiloPubblico=:profiloPubblico,
					cod_posizione=LAST_INSERT_ID()
				ON DUPLICATE KEY
					UPDATE
						nomeDaVisualizzare=:nomeDaVisualizzare, tariffa=:tariffa, gruppo=:gruppo, profiloPubblico=:profiloPubblico, cod_posizione=LAST_INSERT_ID();
				
				DELETE FROM Posizioni WHERE id=:idPosizione;
				";
        $query .="
				INSERT INTO Insegnanti_Modalità
				SET
					cod_insegnante=:id, cod_modalità=:modalita
				ON DUPLICATE KEY
					UPDATE
						cod_modalità=:modalita;
				
				INSERT INTO Contatti
				SET
					id=:id, cellulare=:cellulare, emailContatto=:emailContatto, facebook=:facebook
				ON DUPLICATE KEY
					UPDATE
						cellulare=:cellulare, emailContatto=:emailContatto, facebook=:facebook;
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
							cod_insegnante=:id, cod_materia=(SELECT id FROM Materie WHERE nome=:nomeMateria".$i.")
						ON DUPLICATE KEY
							UPDATE
								cod_insegnante=:id, cod_materia=(SELECT id FROM Materie WHERE nome=:nomeMateria".$i.");
								";
			$i++;
		}
		$i = 1;
		foreach($this->descrizione as &$sezione) {
			$query .= "	INSERT INTO SezioniProfilo
						SET
							indice=:indice".$i.", titolo=:titolo".$i.", corpo=:corpo".$i.", cod_insegnante=:id
						ON DUPLICATE KEY
							UPDATE
								titolo=:titolo".$i.", corpo=:corpo".$i.", indice=:indice".$i.", cod_insegnante=:id;";
			$i++;
		}
		
		//$query .="SELECT LAST_INSERT_ID() as idPosizione";
		//$query .="SELECT 'ciao' as idPosizione";
		//echo "fkapodmkaslkmniop";
        //echo $query;
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
		$this->nomeDaVisualizzare = htmlspecialchars(strip_tags($this->nomeDaVisualizzare));
		#immagine
		$this->tariffa = htmlspecialchars(strip_tags($this->tariffa));
    	//$this->valutazioneMedia = htmlspecialchars(strip_tags($this->valutazioneMedia));
		//$this->numeroValutazioni = htmlspecialchars(strip_tags($this->numeroValutazioni));
		//$this->promozioni = htmlspecialchars(strip_tags($this->promozioni));
		$this->gruppo = htmlspecialchars(strip_tags($this->gruppo));
		//$this->dataOraRegistrazione = htmlspecialchars(strip_tags($this->dataOraRegistrazione));
    	$this->profiloPubblico = htmlspecialchars(strip_tags($this->profiloPubblico));
		
		$this->modalita = htmlspecialchars(strip_tags($this->modalita));
		
		$this->contatti->cellulare = htmlspecialchars(strip_tags($this->contatti->cellulare));
		$this->contatti->emailContatto = htmlspecialchars(strip_tags($this->contatti->emailContatto));
		$this->contatti->facebook = htmlspecialchars(strip_tags($this->contatti->facebook));
		
		foreach($this->materie as &$materia)
			$materia->nome = htmlspecialchars(strip_tags($materia->nome));
		
		$this->posizione->id = htmlspecialchars(strip_tags($this->posizione->id));
		$this->posizione->latitudine = htmlspecialchars(strip_tags($this->posizione->latitudine));
		$this->posizione->longitudine = htmlspecialchars(strip_tags($this->posizione->longitudine));
		$this->posizione->indirizzo = htmlspecialchars(strip_tags($this->posizione->indirizzo));
		
		
		if($this->id=="") $this->id = null;
		if($this->nomeDaVisualizzare=="") $this->nomeDaVisualizzare = null;
		#immagine
		if($this->tariffa=="") $this->tariffa = null;
		//if($this->valutazioneMedia=="") $this->valutazioneMedia = null;
		//if($this->numeroValutazioni=="") $this->numeroValutazioni = null;
		//if($this->promozioni=="") $this->promozioni = null;
		if($this->gruppo=="") $this->gruppo = null;
		//if($this->dataOraRegistrazione=="") $this->dataOraRegistrazione = null;
		if($this->profiloPubblico=="") $this->profiloPubblico = null;
		
		if($this->modalita=="") $this->modalita = null;
		
		if($this->contatti->cellulare=="") $this->contatti->cellulare = null;
		if($this->contatti->emailContatto=="") $this->contatti->emailContatto = null;
		if($this->contatti->facebook=="") $this->contatti->facebook = null;
		
		foreach($this->materie as &$materia)
			if($materia->nome=="")
				$materia->nome = null;
		
		if($this->posizione->id=="") $this->posizione->id = null;
		if($this->posizione->latitudine=="") $this->posizione->latitudine = null;
		if($this->posizione->longitudine=="") $this->posizione->longitudine = null;
		if($this->posizione->indirizzo=="") $this->posizione->indirizzo = null;
        
        // binding
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nomeDaVisualizzare", $this->nomeDaVisualizzare);
		#immagine
		$stmt->bindParam(":tariffa", $this->tariffa);
        //$stmt->bindParam(":valutazioneMedia", $this->valutazioneMedia);
		//echo $stmt->bindParam(":numeroValutazioni", $this->numeroValutazioni);
		//$stmt->bindParam(":promozioni", $this->promozioni);
		$stmt->bindParam(":gruppo", $this->gruppo);
        //$stmt->bindParam(":dataOraRegistrazione", $this->dataOraRegistrazione);
        $stmt->bindParam(":profiloPubblico", $this->profiloPubblico);
		
		$stmt->bindParam(":modalita", $this->modalita);
		
		$stmt->bindParam(":cellulare", $this->contatti->cellulare);
		$stmt->bindParam(":emailContatto", $this->contatti->emailContatto);
		$stmt->bindParam(":facebook", $this->contatti->facebook);
		//echo " ";
		$i = 1;
		foreach($this->materie as &$materia) {
			$stmt->bindParam(":nomeMateria".$i, $materia->nome);
			$i++;
		}	
		//echo " ";
		$stmt->bindParam(":idPosizione", $this->posizione->id);
		$stmt->bindParam(":latitudine", $this->posizione->latitudine);
		$stmt->bindParam(":longitudine", $this->posizione->longitudine);
		$stmt->bindParam(":indirizzo", $this->posizione->indirizzo);
		
		//FATTO COL NUOVO METODO
		$i = 1;
		foreach($this->descrizione as &$sezione) {
			//$stmt->bindParam(":idSezioneProfilo".$i, prepareParam($sezione->id));
			$stmt->bindParam(":indice".$i, prepareParam($sezione->indice));
			$stmt->bindParam(":titolo".$i, prepareParam($sezione->titolo));
			$stmt->bindParam(":corpo".$i, prepareParam($sezione->corpo));
			$i++;
			echo prepareParam($sezione->indice);
			echo prepareParam($sezione->titolo);
			echo prepareParam($sezione->corpo);
		}
		
		
		/*
		echo $this->posizione->latitudine . "\n";
		echo $this->posizione->longitudine. "\n";
		echo $this->posizione->indirizzo. "\n";
		echo $this->tariffa. "\n";
		echo $this->id. "\n";
		echo $this->promozioni. "\n";
		//echo $this->numeroValutazioni. "\n";
		echo $this->valutazione. "\n";
		echo $this->descrizione. "\n";
		echo $this->gruppo. "\n";
		*/
		echo $query. "\n";
        
        // execute query
        $stmt->execute();
		return $stmt;
    }
	
	// findByid
    function findById(){
        $query = "	
					SELECT 	i.id, i.nomeDaVisualizzare, i.tariffa, i.valutazioneMedia, i.numeroValutazioni, i.gruppo, i.profiloPubblico,
							p.id as idPosizione, p.latitudine, p.longitudine, p.indirizzo,
							c.cellulare, c.emailContatto, c.facebook,
							mo.id as idModalità, mo.nome as nomeModalità
                  	FROM
						((((Insegnanti i 
						LEFT JOIN Posizioni p ON i.cod_posizione = p.id)
						LEFT JOIN Contatti c ON c.id = i.id)
						LEFT JOIN Insegnanti_Modalità iMod ON iMod.cod_insegnante = i.id)
						LEFT JOIN Modalità mo ON iMod.cod_modalità = mo.id)
      				WHERE i.id = :id";
                    
        $stmt = $this->conn->prepare($query);
        
        //$this->id = htmlspecialchars(strip_tags($this->id));
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
		
		//if($this->id=="") $this->id = null;
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
        //$stmt->bindParam(":id", $this->id);
		$stmt->bindParam(":id", prepareParam($this->id));
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
		
		//$stmt->bindParam(":id", prepareParam($this->id));
		
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