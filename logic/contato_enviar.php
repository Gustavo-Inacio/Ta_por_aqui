<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

$sql = 'INSERT INTO fale_conosco(nome_contato, email_contato, emp_contaato, fone_contato, msg_contato) VALUES(:nome, :email, :empresa, :telefone, :mensagem)';
$stmt = $con->prepare($sql);
$stmt->execute(['nome' => $_POST['contactName'], 'email' => $_POST['contactEmail'], 'empresa' => $_POST['contactCompany'], 'telefone' => $_POST['contactPhone'], 'mensagem' => $_POST['contactMessage']]);
?>