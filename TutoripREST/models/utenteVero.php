<?php
class Utente
{
	private $conn;
	private $table_name = "Utenti";
    
	// proprietà di un utente
    public $email;
	public $nome;
	public $eta;
    
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
        
	// CREARE UTENTE
    function create() {
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    email=:email, nome=:nome, eta=:eta";
                    
        $stmt = $this->conn->prepare($query);
        
		$this->email = htmlspecialchars(strip_tags($this->email));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
    	$this->eta = htmlspecialchars(strip_tags($this->eta));
        
        // binding
		$stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":eta", $this->eta);
        
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
	// AGGIORNARE UTENTE
    function update() {
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    nome=:nome, eta=:eta
                WHERE
                    email = :email";

        $stmt = $this->conn->prepare($query);

		$this->email = htmlspecialchars(strip_tags($this->email));
        $this->nome = htmlspecialchars(strip_tags($this->nome));
    	$this->eta = htmlspecialchars(strip_tags($this->eta));

        // binding
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":nome", $this->nome);
        $stmt->bindParam(":eta", $this->eta);

        // execute the query
        if($stmt->execute()){
        	return true;
        }

        return false;
    }
    
	/*
	// CANCELLARE UTENTE
    function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE email = ?";

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(1, $this->email);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }*/
}
?>