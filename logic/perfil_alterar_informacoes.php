<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$query = "UPDATE usuarios SET nome_usuario = :nome, sobrenome_usuario = :sobrenome, fone_usuario = :telefone, site_usuario = :site, desc_usuario = :descricao WHERE id_usuario = :id_usuario";
$stmt = $con->prepare($query);
$stmt->bindValue(':nome', $_POST['userName']);
$stmt->bindValue(':sobrenome', $_POST['userLastName']);
$stmt->bindValue(':telefone', $_POST['userCell']);
$stmt->bindValue(':site', $_POST['userSite']);
$stmt->bindValue(':descricao', $_POST['userDescription']);
$stmt->bindValue(':id_usuario', $_SESSION['idUsuario']);
$stmt->execute();

header('location: ../public/Perfil/meu_perfil.php');