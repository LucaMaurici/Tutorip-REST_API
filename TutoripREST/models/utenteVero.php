<?php
class Insegnante
{
	private $conn;
	//private $table_name = "Insegnanti";
    
	// proprietà
    public $id;
	public $nome
	public $cognome;
	public $eta;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
	
	// CREATE
    function create(){
        $query ="					
				INSERT INTO Insegnanti
                SET
                    id=:id,
					nome=:nome,
					cognome=:cognome,
					eta=:eta
				";
                    
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
		$this->nome = htmlspecialchars(strip_tags($this->nome));
		$this->cognome = htmlspecialchars(strip_tags($this->cognome));
		$this->eta = htmlspecialchars(strip_tags($this->eta));		
		
		if($this->id=="") $this->id = null;
		if($this->nome=="") $this->nome = null;
		if($this->cognome=="") $this->cognome = null;
		if($this->eta=="") $this->eta = null;
        
        // binding
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nome", $this->nome);
		$stmt->bindParam(":cognome", $this->cognome);
		$stmt->bindParam(":eta", $this->eta);
		
		#echo $this->nome->nome . "\n";
		
        // execute query
        if($stmt->execute()){
			return true;
        }
        return false;
    }
}
?>