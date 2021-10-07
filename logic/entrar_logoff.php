<?php
require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

session_start();

//Colocar o status do usuário como offline
$query = "UPDATE usuarios SET online_usuario = false WHERE id_usuario = {$_SESSION['idUsuario']}";
$con->query($query);

//destruindo session
session_destroy();

//destruindo cookies
setcookie('idUsuario', null, -1, '/'); //expira em 30 dias
setcookie('email', null, -1, '/');
setcookie('senha', null, -1, '/');
setcookie('classificacao', null, -1, '/');
setcookie('imagemPerfil', null, -1, '/');

//redirecionando
header('Location: ../public/Entrar/login.php');