<?php
include_once "../Service/parameters.php";

class SezioneProfilo
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
		
        $query = "	SELECT id, indice, titolo, corpo
                  	FROM
						SezioniProfilo
      				WHERE cod_insegnante = :id
					ORDER BY indice";
                    
        $stmt = $this->conn->prepare($query);
        
		$stmt->bindParam(":id", prepareParam($this->id));
		
		//echo prepareParam($this->id);
		
        // execute query
		$stmt->execute();
		return $stmt;
    }

}
?>