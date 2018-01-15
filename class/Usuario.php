<?php

class Usuario{

	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getId(){
		return $this->idusuario;
	}
	public function setId($value){
		$this->idusuario = $value;
	}


	public function getLogin(){
		return $this->deslogin;
	}
	public function setLogin($value){
		$this->deslogin = $value;
	}


	public function getSenha(){
		return $this->dessenha;
	}
	public function setSenha($value){
		$this->dessenha = $value;
	}


	public function getCadastro(){
		return $this->dtcadastro;
	}
	public function setCadastro($value){
		$this->dtcadastro = $value;
	}

	//Carrega informaçoes de um usuario pelo ID.
	public function loadById($id){
		$sql = new Sql();	//Objeto Sql

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));	//Comando select na tabela tb_usuarios buscando por ID, retorna um array.

		if(isset($results[0])){	//Se a primeira linha do array existir, ou seja, se tiver encontrado o usuario.
			$row = $results[0];

			//Coloca as informaçoes carregadas do banco nos atributos do objeto.
			$this->setId($row['idusuario']);
			$this->setLogin($row['deslogin']);
			$this->setSenha($row['dessenha']);
			$this->setCadastro(new DateTime($row['dtcadastro']));
		}
	}

	//__toString é chamada quando um echo é feito em um objeto dessa classe.
	public function __toString(){
		return json_encode(array(
			"idusuario"=>$this->getId(),
			"deslogin"=>$this->getLogin(),
			"dessenha"=>$this->getSenha(),
			"dtcadastro"=>$this->getCadastro()->format("d/m/Y H:i:s")	//Exibe o cadastro com o formato desejado (dd/mm/YYYY, hora minuto e segundo)
		));
	}
}


?>