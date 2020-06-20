<?php
class Credenziali {
	
    private $conn;
	private $table_name = "Credenziali";
    
	// proprietà
    public $Email;
	public $Token;
    public $emailNuova;
    public $passwordNuova;
    
	// costruttore
	public function __construct($db)
	{
		$this->conn = $db;
	}
	
	function getId() {
		$query = "SELECT id FROM " . $this->table_name . " WHERE email=:email";
        $stmt = $this->conn->prepare($query);
        
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        
        // binding
        $stmt->bindParam(":email", $this->Email);
		
		// execute query
		$stmt->execute();
		return $stmt;
	}
    
    function checkEmail() {
    	$query = "SELECT COUNT(*) as n FROM " . $this->table_name . " WHERE email=:email";
        $stmt = $this->conn->prepare($query);
        
        $this->Email = htmlspecialchars(strip_tags($this->Email));
        
        // binding
        $stmt->bindParam(":email", $this->Email);
		
		// execute query
		$stmt->execute();
		return $stmt;
    }
    
    function checkEmailEPassword() {
    	$query = "SELECT COUNT(*) as n FROM " . $this->table_name . " WHERE email=:email && password=:password";
        $stmt = $this->conn->prepare($query);
        
        $this->email = htmlspecialchars(strip_tags($this->email));
		$this->password = htmlspecialchars(strip_tags($this->password));
        
        // binding
        $stmt->bindParam(":email", $this->email);
		$stmt->bindParam(":password", $this->password);
		
		// execute query
		$stmt->execute();
		return $stmt;
    }
    
    function checkEmailEPasswordBoolean() {
    	$stmt = $this->checkEmailEPassword();
    	$result = $stmt->fetch(PDO::FETCH_ASSOC);
		if($result[n]==0) {
        	return false;
        }
        else {
        	return true;
        }
    }        
	
	// CREARE CREDENZIALI
    function create(){
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    email=:email, tokenType=:tokenType, accessToken=:accessToken";
                    
        $stmt = $this->conn->prepare($query);
        
		$this->Email = htmlspecialchars(strip_tags($this->Email));
        $TokenType = htmlspecialchars(strip_tags($this->Token->TokenType));
		$AccessToken = htmlspecialchars(strip_tags($this->Token->AccessToken));
        echo $this->Email;
        echo $TokenType;
		echo $AccessToken;
        // binding
		$stmt->bindParam(":email", $this->Email);
        $stmt->bindParam(":tokenType", $TokenType);
		$stmt->bindParam(":accessToken", $AccessToken);
        
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
	
	// AGGIORNARE CREDENZIALI
    function update(){
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    email=:emailNuova, password=:passwordNuova
                WHERE
                    email = :email";

        $stmt = $this->conn->prepare($query);
        
        $this->emailNuova = htmlspecialchars(strip_tags($this->emailNuova));
    	$this->passwordNuova = htmlspecialchars(strip_tags($this->passwordNuova));
        $this->email = htmlspecialchars(strip_tags($this->email));

        // binding
        $stmt->bindParam(":emailNuova", $this->emailNuova);
        $stmt->bindParam(":passwordNuova", $this->passwordNuova);
        $stmt->bindParam(":email", $this->email);

        // execute the query
        if($stmt->execute()){
        	return true;
        }
        return false;
    }
	
}
?>