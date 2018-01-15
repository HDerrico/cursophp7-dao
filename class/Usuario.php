<?php

class Usuario{
	//Atributos
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	//INICIO: GETTERS AND SETTERS
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
	//TERMINO: GETTERS AND SETTERS


	//INICIO: MÉTODOS DE LISTAS


	//Carrega informaçoes de um usuario pelo ID.
	public function loadById($id){
		$sql = new Sql();	//Objeto Sql

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(":ID"=>$id));	//Comando select na tabela tb_usuarios buscando por ID, retorna um array.

		if(count($results) > 0){	//Se existir informaçoes em results 1 usuario foi encontrado.
			$this->setDados($results[0]);
		}
	}


	//Nao é necessario instanciar um objeto para chamar esse método, por isso ele é estático.
	//Carrega uma lista de usuarios do banco, ordenando pelo login.
	public static function getList(){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin;");
	}

	//Nao é necessario instanciar um objeto para chamar esse método, por isso ele é estático.
	//Carrega uma lista de usuario do banco, buscando pelo login ou parte do login.
	public static function search($login){
		$sql = new Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin", array(
			':SEARCH'=>"%".$login."%"	//Os '%' servem para colocar aspas simples, permitindo a busca por partes do login.
		));
	}

	//Carrega um usuario do banco pelo login e senha.
	public function login($login, $password){
		$sql = new Sql();	//Objeto Sql

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN AND dessenha = :PASSWORD", array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password
		));	//Comando select na tabela tb_usuarios buscando por login e senha, retorna um array.

		if(count($results) > 0){	//Se existirem informaçoes no array, ou seja, se tiver encontrado o usuario.
			$this->setDados($results[0]); //Coloca as informaçoes carregadas do banco nos atributos do objeto.
		}else{
			throw new Exception("LOGIN E/OU SENHA INVALIDOS!", 1);	//Erro, nao encontrou nenhum usuario com essa login/senha
		}
	}
	//TERMINO: MÉTODOS DE LISTAS


	public function setDados($dados){
		$this->setId($dados['idusuario']);
		$this->setLogin($dados['deslogin']);
		$this->setSenha($dados['dessenha']);
		$this->setCadastro(new DateTime($dados['dtcadastro']));
	}


	public function insert(){
		$sql = new Sql();

		$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
			':LOGIN'=>$this->getLogin(),
			':PASSWORD'=>$this->getSenha()
		));

		if(count($results) > 0){
			$this->setDados($results[0]);
		}
	}


	public function update($login, $password){

		$this->setLogin($login);
		$this->setSenha($password);
		$sql = new Sql();

		$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
			':LOGIN'=>$this->getLogin(),
			':PASSWORD'=>$this->getSenha(),
			':ID'=>$this->getId()
			));
	}


	public function __construct($login = "", $password = ""){	//As aspas permitem instanciar objetos sem passar login e senha
		$this->setLogin($login);
		$this->setSenha($password);
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