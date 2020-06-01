<?php
class Ricerca
{
	private $conn;
    
    public $nomeMateria;
    public $valutazioneMedia;
    public $tariffaMassima;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
    
    /*
	function readPerMateria()
	{
		// select all
		$query = "	SELECT i.email, i.descrizione, i.tariffa, i.valutazioneMedia
                  	FROM
      (Insegnanti i JOIN Insegnanti_Materie im ON i.email = im.email) JOIN Materie m ON im.id_materia = m.id
      				WHERE m.nome=:nomeMateria";
                    
		$stmt = $this->conn->prepare($query);
        
        $this->nomeMateria = htmlspecialchars(strip_tags($this->nomeMateria));
        // binding
        $stmt->bindParam(":nomeMateria", $this->nomeMateria);
		// execute query
		$stmt->execute();
		return $stmt;
	}*/
        
	// READ Insegnanti perNomeMateria
	function readPerMateria()
	{
    	$query = "	SELECT i.email, i.descrizione, i.tariffa, i.valutazioneMedia, i.valutazioneMedia * 3 as rilevanza
                  	FROM
      (Insegnanti i JOIN Insegnanti_Materie im ON i.email = im.email) JOIN Materie m ON im.id_materia = m.id
      				WHERE m.nome = :nomeMateria";
                    
		if($this->valutazioneMedia!=null)
        	$query .= " AND "."i.valutazioneMedia >= :valutazioneMedia";
            
        if($this->tariffaMassima!=null)
        	$query .= " AND "."i.tariffaMassima <= :tariffaMassima";
            
            /*
        if($this->nomeCampo2!=null)
        	$query .= " AND "."esempio2=:esempio2";
            */
        
        $query.= "
        		  ORDER BY rilevanza DESC";
            
        
        //echo $query."\n\n";
            
		$stmt = $this->conn->prepare($query);
        
        // binding
        $this->nomeMateria = htmlspecialchars(strip_tags($this->nomeMateria));
        $stmt->bindParam(":nomeMateria", $this->nomeMateria);
        if($this->valutazioneMedia!=null) {
        	$this->valutazioneMedia = htmlspecialchars(strip_tags($this->valutazioneMedia));
            $stmt->bindParam(":valutazioneMedia", $this->valutazioneMedia);
        }
        if($this->tariffaMassima!=null) {
        	$this->tariffaMassima = htmlspecialchars(strip_tags($this->tariffaMassima));
            $stmt->bindParam(":tariffaMassima", $this->tariffaMassima);
        }
        
		// execute query
		$stmt->execute();
        
		return $stmt;
	}
    
    // READ Insegnanti
	/*
	function read()
	{
    
    	$query = "	SELECT i.email, i.descrizione, i.tariffa, i.valutazioneMedia, ( 1*(i.valutazioneMedia/5) + (280/(POW(i.tariffa, 1.5)+280)) ) as rilevanza
                  	FROM
      (Insegnanti i JOIN Insegnanti_Materie im ON i.email = im.email) JOIN Materie m ON im.id_materia = m.id
      				WHERE m.nome = :nomeMateria";
                   
		if($this->valutazioneMedia!=null)
        	$query .= " AND "."i.valutazioneMedia >= :valutazioneMedia";
            
        if($this->tariffaMassima!=null)
        	$query .= " AND "."i.tariffa <= :tariffaMassima";
        
        $query.= "
        		  ORDER BY rilevanza DESC";
            
        
        //echo $query."\n\n";
            
		$stmt = $this->conn->prepare($query);
        
        // binding
        $this->nomeMateria = htmlspecialchars(strip_tags($this->nomeMateria));
        $stmt->bindParam(":nomeMateria", $this->nomeMateria);
        if($this->valutazioneMedia!=null) {
        	$this->valutazioneMedia = htmlspecialchars(strip_tags($this->valutazioneMedia));
            $stmt->bindParam(":valutazioneMedia", $this->valutazioneMedia);
        }
        if($this->tariffaMassima!=null) {
        	$this->tariffaMassima = htmlspecialchars(strip_tags($this->tariffaMassima));
            $stmt->bindParam(":tariffaMassima", $this->tariffaMassima);
        }
        
		// execute query
		$stmt->execute();
        
		return $stmt;
	}
	*/
    
}
?>