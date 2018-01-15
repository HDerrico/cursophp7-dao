<?php

require_once("config.php");

$usuario = new Usuario();

$usuario->loadById(12);

echo $usuario;
?>