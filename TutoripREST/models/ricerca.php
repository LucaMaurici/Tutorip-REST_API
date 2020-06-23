<?php
class Ricerca
{
	private $conn;
    
    public $nomeMateria;
    public $valutazioneMedia;
    public $tariffaMassima;
	public $posizione;
	public $distanzaMassima;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
    /*CREATE or REPLACE view dist as
						SELECT i.Utenti_Credenziali_id as id, 
							(3958*3.1415926*sqrt((:latitudine- p.latitudine)*(:latitudine-p.latitudine) + cos(:latitudine/57.29578)*cos(p.latitudine/57.29578)*(:longitudine- p.longitudine)*(:longitudine- p.longitudine))/180)*1.60934 as distanza
						FROM Insegnanti i JOIN Posizioni p ON i.Posizioni_id = p.id
						
						SELECT i.Utenti_Credenziali_id, i.descrizione, i.tariffa, i.valutazioneMedia,
						( 1*(i.valutazioneMedia/5) + (280/(POW(i.tariffa, 1.5)+280)) + dist.distanza ) as rilevanza
                  	FROM
						((((Insegnanti i JOIN Insegnanti_Materie im ON i.email = im.email) 
						JOIN Materie m ON im.id_materia = m.id) 
						JOIN Posizioni p ON i.Posizioni_id = p.id)
						JOIN dist d ON d.id = i.Utenti_Credenziali_id)
      				WHERE m.nome = :nomeMateria";*/
    // READ Insegnanti
	function read()
	{
		
		//$papagno = (3958*3.1415926*sqrt(($lat2-$lat1)*($lat2-$lat1) + cos($lat2/57.29578)*cos($lat1/57.29578)*($lon2-$lon1)*($lon2-$lon1))/180)*1.60934; 
    	
		$query = "	
					SELECT i.id, i.nomeDaVisualizzare, i.tariffa, i.valutazioneMedia,
							((3958*3.1415926*sqrt((:latitudine- p.latitudine)*(:latitudine-p.latitudine) + cos(:latitudine/57.29578)*cos(p.latitudine/57.29578)*(:longitudine- p.longitudine)*(:longitudine- p.longitudine))/180)*1.60934) as distanza,
						( 1*(i.valutazioneMedia/5) + (280/(POW(i.tariffa, 1.5)+280)) + ( 8000/(8000+((3958*3.1415926*sqrt((:latitudine- p.latitudine)*(:latitudine-p.latitudine) + cos(:latitudine/57.29578)*cos(p.latitudine/57.29578)*(:longitudine- p.longitudine)*(:longitudine- p.longitudine))/180)*1.60934*1000)) ) ) as rilevanza
                  	FROM
						(((Insegnanti i JOIN Insegnanti_Materie im ON i.id = im.cod_insegnante) 
						JOIN Materie m ON im.cod_materia = m.id) 
						JOIN Posizioni p ON i.cod_posizione = p.id)
      				WHERE m.nome = :nomeMateria";
			/*	
		$query = "SELECT i.id, i.tariffa, i.valutazioneMedia 
					FROM ((Insegnanti i JOIN Insegnanti_Materie im ON i.id = im.cod_insegnante) 
						JOIN Materie m ON im.cod_materia = m.id) 
					WHERE m.nome = :nomeMateria";
                   */
				   
		if($this->valutazioneMedia!=null)
        	$query .= " AND "."i.valutazioneMedia >= :valutazioneMedia";
            
        if($this->tariffaMassima!=null)
        	$query .= " AND "."i.tariffa <= :tariffaMassima";
		
		if($this->distanzaMassima!=null)
        	$query .= " HAVING "."distanza <= :distanzaMassima";
        
        $query.= "
        		  ORDER BY rilevanza DESC";
            
        
        //echo $query."\n\n";
        //echo $stmt;   
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
		if($this->distanzaMassima!=null) {
        	$this->distanzaMassima = htmlspecialchars(strip_tags($this->distanzaMassima));
            $stmt->bindParam(":distanzaMassima", $this->distanzaMassima);
        }
        /*
        echo $this->valutazioneMedia;
        echo $this->tariffaMassima;
		echo $this->nomeMateria;
        echo $this->distanzaMassima;
		*/
		// execute query
		$stmt->execute();
		return $stmt;
	}
    
}
?>