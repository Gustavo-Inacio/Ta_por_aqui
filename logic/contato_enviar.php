<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$sql = 'INSERT INTO fale_conosco(nome, email, empresa, telefone, mensagem) VALUES(:nome, :email, :empresa, :telefone, :mensagem)';
$stmt = $con->prepare($sql);
$stmt->execute(['nome' => $_POST['contactName'], 'email' => $_POST['contactEmail'], 'empresa' => $_POST['contactCompany'], 'telefone' => $_POST['contactPhone'], 'mensagem' => $_POST['contactMessage']]);
?>