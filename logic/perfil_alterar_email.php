<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

//atualizar novo email no banco de dados
$query = "UPDATE usuarios SET email_usuario = :email";
$stmt = $con->prepare($query);
$stmt->bindValue(':email', $_GET['email']);
$stmt->execute();

//atualizar novo email na session
$_SESSION['email'] = $_GET['email'];

//atualizar novo email nos cookies
if (isset($_COOKIE['email'])){
    setcookie('email', $_GET['email'], time() + (60*60*24*30), '/');
}

header('location: ../public/Perfil/meu_perfil.php?status=1');