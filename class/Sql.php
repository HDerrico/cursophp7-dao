<?php

class Sql extends PDO{
	//Atributos
	private $conn;

	//Métodos Comuns
	public function __construct(){
		$this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
	}

	//Métodos específicos
	public function setParams($statement, $parameters = array()){
		foreach ($parameters as $key => $value){
			$this->setParam($statement, $key, $value);
		}
	}

	private function setParam($statement, $key, $value){
		$statement->bindParam($key, $value);
	}

	public function query($rawQuery, $params = array()){
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);
		
		$stmt->execute();

		return $stmt;
	}

	public function select($rawQuerry, $params = array()):array{
		$stmt = $this->query($rawQuerry, $params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}


?>