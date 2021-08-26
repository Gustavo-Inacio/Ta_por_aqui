<?php
session_start();

require "DbConnection.php";
$con = new DbConnection();
$con = $con->connect();

if ($_POST['contactName'] === "" || $_POST['contactEmail'] === "" || $_POST['contactPhone'] === "" || $_POST['contactMessage'] === ""){
    header('location: ../public/Contato/contato.php?status=0');
    exit();
}

$_POST['contactCompany'] = $_POST['contactCompany'] === "" ? null : $_POST['contactCompany'];

$sql = 'INSERT INTO fale_conosco(nome_contato, email_contato, emp_contaato, fone_contato, msg_contato) VALUES(:nome, :email, :empresa, :telefone, :mensagem)';
$stmt = $con->prepare($sql);
$stmt->execute(['nome' => $_POST['contactName'], 'email' => $_POST['contactEmail'], 'empresa' => $_POST['contactCompany'], 'telefone' => $_POST['contactPhone'], 'mensagem' => $_POST['contactMessage']]);

header('location: ../public/Contato/contato.php?status=1');