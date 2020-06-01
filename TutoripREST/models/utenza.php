<?php
class Utente
{
	private $conn;
	private $table_name_utenti = "Utenti";
	private $table_name_credenziali = "Credenziali";
    
	// proprietà di un utente
    public $email;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
    
	
	// CANCELLARE UTENZA
    function delete() {
		
        $query = "DELETE FROM " . $this->table_name_utenti . " WHERE email = ?";

        $stmt = $this->conn->prepare($query);

        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(1, $this->email);

        // execute query 1
        if($stmt->execute()) {
			
			$query = "DELETE FROM " . $this->table_name_credenziali . " WHERE email = ?";

			$stmt = $this->conn->prepare($query);

			$this->email = htmlspecialchars(strip_tags($this->email));

			$stmt->bindParam(1, $this->email);
			
			// execute query 2
			if($stmt->execute()) {
				return true;
			}
        }
        return false;
    }
}
?>