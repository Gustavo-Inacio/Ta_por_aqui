<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "UPDATE usuarios SET nome = :nome, sobrenome = :sobrenome, telefone = :telefone, email = :email, site = :site, descricao = :descricao WHERE id_usuario = :id_usuario";
$stmt = $con->prepare($query);
$stmt->bindValue(':nome', $_POST['userName']);
$stmt->bindValue(':sobrenome', $_POST['userLastName']);
$stmt->bindValue(':telefone', $_POST['userCell']);
$stmt->bindValue(':email', $_POST['userEmail']);
$stmt->bindValue(':site', $_POST['userSite']);
$stmt->bindValue(':descricao', $_POST['userDescription']);
$stmt->bindValue(':id_usuario', $_SESSION['idUsuario']);
$stmt->execute();

header('location: ../public/Perfil/meu_perfil.php');