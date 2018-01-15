<?php

require_once("config.php");

/*
//Carrega APENAS um usuario, pelo ID.
$usuario = new Usuario();
$usuario->loadById(12);
echo $usuario;
*/


/*
//Carrega todos os usuarios.
$lista = Usuario::getList();
echo json_encode($lista);
*/


/*
//Carrega uma lista de usuarios buscando pelo login ou parte dele
$search = Usuario::search("Bi");
echo json_encode($search);
*/


/*
//Carrega um usuario pelo Login e Senha.
$usuario = new Usuario();
$usuario->login("Bipe", "Orelha");
echo ($usuario);
*/


/*
//Insere um usuario no banco
$aluno = new Usuario("Bruno", "Zacarin");
$aluno->insert();
echo $aluno;
*/


/*
*/
$usuario = new Usuario();
$usuario->loadById(14);
$usuario->update("Salsicha", "123hau2");
echo $usuario;
?>