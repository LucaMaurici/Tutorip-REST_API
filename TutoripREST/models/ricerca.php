<?php
class Ricerca
{
	private $conn;
    
    public $nomeMateria;
    public $valutazioneMedia;
    public $tariffaMassima;
	public $posizione;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
    
    // READ Insegnanti
	function read()
	{
    
    	$query = "	SELECT i.email, i.descrizione, i.tariffa, i.valutazioneMedia, SQRT(POW(:latitudine-p.latitudine,2)+POW(:longitudine-p.longitudine,2)) as distanza,( 1*(i.valutazioneMedia/5) + (280/(POW(i.tariffa, 1.5)+280)) + distanza ) as rilevanza
                  	FROM
      ((Insegnanti i JOIN Insegnanti_Materie im ON i.email = im.email) JOIN Materie m ON im.id_materia = m.id) JOIN Posizioni p ON i.Posizioni_id = p.id
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
		
		if($this->posizione!=null) {
        	$this->posizione->latitudine = htmlspecialchars(strip_tags($this->posizione->latitudine));
            $stmt->bindParam(":latitudine", $this->posizione->latitudine);
			$this->posizione->longitudine = htmlspecialchars(strip_tags($this->posizione->longitudine));
            $stmt->bindParam(":longitudine", $this->posizione->longitudine);
        }
		
		// execute query
		$stmt->execute();
        
		return $stmt;
	}
    
}
?>