<?php
class Utente
{
	private $conn;
	private $table_name = "Utenti";
    
	// proprietà di un utente
    public $id;
	public $nome;
	public $cognome;
	public $età;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
        
	// READ Utenti
	function read()
	{
		// select all
		$query = "SELECT
                        *
                    FROM
                   " . $this->table_name . "";
		$stmt = $this->conn->prepare($query);
		// execute query
		$stmt->execute();
		return $stmt;
	}
	
	// CREATE
    function create(){
        $query ="					
				INSERT INTO Utenti
                SET
                    id=:id,
					nome=:nome,
					cognome=:cognome,
					età=:eta
				";
                    
        $stmt = $this->conn->prepare($query);
        
        $this->id = htmlspecialchars(strip_tags($this->id));
		$this->nome = htmlspecialchars(strip_tags($this->nome));
		$this->cognome = htmlspecialchars(strip_tags($this->cognome));
		$this->età = htmlspecialchars(strip_tags($this->età));		
		
		if($this->id=="") $this->id = null;
		if($this->nome=="") $this->nome = null;
		if($this->cognome=="") $this->cognome = null;
		if($this->età=="") $this->età = null;
        
        // binding
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nome", $this->nome);
		$stmt->bindParam(":cognome", $this->cognome);
		$stmt->bindParam(":eta", $this->età);
		
		echo $this->id . "\n";
		echo $this->nome . "\n";
		echo $this->cognome . "\n";
		echo $this->età . "\n";
		
        // execute query
        if($stmt->execute()){
			return true;
        }
        return false;
    }
    
	// AGGIORNARE UTENTE
    function update(){

        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nome=:nome, cognome=:cognome, tipo=:tipo
                WHERE
                    id = :id";

        $stmt = $this->conn->prepare($query);

		$this->id = htmlspecialchars(strip_tags($this->id));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
        $this->cognome = htmlspecialchars(strip_tags($this->cognome));
        $this->tipo = htmlspecialchars(strip_tags($this->tipo));

        // binding
        $stmt->bindParam(":id", $this->id);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":cognome", $this->cognome);
        $stmt->bindParam(":tipo", $this->tipo);

        // execute the query
        if($stmt->execute()){
        	return true;
        }

        return false;
    }
    
	// CANCELLARE UTENTE
    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>