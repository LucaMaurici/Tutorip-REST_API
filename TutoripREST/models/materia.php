<?php
include_once "../Service/parameters.php";

class Materia
{
	private $conn;
    
	// proprietà
    public $id;

	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
	
	// findByid
    function findByIdInsegnante(){
		
        $query = "	SELECT m.nome, m.prioritàVisualizzazione
                  	FROM
						Insegnanti_Materie im JOIN Materie m ON im.cod_materia = m.id
      				WHERE im.cod_insegnante = :id
					ORDER BY m.prioritàVisualizzazione DESC";
                    
        $stmt = $this->conn->prepare($query);
        
		$stmt->bindParam(":id", prepareParam($this->id));
		
		//echo prepareParam($this->id);
		
        // execute query
		$stmt->execute();
		return $stmt;
    }
    
    //findAllMaterie
	function findAllMaterie() {
	$query = "select nome 
		  from Materie
		  order by prioritàVisualizzazione DESC";

	 $stmt = $this->conn->prepare($query);

	 $stmt->execute();
	 return $stmt;
	}
	
}
?>